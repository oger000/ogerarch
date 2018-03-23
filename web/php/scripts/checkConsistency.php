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
	$data = array();
	foreach (CheckConsistencyLevel::getRecords(true) as $level => $record) {
		if ($level >= CheckConsistencyLevel::ID_ERROR) {
			$data[] = $record;
		}
	}
	echo Extjs::encData($data);
	exit;
}



// load record
if ($_REQUEST['_action'] == 'loadRecord') {
	$obj = CheckConsistencyLevel::newFromDb(array('id' => $_REQUEST['id']));
	echo Extjs::encData($obj->values);
	exit;
}


// below there is only the consistency check, so exit if not requested
if ($_REQUEST['_action'] != 'checkConsistency') {
	exit;
}


$log = new TextStack();

$log->append(<<< EOD
<HTML>
<HEAD>
	<TITLE>Prüfprotokoll</TITLE>
	<META http-equiv="Content-Type" content="text/html; charset=utf-8">
</HEAD>
<BODY>
<H1>Prüfprotokoll</H1>
EOD
);

// error level is minimum
$checkLevel = max(CheckConsistencyLevel::ID_ERROR, $_REQUEST['checkLevel']);
$errMaster = CheckConsistencyLevel::getRecords(true);


###########################################################

// do excav independent checks first
$dbDefAliasId = Logon::$logon->dbDefAliasId;

if (!$dbDefAliasId) {
	echo $log->flush("No database initialisized. May be logon timed out?\n");
	exit;
}

$dbDef = Config::$dbDefs[$dbDefAliasId];

$log->append("Datenbank: " . ($dbDef['displayName'] ?: $dbDef['dbName']) . "   am: " . date('c') . "<br>\n");
echo $log->flush(<<< EOD
<BR>Das Prüfprotokoll ist derzeit nur minimal umgesetzt, sodass möglicherweise Fehler
vorhanden sind die hier nicht aufscheinen.<BR>
Es fehlen:<br>
<UL>
	<LI>Fund: Erweiterte Stratumprüfung (interface, interfacetyp, complex)</LI>
	<LI>Stratum: vieles</LI>
	<LI>Objekt: alles</LI>
	<LI>Objektgruppe: alles</LI>
</UL>
<BR>
EOD
);


##################################

$log->push("<hr><H2>Grabungsübergreifende Prüfungen</H2>\n");


###########################################

// if  no excavId is given than report all excavations
if (!$_REQUEST['excavId']) {
	$pstmt = Db::prepare("SELECT id FROM " . Excavation::$tableName . " ORDER BY name");
	$pstmt->execute();
	$excavList = $pstmt->fetchAll();
	$pstmt->closeCursor();
}
else {
	$excavList = array(array('id' => $_REQUEST['excavId']));
}


$company = Company::newFromDb(array('id,!=' => 0));

