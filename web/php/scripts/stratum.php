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
if ($_REQUEST['_action'] == 'loadList' || $_REQUEST['_action'] == 'loadQMatrixList') {

	$qMatrixFields = array(
		"id" => 1,
		"excavId" => 1,
		"stratumId" => 1,
		"stratumIdSort" => 1,
		"categoryId" => 1,

		"excavName" => 1,
		"categoryName" => 1,

		"earlierThanIdList" => 1,
		"reverseEarlierThanIdList" => 1,
		"equalToIdList" => 1,
		"contempWithIdList" => 1,

		"archObjectIdList" => 1,

		"isTopEdge" => 1,
		"isBottomEdge" => 1,
		"hasAutoInterface" => 1,

	);


	// get total count for current where values including remote filter
	$sql = Stratum12::getSql("GRIDCOUNT", $seleVals);
	$total = Dbw::fetchValue1($sql, $seleVals);

	// inc remote sort, filter, ...
	$seleVals = array();
	$sql = Stratum12::getSql("GRID", $seleVals);

	$pstmt = Dbw::checkedExecute($sql, $seleVals);
	$data = array();
	while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
		$row = Stratum12::prep4Extjs($row);
		$row = Stratum12::addInterfaceRelations($row);
		// restricted field list for quick matrix
		if ($_REQUEST['_action'] == 'loadQMatrixList') {
			$row = array_intersect_key($row, $qMatrixFields);
		}
		$data[] = $row;
	}
	$pstmt->closeCursor();

	echo Extjs::encData($data, $total);
	exit;

}  // eo loading list



// load one record from db
if ($_REQUEST['_action'] == 'loadRecord' || $_REQUEST['_action'] == 'loadQMatrixRecord' ||
		$_REQUEST['_action'] == 'jumpOffset' || $_REQUEST['_action'] == 'jumpOffsetFilter') {

	$sqlTarget = "FORM";
	$notFoundMsg = Oger::_("Stratum {$_REQUEST['stratumId']} nicht gefunden.");

	if ($_REQUEST['_action'] == 'jumpOffset' || $_REQUEST['_action'] == 'jumpOffsetFilter') {

		$notFoundMsg = "Kein weiterer Datensatz in diese Richtung gefunden.";

		$_REQUEST['stratumIdSort'] = Oger::getNatSortId($_REQUEST['stratumId']);

		if ($_REQUEST['__OFFSET__'] > 0) {
			$sqlTarget = "FORM-OFFSET-NEXT";
			$orderDir = "ASC";
		}
		else {
			$sqlTarget = "FORM-OFFSET-PREV";
			$orderDir = "DESC";
		}

		if ($_REQUEST['_action'] == 'jumpOffsetFilter') {
			$sqlTarget .= "-FILTER";
		}

		// overwrite extjs sort - always sort by master-id / default order
		$_REQUEST['sort'] = array("stratumId" => $orderDir);

		$_REQUEST['start'] = abs($_REQUEST['__OFFSET__']) - 1;
		$_REQUEST['limit'] = 1;
	}  // eo jump


	// remote sort, filter, ...
	$sql = Stratum12::getSql($sqlTarget, $seleVals);

	$pstmt = Dbw::checkedExecute($sql, $seleVals);
	$row = $pstmt->fetch(PDO::FETCH_ASSOC);
	$pstmt->closeCursor();

	if ($row === false) {
		echo Extjs::errorMsg($notFoundMsg);
		exit;
	}

	$row = Stratum12::prep4Extjs($row);
	$row = Stratum12::addInterfaceRelations($row);
	echo Extjs::encData($row);
	exit;
}  // eo loading one record




