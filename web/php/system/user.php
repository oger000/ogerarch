<?php
/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/

require_once(__DIR__ . "/../init.inc.php");


/**
* Load for grid
*/
if ($_REQUEST['_action'] == "loadGrid") {

	// only admin can do this
	if (!Logon::$logon->user->hasPerm("SUPER")) {
		echo Extjs::errorMsg(Oger::_("Sie benötigen Administrationsrechte für diesen Vorgang."));
		exit;
	}  // eo permission check


	$gridWhere =
		"(logonName LIKE `?+:filterText`" .
		" OR realName LIKE `?+:filterText`" .
		")";

	$gridOrder =
		" `?=logonName`" .
		",`?userId`" .
		",`?logonName`" .
		",`?realName`" .
		",`?logonPerm`" .
		",`?superPerm`" .
		"";

	// get total count for current where values
	$seleVals = array();
	$sql = OgerExtjSqlTpl::_prepare(
		"SELECT COUNT(*) AS recordCount" .
		" FROM user" .
		" WHERE {$gridWhere}",
		$seleVals);
	$total = Dbw::fetchValue1($sql, $seleVals);

	// remote sort, filter, ...
	$seleVals = array();
	$sql = OgerExtjSqlTpl::_prepare(
		"SELECT *" .
		" FROM user" .
		" WHERE {$gridWhere}" .
		" ORDER BY {$gridOrder}" .
		" LIMIT `?start`,`?limit`",
		$seleVals);

	$pstmt = Dbw::checkedExecute($sql, $seleVals);
	$data = array();
	while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
		unset($row['password']);  // hide password
		$data[] = $row;
	}
	$pstmt->closeCursor();

	echo Extjs::encData($data, $total);
	exit;
}  // eo load grid



/**
* Load for form
*/
if ($_REQUEST['_action'] == "loadForm") {

	// only admin can do this, or user loads his own record
	if (!(Logon::$logon->user->hasPerm("SUPER") ||
				$_REQUEST['userId'] == Logon::$logon->user->userId)) {
		echo Extjs::errorMsg(Oger::_("Sie benötigen Administrationsrechte für diesen Vorgang."));
		exit;
	}  // eo permission check


	// remote sort, filter, ...
	$seleVals = array();
	$sql = OgerExtjSqlTpl::_prepare(
		"SELECT *" .
		" FROM user" .
		" WHERE userId=:userId",
		$seleVals);

	$pstmt = Dbw::checkedExecute($sql, $seleVals);
	$row = $pstmt->fetch(PDO::FETCH_ASSOC);
	$pstmt->closeCursor();

	// hide password
	unset($row['password']);

	// add user group id list
	$row['userGroupIdList'] = UserToUserGroup::getUserGroupIdList($_REQUEST['userId']);

	echo Extjs::encData($row);
	exit;
}  // eo load form



/*
* Save input
* only admin can do this or logon user can change some fields
* (uncluding password). Permission is checked in saveInput
*/
if ($_REQUEST['_action'] == "INSERT" || $_REQUEST['_action'] == "UPDATE") {

	try {
		User::saveInput($_REQUEST['_action'], $_REQUEST, array("updateUserToUserGroup" => true));
		echo Extjs::enc();
	}
	catch (Exception $ex) {
		echo Extjs::errorMsg($ex->getMessage());
		exit;
	}
	exit;
}  // eo save input


/*
* change password (only for admin or currenlty loged on user)
*/
if ($_REQUEST['_action'] == "changePassword") {
	$_REQUEST['userId'] = Logon::$logon->user->userId;
	try {
		User::setPassword($_REQUEST);
		echo Extjs::enc();
	}
	catch (Exception $ex) {
		echo Extjs::errorMsg($ex->getMessage());
		exit;
	}
	exit;
}




