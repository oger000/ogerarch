<?php
/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Class to handle user logon.
* Info: Static members of an object are not serialized.
* This class has highly dependencies to the user class.
*/
class Logon {

	public static $_id;
	public static $logon;  // hold instance

	public $user;
	public $time;
	public $relaxedUserAdminTimeout;

	public $dbDefAliasId;
	public $dbDefHash;


	/**
	* Check if logon is present
	*/
	public static function isLogon() {

		// if no logon exists at all for this user session id we fail.
		// the logon info is assigned from init.
		if (!static::$logon) {
			return false;
		}

		// if the hash of the database definition stanza changed
		// we force a new logon to avoid cross database logon hijacking
		if (static::$logon->dbDefHash !=
				static::getDbDefHash(Config::$dbDefs[static::$logon->dbDefAliasId])) {
			//throw new Exception("Cross logon violation (DbDefHash)");
			return false;
		}

		return true;
	}  // eo is logon


	/**
	* Check logon and exit if not
	*/
	public static function checkLogon() {

		global $skipLogonCheck;

		// if skip of logon check is requested return here
		if ($skipLogonCheck) {
			// Only skip once. For another skip you have to set again.
			$skipLogonCheck = false;
			return true;
		}

		// check for valid logon for this login user session id
		if (static::isLogon()) {
			return true;
		}

		// if check failed than exit
		$logonId = static::$_id;
		echo Extjs::errorMsg("Logon invalid or logon timed out for logonID $logonId.");
		exit;
	}  // eo check logon


	/**
	* Handle logon request
	*/
	public static function handleLogon($logonName, $password, $dbDefAliasId, $opts = array()) {

		// open database and check structure
		Dbw::openDbAliasId($dbDefAliasId);
		Dbw::checkStruct();

		// if no user is present then create the initial user
		$userCount = Dbw::fetchValue1("SELECT COUNT(*) FROM user");
		if (!$userCount) {
			if (!trim(Config::$initialUser['logonName'])) {
				echo Extjs::errorMsg(Oger::_("Kein User gefunden und kein Initialuser konfiguriert."));
				exit;
			}
			$initName = trim(Config::$initialUser['logonName']);
			User::store("INSERT",
									array('logonName' => $initName,
												'realName' => Config::$initialUser['realName'],
												'password' => User::encryptPassword(trim(Config::$initialUser['password']) ?: $initName),
												'logonPerm' => 1,
												'superPerm' => 1,
												));
		}  // eo create initial user


		// fetch user from db and set values on user object
		$userRow = Dbw::fetchRow1("SELECT * FROM user WHERE logonName=:logonName", array("logonName" => trim($logonName)));
		if (!$userRow) {
			echo Extjs::errorMsg(Oger::_("Anmeldung fehlgeschlagen (12IU4)."));
			exit;
		}
		$user = new User();
		$user->initValues($userRow['userId']);

		// do authentification
		$authOk = false;
		$password = trim($password);

		// user must exist and must have logon permission
		if ($user->hasPerm("LOGON")) {

			// autologon does not need any auth
			if (!$authOk && $opts["autoLogon"]) {
				$authOk = true;
			}
			else {
				$invalidMsg .= "+NAU";  // no auto login
			}

			// ssl client certificate
			if (!$authOk && $opts['sslCertLogon']) {

				// ssl certificate is valid and accepted by browser
				if (Oger::connectionHasValidSslClientCert()) {

					// ssl cert DN matches stored ssl cert
					if (trim($_SERVER['SSL_CLIENT_S_DN']) == trim($user->sslClientDN)
						  && trim($_SERVER['SSL_CLIENT_I_DN']) == trim($user->sslClientIssuerDN)) {
						$authOk = true;
					}
					else {
						$invalidMsg .= "+IC";   // invalid cert
					}
				}
			}

			// TODO: pam-auth and open-id??
			if (!$authOk) {
				//
			}

			// at last resort check local password if given. Do not allow empty passwords!
			if (!$authOk) {
				if ($password) {
					if (User::encryptPassword($password) == trim($user->password)) {
						$authOk = true;
					}
					else {
						$invalidMsg .= "+IP";   // invalid password
					}
				}
				else {
					$invalidMsg .= "+EPR";   // empty password in request
				}
			}  // password check
		}  // eo has logon perm

		else {
			$invalidMsg .= "+NLP";  // no login perm
		} // end of auth

		// if logon failed, than return error message and abort
		if (!$authOk) {
			echo Extjs::errorMsg(Oger::_("Anmeldung fehlgeschlagen (18IA{$invalidMsg}7)."));
			exit;
		}

		// on success set authentificated user to session
		static::toSession($dbDefAliasId, $user);


		// return logon data
		return static::getLogonData();

	}  // end of handle logon


	/**
	* Get logon data from valid logon session.
	*/
	public static function getLogonData() {

		return array(
			"logonId" => static::$_id,
			"dbName" => Config::$dbDefs[static::$logon->dbDefAliasId]['displayName'] .
									" (" . static::$logon->dbDefAliasId . ")",
			"userId" => static::$logon->user->userId,
			"userName" => (static::$logon->user->realName ?: static::$logon->user->logonName),
			"fiscalYear" => number_format(static::$logon->fiscalYear, 1, ".", ""),
			"time" => date("c", static::$logon->time),
		);
	}  // get logon data


	/**
	* Set logon to session
	*/
	public static function toSession($dbDefAliasId, $user) {

		static::logoff();

		static::$_id = static::createLogonId();

		static::$logon = new static();
		static::$logon->dbDefAliasId = $dbDefAliasId;
		static::$logon->dbDefHash = static::getDbDefHash(Config::$dbDefs[$dbDefAliasId]);

		static::$logon->user = $user;

		static::$logon->fiscalYear = $_REQUEST['fiscalYear'];  // TODO force valid fiscal year ???
		static::$logon->time = time();

		// store logon info
		$_SESSION[static::$_id]['logon'] = static::$logon;
	}  // eo set logon to session


	/**
	* Create logon user session id
	* ATTENTION: Session variables must follow the rules of normal
	* variale name - so the key cannot be numeric. There is no error
	* message about this, but numeric keys are lost on the next session start.
	* (see https://bugs.php.net/bug.php?id=44545)
	*/
	public static function createLogonId() {
		//return sha1(var_export($logon, true) . rand());
		//return time() - strtotime("midnight");
		$logonId = $_SESSION['maxLogonId'] + 1;
		$_SESSION['maxLogonId'] = $logonId;
		return "_{$logonId}";
	}  // eo create



	/**
	* Do auto logon
	*/
	public static function autoLogon($dbDefAliasId) {

		// get dbDef of autologin database and corresponding auto logon user id
		$logonName = trim(Config::$dbDefs[$dbDefAliasId]["autoLogonUser"]);

		// if no autologin user id is present for requested database than stop here
		if (!$logonName) {
			echo Extjs::errorMsg(Oger::_("Keine automatische Anmeldung möglich."));
			exit;
		}

		return static::handleLogon($logonName, null, $dbDefAliasId, array("autoLogon" => true));
	}  // eo do autologon


	/**
	 * Create hash for database definition
	 */
	public static function getDbDefHash($dbDef) {
		return sha1(var_export($dbDef, true));
	}  // eo db def hash



	/**
	 * Log off the current user session
	 */
	public static function logoff() {
		if (static::$_id && $_SESSION[static::$_id]) {
			unset($_SESSION[static::$_id]);
		}
	}  // eo logoff



}  // end of class


?>
