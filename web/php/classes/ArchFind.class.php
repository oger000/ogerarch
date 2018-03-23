<?PHP
/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* ArchFind info
*/
class ArchFind extends DbRecord {

	public static $tableName = 'archFind';

	#FIELDDEF BEGIN
	# Table: archFind
	# Fielddef created: 2013-10-09 14:22

	public static $fieldNames = array(
		'id',
		'excavId',
		'archFindId',
		'archFindIdSort',
		'date',
		'fieldName',
		'plotName',
		'section',
		'area',
		'profile',
		'atStepLowering',
		'atStepCleaningRaw',
		'atStepCleaningFine',
		'atStepOther',
		'isStrayFind',
		'interpretation',
		'datingSpec',
		'datingPeriodId',
		'planName',
		'interfaceIdList',
		'archObjectIdList',
		'archObjGroupIdList',
		'specialArchFind',
		'ceramicsCountId',
		'animalBoneCountId',
		'humanBoneCountId',
		'ferrousCountId',
		'nonFerrousMetalCountId',
		'glassCountId',
		'architecturalCeramicsCountId',
		'daubCountId',
		'stoneCountId',
		'silexCountId',
		'mortarCountId',
		'timberCountId',
		'organic',
		'archFindOther',
		'sedimentSampleCountId',
		'slurrySampleCountId',
		'charcoalSampleCountId',
		'mortarSampleCountId',
		'slagSampleCountId',
		'sampleOther',
		'comment'
	);

	public static $keyFieldNames = array(
		'archFindIdSort',
		'excavId',
		'archFindId',
		'id'
	);

	public static $primaryKeyFieldNames = array(
		'id'
	);


	public static $textFieldNames = array(
		'archFindId',
		'archFindIdSort',
		'fieldName',
		'plotName',
		'section',
		'area',
		'profile',
		'interpretation',
		'datingSpec',
		'datingPeriodId',
		'planName',
		'interfaceIdList',
		'archObjectIdList',
		'archObjGroupIdList',
		'specialArchFind',
		'organic',
		'archFindOther',
		'sampleOther',
		'comment'
	);

	public static $numberFieldNames = array(
		'id',
		'excavId',
		'atStepLowering',
		'atStepCleaningRaw',
		'atStepCleaningFine',
		'atStepOther',
		'isStrayFind',
		'ceramicsCountId',
		'animalBoneCountId',
		'humanBoneCountId',
		'ferrousCountId',
		'nonFerrousMetalCountId',
		'glassCountId',
		'architecturalCeramicsCountId',
		'daubCountId',
		'stoneCountId',
		'silexCountId',
		'mortarCountId',
		'timberCountId',
		'sedimentSampleCountId',
		'slurrySampleCountId',
		'charcoalSampleCountId',
		'mortarSampleCountId',
		'slagSampleCountId'
	);

	public static $boolFieldNames = array(

	);

	public static $dateFieldNames = array(
		'date'
	);

	public static $timeFieldNames = array(

	);

	#FIELDDEF END



	private $stratumIdArray = null;



	/**
	* Clear values.
	* Including special vars.
	*/
	public function clearValues() {
		parent::clearValues();
		$this->stratumIdArray = null;
	}  // clear values


	public static $findItemFields = array(
		'ceramicsCountId',
		'ferrousCountId',
		'architecturalCeramicsCountId',
		'silexCountId',
		'animalBoneCountId',
		'nonFerrousMetalCountId',
		'daubCountId',
		'mortarCountId',
		'humanBoneCountId',
		'glassCountId',
		'stoneCountId',
		'timberCountId',
	);

	public static $sampleItemFields = array(
		'sedimentSampleCountId',
		'slurrySampleCountId',
		'mortarSampleCountId',
		'charcoalSampleCountId',
		'slagSampleCountId',
	);



