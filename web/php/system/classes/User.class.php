<?PHP
/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* User class
*/
class User extends DbRec {

	public static $tableName = "user";

	public $perms = array();


	// ###################################



	/**
	* Encrypt password
	*/
	public static function encryptPassword($password) {
		return sha1(trim($password));
	}  // eo encrypt password



	/*
	 * Init values from db
	 */
	public function initValues($userId) {

		if (!$userId) {
			throw new Exception(Oger::_(__CLASS__ . "::" . __METHOD__ . ": User id required."));
		}

		$seleReq = array("userId" => $userId);
		$row = Dbw::fetchRow1("SELECT * FROM user WHERE userId=:userId", $seleReq);
		if (!$row) {
			throw new Exception(Oger::_(__CLASS__ . "::" . __METHOD__ . ": Invalid user id '{$userId}'. User not found."));
		}

		$this->perms = array();
		foreach($row as $key => $value) {

			// skip special fields
			switch ($key) {
			case "logonPerm":
			case "superPerm":
				continue 2;
			}

			// apply standard fields
			$this->$key = $value;
		}  // eo set values to object

	}  // eo init values



	/**
	* Check if user has specific permission
	*/
	public function hasPerm($needPerm) {

		if (!array_key_exists($needPerm, $this->perms)) {
			$this->fetchPerm($needPerm);
		}

		// logon is checked before super permission to
		// disable logon for super admins
		if ($needPerm == "LOGON") {
			return $this->perms['LOGON'];
		}

		// super admin has all perms so we can stop here
		if ($this->perms['SUPER']) {
			return true;
		}

		// return perm for all other requested key
		return $this->perms[$needPerm];
	}  // eo permission check


	/**
	* Fetch and cache specific permission from different sources
	*
	* **********************************************************
	*
	* valid permissions:
	* ------------------
	*
	* LOGON: user.logonPerm
	*   To disable logon without deleting the user.
	*
	* SUPER: user.superPerm
	*   Super user permissions.
	*
	* MASTERDATA: userGroup.editMasterDataPerm
	*   Insert/update/delete master data.
	*
	* BOOKING
	*   Check if permission to update OR insert bookings is assigned.
	*   For Details see INSERTBOOKING and UPDATEBOOKING.
	*
	* INSERTBOOKING: insertBookingPerm
	*   Insert new bookings, but cannot modify existings ones.
	*   Particulary important till booking history exists (with logging who changed a booking).
	*
	* UPDATEBOOKING: updateBookingPerm
	*   Permission to update AND insert bookings.
	*   Maybe can be removed after booking history is in place (see INSERTBOOKING).
	*   Only the core ledger entry is protected:
	*   - Changes to aux book references only need INSERTBOOKING permission.
	*   - Changes ledger open item numbers only need INSERTBOOKING permission.
	*
	*/
	public function fetchPerm($permName) {

		// logon and super perm (located on user)
		if ($permName == "LOGON" || $permName == "SUPER") {

			$userRow = Dbw::fetchRow1(
				"SELECT * FROM user WHERE userId=:userId",
				array("userId" => $this->userId));

			$this->perms['LOGON'] = $userRow['logonPerm'];
			$this->perms['SUPER'] = $userRow['superPerm'];

			return;
		}


		// BOOKING is the shortcut for INSERT-BOOKING
		// UPDATE-BOOKING includes INSERT-BOOKING too !!!
		if ($permName == "BOOKING") {
			$this->perms[$permName] = $this->hasPerm("INSERT-BOOKING") || $this->hasPerm("UPDATE-BOOKING");
			return;
		}


		$maxPermFieldsArr = array(
			"EDIT-MASTERDATA" => "updateMasterDataPerm",  // edit (insert and update) master data perm
			"DELETE-MASTERDATA" => "deleteMasterDataPerm",  // delete master data perm
			"INSERT-BOOKING" => "insertBookingPerm",
			"UPDATE-BOOKING" => "updateBookingPerm",
		);


		// fetch max perm for one field
		if ($maxPermFieldsArr[$permName]) {

			$permVal = $this->fetchPermFromDb($maxPermFieldsArr[$permName], array("max" => true));
			$this->perms[$permName] = $permVal;

			return;
		}

	}  // eo fetch permission


