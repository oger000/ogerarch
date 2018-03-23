<?php
/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/

// Skip logon check here. Only do init
$skipLogonCheck = true;
require_once(__DIR__ . "/../init.inc.php");



/*
* Load db list for db selection
*/
if ($_REQUEST['_action'] == "loadDbDefList") {

	$data = array();

	// collect choosable databases from dbDefs
	foreach (Config::$dbDefs as $dbDefId => $dbDef) {
		if (!$dbDef['visible']) {
			continue;
		}
		$data[] = array(
			"dbDefId" => $dbDefId,
			"name" => ($dbDef['displayName'] ?: $dbDefId),
			"autoLogonUser" => trim($dbDef['autoLogonUser']),
		);
	}  // dbdef loop


	// return available databases
	echo Extjs::encData($data);
	exit;
}  // eo avail db list



/*
* do logon
*/
if ($_REQUEST['_action'] == "logon") {

	// try autologon if requested from logon form
	Oger::sessionRestart();
	if ($_REQUEST['autoLogon']) {
		$logonData = Logon::autoLogon($_REQUEST['dbDefAliasId']);
	}
	else {
		$logonData = Logon::handleLogon(
			$_REQUEST['logonName'], $_REQUEST['password'],
			$_REQUEST['dbDefAliasId'], array("sslCertLogon" => $_REQUEST['sslCertLogon']));
	}

	// if the script has not aborted till here, then
	// logon was successfull. So return logon data
	echo Extjs::encData($logonData);
	exit;
}  // eo logon action



/*
* check logon
*/
if ($_REQUEST['_action'] == "checkLogon") {
	// a debian cronjob deletes session file regulary
	// i hope we can work around that with this
	Oger::sessionRestart();
	$_SESSION['keep-alive'] = time();
	echo Extjs::enc(array('isLogon' => Logon::isLogon()));
	exit;
}  // eo check logon



/*
* do logoff
*/
if ($_REQUEST['_action'] == "logoff") {
	Oger::sessionRestart();
	unset($_SESSION[Logon::$_id]);
	echo Extjs::encData(array('logonId' => Logon::$_id));
	exit;
}  // eo logoff



/*
* has permission
*/
if ($_REQUEST['_action'] == "hasPerm") {
	$hasPerm = Logon::$logon->user->hasPerm($_REQUEST['perm']);
	echo Extjs::enc(array("hasPerm" => $hasPerm));
	exit;
}  // eo has perm


/*
* reset permissions
*/
if ($_REQUEST['_action'] == "resetPerms") {
	Logon::$logon->user->resetPermissions();
	echo Extjs::enc();
	exit;
}  // eo has perm


/*
* load current ssl client cert data
*/
if ($_REQUEST['_action'] == "loadCurrentSslClientCertData") {

	if (!Oger::connectionHasValidSslClientCert()) {
		echo Extjs::errorMsg(Oger::_("Kein gültiges SSL Client Zertifikat gefunden."));
		exit;
	}

	echo Extjs::encData(array(
		"sslClientDN" => $_SERVER['SSL_CLIENT_S_DN'],
		"sslClientIssuerDN" => $_SERVER['SSL_CLIENT_I_DN'],
	));
	exit;
}  // eo has perm



echo Extjs::errorMsg("Invalid request action '{$_REQUEST['_action']}' in " . __FILE__);
exit;



?>
