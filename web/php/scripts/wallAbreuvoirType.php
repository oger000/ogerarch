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



// load list
if ($_REQUEST['_action'] == 'loadList') {
	echo Extjs::encData(WallAbreuvoirType::getRecords());
	exit;
}



// load record
if ($_REQUEST['_action'] == 'loadRecord') {
	$obj = WallAbreuvoirType::newFromDb(array('id' => $_REQUEST['id']));
	echo Extjs::encData($obj->values);
	exit;
}




?>
