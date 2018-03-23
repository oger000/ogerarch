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



/**
* create export file
*/
if ($_REQUEST['_action'] == 'export') {

	$outDate = time();
	$fileName = "ogerarch_" . date('Y-m-d', $outDate);

	switch ($_REQUEST['fileFormat']) {
	case 'XML':
		$data = collectExportData($outDate);
		header("Content-type: application/xml");
		header('Content-disposition: attachment; filename="' . $fileName . '.xml"');
		/*
		$xml = Array2XML::createXML('OGERARCH', $data);
		echo $xml->saveXML();
		*/
		echo OgerXML::arrayToXml('OGERARCH', $data);
		break;
	case 'JSON':
	case 'JSON_FORMATED':
		$data = collectExportData($outDate);
		$jsCode = json_encode($data);
		if ($_REQUEST['fileFormat'] == 'JSON_FORMATED') {
			$jsCode = Oger::formatJson($jsCode);
		}
		header("Content-type: text/plain");   // maybe pure "text/plain" - TODO: check if ok with utf8 (proposed: application/json)
		header('Content-disposition: attachment; filename="' . $fileName . '.json"');
		echo $jsCode;
		break;
	case 'CSV':
		require(__DIR__ . '/exportCsv.php');
		break;
	case 'SQL':
		require(__DIR__ . '/exportSql.php');
		break;
	default:
		printf('Unknown file format %s.', $_REQUEST['fileFormat']);
		exit;
	}

}  // eo export




/*
function xmlToArray($xml) {
	$array = json_decode(json_encode($xml), TRUE);
	foreach ( array_slice($array, 0) as $key => $value ) {
		if ( empty($value) ) $array[$key] = null;
		elseif ( is_array($value) ) $array[$key] = xmlToArray($value);
	}
	return $array;
}
*/