// loop over excavations
foreach ($excavList as $excavSele) {

	$excav = Excavation::newFromDb(array('id' => $excavSele['id']));
	$excavId = $excav->values['id'];
	$log->push("<hr><h2>Grabung: " . $excav->values['name'] . " (Id $excavId)</h2>\n");


	##### INTERNAL CONNECTION TABLES CHECKS #####
	##### this does NOT check if the given values exists,
	##### but only if values are given for both sides of the connection

	################# ARCH FIND TO STRATUM TABLE ####################################

	$log->push("<H3>Stratum-Fund Verknüpfung</H3>\n");

	$stmt = "SELECT * FROM stratumToArchFind WHERE excavId=:excavId ORDER BY excavId,stratumId,archFindId";
	$pstmt = Db::prepare($stmt);
	$pstmt->execute(array('excavId' => $excavId));
	$errFound = false;
	while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
		if (!$row['stratumId']) {
			echo $log->flush(logMsg(CheckConsistencyLevel::ID_INTERNAL,
															"Id " . $row['id'] . ": Stratumnummer fehlt (Fund=" . $row['archFindId'] . ")<BR>"));
			$errFound = true;
		}
		if (!$row['archFindId']) {
			echo $log->flush(logMsg(CheckConsistencyLevel::ID_INTERNAL,
															"Id " . $row['id'] . ": Fundnummer fehlt (Stratum=" . $row['stratumId'] . ")<BR>"));
			$errFound = true;
		}
		if ($row['archFindId'] && $row['stratumId']) {
			$obj1 = Stratum::newFromDb(array('excavId' => $excavId, 'stratumId' => $row['stratumId']));
			$obj2 = ArchFind::newFromDb(array('excavId' => $excavId, 'archFindId' => $row['archFindId']));
			if (!$obj1->values && !$obj2->values) {
				echo $log->flush(logMsg(CheckConsistencyLevel::ID_INTERNAL,
						 "Id " . $row['id'] . ": Weder zugehöriges Stratum noch Fund vorhanden (Stratum=" . $row['stratumId'] . ", Fund=" . $row['archFindId'] . ")<BR>"));
				$errFound = true;
			}
		}
	}

	if ($checkLevel >= CheckConsistencyLevel::ID_DEBUG && !$errFound) {
		echo $log->flush("OK: Keine Fehler gefunden.<br>\n");
	}
	$log->pop();  // stratum to arch find records


	################# ARCH OBJECT TO STRATUM TABLE ####################################

	$log->push("<H3>Objekt-Stratum Verknüpfung</H3>\n");

	$stmt = "SELECT * FROM archObjectToStratum WHERE excavId=:excavId ORDER BY excavId,archObjectId,stratumId";
	$pstmt = Db::prepare($stmt);
	$pstmt->execute(array('excavId' => $excavId));
	$errFound = false;
	while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
		if (!$row['archObjectId']) {
			echo $log->flush(logMsg(CheckConsistencyLevel::ID_INTERNAL,
															"Id " . $row['id'] . ": Objektnummer fehlt (Stratum=" . $row['stratumId'] . ")<BR>"));
			$errFound = true;
		}
		if (!$row['stratumId']) {
			echo $log->flush(logMsg(CheckConsistencyLevel::ID_INTERNAL,
															"Id " . $row['id'] . ": Stratumnummer fehlt (Objekt=" . $row['archObjectId'] . ")<BR>"));
			$errFound = true;
		}
		if ($row['archObjectId'] && $row['stratumId']) {
			$obj1 = ArchObject::newFromDb(array('excavId' => $excavId, 'archObjectId' => $row['archObjectId']));
			$obj2 = Stratum::newFromDb(array('excavId' => $excavId, 'stratumId' => $row['stratumId']));
			if (!$obj1->values && !$obj2->values) {
				echo $log->flush(logMsg(CheckConsistencyLevel::ID_INTERNAL,
						 "Id " . $row['id'] . ": Weder zugehöriges Objekt noch Stratum vorhanden (Objekt=" . $row['archObjectId'] . ", Stratum=" . $row['stratumId'] . ")<BR>"));
				$errFound = true;
			}
		}
	}

	if ($checkLevel >= CheckConsistencyLevel::ID_DEBUG && !$errFound) {
		echo $log->flush("OK: Keine Fehler gefunden.<br>\n");
	}
	$log->pop();  // arch object to stratum records


	################# ARCH OBJECT GROUP TO ARCH OBJECT TABLE ####################################

	$log->push("<H3>Objektgruppe-Objekt Verknüpfung</H3>\n");

	$stmt = "SELECT * FROM archObjGroupToArchObject WHERE excavId=:excavId ORDER BY excavId,archObjGroupId,archObjectId";
	$pstmt = Db::prepare($stmt);
	$pstmt->execute(array('excavId' => $excavId));
	$errFound = false;
	while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
		if (!$row['archObjGroupId']) {
			echo $log->flush(logMsg(CheckConsistencyLevel::ID_INTERNAL,
															"Id " . $row['id'] . ": Objektgruppen-Nummer fehlt (Objekt=" . $row['archObjectId'] . ")<BR>"));
			$errFound = true;
		}
		if (!$row['archObjectId']) {
			echo $log->flush(logMsg(CheckConsistencyLevel::ID_INTERNAL,
															"Id " . $row['id'] . ": Objektnummer fehlt (Objektgruppe=" . $row['archObjGroupId'] . ")<BR>"));
			$errFound = true;
		}
		if ($row['archObjGroupId'] && $row['archObjectId']) {
			$obj1 = ArchObjGroup::newFromDb(array('excavId' => $excavId, 'archObjGroupId' => $row['archObjGroupId']));
			$obj2 = ArchObject::newFromDb(array('excavId' => $excavId, 'archObjectId' => $row['archObjectId']));
			if (!$obj1->values && !$obj2->values) {
				echo $log->flush(logMsg(CheckConsistencyLevel::ID_INTERNAL,
						 "Id " . $row['id'] . ": Weder zugehörige Objektgruppe noch Objekt vorhanden (Objektgruppe=" . $row['archObjGroupId'] . ", Objekt=" . $row['archObjectId'] . ")<BR>"));
				$errFound = true;
			}
		}
	}

	if ($checkLevel >= CheckConsistencyLevel::ID_DEBUG && !$errFound) {
		echo $log->flush("OK: Keine Fehler gefunden.<br>\n");
	}
	$log->pop();  // arch object to stratum records

	##### EO INTERNAL connection table tests #####



	################# ARCH FIND ####################################

	if ($_REQUEST['checkArchFind']) {

		################# LOOP OVER ARCH FINDS ####################################

		$pstmt = Db::prepare("SELECT * FROM " . ArchFind::$tableName . " WHERE excavId=:excavId ORDER BY 0+archFindId");
		$pstmt->execute(array('excavId' => $excavId));
		while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {

			$archFind = new ArchFind($row);
			$values = $archFind->getExtendedValues();

			$log->push("<h3>Fund: " . $values['archFindId'] . "</h3>\n");

			if (!$values['stratumIdList'] && !$values['isStrayFind']) {
				echo $log->flush(logMsg(CheckConsistencyLevel::ID_FATAL, "Kein Stratum angegeben.<br>\n"));
			}
			else {
				if ($checkLevel >= CheckConsistencyLevel::ID_DEBUG) {
					if ($values['stratumIdList']) {
						echo $log->flush("OK: Stratum " . $values['stratumIdList'] . " angegeben.<br>\n");
					}
					elseif ($values['isStrayFind']) {
						echo $log->flush("OK: Ist ein Streu-/Putzfund.<br>\n");
					}
					else {
						echo $log->flush(logMsg(CheckConsistencyLevel::ID_INTERNAL,
							"PRÜFUNGSFEHLER: Prüfung erfolgreich, obwohl weder Stratum noch Streufund.<br>\n"));
					}
				}
				if ($_REQUEST['archFindCheckStratum'] && $values['stratumIdList']) {
					foreach (ExcavHelper::multiXidSplit($values['stratumIdList']) as $stratumId) {
						if (!Stratum::existsStatic(array('excavId' => $excavId, 'stratumId' => $stratumId))) {
							echo $log->flush(logMsg(CheckConsistencyLevel::ID_ERROR,
																			"Angegebenes Stratum $stratumId existiert nicht.<br>\n"));
						}
						elseif ($checkLevel >= CheckConsistencyLevel::ID_DEBUG) {
							echo $log->flush("OK: Angegebenes Stratum $stratumId ist vorhanden.<br>\n");
						}
					}
				}
			}  // stratum id check

			if ($checkLevel >= CheckConsistencyLevel::ID_WARN) {
				// check for any content
				if (!$archFind->hasFindItem2() &&
						!$archFind->hasSampleItem2()) {
					echo $log->flush(logMsg(CheckConsistencyLevel::ID_WARN, "Weder Fund noch Probe angegeben.<br>\n"));
				}
				elseif ($checkLevel >= CheckConsistencyLevel::ID_DEBUG) {
					echo $log->flush("OK: Angabe zu Fund oder Probe ist vorhanden.<br>\n");
				}
			}  // level warn, any content

			//  ---  arch find finale
			$log->pop();   // single arch find

		}  // eo loop over arch finds

	}  // eo arch find checks


	################# STRATUM ####################################

	if ($_REQUEST['checkStratum']) {

		$log->push("<H3>Stratum Neben-Datensatz ohne gültigen Stratum Haupt-Datensatz</H3>\n");

		$stmt = "SELECT stratumId FROM stratum WHERE excavId=:excavId";
		$pstmt = Db::prepare($stmt);
		$pstmt->execute(array('excavId' => $excavId));
		$allRows = $pstmt->fetchAll();
		$pstmt->closeCursor();

		$mainStratumIds = array();
		foreach ($allRows as $row) {
			$mainStratumIds[$row["stratumId"]] = $row["stratumId"];
		}

		// stratum detail records without head record for stratumId
		$stratumSubTables = array('stratumInterface',
															'stratumDeposit',
															'stratumSkeleton',
															'stratumWall',
															'stratumTimber');
		foreach ($stratumSubTables as $tableName) {

			$log->push("<H4>Tabelle $tableName</H4>");

			$stmt = "SELECT stratumId, COUNT(*) AS count FROM $tableName WHERE excavId=:excavId" .
							" GROUP BY stratumId";
			$pstmt = Db::prepare($stmt);
			$pstmt->execute(array('excavId' => $excavId));
			$allRows = $pstmt->fetchAll();
			$pstmt->closeCursor();

			$errFound = false;
			foreach ($allRows as $row) {
				if (!$mainStratumIds[$row["stratumId"]]) {
					$errFound = true;
					echo $log->flush(logMsg(CheckConsistencyLevel::ID_INTERNAL,
																	$row['count'] . " fehlerhafte Datensätze mit Stratum-Nummer " . $row['stratumId'] . " gefunden.<BR>\n",
																	$row['count']));
				}
			}  // eo detail loop
			if ($checkLevel >= CheckConsistencyLevel::ID_DEBUG) {
				if (!$errFound) {
					$log->push("OK: Keine Fehler gefunden.<br>\n");
				}
				echo $log->flush();
			}
			$log->pop();  // table name

		}  // eo check
		$log->pop();  // stratum detail records without stratum head record


		// stratum detail records without head record for stratumId
		//                    AND without head record for stratum2Id
		$stratumSubTables = array('stratumComplex',
															'stratumMatrix');
		foreach ($stratumSubTables as $tableName) {

			$log->push("<H4>Tabelle $tableName</H4>");

			$stmt = "SELECT stratumId, stratum2Id, COUNT(*) AS count FROM $tableName WHERE excavId=:excavId" .
							" GROUP BY stratumId";
			$pstmt = Db::prepare($stmt);
			$pstmt->execute(array('excavId' => $excavId));
			$allRows = $pstmt->fetchAll();
			$pstmt->closeCursor();

			$errFound = false;
			foreach ($allRows as $row) {
				if (!$mainStratumIds[$row["stratumId"]] && !$mainStratumIds[$row["stratum2Id"]]) {
					$errFound = true;
					echo $log->flush(logMsg(CheckConsistencyLevel::ID_INTERNAL,
																	$row['count'] . " fehlerhafte Datensätze mit Stratum-Nummer " . $row['stratumId'] . " gefunden.<BR>\n",
																	$row['count']));
				}
			}  // eo detail loop
			if ($checkLevel >= CheckConsistencyLevel::ID_DEBUG) {
				if (!$errFound) {
					$log->push("OK: Keine Fehler gefunden.<br>\n");
				}
				echo $log->flush();
			}
			$log->pop();  // table name

		}  // eo check
		$log->pop();  // stratum detail records without stratum head record 1+2


		################# LOOP OVER STRATUM ####################################

		$pstmt = Db::prepare("SELECT * FROM " . Stratum::$tableName . " WHERE excavId=:excavId ORDER BY 0+stratumId");
		$pstmt->execute(array('excavId' => $excavId));
		while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {

			$stratum = new Stratum($row);
			$values = $stratum->getAllExtendedValues();

			$log->push("<h3>Stratum: " . $values['stratumId'] . "</h3>\n");

			// check archfind/sample
			if ($_REQUEST['stratumCheckArchFind']) {

				// check at error level
				if ($checkLevel >= CheckConsistencyLevel::ID_ERROR) {

					// should have arch find, but has not
					if ($values['hasArchFind'] && !$values['archFindIdList']) {
						echo $log->flush(logMsg(CheckConsistencyLevel::ID_ERROR,
														 "Fund-Markierung gesetzt, aber keine Fundnummer angegeben.<br>\n"));
					}
					elseif ($checkLevel >= CheckConsistencyLevel::ID_DEBUG) {
						echo $log->flush("OK: Fund-Markierung gesetzt und Fundnummer angegeben.<br>\n");
					}

					// check arch find values
					$sampleCount = 0;
					if ($values['archFindIdList']) {
						foreach (ExcavHelper::multiXidSplit($values['archFindIdList']) as $archFindId) {
							if (!ArchFind::existsStatic(array('excavId' => $excavId, 'archFindId' => $archFindId))) {
								echo $log->flush(logMsg(CheckConsistencyLevel::ID_ERROR,
																				"Angegebener Fund $archFindId existiert nicht.<br>\n"));
							}
							else {
								if ($archFind->hasSampleItem2()) {
									$sampleCount++;
								}
								if ($checkLevel >= CheckConsistencyLevel::ID_DEBUG) {
									echo $log->flush("OK: Angegebener Fund $archFindId ist vorhanden.<br>\n");
								}
							}
						}
					}  // eo arch find id check

					// should have sample, but has not
					if ($values['hasSample'] && !$sampleCount) {
						echo $log->flush(logMsg(CheckConsistencyLevel::ID_ERROR,
														 "Probe-Markierung gesetzt, aber keine Fundnummer mit Probe vorhanden.<br>\n"));
					}
					elseif ($checkLevel >= CheckConsistencyLevel::ID_DEBUG) {
						echo $log->flush("OK: Probe-Markierung gesetzt und Fundnummer mit Probe vorhanden.<br>\n");
					}

				}  // eo error level checks

				// check at info level
				if ($checkLevel >= CheckConsistencyLevel::ID_INFO) {

					// has arch find, but arch find marker not set
					if (!$values['hasArchFind'] && $values['archFindIdList']) {
						echo $log->flush(logMsg(CheckConsistencyLevel::ID_INFO,
														 "Fund-Markierung nicht gesetzt, aber Fundnummer angegeben.<br>\n"));
					}
					elseif ($checkLevel >= CheckConsistencyLevel::ID_DEBUG) {
						echo $log->flush("OK: Fund-Markierung nicht gesetzt und keine Fundnummer angegeben.<br>\n");
					}

					// has sample, but sample marker not set
					if (!$values['hasSample'] && $sampleCount) {
						echo $log->flush(logMsg(CheckConsistencyLevel::ID_INFO,
														 "Probe-Markierung nicht gesetzt, aber Fundnummer mit Probe vorhanden.<br>\n"));
					}
					elseif ($checkLevel >= CheckConsistencyLevel::ID_DEBUG) {
						echo $log->flush("OK: Probe-Markierung nicht gesetzt und keine Fundnummer mit Probe vorhanden.<br>\n");
					}

				}  // eo info level checks

			}  // eo do archfind/sample checks


			// check arch object
			if ($_REQUEST['stratumCheckArchObject']) {

				// check at error level
				if ($checkLevel >= CheckConsistencyLevel::ID_ERROR) {

					// should have arch object, but has not
					if ($values['hasArchObject'] && !$values['archObjectIdList']) {
						echo $log->flush(logMsg(CheckConsistencyLevel::ID_ERROR,
														 "Objekt-Markierung gesetzt, aber keine Objektnummer angegeben.<br>\n"));
					}
					elseif ($checkLevel >= CheckConsistencyLevel::ID_DEBUG) {
						echo $log->flush("OK: Objekt-Markierung gesetzt und Objektnummer angegeben.<br>\n");
					}

					// check arch object values
					if ($values['archObjectIdList']) {
						foreach (ExcavHelper::multiXidSplit($values['archObjectIdList']) as $archObjectId) {
							$archObject = ArchObject::newFromDb(array('excavId' => $excavId, 'archObjectId' => $archObjectId));
							if (!$archObject->values) {
								echo $log->flush(logMsg(CheckConsistencyLevel::ID_ERROR,
																				"Angegebenes Objekt $archObjectId existiert nicht.<br>\n"));
							}
							else {
								if ($checkLevel >= CheckConsistencyLevel::ID_DEBUG) {
									echo $log->flush("OK: Angegebenes Objekt $archObjectId ist vorhanden.<br>\n");
								}
							}
						}
					}  // eo arch object id check

				}  // eo error level checks

				// check at info level
				if ($checkLevel >= CheckConsistencyLevel::ID_INFO) {

					// has arch object, but arch object marker not set
					if (!$values['hasArchObject'] && $values['archObjectIdList']) {
						echo $log->flush(logMsg(CheckConsistencyLevel::ID_INFO,
														 "Objekt-Markierung nicht gesetzt, aber Objektnummer angegeben.<br>\n"));
					}
					elseif ($checkLevel >= CheckConsistencyLevel::ID_DEBUG) {
						echo $log->flush("OK: Objekt-Markierung nicht gesetzt und keine Objektnummer angegeben.<br>\n");
					}

				}  // eo info level checks

			}  // eo do arch object checks


			// check arch object group
			if ($_REQUEST['stratumCheckArchObjGroup']) {

				// check at error level
				if ($checkLevel >= CheckConsistencyLevel::ID_ERROR) {

					// should have arch object group, but has not
					if ($values['hasArchObjGroup'] && !$values['archObjGroupIdList']) {
						echo $log->flush(logMsg(CheckConsistencyLevel::ID_ERROR,
														 "Objektgruppen-Markierung gesetzt, aber keine Objektgruppe ermittelbar.<br>\n"));
					}
					elseif ($checkLevel >= CheckConsistencyLevel::ID_DEBUG) {
						echo $log->flush("OK: Objektgruppen-Markierung gesetzt und Objektgruppe ermittelbar.<br>\n");
					}

				}  // eo error level checks

				// check at info level
				if ($checkLevel >= CheckConsistencyLevel::ID_INFO) {

					// has arch object group, but arch object group marker not set
					if (!$values['hasArchObjGroup'] && $values['archObjGrouopIdList']) {
						echo $log->flush(logMsg(CheckConsistencyLevel::ID_INFO,
														 "Objektgruppen-Markierung nicht gesetzt, aber Objektgruppe ermittelbar.<br>\n"));
					}
					elseif ($checkLevel >= CheckConsistencyLevel::ID_DEBUG) {
						echo $log->flush("OK: Objektgruppen-Markierung nicht gesetzt und keine Objektgrupper ermittelbar.<br>\n");
					}

				}  // eo info level checks

			}  // eo do arch object group checks

			//  ---  stratum finale
			$log->pop();   // single stratum

		}  // eo loop over stratum

	}  // eo stratum checks

	#####################################################

	//$log->pop();   // excavation

}  // eo excavation loop




################ final output #############################


echo $log->flush();

$log->append("<br><hr><H2>Summen</H2>" .
							($errSum[CheckConsistencyLevel::ID_INTERNAL] * 1) . " Interne Fehler<BR>\n" .
							($errSum[CheckConsistencyLevel::ID_FATAL] * 1) . " Fatale Fehler<BR>\n" .
							($errSum[CheckConsistencyLevel::ID_ERROR] * 1) . " Normale Fehler<BR>\n" .
							($errSum[CheckConsistencyLevel::ID_WARN] * 1) . " Warnungen<BR>\n" .
							($errSum[CheckConsistencyLevel::ID_INFO] * 1) . " Hinweise<BR>\n" .
							($errSum[CheckConsistencyLevel::ID_VERBOSE] * 1) . " Extrameldungen<BR>\n" .
							"");
$log->append("</BODY>\n</HTML>\n");
echo $log->flush();
exit;



################ functions #############################


function logMsg($level, $msg, $count = 1) {

	global $errMaster, $errSum;

	$errSum[$level] += $count;

	$text = $errMaster[$level]['code'] . ": " . $msg;
	return $text;
}  // eo log msg




?>
