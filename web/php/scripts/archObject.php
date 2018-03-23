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



// load data from database
if ($_REQUEST['_action'] == 'loadList' || $_REQUEST['_action'] == 'loadRecord') {

	$data = array();

	$sele['fields'] = '*';
	$sele['table'] = ArchObject::$tableName;

	// order by HACK
	$sele['orderBy'] = array('excavId' => 'ASC', '0+archObjectId' => 'ASC');

	$tmpSqlHlp = new OgerExtjSqlTpl();
	$extSort = $tmpSqlHlp->getStoreSort();
	if ($_REQUEST['_action'] == 'loadList') {
		if ($extSort['typeName']) {
			$sele['orderBy'] = array('excavId' => 'ASC', 'typeId' => 'ASC');
		}
		elseif ($extSort['datingSpec']) {
			$sele['orderBy'] = array('excavId' => 'ASC', 'datingSpec' => 'ASC');
		}
		elseif ($extSort['datingPeriodId'] || $extSort['datingPeriodName']) {
			$sele['orderBy'] = array('excavId' => 'ASC', 'datingPeriodId' => 'ASC');
		}
	}

	if ($_REQUEST['id']) {
		$sele['where']['id'] = $_REQUEST['id'];
	}
	if ($_REQUEST['excavId']) {
		$sele['where']['excavId'] = $_REQUEST['excavId'];
	}
	if ($_REQUEST['archObjectId']) {
		$sele['where']['archObjectId'] = $_REQUEST['archObjectId'];
	}

	$sele = DbSeleHelper::prepareSeleOpts($sele);
	$stmt = Db::createSelectStmt($sele);

	$pstmt = Db::prepare($stmt);
	$pstmt->execute($sele['where']);
	while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
		$record = new ArchObject($row);
		$data[] = $record->getExtendedValues();
	}
	$pstmt->closeCursor();

	// if load only one record into form do not send a list of records, but only the first one
	if ($_REQUEST['_action'] == 'loadRecord') {
		if ($data) {
			$data = $data[0];
		}
	}
	else {
		$totalCount = ArchObject::getCount($sele['where']);
	}

	echo Extjs::encData($data, $totalCount);
	exit;
}  // eo loading data to json store



/*
* Save input
*/
if ($_REQUEST['_action'] == 'save') {

	$result = ArchObject::saveInput($_REQUEST, $_REQUEST['dbAction'], array('removeRefs' => true));

	if ($result['errorMsg']) {
		echo Extjs::errorMsg($result['errorMsg']);
		exit;
	}

	echo Extjs::encData($result['data']);
	exit;
}  // eo save posted data to database



/*
* Get new arch find id
*/
if ($_REQUEST['_action'] == 'getNewArchObjectId') {

	$whereVals['excavId'] = $_REQUEST['excavId'];
	$pstmt = Db::prepare("SELECT MAX(0+archObjectId) FROM " . ArchObject::$tableName, $whereVals);
	$pstmt->execute($whereVals);
	$maxArchObjectId = $pstmt->fetchColumn();
	$pstmt->closeCursor();

	$data['newArchObjectId'] = $maxArchObjectId + 1;

	echo Extjs::encData($data);
	exit;
}  // eo get new arch find id




// load stratum list for arch object
if ($_REQUEST['_action'] == 'loadStratumList') {

	$data = array();

	$archObj = ArchObject::newFromDb(array('excavId' => $_REQUEST['excavId'], 'archObjectId' => $_REQUEST['archObjectId']));
	$stratumObjects = $archObj->getStratumObjects();
	foreach ($stratumObjects as $stratum) {
		$data[] = $stratum->getExtendedValues();
	}

	echo Extjs::encData($data);
	exit;
}  // eo loading data to json store




// load arch objectgroup list for arch object
if ($_REQUEST['_action'] == 'loadArchObjGroupRecords') {

	$data = array();

	$stmt = "SELECT * FROM " . ArchObjGroupToArchObject::$tableName;

	$whereVals = array();
	$whereVals['excavId'] = $_REQUEST['excavId'];
	$whereVals['archObjectId'] = $_REQUEST['archObjectId'];

	$pstmt = Db::prepare($stmt, $whereVals, "ORDER BY 0+archObjGroupId");
	$pstmt->execute($whereVals);
	while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
		$obj = ArchObjGroup::newFromDb(array('excavId' => $row['excavId'], 'archObjGroupId' => $row['archObjGroupId']));
		if (!$obj->values['archObjGroupId']) {
			$obj->values['archObjGroupId'] = '? ' . $row['archObjGroupId'];
		}
		$data[] = $obj->getExtendedValues();
	}
	$pstmt->closeCursor();

	echo Extjs::encData($data);
	exit;
}  // eo loading data to json store