	/**
	* Get stratum list
	*/
	public function getStratumIdArray() {

		if ($this->stratumIdArray === null) {
			$this->stratumIdArray = StratumToArchFind::getStratumIdArray($this->values['excavId'], $this->values['archFindId']);
		}
		return $this->stratumIdArray;

	} // eo stratum list



	/**
	* Get values for output for arch find sheets
	*/
	public function getFindSheetValues($opts = array()) {

		if (!$opts['skipFromDb']) {
			$this->fromDb();
		}
		$values = $this->getExtendedValues(array('export' => true));

		$excav = Excavation::newFromDb(array('id' => $this->values['excavId']));
		$values['excavName'] = $excav->values['name'];
		$values['officialId'] = $excav->values['officialId'];
		$values['cadastralCommunityName'] = $excav->values['cadastralCommunityName'];

		$company = Company::newFromDb(array('id' => 1));    // HACK
		$values['companyShortName'] = $company->values['shortName'];

		$values['atStepLowering'] = ($values['atStepLowering'] ? 'X' : '');
		$values['atStepCleaningRaw'] = ($values['atStepCleaningRaw'] ? 'X' : '');
		$values['atStepCleaningFine'] = ($values['atStepCleaningFine'] ? 'X' : '');
		$values['atStepOther'] = ($values['atStepOther'] ? 'X' : '');

		$values['isStrayFind'] = ($values['isStrayFind'] ? 'X' : '');
		/*
		if ($values['isStrayFind']) {
			$values['stratumIdList'] = 'StrF' . ($values['stratumIdList'] ? ',' : '') . $values['stratumIdList'];
		}
		*/

		foreach (static::$findItemFields as $fieldName) {
			foreach (array(1,2,3) as $quant) {
				$values[$fieldName . $quant] = ($this->values[$fieldName] == $quant ? 'X' : '');
			}
		}

		foreach (static::$sampleItemFields as $fieldName) {
			$values[$fieldName] = ($values[$fieldName] ? 'X' : '');
		}

		return $values;
	}  // eo get find ticket values



	/**
	* Get extended values.
	* Use this to decode fields.
	*/
	public function getExtendedValues($opts = array()) {

		$values = $this->values;

		$values['stratumIdList'] = implode(ExcavHelper::$xidDelimiterOut, $this->getStratumIdArray());

		// maybe we should overwrite fromDb and add this there???
		// - workaround a extjs4 bug:
		//   extjs 4.0.7 does not reset radiogroups on loading a form
		//   if no item matches the loaded value (for example a null value)
		//   => we sanisize null items to empty string to satisfy the radio group
		//      looks like '' evaluetes ok with numeric 0 as inputValue
		// - do not beautify on export because this conflicts with non-NULL field policy
		if (!$opts['export']) {
			foreach (static::$findItemFields as $fieldName) {
				if (!$values[$fieldName]) {
					$values[$fieldName] = '';
				}
				// alternative: $values[$fieldName] *= 1;
			}
			// do the same for samples - but to beautify the grid
			foreach (static::$sampleItemFields as $fieldName) {
				if (!$values[$fieldName]) {
					$values[$fieldName] = '';
				}
			}
		}  // eo not-export


		return $values;
	} // eo set extended values



	/**
	* Has find item
	*/
	public function hasFindItem($fieldNames = null) {

		// default to all items
		if (!$fieldNames) {
			$fieldNames = static::$findItemFields;
		}
		elseif (!is_array($fieldNames)) {
			$fieldNames = (array)$fieldNames;
		}

		foreach ($fieldNames as $fieldName) {
			if ($this->values[$fieldName]) {
				return true;
			}
		}

		return $false;
	} // eo set has find item


	/**
	* Has find item
	* Include non exact fields.
	*/
	public function hasFindItem2() {

		if ($this->hasFindItem() ||
				$this->values['specialArchFind'] ||
				$this->values['organic'] ||
				$this->values['archFindOther']) {

			return true;
		}

		return false;
	}  // eo has find item (extendend)



