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

/*
 * TODO
 * move stratify import to separate importExternal module
 * and  use separate input form for that
*
*  PRIVATE NOTICE: references are a wild thing ;-(
 */


/*
* Upload file. Precheck input
*/
if ($_REQUEST['_action'] == 'upload') {

	$importId = time();

	// new entry needs file name and a size
	if (!$_FILES['uploadFileName']['name']) {
		echo Extjs::errorMsg('Name der hochgeladenen Datei konnte nicht ermittelt werden.');
		exit;
	}
	if (!$_FILES['uploadFileName']['size']) {
		echo Extjs::errorMsg('Die hochgeladenen Datei ist leer oder zu gross (Limits: Post=' .
														 ini_get('post_max_size') . ', FileUp=' . ini_get('upload_max_filesize') . ')');
		exit;
	}
	if ($_FILES['uploadFileName']['error'] != UPLOAD_ERR_OK) {
		echo Extjs::errorMsg('Fehler ' . $_FILES['uploadFileName']['error'] . ' beim Hochladen der Datei ' . $_REQUEST['uploadFileName']);
		exit;
	}


	// precheck if target excav is needed and given
	needTargetExcavInput();

	// save upload and file info to session
	Oger::sessionRestart();
	$_SESSION[Logon::$_id]['import'][$importId]['fileMemo'] = $_FILES['uploadFileName'];
	$_SESSION[Logon::$_id]['import'][$importId]['requestMemo'] = $_REQUEST;

	$log = '';
	$log .= "Filename: " . $_SESSION[Logon::$_id]['import'][$importId]['fileMemo']['name'] . "\n";

	// move uploaded file to permanent place
	$movedUploadFile = $_FILES['uploadFileName']['tmp_name'] . "_ogerarch-upload";
	if (!move_uploaded_file($_FILES['uploadFileName']['tmp_name'], $movedUploadFile)) {
		echo "<br>ABBRUCH: Uploadfile konnte nicht gespeichert werden (move_uploaded_file failed).\n";
		exit;
	}
	$_SESSION[Logon::$_id]['import'][$importId]['fileMemo']['tmp_name_moved'] = $movedUploadFile;
	session_write_close();

	// output log
	$log .= "Upload OK.\n";
	$log .= "ImportID $importId\n";
	$log .= "Import startet automatisch in eigenem Fenster.\n";
	echo Extjs::encData(array('log' => $log, 'importId' => $importId));

	exit;
}  // precheck



/*
* Import file
*/
if ($_REQUEST['_action'] == 'import') {

	$importId = $_REQUEST['importId'];

	echo HtmlHelper::htmlStart();

	if (!$importId) {
		echo "<H1>Importfehler</H1>\n";
		echo "<br>ABBRUCH: ImportID fehlt.\n";
		exit;
	}

	if (!$_SESSION[Logon::$_id]['import'][$importId]) {
		echo "<H1>Importfehler</H1>\n";
		echo "<br>ABBRUCH: ImportID " . $importId . " nicht gefunden. Eventuell bereits importiert oder Upload fehlerhaft.<br>";
		exit;
	}

	// process and destroy session object and tmp upload file
	$content = file_get_contents($_SESSION[Logon::$_id]['import'][$importId]['fileMemo']['tmp_name_moved']);
	unlink($_SESSION[Logon::$_id]['import'][$importId]['fileMemo']['tmp_name_moved']);

	$_REQUEST = array_merge($_SESSION[Logon::$_id]['import'][$importId]['requestMemo'], $_REQUEST);
	$sessionMemo = $_SESSION[Logon::$_id]['import'][$importId];
	unset($_SESSION[Logon::$_id]['import'][$importId]);


	// precheck if target excav is needed and given
	needTargetExcavInput();


	switch ($_REQUEST['fileFormat']) {
	case 'STRATIFY_LST':
		importStratifyLst($excav, $content, $_REQUEST['actionMode'] == 'ACTIONMODE_APPLY');
		break;
	case 'OGERARCH_JSON':
	case 'ARCHDOCUCOMPAT_JSON':
		importOgerArchJson($content, $sessionMemo);
		break;
	default:
		echo 'Unbekanntes Importformat ' . $_REQUEST['fileFormat'];
		exit;
	}

	exit;
}  // import



// include(__DIR__ . '/importSpecialFormats.php');



