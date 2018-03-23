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
	$sele['table'] = StratumType::$tableName;
	$sele['orderBy'] = array('categoryId' => 'ASC', 'name' => 'ASC');


	if ($_REQUEST['id']) {
		$sele['where']['id'] = $_REQUEST['id'];
	}
	if ($_REQUEST['categoryId']) {
		$sele['where']['categoryId'] = $_REQUEST['categoryId'];
	}

	$sele = DbSeleHelper::prepareSeleOpts($sele);
	$stmt = Db::createSelectStmt($sele);

	$pstmt = Db::prepare($stmt);
	$pstmt->execute($sele['where']);
	while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
		$record = new StratumType($row);
		$data[] = $record->getExtendedValues();
	}
	$pstmt->closeCursor();

	// if load only one record into form do not send a list of records, but only the first one
	if ($_REQUEST['_action'] == 'loadRecord') {
		$data = $data[0];
	}
	echo Extjs::encData($data);

}  // eo loading data to json store



/*
* Save input
*/
if ($_REQUEST['_action'] == 'save') {

	// create new
	$record = new StratumType($_REQUEST);


	// construct new id for insert
	if ($_REQUEST['dbAction'] == Db::ACTION_INSERT) {
		$record->values['id'] = (string)(StratumType::getMaxValue('id') + 1);
	}

	// check for required fields
	if (!$record->values['categoryId']) {
		echo Extjs::errorMsg(Oger::_("Kategorieangabe fehlt."));
		exit;
	}
	if (!$record->values['name']) {
		echo Extjs::errorMsg(Oger::_("Bezeichnung fehlt."));
		exit;
	}


	$record->toDb($_REQUEST['dbAction']);
	echo Extjs::encData($record->getExtendedValues());

}  // eo save posted data to database



?>
