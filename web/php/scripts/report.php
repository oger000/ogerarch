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

$pdf = new OgerPdf0();


$checkboxUnchecked = mb_convert_encoding('&#x2610;', 'UTF-8', 'HTML-ENTITIES');
$checkboxChecked = mb_convert_encoding('&#x2612;', 'UTF-8', 'HTML-ENTITIES');


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


// loop over excavations
foreach ($excavList as $excavSele) {

	$company = Company::newFromDb(array('id,!=' => 0));
	$excav = Excavation::newFromDb(array('id' => $excavSele['id']));

	// --- arch find report

	// special handling for arch find sheet
	if ($_REQUEST['reportType'] == 'TYPE_ARCHFIND' && $_REQUEST['reportMode'] == 'MODE_FINDSHEET') {
		$_REQUEST['_action'] = 'massPrintFindSheets';
		$_REQUEST['numCopies'] = 1;
		include(__DIR__ . '/archFind.php');
		exit;
	}

	if ($_REQUEST['reportType'] == 'TYPE_ARCHFIND') {
		archFindList($pdf, $company, $excav);
	}

	//  stratum report
	if ($_REQUEST['reportType'] == 'TYPE_STRATUM') {

		if ($_REQUEST['reportMode'] == "MODE_LIST-BDA") {
			$tbs = new OgerTinyButStrong();
			$tbs->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
			$tbsTpl = "pdftemplates/report/StratumListBda.odt";
			if (!file_exists($tbsTpl)) {
				echo sprintf("Template '%s' nicht gefunden.", $tbsTpl);
				exit;
			}
			$tbs->LoadTemplate($tbsTpl, OPENTBS_ALREADY_UTF8);

			$tbs->PlugIn(OPENTBS_SELECT_HEADER);
			$tbs->MergeField("excavation", $excav->values);
			$tbs->PlugIn(OPENTBS_SELECT_FOOTER);
			$tbs->MergeField("company", $company->values);

			$tbs->PlugIn(OPENTBS_SELECT_MAIN);
		}
		stratumList($pdf, $company, $excav, $tbs);
	}

	// arch object report
	if ($_REQUEST['reportType'] == 'TYPE_ARCHOBJECT') {
		archObjectList($pdf, $company, $excav);
	}

	// arch object group report
	if ($_REQUEST['reportType'] == 'TYPE_ARCHOBJGROUP') {
		archObjGroupList($pdf, $company, $excav);
	}

}  // eo excavation loop

// output
if ($tbs) {
	$tbsTpl = basename($tbsTpl);
	$tbs->Show(OPENTBS_DOWNLOAD, $tbsTpl);
}
else {
	$pdf->Output(Oger::_('Bericht'), 'I');
}
exit;


################ functions #############################


################ ARCH FIND #############################

/*
 * Create arch find list
 */
function archFindList($pdf, $company, $excav) {

	$oldTimeLimit = ini_get("max_execution_time");

	$excavValues = $excav->values;
	foreach ($excavValues as $key => $value) {
		$excavValues['excav' . ucfirst($key)] = $value;
	}


	switch ($_REQUEST['reportMode']) {
	case "MODE_REPORT-SHORT":
		$tpl = PdfTemplate::getTemplate("ArchFindReportShort", "report");
		break;
	case "MODE_REPORT-MEDIUM":
		$tpl = PdfTemplate::getTemplate("ArchFindReportMedium", "report");
		break;
	case "MODE_REPORT-FULL":
		$tpl = PdfTemplate::getTemplate("ArchFindReportFull", "report");
		break;
	default:
		return;
	}

	$pdf->tplSet($tpl);
	$pdf->tplSetHeaderValues($excavValues);
	$pdf->tplSetFooterValues(array("companyShortName" => $company->values['shortName']));
	$pdf->tplUse("init");
	$pdf->addPage();


	if (array_key_exists("beginId", $_REQUEST)) {
		$_REQUEST['beginId'] = Oger::getNatSortId($_REQUEST['beginId']);
	}
	if (array_key_exists("endId", $_REQUEST)) {
		$_REQUEST['endId'] = Oger::getNatSortId($_REQUEST['endId']);
	}

	$sql = ArchFind12::getSql("EXPORT", $whereVals);
	$pstmt = Dbw::checkedExecute($sql, $whereVals);
	while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {

		$row = ArchFind12::prep4Report($row);

		// respect one record per page
		if ($_REQUEST['newPagePerItem'] && ++$recordCount > 1) {
			$pdf->addPage();
		}

		// output one arch find record
		$pdf->tplUse("body", $row);

		set_time_limit($oldTimeLimit);
	}  // eo loop over arch find records

	// add list of abbrevs for shortlist
	if ($_REQUEST['reportMode'] == "MODE_REPORT-SHORT") {
		$pdf->addPage();
		$pdf->tplUse("abbrev");
	}

}  // eo arch find list





