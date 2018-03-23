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
if ($_REQUEST['_action'] == "loadGrid" || $_REQUEST['_action'] == "loadStockGrid") {

	$gridWhere =
		"     excavId=:excavId" .
		" AND stockLocationId=`?+:stockLocationId`" .
		" AND archFindId =`?+:archFindId`" .
		" AND archFindId LIKE `?+:archFindIdLike`" .
		"";

	$gridOrder =
		" `?=excavId,archFindIdSort,archFindSubIdSort`" .
		",`?archFindId=excavId,archFindIdSort,archFindSubIdSort`" .
		",`?stockLocationName=excavId,stockLocationId,archFindIdSort,archFindSubIdSort`" .
		"";

	// get total count for current where values including remote filter
	$seleVals = array();
	$sql = OgerExtjSqlTpl::_prepare(
		"SELECT COUNT(*) AS recordCount" .
		" FROM prepFindTMPNEW" .
		" WHERE {$gridWhere}",
		$seleVals);
	$total = Dbw::fetchValue1($sql, $seleVals);

	// inc remote sort, filter, ...
	$seleVals = array();
	$sql = OgerExtjSqlTpl::_prepare(
		"SELECT *," .
			"(SELECT name FROM stockLocation" .
			"  WHERE stockLocation.stockLocationId=prepFindTMPNEW.stockLocationId" .
			") AS stockLocationName" .
		" FROM prepFindTMPNEW" .
		" WHERE {$gridWhere}" .
		" ORDER BY {$gridOrder}",
		$seleVals);

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

	// remote sort, filter, ...
	$seleVals = array();
	$sql = OgerExtjSqlTpl::_prepare(
		"SELECT *," .
			"(SELECT name FROM stockLocation" .
			"  WHERE stockLocation.stockLocationId=prepFindTMPNEW.stockLocationId" .
			") AS stockLocationName" .
		" FROM prepFindTMPNEW" .
		" WHERE excavId=:excavId AND archFindId=:archFindId AND archFindSubId=:archFindSubId" .
		"", $seleVals);
	$row = Dbw::fetchRow1($sql, $seleVals);
	$row['stockLocFullName'] = StockLocation12::getFullName($row['stockLocationId']);

	echo Extjs::encData($row);
	exit;
}  // eo loading one record



/*
* Save input
*/
if ($_REQUEST['_action'] == "save" || $_REQUEST['_action'] == 'rename') {

	if ($_REQUEST['_action'] == "rename") {
		$_REQUEST['dbAction'] = "rename";
	}

	try {
		PrepFind12::storeInput($_REQUEST, $_REQUEST['dbAction'], array("removeRefs" => true));
	}
	catch (Exception $ex) {
		echo Extjs::errorMsg($ex->getMessage());
		exit;
	}

	echo Extjs::encData();
	exit;
}  // eo save posted data to database



/**
* delete prep find (and connections)
*/
if ($_REQUEST['_action'] == 'delete') {

	if (!$_REQUEST['excavId']) {
		echo Extjs::errorMsg(Oger::_("Grabungs-ID erforderlich."));
		exit;
	}
	if (!$_REQUEST['archFindId']) {
		echo Extjs::errorMsg(Oger::_("Fund-Nummer erforderlich."));
		exit;
	}
	if (!$_REQUEST['archFindSubId']) {
		echo Extjs::errorMsg(Oger::_("Fund-SubNummer erforderlich."));
		exit;
	}

	$whereVals = array("excavId" => $_REQUEST['excavId'],
		"archFindId" => $_REQUEST['archFindId'], "archFindSubId" => $_REQUEST['archFindSubId']);

	try {
		Dbw::checkedExecute(
			"DELETE FROM prepFindTMPNEW WHERE excavId=:excavId" .
			" AND archFindId=:archFindId AND archFindSubId=:archFindSubId", $whereVals);
	}
	catch (Exception $ex) {
		echo Extjs::errorMsg(Oger::_("Löschen fehlgeschlagen. Datenbankfehler: " . $ex->getMessage() . "."));
		exit;
	}

	// signal success
	echo Extjs::enc();

}  // eo delete



