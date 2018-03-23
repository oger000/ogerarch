<?php
/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/

require_once(__DIR__ . '/../init.inc.php');



// load list from database
if ($_REQUEST['_action'] == "loadList") {

	// get total count for current where values including remote filter
	$sql = ArchFind12::getSql("GRIDCOUNT", $seleVals);
	$total = Dbw::fetchValue1($sql, $seleVals);

	// inc remote sort, filter, ...
	$seleVals = array();
	$sql = ArchFind12::getSql("GRID", $seleVals);
//@file_put_contents("debug.localonly", "sql=$sql\n" . var_export($seleVals, true) . "\n\n", FILE_APPEND);

	$pstmt = Dbw::checkedExecute($sql, $seleVals);
	$data = array();
	while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
		$data[] = ArchFind12::prep4Extjs($row);
	}
	$pstmt->closeCursor();

	echo Extjs::encData($data, $total);
	exit;

}  // eo loading list



// load one record from db
if ($_REQUEST['_action'] == "loadRecord" ||
		$_REQUEST['_action'] == "jumpOffset" || $_REQUEST['_action'] == "jumpOffsetFilter") {

	$sqlTarget = "FORM";
	$notFoundMsg = Oger::_("Fundnummer {$_REQUEST['archFindId']} nicht gefunden.");

	if ($_REQUEST['_action'] == "jumpOffset" || $_REQUEST['_action'] == "jumpOffsetFilter") {

		$notFoundMsg = "Keine weiteren Datensätze in diese Richtung gefunden.";

		$_REQUEST['archFindIdSort'] = Oger::getNatSortId($_REQUEST['archFindId']);

		if ($_REQUEST['__OFFSET__'] > 0) {
			$sqlTarget = "FORM-OFFSET-NEXT";
			$orderDir = "ASC";
		}
		else {
			$sqlTarget = "FORM-OFFSET-PREV";
			$orderDir = "DESC";
		}

		if ($_REQUEST['_action'] == "jumpOffsetFilter") {
			$sqlTarget .= "-FILTER";
		}

		// overwrite extjs sort - always sort by master-id / default order
		$_REQUEST['sort'] = array("archFindId" => $orderDir);

		$_REQUEST['start'] = abs($_REQUEST['__OFFSET__']) - 1;
		$_REQUEST['limit'] = 1;
	}  // eo jump


	// remote sort, filter, ...
	$sql = ArchFind12::getSql($sqlTarget, $seleVals);
	$pstmt = Dbw::checkedExecute($sql, $seleVals);
	$row = $pstmt->fetch(PDO::FETCH_ASSOC);
	$pstmt->closeCursor();

	if ($row === false) {
		echo Extjs::errorMsg($notFoundMsg);
		exit;
	}

	echo Extjs::encData(ArchFind12::prep4Extjs($row));
	exit;
}  // eo loading one record



/*
* Save input
*/
if ($_REQUEST['_action'] == "save") {

	try {
		$row = ArchFind12::storeInput($_REQUEST, $_REQUEST['dbAction'], array("removeRefs" => true));
	}
	catch (Exception $ex) {
		echo Extjs::errorMsg($ex->getMessage());
		exit;
	}

	echo Extjs::encData($row);
	exit;
}  // eo save posted data to database



/*
* Print arch find sheet (single form)
*/
if ($_REQUEST['_action'] == 'printFindSheet') {

	$_REQUEST['numCopies'] = max(0 + $_REQUEST['numCopies'], 1);
	$findSheets[] = array('excavId' => $_REQUEST['excavId'], 'archFindId' => $_REQUEST['archFindId'],
												'numCopies' => $_REQUEST['numCopies']);
	ArchFind::printArchFindSheets($findSheets);
	exit;
}  // eo print single arch find sheet


/*
* Print arch find sheet (multi sheets)
*/
if ($_REQUEST['_action'] == 'printMultiFindSheets') {

	$findSheets = array();
	for ($i = 0; $i <= 9 ; $i++) {
		$findSheets[] = array('excavId' => $_REQUEST['excavId'],
													'archFindId' => $_REQUEST['archFindId' . $i],
													'numCopies' => $_REQUEST['numCopies'. $i]);
	}

	ArchFind::printArchFindSheets($findSheets);
	exit;
}  // eo print multiple arch find sheet


