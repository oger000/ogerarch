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


	$gridWhere .=
		"(name LIKE `?+:filterText`" .
		")";

	$gridOrder =
		" `?=name`" .
		",`?userGroupId`" .
		",`?name`" .
		"";

	// get total count for current where values
	$seleVals = array();
	$sql = OgerExtjSqlTpl::_prepare(
		"SELECT COUNT(*) AS recordCount" .
		" FROM userGroup" .
		" WHERE {$gridWhere}",
		$seleVals);
	$total = Dbw::fetchValue1($sql, $seleVals);

	// remote sort, filter, ...
	$seleVals = array();
	$sql = OgerExtjSqlTpl::_prepare(
		"SELECT *" .
		" FROM userGroup" .
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

	// only admin can do this
	if (!(Logon::$logon->user->hasPerm("SUPER"))) {
		echo Extjs::errorMsg(Oger::_("Sie benötigen Administrationsrechte für diesen Vorgang."));
		exit;
	}  // eo permission check


	// remote sort, filter, ...
	$seleVals = array();
	$sql = OgerExtjSqlTpl::_prepare(
		"SELECT *" .
		" FROM userGroup" .
		" WHERE userGroupId=:userGroupId",
		$seleVals);

	$pstmt = Dbw::checkedExecute($sql, $seleVals);
	$row = $pstmt->fetch(PDO::FETCH_ASSOC);
	$pstmt->closeCursor();

	unset($row['password']);  // hide password
	echo Extjs::encData($row);
	exit;
}  // eo load form



/*
* Save input
* Only admin can do this. Permission is checked in saveInput
*/
if ($_REQUEST['_action'] == "INSERT" || $_REQUEST['_action'] == "UPDATE") {

	try {
		UserGroup::saveInput($_REQUEST['_action'], $_REQUEST);
		echo Extjs::enc();
	}
	catch (Exception $ex) {
		echo Extjs::errorMsg($ex->getMessage());
		exit;
	}
	exit;
}  // eo save input



/*
* delete
*/
if ($_REQUEST['_action'] == "delete") {

	// only admin can do this
	if (!Logon::$logon->user->hasPerm("SUPER")) {
		echo Extjs::errorMsg(Oger::_("Sie benötigen Administrationsrechte für diesen Vorgang."));
		exit;
	}  // eo permission check

	try {
		$pstmt = Dbw::$conn->prepare("DELETE FROM userGroup WHERE userGroupId=:userGroupId");
		$pstmt->execute(array("userGroupId" => $_REQUEST['userGroupId']));
	}
	catch (Exception $ex) {
		echo Extjs::errorMsg($ex->getMessage());
		exit;
	}

	echo Extjs::msg(sprintf(Oger::_("%s Datensätze gelöscht."), $pstmt->rowCount()));
	exit;
}  // eo delete





echo Extjs::errorMsg("Invalid request action '{$_REQUEST['_action']}' in " . __FILE__);
exit;


?>