// load arch find records for arch object
if ($_REQUEST['_action'] == 'loadArchFindRecords') {

	$data = array();

	$archObj = ArchObject::newFromDb(array('excavId' => $_REQUEST['excavId'], 'archObjectId' => $_REQUEST['archObjectId']));
	$stratumIdArray = $archObj->getStratumIdArray();

	// collect archfinds
	$allArchFinds = array();
	foreach ($stratumIdArray as $stratumId) {
		$stratum = Stratum::newFromDb(array('excavId' => $_REQUEST['excavId'], 'stratumId' => $stratumId));
		$archFinds = $stratum->getArchFindObjects();
		foreach ($archFinds as $archFind) {
			// avoid duplicates
			$allArchFinds[$archFind->values['archFindId']] = $archFind;
		}
	}

	// create final output
	ksort($allArchFinds);
	foreach ($allArchFinds as $archFind) {
		$data[] = $archFind->getExtendedValues();
	}

	echo Extjs::encData($data);
	exit;
}  // eo loading data to json store



/**
* delete arch object (and connections)
*/
if ($_REQUEST['_action'] == 'delete') {

	if (!$_REQUEST['excavId']) {
		echo Extjs::errorMsg(Oger::_("Grabungs-ID erforderlich."));
		exit;
	}
	if (!$_REQUEST['archObjectId']) {
		echo Extjs::errorMsg(Oger::_("Objekt-Nr erforderlich."));
		exit;
	}


	// get extended arch object values and save in trash
	$whereVals = array('excavId' => $_REQUEST['excavId'], 'archObjectId' => $_REQUEST['archObjectId']);
	$archObjectObj = new ArchObject();
	$archObjectObj->fromDb($whereVals);
	$data = $archObjectObj->getExtendedValues(array('export' => true));

	$trash = new Trash();
	$trash->values['userId'] = $_SESSION[Logon::$_id]['logon']->user->userId;
	$trash->values['userName'] = "{$_SESSION[Logon::$_id]['logon']->user->logonName} ({$_SESSION[Logon::$_id]['logon']->user->realName})";
	$trash->values['time'] = date('c');
	$trash->values['type'] = 'ARCHOBJECT';
	$trash->values['content'] = json_encode($data);
	$trash->toDb(Db::ACTION_INSERT);


	// delete arch object to stratum
	$whereVals = array('excavId' => $_REQUEST['excavId'], 'archObjectId' => $_REQUEST['archObjectId']);
	$linkTableName = ArchObjectToStratum::$tableName;
	$otherTableName = Stratum::$tableName;
	$stmt = "DELETE $linkTableName FROM $linkTableName";
	$where = "$linkTableName.excavId=:excavId AND $linkTableName.archObjectId=:archObjectId";
	if ($_REQUEST['unlinkStratum']) {
		// force deletion without additional checks
	}
	else {
		// delete only if link becomes unconnected (no arch object)
		$stmt .= " LEFT OUTER JOIN $otherTableName ON" .
						 " $linkTableName.excavId=$otherTableName.excavId AND $linkTableName.stratumId=$otherTableName.stratumId";
		$where .= " AND $otherTableName.id IS NULL";
	}
	//echo "del-stratumtoarchobj-stmt=$stmt WHERE $where ;;; "; echo var_export($whereVals, true); exit;
	$pstmt = Db::prepare($stmt, $where);
	$pstmt->execute($whereVals);

	// delete arch object group to arch object connection
	$whereVals = array('excavId' => $_REQUEST['excavId'], 'archObjectId' => $_REQUEST['archObjectId']);
	$linkTableName = ArchObjGroupToArchObject::$tableName;
	$otherTableName = ArchObjGroup::$tableName;
	$stmt = "DELETE $linkTableName FROM $linkTableName";
	$where = "$linkTableName.excavId=:excavId AND $linkTableName.archObjectId=:archObjectId";
	if ($_REQUEST['unlinkArchObjGroup']) {
		// force deletion without additional checks
	}
	else {
		// delete only if link becomes unconnected (corresponding arch object group does not exist)
		$stmt .= " LEFT OUTER JOIN $otherTableName ON" .
						 " $linkTableName.excavId=$otherTableName.excavId AND $linkTableName.archObjGroupId=$otherTableName.archObjGroupId";
		$where .= " AND $otherTableName.id IS NULL";
	}
	//echo "del-objgrptoobj-stmt=$stmt WHERE $where ;;; "; echo var_export($whereVals, true); exit;
	$pstmt = Db::prepare($stmt, $where);
	$pstmt->execute($whereVals);


	// delete arch object
	$whereVals = array('excavId' => $_REQUEST['excavId'], 'archObjectId' => $_REQUEST['archObjectId']);
	$pstmt = Db::prepare("DELETE FROM " . ArchObject::$tableName, $whereVals);
	$pstmt->execute($whereVals);

	exit;
}  // eo delete





echo Extjs::errorMsg(sprintf("Invalid action '%s' in '%s'.", $_REQUEST['_action'], $_SERVER['PHP_SELF']));
exit;


?>