/*
* Save mass state change
*/
if ($_REQUEST['_action'] == "massSaveState") {

	$subDelim = ExcavHelper::$xidSubIdDelimiter;

	$stateFields = array(
		// status fields
		"washStatusId",
		"labelStatusId",
		"restoreStatusId",
		"photographStatusId",
		"drawStatusId",
		"layoutStatusId",
		"scientificStatusId",
		"publishStatusId",
		// material fields
		'ceramicsCountId',
		'animalBoneCountId',
		'humanBoneCountId',
		'ferrousCountId',
		'nonFerrousMetalCountId',
		'glassCountId',
		'architecturalCeramicsCountId',
		'daubCountId',
		'stoneCountId',
		'silexCountId',
		'mortarCountId',
		'timberCountId',
	);
	$stateFields = array_flip($stateFields);

	// remove "unchanged" states (value -1)
	foreach ($_REQUEST as $key => $value_) {
		if (array_key_exists($key, $stateFields) && $value_ == -1) {
			unset($_REQUEST[$key]);
		}
	}

	// if nothing changed there is no need to save anything
	foreach ($stateFields as $stateField => $dummy) {
		if (array_key_exists($stateField, $_REQUEST)) {
			$changeFieldCount++;
		}
	}
	if (!$changeFieldCount) {
		echo Extjs::errorMsg(Oger::_("Keine Verarbeitung erforderlich, weil keine Statusänderungen erfasst wurden."));
		exit;
	}

	// split out prep find and arch find ids
	// but do NOT sort or unify, because both lists has to be in sync

	$archFindIds = ExcavHelper::multiXidSplit($_REQUEST['archFindIdList']);
	if (!$archFindIds) {
		echo Extjs::errorMsg(Oger::_("Keine Fundnummern erfasst."));
		exit;
	}


	$okIds = array();
	$errMsg = "";
	foreach ($archFindIds as $archFindIdSubId) {

		list($archFindId, $archFindSubId) = ExcavHelper::xidSubIdSplit($archFindIdSubId);
		$whereVals = array("excavId" => $_REQUEST['excavId'],
			"archFindId" => $archFindId, "archFindSubId" => $archFindSubId);

		$oldCount = Dbw::fetchValue1(
			"SELECT COUNT(*) FROM prepFindTMPNEW WHERE excavId=:excavId" .
			" AND archFindId=:archFindId AND archFindSubId=:archFindSubId",
			$whereVals);
		if (!$oldCount) {
			$errMsg .= Oger::_("* {$archFindId}{$subDelim}{$archFindSubId}: Unbekannte Fundnummer{$subDelim}Subnummer.\n\n");
			continue;
		}

		$_REQUEST['archFindId'] = $archFindId;
		$_REQUEST['archFindSubId'] = $archFindSubId;
		try {
			PrepFind12::storeInput($_REQUEST, "UPDATE", $whereVals);
			$okIds[] = "{$archFindId}{$subDelim}{$archFindSubId}";
		}
		catch (Exception $ex) {
			$errMsg .= "* {$archFindId}{$subDelim}{$archFindSubId}: " . Extjs::errorMsg($ex->getMessage()) . "\n\n";
		}
	}

	$okMsg = implode(", ", $okIds);
	echo Extjs::encData(array("okMsg" => $okMsg, "errorMsg" => $errMsg));
	exit;
}  // eo mass edit




/*
* Mass move of arch finds to another location
*/
if ($_REQUEST['_action'] == "movePrepFindLoc") {

	// prepare prep find internal ids
	$archFindIds = ExcavHelper::multiXidSplit($_REQUEST['archFindIdList']);

	if (!$archFindIds) {
		echo Extjs::errorMsg(Oger::_("Keine Verarbeitung erforderlich, weil keine Funde verschoben wurden."));
		exit;
	}

	// check if target location can contain arch finds directly
	$loc = Dbw::fetchRow1(
		"SELECT * FROM stockLocation WHERE stockLocationId=:id",
		array("id" => $_REQUEST['moveTo']));
	if (!$loc['canItem']) {
		echo Extjs::errorMsg(Oger::_("Der Ziel-Lagerort '{$loc['name']}' kann Funde nicht direkt aufnehmen."));
		exit;
	}

	$_REQUEST['stockLocationId'] = $_REQUEST['moveTo'];
	try {
		foreach ($archFindIds as $archFindIdSubId) {
			list($_REQUEST['archFindId'], $_REQUEST['archFindSubId']) = ExcavHelper::xidSubIdSplit($archFindIdSubId);
			PrepFind12::storeInput($_REQUEST, "UPDATE");
			$updateCount++;
		}
	}
	catch (Exception $ex) {
		echo Extjs::errorMsg($ex->getMessage());
		exit;
	}

	echo Extjs::encData(array("updateCount" => $updateCount));
	exit;
}  // eo mass move



?>
