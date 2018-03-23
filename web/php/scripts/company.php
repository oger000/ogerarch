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
	$sele['table'] = Company::$tableName;
	$sele['orderBy'] = array('name1' => 'ASC');

	if ($_REQUEST['id']) {
		$sele['where']['id'] = $_REQUEST['id'];
	}


	$sele = DbSeleHelper::prepareSeleOpts($sele);
	$stmt = Db::createSelectStmt($sele);

	$pstmt = Db::prepare($stmt);
	$pstmt->execute($sele['where']);
	while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
		$record = new Company($row);
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
		$totalCount = Company::getCount($sele['where']);
	}

	echo Extjs::encData($data, $totalCount);

}  // eo loading data to json store



/*
* Save input
*/
if ($_REQUEST['_action'] == 'save') {

	$result = Company::saveInput($_REQUEST, $_REQUEST['dbAction']);

	if ($result['errorMsg']) {
		echo Extjs::errorMsg($result['errorMsg']);
		exit;
	}

	echo Extjs::encData($result['data']);
}  // eo save posted data to database




?>