/*
* Import ogerarch JSON
*/
function importOgerArchJson($content, $sessionMemo) {

	$doApply = $sessionMemo['requestMemo']['actionMode'] == 'ACTIONMODE_APPLY';

	echo "<H1>Import OgerArch JSON File</H1>";
	echo "*** Dateiname: " . $sessionMemo['fileMemo']['name'] . "<br>";
	echo "*** Dateigrösse: " . strlen($content) . " Bytes<br>";
	echo "*** Modus: " . $sessionMemo['requestMemo']['actionMode'] . "<br>";

	// backward compability - remove comments (2012-05) TODO cleanup someday
	// comments are not specified in JSON, so we do not exmport anymore
	// but offer a formated json export
	if (preg_match('|^//.*$|ms', $content)) {
		echo "<br><hr><b>WICHTIGER HINWEIS:</b><br>Die Importdatei enthält Kommentare, was auf eine veraltete Version hinweist. " .
				 "Die Kommentare werde entfernt und der Import wird durchgeführt.<br>" .
				 "<b>Bitte die Installation mit welcher die Exportdatei erstellt wurde aktualisieren.</b><br><hr><br>\n";
		$content = preg_replace('|^//.*$|ms', '', $content);
		$content = preg_replace('|^\s*$|ms', '', $content);
	}

	// backward compability mode for archdocu-exports
	// try to sanisize nullvalues to "0".
	// maybe result in ugly output
	// UGLY HACK, NOT VERY SAFE BUT WE RISK THAT THE IMPORT FAILS AT JSON_DECODE
	// WILL FAIL if ':null' is part of a string content
	if ($sessionMemo['requestMemo']['fileFormat'] == 'ARCHDOCUCOMPAT_JSON') {
		$content = str_replace(':null', ':"0"', $content);
	}

	// decode
	$importPack = json_decode($content, true);
	if (!$importPack) {          // if === null ???
		$jsonError = json_last_error();
		$jsonErrorText = "$jsonError ";
		switch ($jsonError) {
		case JSON_ERROR_NONE:
			$jsonErrorText .= 'Es ist ein JSON-Fehler aufgetreten';
			break;
		case JSON_ERROR_DEPTH:
			$jsonErrorText .= 'Die maximale Stacktiefe wurde erreicht';
			break;
		case JSON_ERROR_CTRL_CHAR:
			$jsonErrorText .= 'Steuerzeichenfehler - eventuell fehlerhaft kodiert';
			break;
		case JSON_ERROR_SYNTAX:
			$jsonErrorText .= 'Syntaxfehler - eventuell Kommentarzeilen enthalten';
			break;
		default:
			$jsonErrorText .= 'Unbekannter Fehler';
		}
		echo "<br>Importdatei ohne Daten oder fehlerhaft.<br>JSON-Fehlercode: $jsonErrorText.<br>";
		exit;
	}


	// sanisize array - cast not possible because of reference usage
	if (!is_array($importPack['EXCAVATIONLIST'])) {
		$importPack['EXCAVATIONLIST'] = array();
	}

	// backward compability for renamed items (2012-05) TODO cleanup someday
	foreach ($importPack['EXCAVATIONLIST'] as &$importVals) {
		if (!$importVals['TRANSFERHEADER']['EXCAVATIONMASTERCOPY']) {
			$importVals['TRANSFERHEADER']['EXCAVATIONMASTERCOPY'] = $importVals['TRANSFERHEADER']['MASTERDATACOPY'];
		}
	}
	unset($importVals);   // release reference to importpackage


	// list contained excavations and exit
	// OBSOLETED by content listing
	if ($sessionMemo['requestMemo']['actionMode'] == 'ACTIONMODE_EXCAVATIONLIST') {
		echo "<br>";
		echo "<H3>Liste der Grabungen in der Importdatei</H3>";
		echo "<UL>";
		foreach ($importPack['EXCAVATIONLIST'] as &$importVals) {
			$sourceExcavCopyVals = $importVals['TRANSFERHEADER']['EXCAVATIONMASTERCOPY'];
			echo "<LI>ID " . $sourceExcavCopyVals['id'] . " " . $sourceExcavCopyVals['name'] .
						" von " . $sourceExcavCopyVals['beginDate'] . " bis " . $sourceExcavCopyVals['endDate'] .
						""; //"<br>";
		}
		unset($importVals);   // release reference to importpackage
		echo "</UL>";
		echo "Ende der Grabungsliste<br>";
		exit;
	}


	// list volume contents and exit
	if ($sessionMemo['requestMemo']['actionMode'] == 'ACTIONMODE_VOLUMECONTENT') {
		echo "<br>";
		echo "<H3>Kurzübersicht über den Inhalt der Importdatei</H3>\n";
		echo "Erstellt am " . $importPack['METADATA']['DATE'] . "<br><br>\n";
		echo "OgerArch-Version " . $importPack['METADATA']['OGERARCHVERSION'] . "<br>\n";
		echo "DbStruc-Version " . $importPack['METADATA']['DBSERIAL'] . "<br><br>\n";
		echo "<b>" . count($importPack['EXCAVATIONLIST']) . " Grabungen:</b><br>\n";
		echo "<UL>";
		foreach ($importPack['EXCAVATIONLIST'] as &$importVals) {
			$sourceExcavCopyVals = $importVals['TRANSFERHEADER']['EXCAVATIONMASTERCOPY'];
			echo "<LI><b>ID " . $sourceExcavCopyVals['id'] . ": " . $sourceExcavCopyVals['name'] .
						" von " . $sourceExcavCopyVals['beginDate'] . " bis " . $sourceExcavCopyVals['endDate'] .
						"</b>"; //"<br>";
			echo "<UL>";
			echo "<LI>" . count($importVals['ARCHFINDLIST']) . " Funde";
			echo "<LI>" . count($importVals['STRATUMLIST']) . " Strata";
			echo "<LI>" . count($importVals['ARCHOBJECTLIST']) . " Objekte";
			echo "<LI>" . count($importVals['ARCHOBJECTGROUPLIST']) . " Objektgruppen";
			echo "</UL>";
		}
		unset($importVals);   // release reference to importpackage
		echo "</UL>";
		echo "<b>Stammdaten:</b><br>\n";
		echo "<UL>";
		echo "<LI>" . count($importPack['MASTERDATA']['COMPANYLIST']) . " Firmen";
		echo "<LI>" . count($importPack['MASTERDATA']['STRATUMCATEGORYLIST']) . " Stratum Kategorien";
		echo "<LI>" . count($importPack['MASTERDATA']['STRATUMTYPELIST']) . " Stratum Art/Bezeichnung";
		echo "<LI>" . count($importPack['MASTERDATA']['ARCHOBJECTTYPELIST']) . " Objekt Art/Bezeichnung";
		echo "<LI>" . count($importPack['MASTERDATA']['ARCHOBJECTGROUPTYPELIST']) . " Objektgruppe Art/Bezeichnung";
		echo "</UL>";
		echo "<b>Extradaten:</b><br>\n";
		echo "<UL>";
		echo "<LI>Datenbankstruktur ist " . (count($importPack['EXTRADATA']['DBSTRUCT']) ? '' : 'nicht ') . "enthalten";
		echo "</UL>";
		echo "*** Ende der Kurzübersicht<br>";
		exit;
	}


	###############################################################
	# create autobackup

	$_REQUEST['__OGER_AUTOBACKUP__'] = "import";
	include(__DIR__ . "/exportSql.php");


	###############################################################
	# start import

	$oldTimeLimit = ini_get('max_execution_time');

	if (excavDataRequested()) {

		if (!$_REQUEST['sourceExcavId']) {
			// if no source excav id is given and only one excavation in import file
			// then take the excav id of that excavation
			if (count($importPack['EXCAVATIONLIST']) == 1) {
				$_REQUEST['sourceExcavId'] = $importPack['EXCAVATIONLIST'][0]['TRANSFERHEADER']['EXCAVATIONMASTERCOPY']['id'];
			}
			else {
				echo "<br>ABBRUCH: Keine Quell GrabungsID angegeben.<br>";
				exit;
			}
		}

		$sourceExcavPos = -1;
		$sourceExcavCopyVals = array();
		foreach ($importPack['EXCAVATIONLIST'] as &$importVals) {
			$sourceExcavPos++;
			if ($importVals['TRANSFERHEADER']['EXCAVATIONMASTERCOPY']['id'] == $_REQUEST['sourceExcavId']) {
				$sourceExcavCopyVals = $importPack['EXCAVATIONLIST'][$sourceExcavPos]['TRANSFERHEADER']['EXCAVATIONMASTERCOPY'];
				break;
			}
		}
		unset($importVals);   // release reference to importpackage

		if (!$sourceExcavCopyVals) {
			echo "<br>ABBRUCH: Quell GrabungsID '" . $_REQUEST['sourceExcavId'] . "' nicht in Importdatei gefunden.<br>";
			exit;
		}

		echo "<br>";
		echo "*** Quell Grabung:" . " ID " . $_REQUEST['sourceExcavId'] .
																" " . $sourceExcavCopyVals['name'] .
																" von " . $sourceExcavCopyVals['beginDate'] . " bis " . $sourceExcavCopyVals['endDate'] .
																" (Methode: " . $sourceExcavCopyVals['excavMethodId'] . ")" .
																"<br>\n";
		echo "*** Position der Quell Grabung im Datenträger: " . ($sourceExcavPos + 1) . "<br>";
		echo "<br>";

	}  // eo source excav needed


	if (needTargetExcavInput() || $_REQUEST['excavationInsert']) {

		if ($_REQUEST['excavationInsert']) {
			$targetExcavRow = $sourceExcavCopyVals;
			$targetExcavRow['id'] = "_NEU_";  // will be overwritten on db-insert
		}
		else {
			$targetExcavRow = Dbw::fetchRow1(
				"SELECT * FROM excavation WHERE id=:id", array("id" => $_REQUEST['targetExcavId']));
		}


		echo "*** Ziel Grabung:" . " ID " . $targetExcavRow['id'] . " " . $targetExcavRow['name'] .
															 " von " . $targetExcavRow['beginDate'] . " bis " . $targetExcavRow['endDate'] .
															 " (Methode: " . $targetExcavRow['excavMethodId'] . ")" .
															 "<br>";
		echo "<br>";

		if (needTargetExcavInput()) {
			if ($sourceExcavCopyVals['excavMethodId'] != $targetExcavRow['excavMethodId']) {
				echo "<br><br>ABBRUCH: Die Grabungsmethoden stimmen nicht überein.<br>";
				exit;
			}
		}

	}  // if target excav or new excav


	if (!$doApply) {
		echo "<hr><br><b>*** TESTLAUF *** Übernahme wird nur getestet, aber nicht durchgeführt.</b><br>";
	}

	echo "<br>";
	flush();


	########################################

	$errorTotal = 0;

	########################################
	# MASTERDATA

	// company
	if ($_REQUEST['companyMaster']) {

		echo "<HR>";
		echo "<H3>Firmenstamm</H3>";

		unset($importVals);   // release reference to importpackage
		$importVals = $importPack['MASTERDATA']['COMPANYLIST'][0];  // first (and only)
		if (!$importVals) {
			echo "Kein Firmenstamm in Importdatei - kein Import möglich<br>\n";
		}
		else {
			$oldRecord = Company::newFromDb(array('id' => 1));
			$dbAction = null;
			if ($_REQUEST['companyMaster'] == 'INSERT') {
				if ($oldRecord->values) {
					echo "Firmenstamm bereits vorhanden - Import wird nicht durchgeführt.<br>\n";
				}
				else {
					$dbAction = DB::ACTION_INSERT;
				}
			}
			elseif ($_REQUEST['companyMaster'] == 'REPLACE_OR_INSERT') {
				$dbAction = DB::ACTION_UPDATE;
				// fallback to insert if not exists
				if (!$oldRecord->values) {
					$dbAction = DB::ACTION_INSERT;
				}
			}

			if ($dbAction) {
				$result = Company::saveInput($importVals, $dbAction, array('checkOnly' => (!$doApply)));
				if ($result['errorMsg']) {
					echo "Fehler bei Firmenstamm ($dbAction): {$result['errorMsg']}<br>";
					$errorCount++;
				}
				else {
					echo "Firmenstamm erfolgreich übernommen ($dbAction).<br>";
				}
			}
		}  // eo import-record exists - try import

	}  // eo company


	// -------------------------

	$allTypeInsertSum = 0;

	// -------------------------


	// stratum categories
	if ($_REQUEST['stratumCategoryMaster']) {
		// stratum categories - are fixed and therefore cannot be imported
	}


	// stratum types
	$tmpPstmt = Db::prepare("SELECT * FROM " . StratumType::$tableName);
	$tmpPstmt->execute();
	$stratumTypes = (array)$tmpPstmt->fetchAll(PDO::FETCH_ASSOC);
	$tmpPstmt->closeCursor();

	if ($_REQUEST['stratumTypeMaster']) {

		echo "<HR>";
		echo "<H3>Stammdaten: Stratum Art/Bezeichnung</H3>";

		$typeInsertCount = 0;
		foreach((array)$importPack['MASTERDATA']['STRATUMTYPELIST'] as $importVals) {
			$found = false;
			foreach ($stratumTypes as $archType) {
				if (strtoupper($importVals['name']) == strtoupper($archType['name']) &&
						$importVals['categoryId'] == $archType['categoryId']) {
					$found = true;
					break;
				}
			}  // eo search for known stratum type
			if ($found) {
				continue;
			}
			$typeRec = new StratumType($importVals);
			$typeRec->values['id'] = -1;
			if ($doApply) {
				$typeRec->values['id'] = StratumType::getMaxValue('id') + 1;
				$typeRec->toDb(Db::ACTION_INSERT);
			}
			$categoryRecord = StratumCategory::newFromDb(array('id' => $importVals['categoryId']));
			echo "Art/Bezeichnung {$importVals['name']} in Kategorie {$categoryRecord->values['name']} erfolgreich angelegt.<br>";
			$typeInsertCount++;
			$allTypeInsertSum++;
			// remember new types (also usefull for test-only mode)
			$stratumTypes[] = $typeRec->values;
		}
		echo "<br>Statistik Stratum Art/Bezeichnung:<br>" .
				 " * $typeInsertCount Datensätze hinzugefügt<br>";
	}  // eo stratum type


	// arch object types
	$tmpPstmt = Db::prepare("SELECT * FROM " . ArchObjectType::$tableName);
	$tmpPstmt->execute();
	$archObjectTypes = (array)$tmpPstmt->fetchAll(PDO::FETCH_ASSOC);
	$tmpPstmt->closeCursor();

	if ($_REQUEST['archObjectTypeMaster']) {

		echo "<HR>";
		echo "<H3>Stammdaten: Objekt Art/Bezeichnung</H3>";

		$typeInsertCount = 0;
		foreach((array)$importPack['MASTERDATA']['ARCHOBJECTTYPELIST'] as $importVals) {
			$found = false;
			foreach ($archObjectTypes as $archType) {
				if (strtoupper($importVals['name']) == strtoupper($archType['name'])) {
					$found = true;
					break;
				}
			}  // eo search for known stratum type
			if ($found) {
				continue;
			}
			$typeRec = new ArchObjectType($importVals);
			$typeRec->values['id'] = -1;
			if ($doApply) {
				$typeRec->values['id'] = ArchObjectType::getMaxValue('id') + 1;
				$typeRec->toDb(Db::ACTION_INSERT);
			}
			echo "Art/Bezeichnung {$importVals['name']} erfolgreich angelegt.<br>";
			$typeInsertCount++;
			$allTypeInsertSum++;
			// remember new types (also usefull for test-only mode)
			$archObjectTypes[] = $typeRec->values;
		}
		echo "<br>Statistik Objekt Art/Bezeichnung:<br>" .
				 " * $typeInsertCount Datensätze hinzugefügt<br>";
	}


	// arch object group types
	$tmpPstmt = Db::prepare("SELECT * FROM " . ArchObjGroupType::$tableName);
	$tmpPstmt->execute();
	$archObjGroupTypes = (array)$tmpPstmt->fetchAll(PDO::FETCH_ASSOC);
	$tmpPstmt->closeCursor();

	if ($_REQUEST['archObjGroupTypeMaster']) {

		echo "<HR>";
		echo "<H3>Stammdaten: Objektgruppe Art/Bezeichnung</H3>";

		$typeInsertCount = 0;
		foreach((array)$importPack['MASTERDATA']['ARCHOBJECTGROUPTYPELIST'] as $importVals) {
			$found = false;
			foreach ($archObjGroupTypes as $archType) {
				if (strtoupper($importVals['name']) == strtoupper($archType['name'])) {
					$found = true;
					break;
				}
			}  // eo search for known stratum type
			if ($found) {
				continue;
			}
			$typeRec = new ArchObjGroupType($importVals);
			$typeRec->values['id'] = -1;
			if ($doApply) {
				$typeRec->values['id'] = ArchObjGroupType::getMaxValue('id') + 1;
				$typeRec->toDb(Db::ACTION_INSERT);
			}
			echo "Art/Bezeichnung {$importVals['name']} erfolgreich angelegt.<br>";
			$typeInsertCount++;
			$allTypeInsertSum++;
			// remember new types (also usefull for test-only mode)
			$archObjGroupTypes[] = $typeRec->values;
		}
		echo "<br>Statistik Objektgruppe Art/Bezeichnung:<br>" .
				 " * $typeInsertCount Datensätze hinzugefügt<br>";
	}



	########################################
	# EXCAVATION DATA

	set_time_limit($oldTimeLimit);

	// excavation master data
	if ($_REQUEST['excavationInsert'] || $_REQUEST['excavationUpdate']) {

		echo "<HR>";
		echo "<H3>Grabungsstamm</H3>";

		unset($importVals);   // release reference to importpackage
		$importVals = $sourceExcavCopyVals;
		$dbAction = null;
		$importVals['id'] = $targetExcavRow['id'];
		if ($_REQUEST['excavationInsert']) {
			unset($importVals['id']);
			$dbAction = DB::ACTION_INSERT;
		}
		elseif ($_REQUEST['excavationUpdate'] == 'REPLACE') {
			$dbAction = DB::ACTION_UPDATE;
		}

		if ($dbAction) {
			$result = Excavation::saveInput($importVals, $dbAction, array('checkOnly' => (!$doApply)));
			if ($result['errorMsg']) {
				echo "<br>ABBRUCH: Fehler bei Grabung {$importVals['id']} {$importVals['name']} ($dbAction): {$result['errorMsg']}<br>";
				exit;
			}
			// read target excavation back from database if applied
			if ($doApply) {
				$targetExcavRow = Dbw::fetchRow1(
					"SELECT * FROM excavation WHERE id=:id", array("id" => $result['data']['id']));
			}
			echo "Grabung: " . $targetExcavRow['id'] . " " . $targetExcavRow['name'] .
																 " von " . $targetExcavRow['beginDate'] . " bis " . $targetExcavRow['endDate'] .
																 " (Methode: " . $targetExcavRow['excavMethodId'] . ")" .
																 " erfolgreich angelegt ($dbAction)." .
																 "<br>";
		}
	}  // eo excavation master


	// -----------------------------------------------------




	// ##########################################
	// ARCH FIND
	echo "<HR>";
	echo "<H3>Fund</H3>";

	if ($_REQUEST['archFindInsert'] || $_REQUEST['archFindUpdate']) {

		if ($_REQUEST['logExtended']) {
			echo count($importPack['EXCAVATIONLIST'][$sourceExcavPos]['ARCHFINDLIST']) . " Funde am Datenträger.<br><br>";
		}

		$insertCount = 0;
		$updateCount = 0;
		$errorCount = 0;
		// sanisize array - cast not possible because of reference usage
		if (!is_array($importPack['EXCAVATIONLIST'][$sourceExcavPos]['ARCHFINDLIST'])) {
			$importPack['EXCAVATIONLIST'][$sourceExcavPos]['ARCHFINDLIST'] = array();
		}
		foreach ($importPack['EXCAVATIONLIST'][$sourceExcavPos]['ARCHFINDLIST'] as &$importVals) {

			$dbAction = null;
			$importVals['excavId'] = $targetExcavRow['id'];

			// check for import range
			$_REQUEST['archFindBeginId'] = trim($_REQUEST['archFindBeginId']);
			$_REQUEST['archFindEndId'] = trim($_REQUEST['archFindEndId']);
			if (($_REQUEST['archFindBeginId'] &&
					 Oger::getNatSortId($importVals['archFindId']) < Oger::getNatSortId($_REQUEST['archFindBeginId'])) ||
					($_REQUEST['archFindEndId'] &&
					 Oger::getNatSortId($importVals['archFindId']) > Oger::getNatSortId($_REQUEST['archFindEndId']))) {
				if ($_REQUEST['logExtended']) {
					echo "Fund {$importVals['archFindId']} nicht innerhalb des von/bis Bereiches.<br>";
				}
				continue;
			}

			// precheck if should be imported at all
			$oldRecord = Dbw::fetchRow1(
				"SELECT * FROM archFind WHERE excavId=:excavId AND archFindId=:archFindId",
				array("excavId" => $importVals['excavId'], "archFindId" => $importVals['archFindId']));

			if ($oldRecord !== false) {
				if ($_REQUEST['archFindUpdate'] == 'REPLACE') {
					// import ok - nothing to do
				}
				//elseif ($_REQUEST['archFindUpdate'] == 'MERGE_EMPTY') {
					// TODO
				//}
				else {
					if ($_REQUEST['logExtended']) {
						echo "Fund {$importVals['archFindId']} bereits vohanden und kein Update gewünscht.<br>";
					}
					continue;
				}
				$dbAction = "UPDATE";
			}
			else {  // no old record present
				if ($_REQUEST['archFindInsert'] == 'INSERT') {
					// import ok - nothing to do
				}
				else {
					if ($_REQUEST['logExtended']) {
						echo "Fund {$importVals['archFindId']} nicht vorhanden und keine Neuanlage gewünscht.<br>";
					}
					continue;
				}
				$dbAction = "INSERT";
			}
			unset($importVals['id']);  // id not used anymore

			// store to db
			try {
				ArchFind12::storeInput($importVals, $dbAction,
															 array("removeRefs" => $_REQUEST['archFindRemoveRefs'],
																		 "checkOnly" => (!$doApply)));
			}
			catch (Exception $ex) {
				echo "Fehler bei Fund {$importVals['archFindId']}: {$ex->getMessage()}<br>";
				$errorCount++;
				continue;
			}

			echo "Fund {$importVals['archFindId']} erfolgreich importiert ($dbAction).<br>";
			if ($dbAction == Db::ACTION_INSERT) {
				$insertCount++;
			}
			else {
				$updateCount++;
			}

			set_time_limit($oldTimeLimit);
		}  // eo arch find loop
		unset($importVals);   // release reference to importpackage

		$errorTotal += $errorCount;
		echo "<br>Statistik Fund:<br>" .
				 " * $insertCount Datensätze hinzugefügt<br>" .
				 " * $updateCount Datensätze aktualisiert<br>" .
				 " *** $errorCount Fehler ***<br>";
	}
	else {
		echo "Import nicht ausgewählt.<br>";
	}  // eo arch find
	flush();


	// ##########################################
	// STRATUM
	echo "<HR>";
	echo "<H3>Stratum</H3>";

	if ($_REQUEST['stratumInsert'] || $_REQUEST['stratumUpdate']) {

		if ($_REQUEST['logExtended']) {
			echo count($importPack['EXCAVATIONLIST'][$sourceExcavPos]['STRATUMLIST']) . " Strata am Datenträger.<br><br>";
		}

		$insertCount = 0;
		$updateCount = 0;
		$typeInsertCount = 0;
		$errorCount = 0;
		// sanisize array - cast not possible because of reference usage
		if (!is_array($importPack['EXCAVATIONLIST'][$sourceExcavPos]['STRATUMLIST'])) {
			$importPack['EXCAVATIONLIST'][$sourceExcavPos]['STRATUMLIST'] = array();
		}
		foreach ($importPack['EXCAVATIONLIST'][$sourceExcavPos]['STRATUMLIST'] as &$importVals) {

			$dbAction = null;
			$importVals['excavId'] = $targetExcavRow['id'];

			// check for import range
			if (($_REQUEST['stratumBeginId'] &&
					 Oger::getNatSortId($importVals['stratumId']) < Oger::getNatSortId($_REQUEST['stratumBeginId'])) ||
					($_REQUEST['stratumEndId'] &&
					 Oger::getNatSortId($importVals['stratumId']) > Oger::getNatSortId($_REQUEST['stratumEndId']))) {
				if ($_REQUEST['logExtended']) {
					echo "Stratum {$importVals['stratumId']} nicht innerhalb des von/bis Bereiches.<br>";
				}
				continue;
			}

			// precheck if should be imported at all
			$oldRecord = Dbw::fetchRow1(
				"SELECT * FROM stratum WHERE excavId=:excavId AND stratumId=:stratumId",
				array("excavId" => $importVals['excavId'], "stratumId" => $importVals['stratumId']));

			if ($oldRecord !== false) {
				if ($_REQUEST['stratumUpdate'] == 'REPLACE') {
					// import ok - nothing to do
				}
				//elseif ($_REQUEST['stratumUpdate'] == 'MERGE_EMPTY') {
					// TODO
				//}
				else {
					if ($_REQUEST['logExtended']) {
						echo "Stratum {$importVals['stratumId']} bereits vohanden und kein Update gewünscht.<br>";
					}
					continue;
				}
				$dbAction = Db::ACTION_UPDATE;
				$importVals['id'] = $oldRecord['id'];
			}
			else {
				if ($_REQUEST['stratumInsert'] == 'INSERT') {
					// import ok - nothing to do
				}
				else {
					if ($_REQUEST['logExtended']) {
						echo "Stratum {$importVals['stratumId']} nicht vorhanden und keine Neuanlage gewünscht.<br>";
					}
					continue;
				}
				$dbAction = Db::ACTION_INSERT;
				unset($importVals['id']);
			}

			// prepare values
			//unset($importVals['id']);  // id not used anymore
			// we can NOT unset id, because on update we need that id if the
			// stratum taböe is updated, but the category changes and we have to
			// provide an id for insert into the new subtable (stratumInterface, ...)

			// -----------------------------------
			// for backward compatibility
			// field rename: tombOtherMaterialStratumId -> tombOtherMaterialStratumIdList
			// use old name, if new not present (old export file) in import

			if (array_key_exists("tombOtherMaterialStratumId", $importVals) &&
					!array_key_exists("tombOtherMaterialStratumIdList", $importVals)) {
				$importVals['tombOtherMaterialStratumIdList'] = $importVals['tombOtherMaterialStratumId'];
			}

			// handle stratum type masterdata, only important if type is given
			// only type name is checked - type id is recalced
			$importVals['typeName'] = trim($importVals['typeName']);
			$importVals['typeId'] = trim($importVals['typeId']);

			// sanity check if type name is "lost" but type id holds a "name"
			// setting an empty id does no harm because name IS empty already
			if (!$importVals['typeName'] && !is_numeric($importVals['typeId'])) {
				$importVals['typeName'] = $importVals['typeId'];
			}

			if (!$importVals['typeName']) {
				$importVals['typeId'] = "";
			}
			else {

				$knownTypeId = null;

				// search (case insensitive) for known stratum type names (categoryId must match as well)
				// known stratum types get internal id even if it is an "text only" value
				// (no masterdata) in the source excavation
				foreach ($stratumTypes as $archType) {
					if (strtoupper($importVals['typeName']) == strtoupper($archType['name']) &&
							$importVals['categoryId'] == $archType['categoryId']) {
						$knownTypeId = $archType['id'];
						break;
					}
				}  // eo search for known stratum type

				// stratum type is known
				if ($knownTypeId) {
					$importVals['typeId'] = $knownTypeId;
				}
				// stratum type is unknown
				else {

					$typeImportMode = null;

					switch ($sessionMemo['requestMemo']['stratumType']) {
					case 'INHERIT_SOURCE':
						if (is_numeric($importVals['typeId'])) {
							$typeImportMode = 'TYPEIMPORT_MASTERDATA';
						}
						else {
							$typeImportMode = 'TYPEIMPORT_TEXT';
						}
						break;
					case 'MASTERDATA_ONLY':
						$typeImportMode = 'TYPEIMPORT_MASTERDATA';
						break;
					case 'TEXTVALUE_ONLY':
						$typeImportMode = 'TYPEIMPORT_TEXT';
						break;
					default:
						$typeImportMode = 'TYPEIMPORT_TEXT';
					}

					// typeName must not be empty (checked above)
					// and must not be numeric (checked now)
					if (is_numeric($importVals['typeName'])) {
						$importVals['typeName'] = "Imported (Id/Name=" . $importVals['typeName'] . ")";
					}

					switch ($typeImportMode) {
					case 'TYPEIMPORT_TEXT':
						$importVals['typeId'] = $importVals['typeName'];
						break;
					case 'TYPEIMPORT_MASTERDATA':
						// fake non-zero id for test-only mode
						$typeRec = new StratumType(array('id' => -1,
																						 'categoryId' => $importVals['categoryId'],
																						 'name' => $importVals['typeName'],
																						 'code' => $importVals['typeCode']));
						if ($doApply) {
							$typeRec->values['id'] = StratumType::getMaxValue('id') + 1;
							$typeRec->toDb(Db::ACTION_INSERT);
						}
						$categoryRecord = StratumCategory::newFromDb(array('id' => $importVals['categoryId']));
						echo "+ Stratum Art/Bezeichnung {$importVals['typeName']}" .
								 " in Kategorie {$categoryRecord->values['name']} " .
								 " von Stratum {$importVals['stratumId']} erfolgreich angelegt.<br>";
						$typeInsertCount++;
						$allTypeInsertSum++;
						// remember new types (also usefull for test-only mode)
						$stratumTypes[] = $typeRec->values;
						// adjust typeid on stratum
						$importVals['typeId'] = $typeRec->values['id'];
						break;
					default:
						echo "* Ungültiger typeImportMode '$typeImportMode' bei Stratum " . $importVals['stratumId'] . "<br>";
					}

				}  // eo unknown stratum type

			}  // eo handle stratum type

			// store to db
			try {
				Stratum12::storeInput($importVals, $dbAction,
															 array("removeRefs" => $_REQUEST['stratumRemoveRefs'],
																		 "checkOnly" => (!$doApply)));
			}
			catch (Exception $ex) {
				echo "Fehler bei Stratum {$importVals['stratumId']}: {$ex->getMessage()}<br>";
				$errorCount++;
				continue;
			}

			echo "Stratum {$importVals['stratumId']} erfolgreich importiert ($dbAction).<br>";
			if ($dbAction == Db::ACTION_INSERT) {
				$insertCount++;
			}
			else {
				$updateCount++;
			}

			set_time_limit($oldTimeLimit);
		}  // eo stratum loop
		unset($importVals);   // release reference to importpackage

		$errorTotal += $errorCount;
		echo "<br>Statistik Stratum:<br>" .
				 " * $insertCount Datensätze hinzugefügt<br>" .
				 " * $updateCount Datensätze aktualisiert<br>" .
				 " * $typeInsertCount Art/Bezeichnung Stammdaten hinzugefügt<br>" .
				 " *** $errorCount Fehler ***<br>";
	}
	else {
		echo "Kein Import ausgewählt.<br>";
	}  // eo stratum
	flush();



	// ##########################################
	// ARCH OBJECT
	echo "<HR>";
	echo "<H3>Objekt</H3>";

	if ($_REQUEST['archObjectInsert'] || $_REQUEST['archObjectUpdate']) {

		if ($_REQUEST['logExtended']) {
			echo count($importPack['EXCAVATIONLIST'][$sourceExcavPos]['ARCHOBJECTLIST']) . " Objekte am Datenträger.<br><br>";
		}

		$insertCount = 0;
		$updateCount = 0;
		$typeInsertCount = 0;
		$errorCount = 0;
		// sanisize array - cast not possible because of reference usage
		if (!is_array($importPack['EXCAVATIONLIST'][$sourceExcavPos]['ARCHOBJECTLIST'])) {
			$importPack['EXCAVATIONLIST'][$sourceExcavPos]['ARCHOBJECTLIST'] = array();
		}
		foreach ($importPack['EXCAVATIONLIST'][$sourceExcavPos]['ARCHOBJECTLIST'] as &$importVals) {

			$dbAction = null;
			$importVals['excavId'] = $targetExcavRow['id'];

			// check for import range
			if (($_REQUEST['archObjectBeginId'] && 0 + $importVals['archObjectId'] < 0 + $_REQUEST['archObjectBeginId']) ||
					($_REQUEST['archObjectEndId'] && 0 + $importVals['archObjectId'] > 0 + $_REQUEST['archObjectEndId'])) {
				if ($_REQUEST['logExtended']) {
					echo "Objekt {$importVals['archObjectId']} nicht innerhalb des von/bis Bereiches.<br>";
				}
				continue;
			}

			// precheck if imported at all
			$oldRecord = ArchObject::newFromDb(array('excavId' => $importVals['excavId'],
																							 'archObjectId' => $importVals['archObjectId']));
			if ($oldRecord->values) {
				if ($_REQUEST['archObjectUpdate'] == 'REPLACE') {
					// import ok - nothing to do
				}
				//elseif ($_REQUEST['archObjectUpdate'] == 'MERGE_EMPTY') {
					// TODO
				//}
				else {
					if ($_REQUEST['logExtended']) {
						echo "Objekt {$importVals['archObjectId']} bereits vohanden und kein Update gewünscht.<br>";
					}
					continue;
				}
				$dbAction = Db::ACTION_UPDATE;
				$importVals['id'] = $oldRecord->values['id'];
			}
			else {
				if ($_REQUEST['archObjectInsert'] == 'INSERT') {
					// import ok - nothing to do
				}
				else {
					if ($_REQUEST['logExtended']) {
						echo "Objekt {$importVals['archObjectId']} nicht vorhanden und keine Neuanlage gewünscht.<br>";
					}
					continue;
				}
				$dbAction = Db::ACTION_INSERT;
				unset($importVals['id']);
			}

			// handle arch object type masterdata, only important if type is given
			// only type name is checked - type id is recalced
			$importVals['typeName'] = trim($importVals['typeName']);
			$importVals['typeId'] = trim($importVals['typeId']);

			// sanity check if type name is "lost" but type id holds a "name"
			// setting an empty id does no harm because name IS empty already
			if (!$importVals['typeName'] && !is_numeric($importVals['typeId'])) {
				$importVals['typeName'] = $importVals['typeId'];
			}

			if (!$importVals['typeName']) {
				$importVals['typeId'] = "";
			}
			else {

				$knownTypeId = null;

				// search (case insensitive) for known arch object type names
				// known arch object types get internal id even if it is an "text only" value
				// (no masterdata) in the source excavation
				foreach ($archObjectTypes as $archType) {
					if (strtoupper($importVals['typeName']) == strtoupper($archType['name'])) {
						$knownTypeId = $archType['id'];
						break;
					}
				}  // eo search for known arch type

				// arch type is known
				if ($knownTypeId) {
					$importVals['typeId'] = $knownTypeId;
				}
				// type is unknown
				else {

					$typeImportMode = null;

					switch ($sessionMemo['requestMemo']['archObjectType']) {
					case 'INHERIT_SOURCE':
						if (is_numeric($importVals['typeId'])) {
							$typeImportMode = 'TYPEIMPORT_MASTERDATA';
						}
						else {
							$typeImportMode = 'TYPEIMPORT_TEXT';
						}
						break;
					case 'MASTERDATA_ONLY':
						$typeImportMode = 'TYPEIMPORT_MASTERDATA';
						break;
					case 'TEXTVALUE_ONLY':
						$typeImportMode = 'TYPEIMPORT_TEXT';
						break;
					default:
						$typeImportMode = 'TYPEIMPORT_TEXT';
					}

					// typeName must not be empty (checked above)
					// and must not be numeric (checked now)
					if (is_numeric($importVals['typeName'])) {
						$importVals['typeName'] = "Imported (Id/Name=" . $importVals['typeName'] . ")";
					}

					switch ($typeImportMode) {
					case 'TYPEIMPORT_TEXT':
						$importVals['typeId'] = $importVals['typeName'];
						break;
					case 'TYPEIMPORT_MASTERDATA':
						// fake non-zero id for test-only mode
						$typeRec = new ArchObjectType(array('id' => -1,
																								'name' => $importVals['typeName'],
																								'code' => $importVals['typeCode']));
						if ($doApply) {
							$typeRec->values['id'] = ArchObjectType::getMaxValue('id') + 1;
							$typeRec->toDb(Db::ACTION_INSERT);
						}
						echo "+ Objekt Art/Bezeichnung {$importVals['typeName']}" .
								 " von Objekt {$importVals['archObjectId']} erfolgreich angelegt.<br>";
						$typeInsertCount++;
						$allTypeInsertSum++;
						// remember new types (also usefull for test-only mode)
						$archObjectTypes[] = $typeRec->values;
						// adjust typeid
						$importVals['typeId'] = $typeRec->values['id'];
						break;
					default:
						echo "* Ungültiger typeImportMode '$typeImportMode' bei Objekt " . $importVals['archObjectId'] . "<br>";
					}

				}  // eo unknown type

			}  // eo handle arch type

			// store to db
			$result = ArchObject::saveInput($importVals, $dbAction,
																			array('removeRefs' => $_REQUEST['archObjectRemoveRefs'],
																						'checkOnly' => (!$doApply)));
			if ($result['errorMsg']) {
				echo "Fehler bei Objekt {$importVals['archObjectId']}: {$result['errorMsg']}<br>";
				$errorCount++;
				continue;
			}

			echo "Objekt {$importVals['archObjectId']} erfolgreich importiert ($dbAction).<br>";
			if ($dbAction == Db::ACTION_INSERT) {
				$insertCount++;
			}
			else {
				$updateCount++;
			}

			set_time_limit($oldTimeLimit);
		}  // eo arch object loop
		unset($importVals);   // release reference to importpackage

		$errorTotal += $errorCount;
		echo "<br>Statistik Objekt:<br>" .
				 " * $insertCount Datensätze hinzugefügt<br>" .
				 " * $updateCount Datensätze aktualisiert<br>" .
				 " * $typeInsertCount Art/Bezeichnung Stammdaten hinzugefügt<br>" .
				 " *** $errorCount Fehler ***<br>";

	}
	else {
		echo "Kein Import ausgewählt.<br>";
	}  // eo arch object
	flush();


	// ARCH OBJECT GROUP
	echo "<HR>";
	echo "<H3>Objektgruppe</H3>";

	if ($_REQUEST['archObjGroupInsert'] || $_REQUEST['archObjGroupUpdate']) {

		if ($_REQUEST['logExtended']) {
			echo count($importPack['EXCAVATIONLIST'][$sourceExcavPos]['ARCHOBJECTGROUPLIST']) . " Objektgruppen am Datenträger.<br><br>";
		}

		$insertCount = 0;
		$updateCount = 0;
		$typeInsertCount = 0;
		$errorCount = 0;
		// sanisize array - cast not possible because of reference usage
		if (!is_array($importPack['EXCAVATIONLIST'][$sourceExcavPos]['ARCHOBJECTGROUPLIST'])) {
			$importPack['EXCAVATIONLIST'][$sourceExcavPos]['ARCHOBJECTGROUPLIST'] = array();
		}
		foreach ($importPack['EXCAVATIONLIST'][$sourceExcavPos]['ARCHOBJECTGROUPLIST'] as &$importVals) {

			$dbAction = null;
			$importVals['excavId'] = $targetExcavRow['id'];

			// check for import range
			if (($_REQUEST['archObjGroupBeginId'] && 0 + $importVals['archObjGroupId'] < 0 + $_REQUEST['archObjGroupBeginId']) ||
					($_REQUEST['archObjGroupEndId'] && 0 + $importVals['archObjGroupId'] > 0 + $_REQUEST['archObjGroupEndId'])) {
				if ($_REQUEST['logExtended']) {
					echo "Objektgruppe {$importVals['archObjGroupId']} nicht innerhalb des von/bis Bereiches.<br>";
				}
				continue;
			}

			// precheck if imported at all
			$oldRecord = ArchObjGroup::newFromDb(array('excavId' => $importVals['excavId'],
																								 'archObjGroupId' => $importVals['archObjGroupId']));
			if ($oldRecord->values) {
				if ($_REQUEST['archObjGroupUpdate'] == 'REPLACE') {
					// import ok - nothing to do
				}
				//elseif ($_REQUEST['archObjGroupUpdate'] == 'MERGE_EMPTY') {
					// TODO
				//}
				else {
					if ($_REQUEST['logExtended']) {
						echo "Objektgruppe {$importVals['archObjGroupId']} bereits vohanden und kein Update gewünscht.<br>";
					}
					continue;
				}
				$dbAction = Db::ACTION_UPDATE;
				$importVals['id'] = $oldRecord->values['id'];
			}
			else {
				if ($_REQUEST['archObjGroupInsert'] == 'INSERT') {
					// import ok - nothing to do
				}
				else {
					if ($_REQUEST['logExtended']) {
						echo "Objektgruppe {$importVals['archObjGroupId']} nicht vorhanden und keine Neuanlage gewünscht.<br>";
					}
					continue;
				}
				$dbAction = Db::ACTION_INSERT;
				unset($importVals['id']);
			}

			// handle arch object group type masterdata, only important if type is given
			// only type name is checked - type id is recalced
			$importVals['typeName'] = trim($importVals['typeName']);
			$importVals['typeId'] = trim($importVals['typeId']);

			// sanity check if type name is "lost" but type id holds a "name"
			// setting an empty id does no harm because name IS empty already
			if (!$importVals['typeName'] && !is_numeric($importVals['typeId'])) {
				$importVals['typeName'] = $importVals['typeId'];
			}

			if (!$importVals['typeName']) {
				$importVals['typeId'] = "";
			}
			else {

				$knownTypeId = null;

				// search (case insensitive) for known arch object group type names
				// known arch object group types get internal id even if it is an "text only" value
				// (no masterdata) in the source excavation
				foreach ($archObjGroupTypes as $archType) {
					if (strtoupper($importVals['typeName']) == strtoupper($archType['name'])) {
						$knownTypeId = $archType['id'];
						break;
					}
				}  // eo search for known arch type

				// arch type is known
				if ($knownTypeId) {
					$importVals['typeId'] = $knownTypeId;
				}
				// type is unknown
				else {

					$typeImportMode = null;

					switch ($sessionMemo['requestMemo']['archObjGroupType']) {
					case 'INHERIT_SOURCE':
						if (is_numeric($importVals['typeId'])) {
							$typeImportMode = 'TYPEIMPORT_MASTERDATA';
						}
						else {
							$typeImportMode = 'TYPEIMPORT_TEXT';
						}
						break;
					case 'MASTERDATA_ONLY':
						$typeImportMode = 'TYPEIMPORT_MASTERDATA';
						break;
					case 'TEXTVALUE_ONLY':
						$typeImportMode = 'TYPEIMPORT_TEXT';
						break;
					default:
						$typeImportMode = 'TYPEIMPORT_TEXT';
					}

					// typeName must not be empty (checked above)
					// and must not be numeric (checked now)
					if (is_numeric($importVals['typeName'])) {
						$importVals['typeName'] = "Imported (Id/Name=" . $importVals['typeName'] . ")";
					}

					switch ($typeImportMode) {
					case 'TYPEIMPORT_TEXT':
						$importVals['typeId'] = $importVals['typeName'];
						break;
					case 'TYPEIMPORT_MASTERDATA':
						// fake non-zero id for test-only mode
						$typeRec = new ArchObjGroupType(array('id' => -1,
																									'name' => $importVals['typeName'],
																									'code' => $importVals['typeCode']));
						if ($doApply) {
							$typeRec->values['id'] = ArchObjGroupType::getMaxValue('id') + 1;
							$typeRec->toDb(Db::ACTION_INSERT);
						}
						echo "+ Objektgruppe Art/Bezeichnung {$importVals['typeName']}" .
								 " von Objektgruppe {$importVals['archObjGroupId']} erfolgreich angelegt.<br>";
						$typeInsertCount++;
						$allTypeInsertSum++;
						// remember new types (also usefull for test-only mode)
						$archObjGroupTypes[] = $typeRec->values;
						// adjust typeid
						$importVals['typeId'] = $typeRec->values['id'];
						break;
					default:
						echo "* Ungültiger typeImportMode '$typeImportMode' bei Objektgruppe " . $importVals['archObjGroupId'] . "<br>";
					}

				}  // eo unknown type

			}  // eo handle arch type

			// store to db
			$result = ArchObjGroup::saveInput($importVals, $dbAction,
																				array('removeRefs' => $_REQUEST['archObjGroupRemoveRefs'],
																							'checkOnly' => (!$doApply)));
			if ($result['errorMsg']) {
				echo "Fehler bei Objektgruppe {$importVals['archObjGroupId']}: {$result['errorMsg']}<br>";
				$errorCount++;
				continue;
			}

			echo "Objektgruppe {$importVals['archObjGroupId']} erfolgreich importiert ($dbAction).<br>";
			if ($dbAction == Db::ACTION_INSERT) {
				$insertCount++;
			}
			else {
				$updateCount++;
			}

			set_time_limit($oldTimeLimit);
		}  // eo arch object group loop
		unset($importVals);   // release reference to importpackage

		$errorTotal += $errorCount;
		echo "<br>Statistik Objektgruppe:<br>" .
				 " * $insertCount Datensätze hinzugefügt<br>" .
				 " * $updateCount Datensätze aktualisiert<br>" .
				 " * $typeInsertCount Art/Bezeichnung Stammdaten hinzugefügt<br>" .
				 " *** $errorCount Fehler ***<br>";

	}
	else {
		echo "Kein Import ausgewählt.<br>";
	}  // eo arch object group
	flush();


	// final infos
	echo "<HR>";
	echo "<br><b>Statistik Gesamt:</b><br>";
	echo "<b>*** $errorTotal Fehler***</b><br>";

	echo "<br>";
	if (!$doApply) {
		echo "<b>*** TESTLAUF *** Übernahme wurde nur getestet, aber nicht durchgeführt.</b><br><br>";
	}
	else {
		if ($allTypeInsertSum) {
			echo "Neue Stammdaten für Art/Bezeichnung wurde angelegt. Die Nachschlagelisten müssen aktualisiert werden, damit diese Neuanlagen sichtbar werden.<br><br>";
		}
	}
	echo "<HR>";

}  // eo arch docu json




