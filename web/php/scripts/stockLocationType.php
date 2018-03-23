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



// load list from database
if ($_REQUEST['_action'] == "loadGrid") {

	// get total count for current where values including remote filter
	$sql = StockLocationType12::getSql("GRIDCOUNT", $seleVals);
	$total = Dbw::fetchValue1($sql, $seleVals);

	// inc remote sort, filter, ...
	$seleVals = array();
	$sql = StockLocationType12::getSql("GRID", $seleVals);

	$pstmt = Dbw::checkedExecute($sql, $seleVals);
	$data = array();
	while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
		$data[] = $row;
	}
	$pstmt->closeCursor();

	echo Extjs::encData($data, $total);
	exit;

}  // eo loading list



// load one record from db
if ($_REQUEST['_action'] == "loadRecord") {

	$seleVals = array();
	$sql = StockLocationType12::getSql("FORM", $seleVals);

	$row = Dbw::fetchRow1($sql, $seleVals);
	if ($row === false) {
		echo Extjs::errorMsg(Oger::_("Datensatz nicht gefunden"));
		exit;
	}

	echo Extjs::encData($row);
	exit;
}  // eo loading one record



/*
* Save input
*/
if ($_REQUEST['_action'] == "save") {

	try {
		$row = StockLocationType12::storeInput($_REQUEST, $_REQUEST['dbAction']);
	}
	catch (Exception $ex) {
		echo Extjs::errorMsg($ex->getMessage());
		exit;
	}

	echo Extjs::encData($row);
	exit;
}  // eo save posted data to database


// load list as size combo from database
if ($_REQUEST['_action'] == "loadSizeCombo") {

	// get total count for current where values including remote filter
	/*
	$sql = StockLocationType12::getSql("SIZECOMBO", $seleVals);
	$total = Dbw::fetchValue1($sql, $seleVals);
	*/

	// inc remote sort, filter, ...
	$seleVals = array();
	$sql = StockLocationType12::getSql("SIZECOMBO", $seleVals);

	$pstmt = Dbw::checkedExecute($sql, $seleVals);
	$data = array();
	while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
		$data[] = $row;
	}
	$pstmt->closeCursor();

	echo Extjs::encData($data, $total);
	exit;

}  // eo loading list


?>