/*
* Save input from form or from cell edit
*/
if ($_REQUEST['_action'] == 'save') {

	// merge field aliases when only one field necessary for export
	switch ($_REQUEST['categoryId']) {
	case StratumCategory12::ID_INTERFACE:
		break;
	case StratumCategory12::ID_DEPOSIT:
		if (array_key_exists("DEPOSIT___orientation", $_REQUEST)) {
			$_REQUEST['orientation'] = $_REQUEST['DEPOSIT___orientation'];
			unset($_REQUEST['DEPOSIT___orientation']);
		}
		break;
	case StratumCategory12::ID_SKELETON:
		if (array_key_exists("SKELETON___orientation", $_REQUEST)) {
			$_REQUEST['orientation'] = $_REQUEST['SKELETON___orientation'];
			unset($_REQUEST['SKELETON___orientation']);
		}
		break;
	case StratumCategory12::ID_WALL:
		if (array_key_exists("WALL___relationDescription", $_REQUEST)) {
			$_REQUEST['relationDescription'] = $_REQUEST['WALL___relationDescription'];
			unset($_REQUEST['WALL___relationDescription']);
		}
		break;
	case StratumCategory12::ID_TIMBER:
		if (array_key_exists("TIMBER___orientation", $_REQUEST)) {
			$_REQUEST['orientation'] = $_REQUEST['TIMBER___orientation'];
			unset($_REQUEST['TIMBER___orientation']);
		}
		if (array_key_exists("TIMBER___relationDescription", $_REQUEST)) {
			$_REQUEST['relationDescription'] = $_REQUEST['TIMBER___relationDescription'];
			unset($_REQUEST['TIMBER___relationDescription']);
		}
		break;
	}  // eo case category


	try {
		$row = Stratum12::storeInput($_REQUEST, $_REQUEST['dbAction'], array('removeRefs' => true));
	}
	catch (Exception $ex) {
		echo Extjs::errorMsg($ex->getMessage());
		exit;
	}

	echo Extjs::encData($row);
	exit;
}  // eo save posted data to database



// load complex parts data from database for complex grid
if ($_REQUEST['_action'] == 'loadComplexPartList') {

	$data = array();

	/*
	$stmt =
	"SELECT * FROM stratumComplex " .
	"INNER JOIN stratum ON (stratumComplex.excavId=stratum.excavId AND stratumComplex.stratumId=stratum.stratumId) " .
	"WHERE stratumComplex.excavId=:excavId AND stratumComplex.stratumId=:stratumId " .
	"ORDER BY stratumComplex.stratum2Id";
	*/
	$stmt = "SELECT * FROM " . StratumComplex::$tableName;

	$whereVals = array();
	$whereVals['excavId'] = $_REQUEST['excavId'];
	$whereVals['stratumId'] = $_REQUEST['stratumId'];

	$pstmt = Db::prepare($stmt, $whereVals, "ORDER BY stratum2Id");
	$pstmt->execute($whereVals);
	while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
		$obj = Stratum::newFromDb(array('excavId' => $row[excavId], 'stratumId' => $row[stratum2Id]));
		$data[] = $obj->getExtendedValues();
	}
	$pstmt->closeCursor();

	echo Extjs::encData($data);

}  // eo loading data to json store