/*
* Print arch find sheet (massprint)
*/
if ($_REQUEST['_action'] == 'massPrintFindSheets') {

	$oldTimeLimit = ini_get('max_execution_time');

	if (!$_REQUEST['excavId']) {
		echo Oger::_("Bitte Grabung für Fundzettel auswählen.");
		exit;
	}

	$findSheets = array();

	$whereVals = array();
	$whereVals['excavId'] = $_REQUEST['excavId'];

	if ($_REQUEST['beginId']) {
		$whereVals['archFindId#SIGNED,>=,beginId'] = $_REQUEST['beginId'];
	}
	if ($_REQUEST['endId']) {
		$whereVals['archFindId#SIGNED,<=,endId'] = $_REQUEST['endId'];
	}
	if ($_REQUEST['beginDate']) {
		$whereVals['date,>='] = $_REQUEST['beginDate'];
	}
	if ($_REQUEST['endDate']) {
		$whereVals['date,<='] = $_REQUEST['endDate'];
	}

	$stmt = "SELECT * FROM " . ArchFind::$tableName;
	$pstmt = Db::prepare($stmt, $whereVals, " ORDER BY excavId,0+archFindId");
	$whereVals = Db::getCleanWhereVals($whereVals);
	$pstmt->execute($whereVals);
	while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
		$findSheet = array();
		$archFind = new ArchFind($row);

		$findSheet['values'] = $archFind->getFindSheetValues(array('skipFromDb' => true));

		$numCopies = 0;
		if ($_REQUEST['sheetPerFindCategory']) {
			foreach(ArchFind::$findItemFields as $fieldName) {
				if ($archFind->values[$fieldName]) {
					$numCopies++;
				}
			}
			if ($archFind->values['specialArchFind']) {
				$numCopies++;
			}
			if ($archFind->values['organic']) {
				$numCopies++;
			}
			if ($archFind->values['archFindOther']) {
				$numCopies++;
			}
		}

		if ($_REQUEST['sheetPerSampleCategory']) {
			foreach(ArchFind::$sampleItemFields as $fieldName) {
				if ($archFind->values[$fieldName]) {
					$numCopies++;
				}
			}
			if ($archFind->values['sampleOther']) {
				$numCopies++;
			}
		}

		$numCopies *= $_REQUEST['numCopies'];
		$findSheet['numCopies'] = max($numCopies, $_REQUEST['numCopies']);

		$findSheets[] = $findSheet;

		set_time_limit($oldTimeLimit);
	}

	ArchFind::printPreparedArchFindSheets($findSheets);
	exit;
}  // eo print multiple arch find sheet



/*
* Print empty arch find sheet
*/
if ($_REQUEST['_action'] == 'printEmptyFindSheet') {

	$tpl = PdfTemplate::getTemplate('ArchFindSheet');

	$record = ArchFind::newFromDb();
	foreach (ArchFind::$fieldNames as $fieldName) {
		$record->values[$fieldName] = '';
	}

	if ($_REQUEST['excavationOut']) {
		$record->values['excavId'] = $_REQUEST['excavId'];
	}

	$values = $record->getFindSheetValues(array('skipFromDb' => true));
	if (!$_REQUEST['companyOut']) {
		$values['companyShortName'] = '';
	}
	if ($_REQUEST['dateOut']) {
		$values['date'] =  $_REQUEST['date'];
	}
	else {
		$values['date'] =  '';
	}

	$findSheets[] = array('values' => $values, 'numCopies' => $_REQUEST['numCopies']);
	ArchFind::printPreparedArchFindSheets($findSheets);
	exit;
} // eo print empty arch find sheet



/*
* Get new arch find id
*/
if ($_REQUEST['_action'] == 'getNewArchFindId') {

	$whereVals['excavId'] = $_REQUEST['excavId'];
	$pstmt = Db::prepare("SELECT MAX(0+archFindId) FROM " . ArchFind::$tableName, $whereVals);
	$pstmt->execute($whereVals);
	$maxArchFindId = $pstmt->fetchColumn();
	$pstmt->closeCursor();

	$data['newArchFindId'] = $maxArchFindId + 1;

	echo Extjs::encData($data);
	exit;
}  // eo get new arch find id