	/**
	* Fetch permission for one field
	*/
	private function fetchPermFromDb($fieldName, $opts) {

		$fieldExpr = $fieldName ;

		if ($opts['max']) {
			$fieldExpr = "MAX({$fieldName})";
		}

		return Dbw::fetchValue1(
			"SELECT {$fieldExpr} FROM userGroup AS ug" .
			" INNER JOIN userToUserGroup utg ON utg.userGroupId=ug.userGroupId" .
			" WHERE utg.userId=:userId",
			array("userId" => $this->userId));

	}  // eo fetch perm for one field


	/**
	* Reset/update permissions
	* Simply set permissions to empty array.
	* Particular permissions will be fetched if needed.
	*/
	public function resetPermissions() {
		$this->perms = array();
	}  // eo reset perms



	/*
	* Save input
	* also used for changePassword!
	* @param $opts: updateUserToUserGroup: true or false. Defaults to false.
	*
	*/
	public static function saveInput($action, $values, $opts = array()) {

		// trim all values
		foreach ($values as $key => $value) {
			$values[$key] = trim($value);
		}

		$newVals = $values;
		$whereVals = array("userId" => $values['userId']);

		// superuser can disable the paranoia mode for given time (in minutes)
		if (Logon::$logon->user->hasPerm("SUPER") && $values['skipSignTimeout']) {
			$values['skipSignTimeout'] = min(30, $values['skipSignTimeout']);
			session_start();
			$_SESSION[Logon::$_id]['logon']->relaxedUserAdminTimeout = time() + ($values['skipSignTimeout'] * 60);
			session_write_close();
		}


		// only admin can do this, or user updates his own record
		if (!Logon::$logon->user->hasPerm("SUPER")) {

			// for non-admin user allow restricted update of some fields and for password changing
			if ($values['userId'] == Logon::$logon->user->userId && $action == "UPDATE") {
				$newVals = array_intersect_key($newVals, array(
					"userId" => null,
					//"logonName" => null,  // TODO rethink if this should be prohibited - only super can do for now
					"realName" => null,
					));
			}
			else {  // every thing else is reserved to admin
				throw new Exception(Oger::_("Sie benötigen Administrationsrechte für diesen Vorgang (user-save)."));
			}

			// recreate logon name from existing record (for later default checks)
			if ($oldRow = Dbw::fetchRow1("SELECT * FROM user WHERE userId=:userId", array("userId" => $values['userId']))) {
				$newVals['logonName'] = $oldRow['logonName'];
			}
		}

		// everything needs password of logged on user (from superuser too !!!)
		// as sign. This is not user-friendly, but secure. Can be relaxed from super ;-) in the user admin form
		if (Logon::$logon->user->hasPerm("SUPER") && time() <= Logon::$logon->relaxedUserAdminTimeout) {
			// we skip extra password check for this request
		}
		elseif (User::encryptPassword($values['oldPassword']) != Logon::$logon->user->password) {
			throw new Exception(Oger::_("Passwort des angemeldeten Users stimmt nicht."));
		}


		if (!$newVals['logonName']) {
			throw new Exception(Oger::_("Der Logon-Name darf nicht leer sein."));
		}


		// pre check password (e.g. new users need a password, check password repetition, etc)
		$isNewUser = ($action == "INSERT");
		static::setPassword($values, array("checkOnly" => true, "isNewUser" => $isNewUser));

		// store to db - never set password or ssl cert direct, but only via setPassword()
		unset($newVals['password']);
		unset($newVals['sslClientDN']);
		unset($newVals['sslClientIssuerDN']);
		static::store($action, $newVals, $whereVals);

		// recheck and set or change password
		static::setPassword($values, array("isNewUser" => $isNewUser));

		// set or update userToUserGroup assignment (admin only)
		if (Logon::$logon->user->hasPerm("SUPER") && $opts['updateUserToUserGroup']) {
			UserToUserGroup::saveUserGroupIdList($values['userId'], $values['userGroupIdList'], array("allowDelete" => true));
		}
	}  // eo save input