/*
* delete
*/
if ($_REQUEST['_action'] == "delete") {

	// only admin can do this
	if (!Logon::$logon->user->hasPerm("SUPER")) {
		echo Extjs::errorMsg(Oger::_("Sie benötigen Administrationsrechte für diesen Vorgang."));
		exit;
	}  // eo permission check

	// user cannot delete itself
	if ($_REQUEST['userId'] == Logon::$logon->user->userId) {
		echo Extjs::errorMsg(Oger::_("Der aktuelle User kann sich nicht selbst löschen."));
		exit;
	}

	try {
		$pstmt = Dbw::$conn->prepare("DELETE FROM user WHERE userId=:userId");
		$pstmt->execute(array("userId" => $_REQUEST['userId']));
	}
	catch (Exception $ex) {
		echo Extjs::errorMsg($ex->getMessage());
		exit;
	}


	echo Extjs::msg(sprintf(Oger::_("%s Datensätze gelöscht."), $pstmt->rowCount()));
	exit;
}  // eo delete



/**
* Load assigned user groups
*/
if ($_REQUEST['_action'] == "loadAssignedUserGroupGrid") {

	// get total count for current where values
	$seleVals = array();
	$sql = OgerExtjSqlTpl::_prepare(
		"SELECT COUNT(*) AS recordCount" .
		" FROM userToUserGroup" .
		" WHERE userId=:userId",
		$seleVals);
	$total = Dbw::fetchValue1($sql, $seleVals);

	// remote sort, filter, ...
	$seleVals = array();
	$sql = OgerExtjSqlTpl::_prepare(
		"SELECT *" .
		" FROM userToUserGroup AS utg" .
		" INNER JOIN userGroup AS ug" .
		"   ON utg.userGroupId=ug.userGroupId" .
		" WHERE utg.userId=:userId" .
		" ORDER BY ug.name" .
		" LIMIT `?start`,`?limit`",
		$seleVals);

	$pstmt = Dbw::checkedExecute($sql, $seleVals);
	$data = array();
	while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
		$data[] = $row;
	}
	$pstmt->closeCursor();

	echo Extjs::encData($data, $total);
	exit;
}  // eo load assigned groups


/**
* Load available / non-assigned user groups
*/
if ($_REQUEST['_action'] == "loadAvailableUserGroupGrid") {

	// only admin sees available groups
	if (!Logon::$logon->user->hasPerm("SUPER")) {
		echo Extjs::encData(array(), 0);
		exit;
	}

	// get total count for current where values
	$seleVals = array();
	$sql = OgerExtjSqlTpl::_prepare(
		"SELECT COUNT(*) AS recordCount" .
		" FROM userGroup AS ug" .
		" WHERE NOT EXISTS" .
		"   ( SELECT 1 " .
		"     FROM userToUserGroup AS utg" .
		"     WHERE utg.userGroupId=ug.userGroupId" .
		"           AND utg.userId=:userId" .
		"    )" .
		"",
		$seleVals);
	$total = Dbw::fetchValue1($sql, $seleVals);

	// remote sort, filter, ...
	$seleVals = array();
	$sql = OgerExtjSqlTpl::_prepare(
		"SELECT *" .
		" FROM userGroup AS ug" .
		" WHERE NOT EXISTS" .
		"   ( SELECT 1 " .
		"     FROM userToUserGroup AS utg" .
		"     WHERE utg.userGroupId=ug.userGroupId" .
		"           AND utg.userId=:userId" .
		"    )" .
		" ORDER BY ug.name" .
		" LIMIT `?start`,`?limit`" .
		"",
		$seleVals);

	$pstmt = Dbw::checkedExecute($sql, $seleVals);
	$data = array();
	while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
		$data[] = $row;
	}
	$pstmt->closeCursor();

	echo Extjs::encData($data, $total);
	exit;
}  // eo load available groups



echo Extjs::errorMsg("Invalid request action '{$_REQUEST['_action']}' in " . __FILE__);
exit;


?>
