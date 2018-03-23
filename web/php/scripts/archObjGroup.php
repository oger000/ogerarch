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
	$sele['table'] = ArchObjGroup::$tableName;
	$sele['orderBy'] = array('excavId' => 'ASC', '0+archObjGroupId' => 'ASC');


	if ($_REQUEST['id']) {
		$sele['where']['id'] = $_REQUEST['id'];
	}
	if ($_REQUEST['excavId']) {
		$sele['where']['excavId'] = $_REQUEST['excavId'];
	}
	if ($_REQUEST['archObjGroupId']) {
		$sele['where']['archObjGroupId'] = $_REQUEST['archObjGroupId'];
	}

	$sele = DbSeleHelper::prepareSeleOpts($sele);
	$stmt = Db::createSelectStmt($sele);

	$pstmt = Db::prepare($stmt);
	$pstmt->execute($sele['where']);
	while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
		$record = new ArchObjGroup($row);
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
		$totalCount = ArchObjGroup::getCount($sele['where']);
	}

	echo Extjs::encData($data, $totalCount);

}  // eo loading data to json store



/*
* Save input
*/
if ($_REQUEST['_action'] == 'save') {

	$result = ArchObjGroup::saveInput($_REQUEST, $_REQUEST['dbAction'], array('removeRefs' => true));

	if ($result['errorMsg']) {
		echo Extjs::errorMsg($result['errorMsg']);
		exit;
	}

	echo Extjs::encData($result['data']);
}  // eo save posted data to database



/*
* Get new arch object group id
*/
if ($_REQUEST['_action'] == 'getNewArchObjGroupId') {

	$whereVals['excavId'] = $_REQUEST['excavId'];
	$pstmt = Db::prepare("SELECT MAX(0+archObjGroupId) FROM " . ArchObjGroup::$tableName, $whereVals);
	$pstmt->execute($whereVals);
	$maxArchObjGroupId = $pstmt->fetchColumn();
	$pstmt->closeCursor();

	$data['newArchObjGroupId'] = $maxArchObjGroupId + 1;

	echo Extjs::encData($data);
}  // eo get new arch object group id




// load arch object list for arch object GROUP
if ($_REQUEST['_action'] == 'loadArchObjectList') {

	$data = array();

	$stmt = "SELECT * FROM " . ArchObjGroupToArchObject::$tableName;

	$whereVals = array();
	$whereVals['excavId'] = $_REQUEST['excavId'];
	$whereVals['archObjGroupId'] = $_REQUEST['archObjGroupId'];

	$pstmt = Db::prepare($stmt, $whereVals, "ORDER BY 0+archObjectId");
	$pstmt->execute($whereVals);
	while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
		$obj = ArchObject::newFromDb(array('excavId' => $row['excavId'], 'archObjectId' => $row['archObjectId']));
		if (!$obj->values['archObjectId']) {
			$obj->values['archObjectId'] = '? ' . $row['archObjectId'];
		}
		$data[] = $obj->getExtendedValues();
	}
	$pstmt->closeCursor();

	echo Extjs::encData($data);

}  // eo loading data to json store


/**
* delete arch object group (and connections)
*/
if ($_REQUEST['_action'] == 'delete') {

	if (!$_REQUEST['excavId']) {
		echo Extjs::errorMsg(Oger::_("Grabungs-ID erforderlich."));
		exit;
	}
	if (!$_REQUEST['archObjGroupId']) {
		echo Extjs::errorMsg(Oger::_("Objektgruppen-Nr erforderlich."));
		exit;
	}


	// get extended arch object group values and save in trash
	$whereVals = array('excavId' => $_REQUEST['excavId'], 'archObjGroupId' => $_REQUEST['archObjGroupId']);
	$archObjGroupObj = new ArchObjGroup();
	$archObjGroupObj->fromDb($whereVals);
	$data = $archObjGroupObj->getExtendedValues(array('export' => true));

	$trash = new Trash();
	$trash->values['userId'] = $_SESSION[Logon::$_id]['logon']->user->userId;
	$trash->values['userName'] = "{$_SESSION[Logon::$_id]['logon']->user->logonName} ({$_SESSION[Logon::$_id]['logon']->user->realName})";
	$trash->values['time'] = date('c');
	$trash->values['type'] = 'ARCHOBJGROUP';
	$trash->values['content'] = json_encode($data);
	$trash->toDb(Db::ACTION_INSERT);


	// delete arch object group to arch object connection
	$whereVals = array('excavId' => $_REQUEST['excavId'], 'archObjGroupId' => $_REQUEST['archObjGroupId']);
	$linkTableName = ArchObjGroupToArchObject::$tableName;
	$otherTableName = ArchObject::$tableName;
	$stmt = "DELETE $linkTableName FROM $linkTableName";
	$where = "$linkTableName.excavId=:excavId AND $linkTableName.archObjGroupId=:archObjGroupId";
	if ($_REQUEST['unlinkArchObject']) {
		// force deletion without additional checks
	}
	else {
		// delete only if link becomes unconnected (corresponding arch object does not exist)
		$stmt .= " LEFT OUTER JOIN $otherTableName ON" .
						 " $linkTableName.excavId=$otherTableName.excavId AND $linkTableName.archObjectId=$otherTableName.archObjectId";
		$where .= " AND $otherTableName.id IS NULL";
	}
	//echo "del-objgrptoobj-stmt=$stmt WHERE $where ;;; "; echo var_export($whereVals, true); exit;
	$pstmt = Db::prepare($stmt, $where);
	$pstmt->execute($whereVals);


	// delete arch object group
	$whereVals = array('excavId' => $_REQUEST['excavId'], 'archObjGroupId' => $_REQUEST['archObjGroupId']);
	$pstmt = Db::prepare("DELETE FROM " . ArchObjGroup::$tableName, $whereVals);
	$pstmt->execute($whereVals);

}  // eo delete




?>