	/*
	* Set password or import ssl cert
	*/
	public static function setPassword($values, $opts = array()) {

		// only admin can do this, or user updates his own password or ssl cert
		if (!(Logon::$logon->user->hasPerm("SUPER") ||
					$values['userId'] == Logon::$logon->user->userId)) {
			throw new Exception(Oger::_("Sie benötigen Administrationsrechte für diesen Vorgang (changePwd)."));
		}

		// trim all values
		foreach ($values as $key => $value) {
			$values[$key] = trim($value);
		}


		$whereVals = array("userId" => $values['userId']);

		// check password repetition in all cases (even if empty)
		if ($values['newPassword'] !== $values['newPasswordRepeated']) {
			throw new Exception(Oger::_("Passwortwiederholung fehlerhaft."));
		}


		// new user needs password
		if ($opts['isNewUser'] && !$values['newPassword']) {
				throw new Exception(Oger::_("(Neues) Passwort für neuen User ist erforderlich."));
		}  // eo new user


		// for existing user or if superuser set password for another user
		// then check against existing password
		if (!$opts['isNewUser']) {

			$oldVals = Dbw::fetchRow1("SELECT * FROM user WHERE userId=:userId", $whereVals);

			// if values are unchanged, then we return here
			if (!$values['newPassword']
			  && $values['sslClientDN'] == $oldVals['sslClientDN']
			  && $values['sslClientIssuerDN'] == $oldVals['sslClientIssuerDN']
			) {
				return;
			}

			if (Logon::$logon->user->hasPerm("SUPER")
				&& $values['userId'] != Logon::$logon->user->userId
			) {
				// current user has super-perm and does not need to know password of selected user,
				// but must provide his own.
				if (User::encryptPassword($values['oldPassword']) != Logon::$logon->user->password) {
					throw new Exception(Oger::_("(Altes) Passwort (von aktuellem User!) stimmt nicht."));
				}
			}
			else {
				if (User::encryptPassword($values['oldPassword']) != $oldVals['password']) {
					throw new Exception(Oger::_("Altes Passwort stimmt nicht."));
				}
			}
		}  // eo update



		// stop here if only password check
		if ($opts['checkOnly']) {
			return;
		}


		// store password and/or ssl cert to db (and nothing else)
		$newVals = array();
		$newVals['userId'] = $values['userId'];

		if ($values['newPassword']) {
			$newVals['password'] = User::encryptPassword($values['newPassword']);
		}

		if ($values['importSslClientCert']) {

			$newVals['sslClientDN'] = trim($_SERVER['SSL_CLIENT_S_DN']);
			$newVals['sslClientIssuerDN'] = trim($_SERVER['SSL_CLIENT_I_DN']);

			if (!($newVals['sslClientDN'] && $newVals['sslClientIssuerDN'])) {
				throw new Exception(Oger::_("Kein gültiges SSL Client Zertifikat importiert."));
			}
		}
		else {
			$newVals['sslClientDN'] = $values['sslClientDN'];
			$newVals['sslClientIssuerDN'] = $values['sslClientIssuerDN'];
		}

		if (($newVals['sslClientDN'] && !$newVals['sslClientIssuerDN'])
			|| (!$newVals['sslClientDN'] && $newVals['sslClientIssuerDN'])
		) {
			throw new Exception(Oger::_("SSL Client Zertifikat benötigt sowohl 'Client DN' als auch 'Client Issuer DN'."));
		}


		// update user with password or ssl cert
		static::store("UPDATE", $newVals, $whereVals);

		if ($newVals['userId'] == Logon::$logon->user->userId && $newVals['password']) {
			Logon::$logon->user->userId->password = $newVals['password'];
		}
	}  // eo set password





}  // eo class



?>