################ STRATUM #############################

/*
 * Create stratum list
 */
function stratumList($pdf, $company, $excav, $tbs) {

	global $checkboxChecked, $checkboxUnchecked;

	$oldTimeLimit = ini_get("max_execution_time");

	$excavValues = $excav->values;
	foreach ($excavValues as $key => $value) {
		$excavValues['excav' . ucfirst($key)] = $value;
	}


	switch ($_REQUEST['reportMode']) {
	case "MODE_LIST-BDA":
		$tpl = PdfTemplate::getTemplate("StratumListBda", "report");
		break;
	case "MODE_REPORT-SHORT":
		$tpl = PdfTemplate::getTemplate("StratumReportShort", "report");
		break;
	case "MODE_REPORT-MEDIUM":
		$tpl = PdfTemplate::getTemplate("StratumReportMedium", "report");
		break;
	case "MODE_REPORT-FULL":
		$tpl = PdfTemplate::getTemplate("StratumReportFull", "report");
		break;
	default:
		return;
	}

	$pdf->tplSet($tpl);
	$pdf->tplSetHeaderValues($excavValues);
	$pdf->tplSetFooterValues(array("companyShortName" => $company->values['shortName']));
	$pdf->tplUse("init");
	$pdf->addPage();

	if (array_key_exists("beginId", $_REQUEST)) {
		$_REQUEST['beginId'] = Oger::getNatSortId($_REQUEST['beginId']);
	}
	if (array_key_exists("endId", $_REQUEST)) {
		$_REQUEST['endId'] = Oger::getNatSortId($_REQUEST['endId']);
	}


	// create pstmt for arch finds in advance
	$sqlArchFind =
		"SELECT archFind.* FROM archFind " .
		" INNER JOIN stratumToArchFind AS stToAf " .
		"  ON stToAf.excavId=archFind.excavId AND stToAf.archFindId=archFind.archFindId " .
		"WHERE stToAf.excavId=:excavId AND stToAf.stratumId=:stratumId";
	$pstmtArchFind = Dbw::$conn->prepare($sqlArchFind);


	$valueRows = array();
	$sql = Stratum12::getSql("EXPORT", $whereVals);
	$pstmt = Dbw::checkedExecute($sql, $whereVals);
	while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {

		$values = Stratum12::prep4Export($row);

		// respect one record per page
		if ($_REQUEST["newPagePerItem"] && ++$recordCount > 1) {
			$pdf->addPage();
		}


		// prepare category dependend output
		$tplBody = "";
		$shortSummaryFields = array();

		switch ($values['categoryId']) {
		case StratumCategory::ID_INTERFACE:
			$shortSummaryFields = array_merge($shortSummaryFields, array(
				"shape" => Oger::_("Form"),
				"contour" => Oger::_("Kontur"),
				"vertex" => Oger::_("Ecken"),
				"sidewall" => Oger::_("Seiten"),
				"intersection" => Oger::_("Seitenübergang"),
				"basis" => Oger::_("Basis"),
			));
			$tplBody = "body_interface";
			break;
		case StratumCategory::ID_DEPOSIT:
			$shortSummaryFields = array_merge($shortSummaryFields, array(
				"color" => Oger::_("Farbe"),
				"materialDenotation" => Oger::_("Materialansprache"),
				"consistency" => Oger::_("Konsistenz"),
				"inclusion" => Oger::_("Einschlüsse"),
				"hardness" => Oger::_("Härte"),
				"orientation" => Oger::_("Orientierung"),
				"incline" => Oger::_("Gefälle"),
			));
			$tplBody = "body_deposit";
			break;
		case StratumCategory::ID_SKELETON:
			$shortSummaryFields = array_merge($shortSummaryFields, array(
				"bodyPositionName" => Oger::_("Körperlage"),
				"orientation" => Oger::_("Orientierung"),
				"specialBurial" => Oger::_("Sonderbestattung"),
				"positionDescription" => Oger::_("Skelettanmerkungen"),
				"recoverySingleBones" => Oger::_("Einzelknochen-Bergung"),
				"recoveryBlock" => Oger::_("Blockbergung"),
				"recoveryHardened" => Oger::_("Härtung/Bergung"),
				"bodyLength" => Oger::_("Körperlänge in mm"),
				"boneQualityName" => Oger::_("Erhaltungszustand"),
				"sexName" => Oger::_("Geschlecht"),
				"genderName" => Oger::_("Gender"),
				"ageName" => Oger::_("Alter"),
			));
			$tplBody = "body_skeleton";
			break;
		case StratumCategory::ID_TIMBER:
			$shortSummaryFields = array_merge($shortSummaryFields, array(
				"dendrochronology" => Oger::_("Dendrochronologie"),
				"timberType" => Oger::_("Holzart"),
				"physioZoneDullEdge" => Oger::_("Waldkante"),
				"physioZoneSeapWood" => Oger::_("Splint"),
				"physioZoneHeartWood" => Oger::_("Kern"),
				"secundaryUsage" => Oger::_("Sekundäre Verwendung"),
			));
			$tplBody = "body_timber";
			break;
		case StratumCategory::ID_WALL:
			$shortSummaryFields = array_merge($shortSummaryFields, array(
				"constructionTypeName" => Oger::_("Bauart"),
				"wallBaseTypeName" => Oger::_("Mauerwerk/Typ"),
				"structureTypeName" => Oger::_("Struktur"),
				"layerDescription" => Oger::_("Lagen"),
				"shellDescription" => Oger::_("Mauerschale"),
				"kernelDescription" => Oger::_("Mauerkern"),
				"formworkDescription" => Oger::_("Schalung"),
				"materialTypeName" => Oger::_("Material"),
				"spoilDescription" => Oger::_("Spolien"),
				"binderTypeName" => Oger::_("Bindemittel"),
				"abreuvoirTypeName" => Oger::_("Fugenbild"),
				"plasterSurfaceName" => Oger::_("Verputz-Oberfläche"),
				"plasterThickness" => Oger::_("Verputzstärke"),
			));
			$tplBody = "body_wall";
			break;
		case StratumCategory::ID_COMPLEX:
			$shortSummaryFields = array_merge($shortSummaryFields, array(
				"complexPartIdList" => Oger::_("Stratumliste"),
			));
			$tplBody = "body_complex";
			break;
		}  // eo switch

		// common short summary fields at the end
		$shortSummaryFields = array_merge($shortSummaryFields, array(
			"archFindIdList" => Oger::_("Fund"),
			"comment" => Oger::_("Anmerkungen"),
		));


		// we use integers for boolean values, so we cannot use the database info
		// to detect boolean field names and we have to code them explicitly
		$boolFieldNames = array(
			"planDigital",
			"planAnalog",
			"photogrammetry",
			"photoDigital",
			"photoSlide",
			"photoPrint",
			"hasArchFind",
			"hasSample",
			"hasArchObject",
			"hasArchObjGroup",

			"dislocationNone",
			"dislocationBase",
			"dislocationShaft",
			"dislocationPrivation",
			"dislocationDen",
			"recoverySingleBones",
			"recoveryBlock",
			"recoveryHardened",
			"specialBurial",

			"dendrochronology",
			"secundaryUsage",
			"physioZoneDullEdge",
			"physioZoneSeapWood",
			"physioZoneHeartWood",

			"datingStratigraphy",
			"datingWallStructure",
			"hasPutlogHole",
			"hasBarHole",
			"hasCommonBrick",
			"hasVaultBrick",
			"hasRoofTile",
			"hasFortificationBrick",
			"hasProductionStampSign",
			"hasProductionFingerSign",
			"hasProductionOtherAttribute",
			"binderLimeVisible",
		);
		foreach ($boolFieldNames as $fieldName) {
			if (array_key_exists($fieldName, $values)) {
				$values[$fieldName . "YesNo"] = ($values[$fieldName] ? Oger::_("Ja") : Oger::_("Nein"));
			}
		}  // eo boolfield yes no


		// create labellists (usualy checkbox groups)
		$stratumLabels = Stratum::getItemLabels($values['categoryId']);
		foreach (array(
									 "planTypeList" => array("planDigital",
																					 "planAnalog",
																				),
									 "photoTypeList" => array("photogrammetry",
																						"photoDigital",
																						"photoSlide",
																						"photoPrint",
																				),

									 "dislocationList" => array("dislocationNone",
																							"dislocationBase",
																							"dislocationShaft",
																							"dislocationPrivation",
																							"dislocationDen",
																				),
									 "recoveryList" => array("recoverySingleBones",
																					 "recoveryBlock",
																					 "recoveryHardened",
																					),

									 "physioZoneList" => array("physioZoneDullEdge",
																						 "physioZoneSeapWood",
																						 "physioZoneHeartWood",
																				),

									 "datingBaseList" => array("datingStratigraphy",
																						 "datingWallStructure",
																						),
									 "brickTypeList" => array("hasCommonBrick",
																						"hasVaultBrick",
																						"hasRoofTile",
																						"hasFortificationBrick",
																					 ),
									 "brickProductionSignList" => array("hasProductionStampSign",
																											"hasProductionFingerSign",
																											"hasProductionOtherAttribute",
																										),

									) as $listFieldName => $fieldNames) {
			$tmp = "";
			foreach ($fieldNames as $fieldName) {
				if ($values[$fieldName]) {
					$tmp .= ($tmp ? ", " : "") . $stratumLabels[$fieldName];
				}
			}
			$values[$listFieldName] = $tmp;
		}

		// add contanedIn an contains info
		$values = Stratum12::addInterfaceRelations($values);

		// the shortlist is done in body_end,
		// so we can create the short summary here for all categories
		$values['shortSummaryText'] = "";
		foreach ($shortSummaryFields as $fieldName => $label) {
			if ($values[$fieldName]) {
				$values['shortSummaryText'] .= ($values['shortSummaryText'] ? ", " : "");
				if (array_key_exists($fieldName . "YesNo", $values)) {
					$fieldName = $fieldName . "YesNo";
				}
				$values['shortSummaryText'] .= $label . ": " . $values[$fieldName];
			}
		}



		// get sample types
		$findLabels = ArchFind12::getItemLabels();
		$sampleColl = array();
		$sampleTxColl = array();
		$pstmtArchFind->execute(array("excavId" => $values['excavId'], "stratumId" => $values['stratumId']));
		while ($rowArchFind = $pstmtArchFind->fetch(PDO::FETCH_ASSOC)) {
			if (!ArchFind12::hasSampleItemOrText($rowArchFind)) {
				continue;
			}
			foreach (ArchFind12::$sampleItemFields as $fieldName) {
				if ($rowArchFind[$fieldName]) {
					$sampleColl[$findLabels[$fieldName]][] = $rowArchFind['archFindId'];
				}
			}
			if ($rowArchFind['sampleOther']) {
				$sampleTxColl[$rowArchFind['sampleOther']][] = $rowArchFind['archFindId'];
			}
		}
		$tmp = "";
		foreach($sampleColl as $findLabel => $findIds) {
			$tmp .= ($tmp ? ", " : "") . $findLabel . " (" . ExcavHelper::multiXidPrepare($findIds) . ")";
		}
		foreach($sampleTxColl as $findLabel => $findIds) {
			$tmp .= ($tmp ? ", " : "") . $findLabel . " (" . ExcavHelper::multiXidPrepare($findIds) . ")";
		}
		$values['sampleReferenceList'] = $tmp;


		// add fields for bda - list
		if ($_REQUEST['reportMode'] == "MODE_LIST-BDA") {

			$values['hasVerbalDescription'] = "x";   // $checkboxChecked;
			$values['hasPictureReference'] = (($values['photogrammetry'] || $values['photoDigital'] || $values['photoSlide'] || $values['photoPrint']) ? "x" : "");
			$values['hasDigitalDocu'] = ($values['planDigital'] ? "x" : "");
			$values['hasAnalogDocu'] = ($values['planAnalog'] ? "x" : "");

			// variable stratum type position
			switch ($_REQUEST['bdaListStratumType']) {
			case "BDALIST_STRATUMTYPE_NONE":
				// do nothing
				break;
			case "BDALIST_STRATUMTYPE_COMMENT":
				$values['listComment'] = rtrim($values['listComment']);
				if ($values['listComment'] && trim($values['typeName'])) {
					$values['listComment'] .= "\n";
				}
				$values['listComment'] .= trim($values['typeName']);
				break;
			case "BDALIST_STRATUMTYPE_NOTATION":
				// replace category name only if typename is present
				if (trim($values['typeName'])) {
					$values['categoryName'] = $values['typeName'];
				}
				break;
			}

		}  // eo stratum bda list specific values


		// output one stratum
		if ($tbs) {
			$valueRows[] = $values;
		}
		else {
			$pdf->tplUse("body_begin", $values);
			$pdf->tplUse($tplBody, $values);
			$pdf->tplUse("body_end", $values);
		}

		set_time_limit($oldTimeLimit);
	}  // eo loop over stratum records


	// fillup page with empty cells on bda list
	if ($_REQUEST['reportMode'] == "MODE_LIST-BDA") {
		$values = $pdf->getVarNames($pdf->tplGetBlock("body_end"));
		foreach ($values as &$value) {
			$value = "";
		}
		$sanityCounter = 0;
		$lastPage = $pdf->getPage();
		while ($pdf->getPage() == $lastPage) {
			if (++$sanityCounter > 100) {
				break;
			}
			$pdf->tplUse("body_end", $values);
		}
		if ($pdf->getPage() > $lastPage) {
			$pdf->deletePage($pdf->getPage());
		}
	}


	if ($tbs) {
		$tbs->MergeBlock("stratum", $valueRows);
	}

}  // eo stratum list