/**
* rename stratum (and connections)
*/
if ($_REQUEST['_action'] == 'rename') {

	if (!$_REQUEST['excavId']) {
		echo Extjs::errorMsg(Oger::_("Grabungs-ID erforderlich."));
		exit;
	}
	if (!$_REQUEST['oldStratumId']) {
		echo Extjs::errorMsg(Oger::_("Alte Stratum-Nummer erforderlich."));
		exit;
	}
	if (!$_REQUEST['stratumId']) {
		echo Extjs::errorMsg(Oger::_("Neue Stratum-Nummer erforderlich."));
		exit;
	}
	if ($err = ExcavHelper::xidValidErr($_REQUEST['stratumId'])) {
		echo Extjs::errorMsg($err);
		exit;
	}



	if (Dbw::fetchValue1(
				"SELECT COUNT(*) FROM stratum WHERE excavId=:excavId AND stratumId=:stratumId",
				array("excavId" => $_REQUEST['excavId'], "stratumId" => $_REQUEST['stratumId'])) > 0) {
		// allow change in letter case
		if (trim(strtoupper($_REQUEST['stratumId'])) != trim(strtoupper($_REQUEST['oldStratumId']))) {
			echo Extjs::errorMsg(Oger::_("Neue Stratum-Nummer ist breits vorhanden - Umbenennen fehlgeschlagen."));
			exit;
		}
	}

	Dbw::$conn->beginTransaction();
	try {
		$values = array("excavId" => $_REQUEST['excavId'], "stratumId" => $_REQUEST['stratumId'],
										"stratumIdSort" => Oger::getNatSortId($_REQUEST['stratumId']),
										"oldStratumId" => $_REQUEST['oldStratumId']);
		$where = " WHERE excavId=:excavId AND stratumId=:oldStratumId ";


		// rename on main stratum and subtables
		Dbw::checkedExecute(
			"UPDATE stratum SET stratumId=:stratumId, stratumIdSort=:stratumIdSort {$where}",
			$values);
		unset($values['stratumIdSort']);  // id sort not used from now on

		// rename substratums
		Dbw::checkedExecute("UPDATE stratumInterface SET stratumId=:stratumId {$where}", $values);
		Dbw::checkedExecute("UPDATE stratumDeposit SET stratumId=:stratumId {$where}", $values);
		Dbw::checkedExecute("UPDATE stratumSkeleton SET stratumId=:stratumId {$where}", $values);
		Dbw::checkedExecute("UPDATE stratumWall SET stratumId=:stratumId {$where}", $values);
		Dbw::checkedExecute("UPDATE stratumTimber SET stratumId=:stratumId {$where}", $values);

		// rename matrix whithout asking in dialog
		Dbw::checkedExecute("UPDATE stratumMatrix SET stratumId=:stratumId {$where}", $values);
		Dbw::checkedExecute(
			"UPDATE stratumMatrix SET stratum2Id=:stratumId " .
			" WHERE excavId=:excavId AND stratum2Id=:oldStratumId ",
			$values);


		$stmt = "UPDATE stratumToArchFind SET stratumId=:stratumId {$where}";
		if ($_REQUEST['renameArchFind']) {
			// force rename without additional checks
		}
		else {
			// rename only if link becomes unconnected (corresponding archFind does not exist)
			$stmt .= " AND NOT EXISTS (SELECT 1 FROM archFind " .
								" WHERE excavId=:excavId AND archFindId=stratumToArchFind.archFindId) ";
		}
		Dbw::checkedExecute($stmt, $values);


		$stmt = "UPDATE archObjectToStratum SET stratumId=:stratumId {$where}";
		if ($_REQUEST['renameArchObject']) {
			// force rename without additional checks
		}
		else {
			// rename only if link becomes unconnected (corresponding archObject does not exist)
			$stmt .= " AND NOT EXISTS (SELECT 1 FROM archObject " .
								" WHERE excavId=:excavId AND archObjectId=archObjectToStratum.archObjectId) ";
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




/*
* Get history for one field
*/
if ($_REQUEST['_action'] == 'loadFieldHistory') {

	$data = array();

	$fieldName = $_REQUEST['fieldName'];
	try {
		Db::checkFieldNamesEx($fieldName);
	}
	catch (Exception $ex) {
		echo Extjs::errorMsg($ex->getMessage());
		exit;
	}

	$categoryInfo = StratumCategory::getStrucInfo($_REQUEST['categoryId']);
	$tableName = $categoryInfo['className']::$tableName;
	// fallback to common stratum table if no category given
	if (!$tableName) {
		$tableName = Stratum::$tableName;
	}

	//$sele = DbSeleHelper::prepareSeleOpts();  // get $sele['where']['excavId']

	//$stmt = "SELECT $fieldName, COUNT(*) AS recordCount FROM $tableName " .
	//				"WHERE excavId=:excavId GROUP BY $fieldName ORDER BY recordCount DESC LIMIT 100";
	$stmt = "SELECT $fieldName, COUNT(*) AS recordCount FROM $tableName " .
					"WHERE excavId=:excavId GROUP BY $fieldName";
	$pstmt = Db::prepare($stmt);
	$pstmt->execute(array('excavId' => $_REQUEST['excavId']));
	while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
		$data[] = array('id' => $row[$fieldName], 'text' => $row[$fieldName]);
	}
	$pstmt->closeCursor();

	echo Extjs::encData($data, count($data));
}  // eo get field history


/*
* Get new stratum id
*/
if ($_REQUEST['_action'] == 'getNewStratumId') {

	$tableName = Stratum::$tableName;

	$whereVals['excavId'] = $_REQUEST['excavId'];
	$pstmt = Db::prepare("SELECT MAX(0+stratumId) FROM {$tableName} WHERE excavId=:excavId");
	$pstmt->execute($whereVals);
	$maxStratumId = $pstmt->fetchColumn();
	$pstmt->closeCursor();
	$data['newStratumId'] = $maxStratumId + 1;


	// if NEXT stratum id after a given old stratum id is unused, then use that
	// only xxxx0000 pattern are handled correct (text BEFORE number)
	if ($_REQUEST['oldStratumId']) {

		$whereVals['stratumIdSort'] = Oger::getNatSortId($_REQUEST['oldStratumId']);
		$pstmt = Db::prepare(
			"SELECT stratumId FROM {$tableName} " .
			" WHERE excavId=:excavId AND stratumIdSort > :stratumIdSort " .
			" ORDER BY stratumIdSort " .
			" LIMIT 1"
		);
		$pstmt->execute($whereVals);
		$nextUsedStratumId = $pstmt->fetchColumn();
		$pstmt->closeCursor();
		preg_match('/[^\d]+/', $_REQUEST['oldStratumId'], $textMatch);
		preg_match('/\d+/', $_REQUEST['oldStratumId'], $numMatch);
		$nextCalcedStratumId = $textMatch[0] . ($numMatch[0] + 1);
		if ($nextUsedStratumId > $nextCalcedStratumId) {
			$data['newStratumId'] = $nextCalcedStratumId;
		}
	}

	echo Extjs::encData($data);
	exit;
}  // eo get new stratum id



// load arch find records for stratum
if ($_REQUEST['_action'] == 'loadArchFindRecords') {

	$data = array();

	$stratum = Stratum::newFromDb(array('excavId' => $_REQUEST['excavId'], 'stratumId' => $_REQUEST['stratumId']));
	$archFinds = $stratum->getArchFindObjects();

	foreach ($archFinds as $archFind) {
		$data[] = $archFind->getExtendedValues();
	}

	echo Extjs::encData($data);

}  // eo loading data to json store




// load arch object records for stratum
if ($_REQUEST['_action'] == 'loadArchObjectRecords') {

	$data = array();

	$stratum = Stratum::newFromDb(array('excavId' => $_REQUEST['excavId'], 'stratumId' => $_REQUEST['stratumId']));
	$archObjectObjects = $stratum->getArchObjectObjects();
	foreach ($archObjectObjects as $archObject) {
		$data[] = $archObject->getExtendedValues();
	}

	echo Extjs::encData($data);

}  // eo loading data to json store




// load arch object GROUP records for stratum
if ($_REQUEST['_action'] == 'loadArchObjGroupRecords') {

	$data = array();

	$stratum = Stratum::newFromDb(array('excavId' => $_REQUEST['excavId'], 'stratumId' => $_REQUEST['stratumId']));
	$archObjGroups = $stratum->getArchObjGroupObjects();

	// get arch object group values
	foreach ($archObjGroups as $archObjGroup) {
		$data[] = $archObjGroup->getExtendedValues();
	}

	echo Extjs::encData($data);

}  // eo loading data to json store




// delete stratum (and connections)
if ($_REQUEST['_action'] == 'delete') {

	if (!$_REQUEST['excavId']) {
		echo Extjs::errorMsg(Oger::_("Grabungs-ID erforderlich."));
		exit;
	}
	if (!$_REQUEST['stratumId']) {
		echo Extjs::errorMsg(Oger::_("Stratum-Nummer erforderlich."));
		exit;
	}


	// get extended stratum values and save in trash
	$whereVals = array('excavId' => $_REQUEST['excavId'], 'stratumId' => $_REQUEST['stratumId']);
	$stratumObj = new Stratum();
	$stratumObj->allFromDb($whereVals);
	$data = $stratumObj->getAllExtendedValues(array('export' => true));

	$trash = new Trash();
	$trash->values['userId'] = $_SESSION[Logon::$_id]['logon']->user->userId;
	$trash->values['userName'] = "{$_SESSION[Logon::$_id]['logon']->user->logonName} ({$_SESSION[Logon::$_id]['logon']->user->realName})";
	$trash->values['time'] = date('c');
	$trash->values['type'] = 'STRATUM';
	$trash->values['content'] = json_encode($data);
	$trash->toDb(Db::ACTION_INSERT);


	// delete stratum to arch find
	$whereVals = array('excavId' => $_REQUEST['excavId'], 'stratumId' => $_REQUEST['stratumId']);
	$linkTableName = StratumToArchFind::$tableName;
	$otherTableName = ArchFind::$tableName;
	$stmt = "DELETE $linkTableName FROM $linkTableName";
	$where = "$linkTableName.excavId=:excavId AND $linkTableName.stratumId=:stratumId";
	if ($_REQUEST['unlinkArchFind']) {
		// force deletion without additional checks
	}
	else {
		// delete only if link becomes unconnected (corresponding arch find does not exist)
		$stmt .= " LEFT OUTER JOIN $otherTableName ON" .
						 " $linkTableName.excavId=$otherTableName.excavId AND $linkTableName.archFindId=$otherTableName.archFindId";
		$where .= " AND $otherTableName.id IS NULL";
	}
	//echo "del-stratumtoarchfind-stmt=$stmt WHERE $where ;;; "; echo var_export($whereVals, true); exit;
	$pstmt = Db::prepare($stmt, $where);
	$pstmt->execute($whereVals);


	// delete matrix info (all relations)
	$whereVals = array('excavId' => $_REQUEST['excavId'], 'stratumId' => $_REQUEST['stratumId']);
	if ($_REQUEST['unlinkMatrix']) {
		// force deletion without additional checks
		$pstmt = Db::prepare('DELETE FROM ' . StratumMatrix::$tableName .
												 ' WHERE excavId=:excavId AND (stratumId=:stratumId OR stratum2Id=:stratumId)');
		$pstmt->execute($whereVals);
	}
	else {
		// delete only if link becomes unconnected (corresponding matrix counterpart does not exist)
		// prepare delete statement
		$pstmt2 = Db::prepare("DELETE FROM " . StratumMatrix::$tableName . " WHERE id=:id");
		// search entries
		$pstmt = Db::prepare('SELECT * FROM ' . StratumMatrix::$tableName .
												 ' WHERE excavId=:excavId AND (stratumId=:stratumId OR stratum2Id=:stratumId)');
		$pstmt->execute($whereVals);
		while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
			if ($row['stratumId'] == $_REQUEST['stratumId']) {
				$stratumIdOther = $row['stratum2Id'];
			}
			else {
				$stratumIdOther = $row['stratumId'];
			}
			if (!Stratum::existsStatic(array('excavId' => $_REQUEST['excavId'], 'stratumId' => $stratumIdOther))) {
				$pstmt2->execute(array('id' => $row['id']));
			}
		}
		$pstmt->closeCursor();
	}


	// delete complex info
	$whereVals = array('excavId' => $_REQUEST['excavId'], 'stratumId' => $_REQUEST['stratumId']);
	$linkTableName = StratumComplex::$tableName;
	$otherTableName = Stratum::$tableName;
	$stmt = "DELETE $linkTableName FROM $linkTableName";
	$where = "$linkTableName.excavId=:excavId AND $linkTableName.stratumId=:stratumId";
	if ($_REQUEST['unlinkComplex']) {
		// force deletion without additional checks
	}
	else {
		// delete only if link becomes unconnected (corresponding stratum does not exist)
		$stmt .= " LEFT OUTER JOIN $otherTableName ON" .
						 " $linkTableName.excavId=$otherTableName.excavId AND $linkTableName.stratumId=$otherTableName.stratumId";
		$where .= " AND $otherTableName.id IS NULL";
	}
	//echo "del-stratumcomplex-stmt=$stmt WHERE $where ;;; "; echo var_export($whereVals, true); exit;
	$pstmt = Db::prepare($stmt, $where);
	$pstmt->execute($whereVals);


	// delete arch object to stratum
	$whereVals = array('excavId' => $_REQUEST['excavId'], 'stratumId' => $_REQUEST['stratumId']);
	$linkTableName = ArchObjectToStratum::$tableName;
	$otherTableName = ArchObject::$tableName;
	$stmt = "DELETE $linkTableName FROM $linkTableName";
	$where = "$linkTableName.excavId=:excavId AND $linkTableName.stratumId=:stratumId";
	if ($_REQUEST['unlinkArchObject']) {
		// force deletion without additional checks
	}
	else {
		// delete only if link becomes unconnected (no arch object)
		$stmt .= " LEFT OUTER JOIN $otherTableName ON" .
						 " $linkTableName.excavId=$otherTableName.excavId AND $linkTableName.archObjectId=$otherTableName.archObjectId";
		$where .= " AND $otherTableName.id IS NULL";
	}
	//echo "del-stratumtoarchobj-stmt=$stmt WHERE $where ;;; "; echo var_export($whereVals, true); exit;
	$pstmt = Db::prepare($stmt, $where);
	$pstmt->execute($whereVals);


	// delete stratum subtables
	$whereVals = array('excavId' => $_REQUEST['excavId'], 'stratumId' => $_REQUEST['stratumId']);
	$categoryInfo = StratumCategory::getStrucInfo($stratumObj->values['categoryId']);
	$stratumSubClassName = $categoryInfo['className'];
	$stmt = "DELETE FROM " . $stratumSubClassName::$tableName;
	//echo "stmt=$stmt<br>\n";exit;
	$pstmt = Db::prepare($stmt, $whereVals);
	$pstmt->execute($whereVals);

	// delete stratum
	$whereVals = array('excavId' => $_REQUEST['excavId'], 'stratumId' => $_REQUEST['stratumId']);
	$pstmt = Db::prepare("DELETE FROM " . Stratum::$tableName, $whereVals);
	$pstmt->execute($whereVals);

	// signal success
	echo Extjs::enc();

}  // eo delete




?>
