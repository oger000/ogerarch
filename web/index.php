<?PHP
/*
#LICENSE BEGIN
#LICENSE END
*/

// Skip logon check here. Only do init
$skipLogonCheck = true;
require_once("php/init.inc.php");


// if called without _LOGINID we create a new one and reload with that
if (!$_REQUEST['_LOGONID']) {
	$loginId = Logon::createLogonId();
	header("Location: index.php?_LOGONID={$loginId}");
	/* alternativly: <head><meta http-equiv="refresh" content="0; url=index.php?_LOGINID={$loginId}">
	 */
	exit;
}


$logonData = "null";  // string representation
$allowSslClientCertLogon = (int)Oger::connectionHasValidSslClientCert();
$appJsFilesFrom = "jslist-app.inc.php";

// if there is a valid logon we transfer existing logon data
if (Logon::isLogon()) {
	$logonData = json_encode(Logon::getLogonData());
	Dbw::checkStruct();  // recheck on app reload
}


require_once("index.inc.php");