################ ARCH OBJECT #############################

/*
 * Create object list
 */
function archObjectList($pdf, $company, $excav) {

	$oldTimeLimit = ini_get('max_execution_time');

	$excavValues = $excav->values;
	foreach ($excavValues as $key => $value) {
		$excavValues['excav' . ucfirst($key)] = $value;
	}

	$whereVals = array();
	$whereVals['excavId'] = $excav->values['id'];

	if ($_REQUEST['beginId']) {
		$whereVals['archObjectId#SIGNED,>=,beginId'] = $_REQUEST['beginId'];
	}
	if ($_REQUEST['endId']) {
		$whereVals['archObjectId#SIGNED,<=,endId'] = $_REQUEST['endId'];
	}
	/*
	if ($_REQUEST['beginDate']) {
		$whereVals['date,>='] = $_REQUEST['beginDate'];
	}
	if ($_REQUEST['endDate']) {
		$whereVals['date,<='] = $_REQUEST['endDate'];
	}
	*/

	switch ($_REQUEST['reportMode']) {
	case 'MODE_LIST-BDA':
		$tpl = PdfTemplate::getTemplate('ArchObjectListBda', 'report');
		break;
	case 'MODE_REPORT-SHORT':
		$tpl = PdfTemplate::getTemplate('ArchObjectReportShort', 'report');
		break;
	case 'MODE_REPORT-MEDIUM':
		$tpl = PdfTemplate::getTemplate('ArchObjectReportMedium', 'report');
		break;
	case 'MODE_REPORT-FULL':
		$tpl = PdfTemplate::getTemplate('ArchObjectReportFull', 'report');
		break;
	default:
		return;
	}

	$pdf->tplSet($tpl);
	$pdf->tplSetHeaderValues($excavValues);
	$pdf->tplSetFooterValues(array('companyShortName' => $company->values['shortName']));
	$pdf->tplUse('init');
	$pdf->addPage();

	$record = new ArchObject();

	$stmt = "SELECT * FROM " . ArchObject::$tableName;
	$pstmt = Db::prepare($stmt, $whereVals, " ORDER BY excavId,0+archObjectId");
	$whereVals = Db::getCleanWhereVals($whereVals);
	$pstmt->execute($whereVals);
	while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {

		$record->clearValues();
		$record->setValues($row);
		$values = $record->getExtendedValues(array('export' => true));

		// respect one record per page
		if ($_REQUEST['newPagePerItem'] && ++$recordCount > 1) {
			$pdf->addPage();
		}

		// output one arch find record
		$pdf->tplUse('body', $values);

		set_time_limit($oldTimeLimit);
	}  // eo loop over arch object records

	// fillup page with empty cells on bda list
	if ($_REQUEST['reportMode'] == 'MODE_LIST-BDA') {
		$values = $pdf->getVarNames($pdf->tplGetBlock('body'));
		foreach ($values as &$value) {
			$value = '';
		}
		$sanityCounter = 0;
		$lastPage = $pdf->getPage();
		while ($pdf->getPage() == $lastPage) {
			if (++$sanityCounter > 100) {
				break;
			}
			$pdf->tplUse('body', $values);
		}
		if ($pdf->getPage() > $lastPage) {
			$pdf->deletePage($pdf->getPage());
		}
	}


}  // eo arch object list