	/**
	* Has sample item
	*/
	public function hasSampleItem($fieldNames = null) {

		// default to all items
		if (!$fieldNames) {
			$fieldNames = static::$sampleItemFields;
		}
		elseif (!is_array($fieldNames)) {
			$fieldNames = (array)$fieldNames;
		}

		foreach ($fieldNames as $fieldName) {
			if ($this->values[$fieldName]) {
				return true;
			}
		}

		return $false;
	} // eo set has sample item



	/**
	* Has sample item
	* Include non exact fields.
	*/
	public function hasSampleItem2() {

		if ($this->hasSampleItem() ||
				$this->values['sampleOther']) {

			return true;
		}

		return false;
	}  // eo has sample item (extendend)



	/**
	* Get item abbrevs
	*/
	public static function getItemAbbrevs() {

		$values = array(
			'specialArchFind' => Oger::_('SO'),
			'ceramicsCountId' => Oger::_('KE'),
			'animalBoneCountId' => Oger::_('TK'),
			'humanBoneCountId' => Oger::_('MK'),
			'ferrousCountId' => Oger::_('FE'),
			'nonFerrousMetalCountId' => Oger::_('BM'),
			'glassCountId' => Oger::_('GL'),
			'architecturalCeramicsCountId' => Oger::_('BK'),
			'daubCountId' => Oger::_('HL'),
			'stoneCountId' => Oger::_('ST'),
			'silexCountId' => Oger::_('SI'),
			'mortarCountId' => Oger::_('MÖ'),
			'timberCountId' => Oger::_('HO'),
			'organic' => Oger::_('OR'),
			'archFindOther' => Oger::_('SF'),
			'sedimentSampleCountId' => Oger::_('se'),
			'slurrySampleCountId' => Oger::_('sc'),
			'charcoalSampleCountId' => Oger::_('hk'),
			'mortarSampleCountId' => Oger::_('mp'),
			'slagSampleCountId' => Oger::_('sl'),
			'sampleOther' => Oger::_('sp'),
			);

		return $values;
	}  // eo get abbrevs


	/**
	* Get item labels
	*/
	public static function getItemLabels() {

		$values = array(
			'atStepLowering' => Oger::_("Abtiefen"),
			'atStepCleaningRaw' => Oger::_("Grobputzen"),
			'atStepCleaningFine' => Oger::_("Feinputzen"),
			'atStepOther' => Oger::_("Sonstiger Arbeitsschritt"),
			'isStrayFind' => Oger::_("Streu-/Putzfund"),
			'specialArchFind' => Oger::_('Sonderfund'),
			'ceramicsCountId' => Oger::_('Keramik'),
			'animalBoneCountId' => Oger::_('Tierknochen'),
			'humanBoneCountId' => Oger::_('Menschenknochen'),
			'ferrousCountId' => Oger::_('Eisen'),
			'nonFerrousMetalCountId' => Oger::_('Buntmetall'),
			'glassCountId' => Oger::_('Glas'),
			'architecturalCeramicsCountId' => Oger::_('Baukeramik'),
			'daubCountId' => Oger::_('Hüttenlehm'),
			'stoneCountId' => Oger::_('Stein'),
			'silexCountId' => Oger::_('Silex'),
			'mortarCountId' => Oger::_('Mörtel'),
			'timberCountId' => Oger::_('Holz'),
			'organic' => Oger::_('Organisch'),
			'archFindOther' => Oger::_('Sonstiger Fund'),
			'sedimentSampleCountId' => Oger::_('Sedimentprobe'),
			'slurrySampleCountId' => Oger::_('Schlämmprobe'),
			'charcoalSampleCountId' => Oger::_('Holzkohleprobe'),
			'mortarSampleCountId' => Oger::_('Mörtelprobe'),
			'slagSampleCountId' => Oger::_('Schlackenprobe'),
			'sampleOther' => Oger::_('Sonstige Probe'),
			);

		return $values;
	}  // eo get abbrevs