/**
* collect data
*/
function collectExportData($outDate) {

	gc_enable ();
	$oldTimeLimit = ini_get('max_execution_time');

	// if excavid is given, than restrict to this excavation
	$whereVals = array();
	if ($_REQUEST['excavId']) {
		$whereVals['id'] = $_REQUEST['excavId'];
	}

	$out = array();

	$out['METADATA']['DATE'] = date('c', $outDate);
	$out['METADATA']['EXCAVATIONSHORTLIST'] = array();
	$out['METADATA']['STARTPARAMETER'] = $_REQUEST;

	if (file_exists('config/version.inc.php')) {
		$out['METADATA']['OGERARCHVERSION'] = trim(file_get_contents('config/version.inc.php'));
	}
	else {
		$out['METADATA']['OGERARCHVERSION'] = "OgerArch Version File not found.";
	}
	//$out['METADATA']['DBSERIAL'] = ConfigDb::getCurrentDbStrucSerial();
	//$out['METADATA']['DBSERIAL'] .= "(" . date("c", $out['METADATA']['DBSERIAL']) . ")";



	// EXCAVATION (DETAIL) DATA
	if ($_REQUEST['excavation'] ||
			$_REQUEST['archFind'] ||
			$_REQUEST['stratum'] ||
			$_REQUEST['archObject'] ||
			$_REQUEST['archObjGroup']) {


		$excavCount = 0;
		$pstmtExcav = Db::prepare('SELECT * FROM ' . Excavation::$tableName, $whereVals);
		$pstmtExcav->execute($whereVals);
		while ($excavRow = $pstmtExcav->fetch(PDO::FETCH_ASSOC)) {

			// -----------------------------------------------

			$excav = new Excavation($excavRow);
			$excavValues = $excav->values;
			$excavId = $excavValues['id'];

			$out['METADATA']['EXCAVATIONSHORTLIST'][$excavCount] = array('id' => $excavValues['id'], 'name' => $excavValues['name'] .
				 ' [' . $excavValues['beginDate'] . '] - [' . $excavValues['endDate'] . ']');

			// -----------------------------------------------

			// preserve excavation masterdata always in "hidden" field even if not explicitly exported
			$out['EXCAVATIONLIST'][$excavCount]['TRANSFERHEADER']['EXCAVATIONMASTERCOPY'] = $excavValues;

			// -----------------------------------------------

			if ($_REQUEST['excavation']) {
				$out['EXCAVATIONLIST'][$excavCount]['EXCAVATIONMASTER'] = $excavValues;
			}

			// -----------------------------------------------

			if ($_REQUEST['archFind']) {

				if (array_key_exists("archFindBeginId", $_REQUEST)) {
					$_REQUEST['archFindBeginId'] = Oger::getNatSortId($_REQUEST['archFindBeginId']);
				}
				if (array_key_exists("archFindEndId", $_REQUEST)) {
					$_REQUEST['archFindEndId'] = Oger::getNatSortId($_REQUEST['archFindEndId']);
				}

				$whereVals = array('excavId' => $excavRow['id']);
				$sql = ArchFind12::getSql("EXPORT", $whereVals);
				$pstmtDetail = Dbw::checkedExecute($sql, $whereVals);
				while ($detailRow = $pstmtDetail->fetch(PDO::FETCH_ASSOC)) {
					$detailRow = ArchFind12::prep4Export($detailRow);
					$out['EXCAVATIONLIST'][$excavCount]['ARCHFINDLIST'][$detailRow['archFindId']] = $detailRow;
					set_time_limit($oldTimeLimit);
				}
				$pstmtDetail->closeCursor();

			}  // eo archFind

			// -----------------------------------------------

			if ($_REQUEST['stratum']) {

				if (array_key_exists("stratumBeginId", $_REQUEST)) {
					$_REQUEST['stratumBeginId'] = Oger::getNatSortId($_REQUEST['stratumBeginId']);
				}
				if (array_key_exists("stratumEndId", $_REQUEST)) {
					$_REQUEST['stratumEndId'] = Oger::getNatSortId($_REQUEST['stratumEndId']);
				}

				$whereVals = array('excavId' => $excavRow['id']);
				$sql = Stratum12::getSql("EXPORT", $whereVals);
				$pstmtDetail = Dbw::checkedExecute($sql, $whereVals);
				while ($detailRow = $pstmtDetail->fetch(PDO::FETCH_ASSOC)) {
					$detailRow = Stratum12::prep4Export($detailRow);

					// UGLY HACK: remove NULL-values. Should be safe,
					// because there are no fields that allow NULL values
					// in all the stratum and stratum sub-tables
					// so NULL values can only result from non-existing sql-joined tables
					foreach($detailRow as $k => $v) {
						if ($v === null) {
							unset($detailRow[$k]);
						}
					}  // null value loop

					$out['EXCAVATIONLIST'][$excavCount]['STRATUMLIST'][$detailRow['stratumId']] = $detailRow;
					set_time_limit($oldTimeLimit);
				}
				$pstmtDetail->closeCursor();

			}  // eo stratum

			// -----------------------------------------------

			if ($_REQUEST['archObject']) {

				$detailCount = 0;

				$detailObj = new ArchObject();

				$whereVals = array('excavId' => $excavRow['id']);
				if ($_REQUEST['archObjectBeginId']) {
					$whereVals['archObjectId#SIGNED,>=,archObjectBeginId'] = $_REQUEST['archObjectBeginId'];
				}
				if ($_REQUEST['archObjectEndId']) {
					$whereVals['archObjectId#SIGNED,<=,archObjectEndId'] = $_REQUEST['archObjectEndId'];
				}

				$pstmtDetail = Db::prepare('SELECT * FROM ' . ArchObject::$tableName, $whereVals, "ORDER BY 0+archObjectId");
				$whereVals = Db::getCleanWhereVals($whereVals);
				$pstmtDetail->execute($whereVals);
				while ($detailRow = $pstmtDetail->fetch(PDO::FETCH_ASSOC)) {

					$detailObj->clearValues();
					$detailObj->setValues($detailRow);
					$detailValues = $detailObj->getExtendedValues(array('export' => true, 'skipExtendedExport' => true));

					$out['EXCAVATIONLIST'][$excavCount]['ARCHOBJECTLIST'][$detailCount] = $detailValues;
					$detailCount++;
					set_time_limit($oldTimeLimit);
				}
				$pstmtDetail->closeCursor();

			}  // eo arch object

			// -----------------------------------------------

			if ($_REQUEST['archObjGroup']) {

				$detailCount = 0;

				$detailObj = new ArchObjGroup();

				$whereVals = array('excavId' => $excavRow['id']);
				if ($_REQUEST['archObjGroupBeginId']) {
					$whereVals['archObjGroupId#SIGNED,>=,archObjGroupBeginId'] = $_REQUEST['archObjGroupBeginId'];
				}
				if ($_REQUEST['archObjGroupEndId']) {
					$whereVals['archObjGroupId#SIGNED,<=,archObjGroupEndId'] = $_REQUEST['archObjGroupEndId'];
				}

				$pstmtDetail = Db::prepare('SELECT * FROM ' . ArchObjGroup::$tableName, $whereVals, "ORDER BY 0+archObjGroupId");
				$whereVals = Db::getCleanWhereVals($whereVals);
				$pstmtDetail->execute($whereVals);
				while ($detailRow = $pstmtDetail->fetch(PDO::FETCH_ASSOC)) {

					$detailObj->clearValues();
					$detailObj->setValues($detailRow);
					$detailValues = $detailObj->getExtendedValues(array('export' => true, 'skipExtendedExport' => true));

					$out['EXCAVATIONLIST'][$excavCount]['ARCHOBJECTGROUPLIST'][$detailCount] = $detailValues;
					$detailCount++;
					set_time_limit($oldTimeLimit);
				}
				$pstmtDetail->closeCursor();

			}  // eo arch object group

			// -----------------------------------------------

			$excavCount++;

		}  // eo EXCAVATION

	}  // eo excavation detail data



	// ###############################
	// #####   MASTER DATA ###

	// company master
	if ($_REQUEST['companyMaster']) {

		$whereVals = array();
		$pstmtDetail = Db::prepare('SELECT * FROM ' . Company::$tableName, $whereVals);  // LIMIT 1 ???
		$pstmtDetail->execute($whereVals);
		while ($detailRow = $pstmtDetail->fetch(PDO::FETCH_ASSOC)) {
			$detailObj = new Company($detailRow);
			$detailValues = $detailObj->getExtendedValues(array('export' => true));
			$out['MASTERDATA']['COMPANYLIST'][] = $detailValues;
		}
		$pstmtDetail->closeCursor();

	}  // eo company master


	// stratum category master
	if ($_REQUEST['stratumCategoryMaster']) {
		$out['MASTERDATA']['STRATUMCATEGORYLIST'] = StratumCategory::getRecords();
	}  // eo stratum category master


	// stratum type master
	if ($_REQUEST['stratumTypeMaster']) {

		$whereVals = array();
		$pstmtDetail = Db::prepare('SELECT * FROM ' . StratumType::$tableName, $whereVals);
		$pstmtDetail->execute($whereVals);
		while ($detailRow = $pstmtDetail->fetch(PDO::FETCH_ASSOC)) {
			$detailObj = new StratumType($detailRow);
			$detailValues = $detailObj->getExtendedValues(array('export' => true));
			$out['MASTERDATA']['STRATUMTYPELIST'][] = $detailValues;
		}
		$pstmtDetail->closeCursor();

	}  // eo stratum type master


	// object type master
	if ($_REQUEST['archObjectTypeMaster']) {

		$whereVals = array();
		$pstmtDetail = Db::prepare('SELECT * FROM ' . ArchObjectType::$tableName, $whereVals);
		$pstmtDetail->execute($whereVals);
		while ($detailRow = $pstmtDetail->fetch(PDO::FETCH_ASSOC)) {
			$detailObj = new ArchObjectType($detailRow);
			$detailValues = $detailObj->getExtendedValues(array('export' => true));
			$out['MASTERDATA']['ARCHOBJECTTYPELIST'][] = $detailValues;
		}
		$pstmtDetail->closeCursor();

	}  // eo object type master


	// object group type master
	if ($_REQUEST['archObjGroupTypeMaster']) {

		$whereVals = array();
		$pstmtDetail = Db::prepare('SELECT * FROM ' . ArchObjGroupType::$tableName, $whereVals);
		$pstmtDetail->execute($whereVals);
		while ($detailRow = $pstmtDetail->fetch(PDO::FETCH_ASSOC)) {
			$detailObj = new ArchObjGroupType($detailRow);
			$detailValues = $detailObj->getExtendedValues(array('export' => true));
			$out['MASTERDATA']['ARCHOBJECTGROUPTYPELIST'][] = $detailValues;
		}
		$pstmtDetail->closeCursor();

	}  // eo object group type master


	// db structure
	if ($_REQUEST['dbStruct']) {
		$dbDefAliasId = Logon::$logon->dbDefAliasId;
		/*
		if (!$dbDefAliasId) {
			echo $log->flush("No database initialisized. May be logon timed out?\n");
			exit;
		}
		*/
		$dbDef = Config::$dbDefs[$dbDefAliasId];
		//$out['EXTRADATA']['DBSTRUCT'] = ConfigDb::getDbStruc($dbDef['dbName']);
	}  // eo stratum category master


	// return collected data
	return $out;
}  // eo collect export data





?>