################ ARCH OBJECT GROUP #############################

/*
 * Create object group list
 */
function archObjGroupList($pdf, $company, $excav) {

	$oldTimeLimit = ini_get('max_execution_time');

	$excavValues = $excav->values;
	foreach ($excavValues as $key => $value) {
		$excavValues['excav' . ucfirst($key)] = $value;
	}

	$whereVals = array();
	$whereVals['excavId'] = $excav->values['id'];

	if ($_REQUEST['beginId']) {
		$whereVals['archObjGroupId#SIGNED,>=,beginId'] = $_REQUEST['beginId'];
	}
	if ($_REQUEST['endId']) {
		$whereVals['archObjGroupId#SIGNED,<=,endId'] = $_REQUEST['endId'];
	}
	/*
	if ($_REQUEST['beginDate']) {
		$whereVals['date,>='] = $_REQUEST['beginDate'];
	}
	if ($_REQUEST['endDate']) {
		$whereVals['date,<='] = $_REQUEST['endDate'];
	}
	*/

	switch ($_REQUEST['reportMode']) {
	case 'MODE_LIST-BDA':
		$tpl = PdfTemplate::getTemplate('ArchObjGroupListBda', 'report');
		break;
	case 'MODE_REPORT-SHORT':
		$tpl = PdfTemplate::getTemplate('ArchObjGroupReportShort', 'report');
		break;
	case 'MODE_REPORT-MEDIUM':
		$tpl = PdfTemplate::getTemplate('ArchObjGroupReportMedium', 'report');
		break;
	case 'MODE_REPORT-FULL':
		$tpl = PdfTemplate::getTemplate('ArchObjGroupReportFull', 'report');
		break;
	default:
		return;
	}

	$pdf->tplSet($tpl);
	$pdf->tplSetHeaderValues($excavValues);
	$pdf->tplSetFooterValues(array('companyShortName' => $company->values['shortName']));
	$pdf->tplUse('init');
	$pdf->addPage();

	$record = new ArchObjGroup();

	$stmt = "SELECT * FROM " . ArchObjGroup::$tableName;
	$pstmt = Db::prepare($stmt, $whereVals, " ORDER BY excavId,0+archObjGroupId");
	$whereVals = Db::getCleanWhereVals($whereVals);
	$pstmt->execute($whereVals);
	while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {

		$record->clearValues();
		$record->setValues($row);
		$values = $record->getExtendedValues(array('export' => true));

		// respect one record per page
		if ($_REQUEST['newPagePerItem'] && ++$recordCount > 1) {
			$pdf->addPage();
		}

		// output one arch object group record
		$pdf->tplUse('body', $values);

		set_time_limit($oldTimeLimit);
	}  // eo loop over arch object group records

	// fillup page with empty cells on bda list
	if ($_REQUEST['reportMode'] == 'MODE_LIST-BDA') {
		$values = $pdf->getVarNames($pdf->tplGetBlock('body'));
		foreach ($values as &$value) {
			$value = '';
		}
		$sanityCounter = 0;
		$lastPage = $pdf->getPage();
		while ($pdf->getPage() == $lastPage) {
			if (++$sanityCounter > 100) {
				break;
			}
			$pdf->tplUse('body', $values);
		}
		if ($pdf->getPage() > $lastPage) {
			$pdf->deletePage($pdf->getPage());
		}
	}


}  // eo arch object group list








?>