	/**
	* Save input to db (including subtables)
	*/
	public static function saveInput($input, $dbAction, $opts = array()) {

		// precheck and prepare input
		$errorMsg = ExcavHelper::xidValidErr($input['archFindId']);
		if ($errorMsg) {
			return array('errorMsg' => Oger::_('Fundnummer: ') . $errorMsg);
		}
		$errorMsg = ExcavHelper::multiXidValidErr($input['stratumIdList'], array('allowBlank' => true));
		if ($errorMsg) {
			return array('errorMsg' => Oger::_('Stratum: ') . $errorMsg);
		}

		DatingHelper::prepareInput($input['datingFrom'], $input['datingTo']);

		// create new find
		$input['archFindIdSort'] = Oger::getNatSortId($input['archFindId']);
		$record = new self($input);

		// check for required fields
		if (!$record->values['excavId']) {
			return array('errorMsg' => Oger::_("Interne ID der Grabung fehlt."));
		}
		if (!$record->values['archFindId']) {
			return array('errorMsg' => Oger::_("Fundnummer fehlt."));
		}

		// on check-only return here
		// should only happen for import, so exists-already-check and rename-check are not necessary
		if ($opts['checkOnly']) {
			return;
		}


		// construct new id for insert
		if ($dbAction == Db::ACTION_INSERT) {
			if ($record->exists(array('excavId', 'archFindId'))) {
				return array('errorMsg' => Oger::_("Fundnummer ist breits vorhanden - Neuanlage fehlgeschlagen."));
			}
			$record->values['id'] = (string)(self::getMaxValue('id') + 1);
		}


		// store record and stratum list, otherwise getExtendedValues() contains an empty stratumIdList
		$record->toDb($dbAction, array('excavId', 'archFindId'));

		// if remove not forced we fake an insert for the reference tables
		$dbAction2 = $dbAction;
		if (!$opts['removeRefs']) {
			$dbAction2 = Db::ACTION_INSERT;
		}

		// prepare and save stratum id list (remove empty)
		$stratumIdArray = ExcavHelper::multiXidSplit($input['stratumIdList']);
		StratumToArchFind::updDbStratumIdArray($record->values['excavId'], $record->values['archFindId'],
																					 $stratumIdArray, $dbAction2);

		// reply with core ids
		$values = array('excavId' => $record->values['excavId'], 'archFindId' => $record->values['archFindId']);
		return array('data' => $values);

	}  // eo save input



