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
* User group class
*/
class UserGroup extends DbRec {

	public static $tableName = "userGroup";


	// ###################################



	/*
	* Save input
	*/
	public static function saveInput($action, $values) {

		// trim all values
		foreach ($values as $key => $value) {
			$values[$key] = trim($value);
		}

		// only admin can edit user groups
		if (!(Logon::$logon->user->hasPerm("SUPER"))) {
			throw new Exception(Oger::_("Sie benötigen Administrationsrechte für diesen Vorgang (usergroup-save)."));
		}

		// everything needs password of logged on user (from superuser too !!!)
		// as sign. This is not user-friendly, but secure. Can be relaxed from super ;-) in the user admin form
		if (Logon::$logon->user->hasPerm("SUPER") && time() <= Logon::$logon->relaxedUserAdminTimeout) {
			// we skip extra password check for this request
		}
		elseif (User::encryptPassword($values['oldPassword']) != Logon::$logon->user->password) {
			throw new Exception(Oger::_("Passwort des angemeldeten Users stimmt nicht."));
		}

		if (!$values['name']) {
			throw new Exception(Oger::_("Der User Gruppen Name darf nicht leer sein."));
		}


		if ($action == "UPDATE") {
			$whereVals = array("userGroupId" => $values['userGroupId']);
		}

		static::store($action, $values, $whereVals);
	}  // eo save input





}  // eo class



?>