/*
* Precheck input value given for target excav
*/
function needTargetExcavInput() {

	$needTargetExcav = true;

	// we dont need for for excavationlist and if new excavation is requested
	if ($_REQUEST['excavationInsert'] || $_REQUEST['actionMode'] == 'ACTIONMODE_EXCAVATIONLIST') {
		$needTargetExcav = false;
	}

	// if no excavation data are imported we also do not need a valid excavation target
	if ($needTargetExcav) {
		if ($_REQUEST['excavationUpdate'] ||
				$_REQUEST['archFindInsert'] || $_REQUEST['archFindUpdate'] ||
				$_REQUEST['stratumInsert'] || $_REQUEST['stratumUpdate'] ||
				$_REQUEST['archObjectInsert'] || $_REQUEST['archObjectUpdate'] ||
				$_REQUEST['archObjGroupInsert'] || $_REQUEST['archObjGroupUpdate']
			 ) {
			// yes wee need
		}
		else {
			$needTargetExcav = false;
		}
	} // 2. check

	if ($needTargetExcav) {
		if (!$_REQUEST['targetExcavId']) {
			echo Extjs::errorMsg('Entweder Import als neue Grabung oder Ziel Grabungs ID erforderlich.');
			exit;
		}
		$excav = Dbw::fetchRow1("SELECT * FROM excavation WHERE id=:id",
																		array("id" => $_REQUEST['targetExcavId']));
		if (!$excav) {
			echo Extjs::errorMsg('Grabungs ID ' . $_REQUEST['targetExcavId'] . ' für die Zielgrabung nicht gefunden.');
			exit;
		}
	}

	return $needTargetExcav;
}  // eo check need of target excav


/*
* Precheck input value given for source excav
*/
function excavDataRequested() {

	// if none of the excav specific data are requested then return false
	if (!($_REQUEST['excavationInsert'] || $_REQUEST['excavationUpdate'] ||
				$_REQUEST['archFindInsert'] || $_REQUEST['archFindUpdate'] ||
				$_REQUEST['stratumInsert'] || $_REQUEST['stratumUpdate'] ||
				$_REQUEST['archObjectInsert'] || $_REQUEST['archObjectUpdate'] ||
				$_REQUEST['archObjGroupInsert'] || $_REQUEST['archObjGroupUpdate']
			 )
		 ) {
		return false;
	}

	// return true by default to be on the safe side
	// if we forget a excav specific request in the above check
	return true;
}  // eo check need of source excav






?>