	/**
	* Print an array of arch find sheet values (already prepared)
	* @findSheets: array of values and numCopies
	*/
	public static function printPreparedArchFindSheets($findSheets, $opts = array()) {

		$oldTimeLimit = ini_get('max_execution_time');

		// output
		$pdf = new OgerPdf0();

		$tpl = PdfTemplate::getTemplate('ArchFindSheet');
		$pdf->tplSet($tpl);

		// get offsets for one sheet
		$offsets = array();
		$offsetsBlock = $pdf->tplGetBlock('offsets');
		$offsetsBlock = str_replace("\r", "\n", $offsetsBlock);
		$lines = explode("\n", $tpl);
		for ($i=0; $i < count($lines); $i++) {
			list($cmd, $opts) = explode(":", $lines[$i], 2);
			$maxSheetDef = 0;
			$cmd = trim($cmd);
			if ($cmd == "SHEETSPERPAGE") {
				$sheetsPerPage = trim($opts);
			}
			if ($cmd == "SHEET") {
				list($pageNo, $offsetX, $offsetY) = explode(",", $opts);
				$pageNo = trim($pageNo);
				$offsets[$pageNo] = array($offsetX, $offsetY);
				$maxSheetDef = max($maxSheetDef, $pageNo);
			}
		}
		if ($sheetsPerPage == 0) {
			$sheetsPerPage = $maxSheetDef;
		}
		// oe get sheet offsets


		// ###################
		$pdf->tplUse('init');

		$sheetCount = 0;
		foreach($findSheets as $findSheet) {

			// number of copies for one arch find id
			for ($count = 0; $count < $findSheet['numCopies']; $count++) {

				$pos = ($sheetCount++) % $sheetsPerPage;
				if ($pos == 0) {
					$pdf->addPage();
				}
				$pdf->startTransform();
				$pdf->translate($offsets[$pos][0], $offsets[$pos][1]);

				// postprepare values (dirty hack)
				// print plotname instead of obj group if obj group is not present
				if ($findSheet['values']['plotName'] && !$findSheet['values']['archObjGroupIdList']) {
					$findSheet['values']['archObjGroupIdList'] = "Pz: " . $findSheet['values']['plotName'];
				}
				$pdf->tplUse('body', $findSheet['values']);

//qrcode test begin
//$printQrCode = true;
if ($printQrCode) {

// set style for barcode
/*
$bcStyle = array(
		'border' => 2,
		'vpadding' => 'auto',
		'hpadding' => 'auto',
		'fgcolor' => array(0,0,0),
		'bgcolor' => false, //array(255,255,255)
		'module_width' => 1, // width of a single module in points
		'module_height' => 1 // height of a single module in points
);
*/
$bcStyle = array(
		'border' => 0,
		'vpadding' => 1,
		'hpadding' => 1,
		'fgcolor' => array(0,0,0),
		'bgcolor' => false, //array(255,255,255)
		'module_width' => 1, // width of a single module in points
		'module_height' => 1 // height of a single module in points
);

$bcText = "Massnahme: {$findSheet['values']['officialId']}\n" .
					"GZ: {$findSheet['values']['officialId2']}\n" .
					"Fund: {$findSheet['values']['archFindId']}\n" .
					"Stratum: {$findSheet['values']['stratumIdList']}\n" .
					"";

$pdf->write2DBarcode($bcText, 'QRCODE,L', 112, 73, 22, 22, $bcStyle, 'N');
//$pdf->write2DBarcode('www.tcpdf.org', 'QRCODE,M', 20, 90, 50, 50, $bcStyle, 'N');
//$pdf->write2DBarcode('www.tcpdf.org', 'QRCODE,Q', 20, 150, 50, 50, $bcStyle, 'N');
//$pdf->write2DBarcode('www.tcpdf.org', 'QRCODE,H', 20, 210, 50, 50, $bcStyle, 'N');
}  //qrcode test end

				$pdf->stopTransform();

				set_time_limit($oldTimeLimit);
			}

		}  // eo loop over multi arch find id

		$pdf->Output(Oger::_('Fundzettel'), 'I');

	}  // eo print prepared arch find sheets



	/**
	* Print an array of arch find sheets (not prepared)
	*/
	public static function printArchFindSheets($findSheetsIn, $opts = array()) {

		$oldTimeLimit = ini_get('max_execution_time');

		$findSheetsOut = array();
		foreach($findSheetsIn as $findSheetIn) {

			$findSheetOut = array();

			$findSheetIn['excavId'] = $findSheetIn['excavId'];
			$findSheetIn['archFindId'] = $findSheetIn['archFindId'];
			$findSheetIn['numCopies'] = $findSheetIn['numCopies'];

			if (!$findSheetIn['excavId'] ||
					!$findSheetIn['archFindId'] ||
					!$findSheetIn['numCopies']) {
				continue;
			}

			$archFind = self::newFromDb(array('excavId' => $findSheetIn['excavId'], 'archFindId' => $findSheetIn['archFindId']));
			if (!$archFind->values) {
				continue;
			}

			$findSheetsOut[] = array('values' => $archFind->getFindSheetValues(array('skipFromDb' => true)),
															 'numCopies' => $findSheetIn['numCopies']);

			set_time_limit($oldTimeLimit);
		}  // eo loop over find sheet

		self::printPreparedArchFindSheets($findSheetsOut, $opts);
	}  // eo print arch find sheets (unprepared)



}  // end of class

?>