/**
* rename arch find (and connections)
*/
if ($_REQUEST['_action'] == 'rename') {

	if (!$_REQUEST['excavId']) {
		echo Extjs::errorMsg(Oger::_("Grabungs-ID erforderlich."));
		exit;
	}
	if (!$_REQUEST['oldArchFindId']) {
		echo Extjs::errorMsg(Oger::_("Alte Fund-Nummer erforderlich."));
		exit;
	}
	if (!$_REQUEST['archFindId']) {
		echo Extjs::errorMsg(Oger::_("Neue Fund-Nummer erforderlich."));
		exit;
	}
	if ($err = ExcavHelper::xidValidErr($_REQUEST['archFindId'])) {
		echo Extjs::errorMsg($err);
		exit;
	}

	if (Dbw::fetchValue1(
				"SELECT COUNT(*) FROM archFind WHERE excavId=:excavId AND archFindId=:archFindId",
				array("excavId" => $_REQUEST['excavId'], "archFindId" => $_REQUEST['archFindId'])) > 0) {
		// allow change in letter case ???
		if (trim(strtoupper($_REQUEST['archFindId'])) != trim(strtoupper($_REQUEST['oldArchFindId']))) {
			echo Extjs::errorMsg(Oger::_("Neue Fundnummer ist breits vorhanden - Umbenennen fehlgeschlagen."));
			exit;
		}
	}

	Dbw::$conn->beginTransaction();
	try {
		$values = array("excavId" => $_REQUEST['excavId'], "archFindId" => $_REQUEST['archFindId'],
										"archFindIdSort" => Oger::getNatSortId($_REQUEST['archFindId']),
										"oldArchFindId" => $_REQUEST['oldArchFindId']);
		$where = " WHERE excavId=:excavId AND archFindId=:oldArchFindId ";

		Dbw::checkedExecute(
			"UPDATE archFind SET archFindId=:archFindId, archFindIdSort=:archFindIdSort {$where}",
			$values);
		unset($values['archFindIdSort']);  // id sort not used from now on


		$stmt = "UPDATE stratumToArchFind SET archFindId=:archFindId {$where}";
		if ($_REQUEST['renameStratum']) {
			// force rename without additional checks
		}
		else {
			// rename only if link becomes unconnected (corresponding stratum does not exist)
			$stmt .= " AND NOT EXISTS (SELECT 1 FROM stratum " .
								" WHERE excavId=:excavId AND stratumId=stratumToArchFind.stratumId) ";
		}
		Dbw::checkedExecute($stmt, $values);


		// commit transaction
		Dbw::$conn->commit();
	}
	catch (Exception $ex) {
		Dbw::$conn->rollback();
		echo Extjs::errorMsg(Oger::_("Umbenennen fehlgeschlagen. Datenbankfehler: " . $ex->getMessage() . "."));
		exit;
	}

	echo Extjs::msg("OK");
	exit;
}  // eo rename



/**
* delete arch find (and connections)
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


	// get extended arch find values and save in trash
	$whereVals = array('excavId' => $_REQUEST['excavId'], 'archFindId' => $_REQUEST['archFindId']);
	$archFindObj = new ArchFind();
	$archFindObj->fromDb($whereVals);
	$data = $archFindObj->getExtendedValues(array('export' => true));

	$trash = new Trash();
	$trash->values['userId'] = $_SESSION[Logon::$_id]['logon']->user->userId;
	$trash->values['userName'] = "{$_SESSION[Logon::$_id]['logon']->user->logonName} ({$_SESSION[Logon::$_id]['logon']->user->realName})";
	$trash->values['time'] = date('c');
	$trash->values['type'] = 'ARCHFIND';
	$trash->values['content'] = json_encode($data);
	$trash->toDb(Db::ACTION_INSERT);


	// delete stratum to arch find
	$stmtCore = " WHERE excavId=:excavId AND archFindId=:archFindId ";
	$stmt = "DELETE FROM stratumToArchFind $stmtCore";
	if ($_REQUEST['unlinkStratum']) {
		// force deletion without additional checks
	}
	else {
		// delete only if link becomes unconnected (corresponding stratum does not exist)
		$stmt .= " AND NOT EXISTS (SELECT 1 FROM stratum " .
							" WHERE excavId=:excavId AND stratumId=stratumToArchFind.stratumId) ";
	}
	$pstmt = Db::prepare($stmt);
	$pstmt->execute($whereVals);


	// delete arch find
	$pstmt = Db::prepare("DELETE FROM archFind $stmtCore");
	$pstmt->execute($whereVals);

	// signal success
	echo Extjs::enc();
	exit;

}  // eo delete






echo Extjs::errorMsg(sprintf("Invalid action '%s' in '%s'.", $_REQUEST['_action'], $_SERVER['PHP_SELF']));
exit;


?>
