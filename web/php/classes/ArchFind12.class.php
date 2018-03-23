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
*/
class ArchFind12 extends DbRec {

	public static $tableName = "archFind";

	public static $findItemFields = array(
		"ceramicsCountId",
		"ferrousCountId",
		"architecturalCeramicsCountId",
		"silexCountId",
		"animalBoneCountId",
		"nonFerrousMetalCountId",
		"daubCountId",
		"mortarCountId",
		"humanBoneCountId",
		"glassCountId",
		"stoneCountId",
		"timberCountId",
	);

	public static $sampleItemFields = array(
		"sedimentSampleCountId",
		"slurrySampleCountId",
		"mortarSampleCountId",
		"charcoalSampleCountId",
		"slagSampleCountId",
	);



	/**
	* Get select template.
	*/
	public static function getSqlTpl($target, &$opts = array()) {

		$listDelim = ExcavHelper::$xidDelimiterOut;


		$seleExcavName =
			"(SELECT name " .
			" FROM excavation AS ex " .
			" WHERE ex.id=archFind.excavId " .
			")";

		$seleStratumIdList =
			"(SELECT GROUP_CONCAT(stratumId ORDER BY CAST(stratumId AS UNSIGNED) SEPARATOR '{$listDelim}') " .
			"  FROM stratumToArchFind AS stToAf " .
			"  WHERE stToAf.excavId=archFind.excavId AND stToAf.archFindId=archFind.archFindId " .
			")";

		$seleExtraCols =
			"{$seleExcavName} AS excavName," .
			"{$seleStratumIdList} AS stratumIdList";


		$seleJoins = "";

		$seleFrom = "" .
			"\n" .
			"FROM archFind " .
			" $seleJoins ";


		$extjsWhere .=
			"      :?hasSpecialArchFind specialArchFind != ''" .
			"  AND :?hasCeramics ceramicsCountId >= 1" .
			"  AND :?hasAnimalBone animalBoneCountId >= 1" .
			"  AND :?hasHumanBone humanBoneCountId >= 1" .
			"  AND :?hasFerrous ferrousCountId >= 1" .
			"  AND :?hasNonFerrous nonFerrousCountId >= 1" .
			"  AND :?hasGlass glassCountId >= 1" .
			"  AND :?hasArchitecturalCeramics architecturalCeramicsCountId >= 1" .
			"  AND :?hasDaub daubCountId >= 1" .
			"  AND :?hasStone stoneCountId >= 1" .
			"  AND :?hasSilex silexCountId >= 1" .
			"  AND :?hasMortar mortarCountId >= 1" .
			"  AND :?hasTimber timberCountId >= 1" .
			"  AND :?hasOrganic organic != ''" .
			"  AND :?hasArchFindOther archFindOther != ''" .

			"  AND :?hasSedimentSample sedimentSampleCountId >= 1" .
			"  AND :?hasSlurrySample slurrySampleCountId >= 1" .
			"  AND :?hasCharcoalSample charcoalSampleCountId >= 1" .
			"  AND :?hasMortarSample mortarSampleCountId >= 1" .
			"  AND :?hasSlagSample slagSampleCountId >= 1" .
			"  AND :?hasSampleOther sampleOther != ''" .

			"  AND (interpretation LIKE :@searchText" .
				 " OR specialArchFind LIKE :@searchText" .
				 " OR organic LIKE :@searchText" .
				 " OR archFindOther LIKE :@searchText" .
				 " OR sampleOther LIKE :@searchText" .
				 " OR comment LIKE :@searchText" .
				 ")" .

			" AND archFindIdSort >=:@archFindBeginId " .
			" AND archFindIdSort <=:@archFindEndId " .
			" AND archFindIdSort >=:@beginId " .
			" AND archFindIdSort <=:@endId " .
			" AND date >=:@beginDate " .
			" AND date <=:@endDate " .
			"";



		$extjsOrder =
			"=archFind.archFindIdSort;" .
			"archFindId=;" .
			"stratumIdList=CAST(stratumIdList AS UNSIGNED);" .
			"date;" .
			"fieldName;" .
			"plotName;" .
			"section;" .
			"area;" .
			"profile;" .
			"atStepLowering;" .
			"atStepCleaningRaw;" .
			"atStepCleaningFine;" .
			"atStepOther;" .
			"isStrayFind;" .
			"interpretation;" .
			"datingSpec;" .
			"datingPeriodId;" .
			"planName;" .
			"interfaceIdList;" .
			"archObjectIdList;" .
			"archObjGroupIdList;" .
			"specialArchFind;" .
			"ceramicsCountId;" .
			"animalBoneCountId;" .
			"humanBoneCountId;" .
			"ferrousCountId;" .
			"nonFerrousMetalCountId;" .
			"glassCountId;" .
			"architecturalCeramicsCountId;" .
			"daubCountId;" .
			"stoneCountId;" .
			"silexCountId;" .
			"mortarCountId;" .
			"timberCountId;" .
			"organic;" .
			"archFindOther;" .
			"sedimentSampleCountId;" .
			"slurrySampleCountId;" .
			"charcoalSampleCountId;" .
			"mortarSampleCountId;" .
			"slagSampleCountId;" .
			"sampleOther;" .
			"comment;" .
			"";


		// ######


		if ($target == "ROW") {
			return
				"SELECT * FROM archFind " .
				"{WHERE excavId=:!excavId AND archFind.archFindId=:!archFindId}";
		}


		if ($target == "GRIDCOUNT") {
			return
				"SELECT COUNT(*) AS recordCount " .
				"{$seleFrom} " .
				"{WHERE excavId=:!excavId AND $extjsWhere}";
		}

		if ($target == "GRID" || $target == "EXPORT") {
			return
				"SELECT *,{$seleExtraCols} " .
				"{$seleFrom} " .
				"{WHERE excavId=:!excavId AND $extjsWhere}" .
				"{ORDER BY $extjsOrder} " .
				"__EXTJS_LIMIT__";
		}

		if ($target == "FORM") {
			return
				"SELECT *,{$seleExtraCols} " .
				"{$seleFrom} " .
				"{WHERE excavId=:!excavId AND archFind.archFindId=:!archFindId}";
		}



		if ($target == "FORM-OFFSET-NEXT") {
			return
				"SELECT *,{$seleExtraCols} " .
				"{$seleFrom} " .
				"{WHERE excavId=:!excavId AND archFind.archFindIdSort > :!archFindIdSort} " .
				"{ORDER BY $extjsOrder} " .  // overwritten in calling script
				"__EXTJS_LIMIT__";
		}
		if ($target == "FORM-OFFSET-PREV") {
			return
				"SELECT *,{$seleExtraCols} " .
				"{$seleFrom} " .
				"{WHERE excavId=:!excavId AND archFind.archFindIdSort < :!archFindIdSort} " .
				"{ORDER BY $extjsOrder} " .  // overwritten in calling script
				"__EXTJS_LIMIT__";
		}
		if ($target == "FORM-OFFSET-NEXT-FILTER") {
			return
				"SELECT *,{$seleExtraCols} " .
				"{$seleFrom} " .
				"{WHERE excavId=:!excavId AND archFind.archFindIdSort > :!archFindIdSort AND $extjsWhere} " .
				"{ORDER BY $extjsOrder} " .  // overwritten in calling script
				"__EXTJS_LIMIT__";
		}
		if ($target == "FORM-OFFSET-PREV-FILTER") {
			return
				"SELECT *,{$seleExtraCols} " .
				"{$seleFrom} " .
				"{WHERE excavId=:!excavId AND archFind.archFindIdSort < :!archFindIdSort AND $extjsWhere} " .
				"{ORDER BY $extjsOrder} " .  // overwritten in calling script
				"__EXTJS_LIMIT__";
		}




		throw new Exception("Invalid id $target for sql template.");
	}  // get select



	/**
	* Prepare for extjs (grid, form)
	*/
	public static function prep4Extjs($row) {

		// unify and resort id lists
		if (array_key_exists("stratumIdList", $row)) {
			$row['stratumIdList'] = ExcavHelper::multiXidPrepare($row['stratumIdList']);
		}

		return $row;
	}  // eo prepare for extjs grid and form


	/**
	* Prepare for export
	*/
	public static function prep4Export($row) {

		$listDelim = ExcavHelper::$xidDelimiterOut;
		$row = static::prep4Extjs($row);

		// remove internal values
		unset($row['id']);
		unset($row['archFindIdSort']);

		return $row;
	}  // eo prepare for export



	/**
	* Prepare for report
	*/
	public static function prep4Report($row) {

		$listDelim = ExcavHelper::$xidDelimiterOut;
		$row = static::prep4Export($row);

		$labels = static::getItemLabels();
		$countText = array(1 => Oger::_("1 Stk"), 2 => Oger::_("1 EH"), 3 => Oger::_("mehrere EH"));

		// at step list
		$tmp = "";
		foreach (array("atStepLowering",
									 "atStepCleaningRaw",
									 "atStepCleaningFine",
									 "atStepOther",
									 "isStrayFind",
									 ) as $fieldName) {
			if ($row[$fieldName]) {
				$tmp .= ($tmp ? "," : "") . $labels[$fieldName];
			}
			$row['atStepList'] = $tmp;
		}


		// long material names
		$tmp = "";
		foreach (static::$findItemFields as $fieldName) {
			if ($row[$fieldName]) {
				$tmp2 = "";
				//$tmp2 .= $countText[$count] . " ";  // quantity not used for now
				$tmp2 .= $labels[$fieldName];
				$tmp .= ($tmp ? ", " : "") . $tmp2;
			}
		}
		$row['detailFindList'] = $tmp;

		// sample checkboxes to text
		$tmp = "";
		foreach (static::$sampleItemFields as $fieldName) {
			if ($row[$fieldName]) {
				$tmp .= ($tmp ? ", " : "") . $labels[$fieldName];
			}
		}
		if ($row['sampleOther']) {
			$tmp .= ($tmp ? ", " : "") . $row['sampleOther'];
		}
		$row['detailSampleList'] = $tmp;


		// material abbrev names
		$abbrevs = static::getItemAbbrevs();
		foreach (array("ceramicsCountId" => "ceramicsCountAbbrev",
									 "animalBoneCountId" => "animalBoneCountAbbrev",
									 "humanBoneCountId" => "humanBoneCountAbbrev",
									 "ferrousCountId" => "ferrousCountAbbrev",
									 "nonFerrousMetalCountId" => "nonFerrousMetalCountAbbrev",
									 "glassCountId" => "glassCountAbbrev",
									 "architecturalCeramicsCountId" => "architecturalCeramicsCountAbbrev",
									 "daubCountId" => "daubCountAbbrev",
									 "stoneCountId" => "stoneCountAbbrev",
									 "silexCountId" => "silexCountAbbrev",
									 "mortarCountId" => "mortarCountAbbrev",
									 "timberCountId" => "timberCountAbbrev",
									 "organic" => "organicAbbrev",
									 "archFindOther" => "archFindOtherAbbrev",
									 "sedimentSampleCountId" => "sedimentSampleCountAbbrev",
									 "slurrySampleCountId" => "slurrySampleCountAbbrev",
									 "charcoalSampleCountId" => "charcoalSampleCountAbbrev",
									 "mortarSampleCountId" => "mortarSampleCountAbbrev",
									 "slagSampleCountId" => "slagSampleCountAbbrev",
									 "sampleOther" => "sampleOtherAbbrev",
						) as $fieldName => $abbrevFieldName) {
			$row[$abbrevFieldName] = ($row[$fieldName] ? $abbrevs[$fieldName] : "");
		}


		return $row;
	}  // eo prepare for report



	/**
	* store input to db
	*/
	public static function storeInput($values, $dbAction, $opts = array()) {

		// precheck and prepare input
		$values['archFindId'] = trim($values['archFindId']);

		$errorMsg = ExcavHelper::xidValidErr($values['archFindId']);
		if ($errorMsg) {
			throw new Exception(Oger::_("Fundnummer: ") . $errorMsg);
		}

		// check for required fields
		if (!$values['excavId']) {
			throw new Exception(Oger::_("Interne ID der Grabung fehlt."));
		}
		if (!$values['archFindId']) {
			throw new Exception(Oger::_("Fundnummer fehlt."));
		}

		if (!($values['stratumIdList'] || $values['isStrayFind'])) {
			throw new Exception(Oger::_("Stratum ist erforderlich (ausgenommen bei Streu-/Putzfund)."));
		}

		// on check-only return here
		// should only happen for import, so exists-already-check and rename-check are not necessary
		if ($opts['checkOnly']) {
			return;
		}

		$seleVals = array("excavId" => $values['excavId'], "archFindId" => $values['archFindId']);

		// check for existing entry and construct new id for insert
		if ($dbAction == "INSERT") {
			// insert of duplicate excavid/stratumid fails on uniq index, so do not check
			$values['id'] = Dbw::fetchValue1("SELECT MAX(id) FROM archFind") + 1;
		}


		// store main record
		$values['archFindIdSort'] = Oger::getNatSortId($values['archFindId']);
		static::store($dbAction, $values, $seleVals);

		// if remove not forced we fake an insert for the reference tables
		$dbAction2 = $dbAction;
		if (!$opts['removeRefs']) {
			$dbAction2 = "INSERT";
		}

		// store stratum id list
		StratumToArchFind12::storeStratumIds(
			$values['excavId'], $values['archFindId'], $values['stratumIdList'], $dbAction2);


		// reply with core ids
		return $seleVals;
	}  // eo save input


	/**
	* Get item labels
	*/
	public static function getItemLabels() {

		$values = array(
			"atStepLowering" => Oger::_("Abtiefen"),
			"atStepCleaningRaw" => Oger::_("Grobputzen"),
			"atStepCleaningFine" => Oger::_("Feinputzen"),
			"atStepOther" => Oger::_("Sonstiger Arbeitsschritt"),
			"isStrayFind" => Oger::_("Streu-/Putzfund"),
			"specialArchFind" => Oger::_("Sonderfund"),
			"ceramicsCountId" => Oger::_("Keramik"),
			"animalBoneCountId" => Oger::_("Tierknochen"),
			"humanBoneCountId" => Oger::_("Menschenknochen"),
			"ferrousCountId" => Oger::_("Eisen"),
			"nonFerrousMetalCountId" => Oger::_("Buntmetall"),
			"glassCountId" => Oger::_("Glas"),
			"architecturalCeramicsCountId" => Oger::_("Baukeramik"),
			"daubCountId" => Oger::_("Hüttenlehm"),
			"stoneCountId" => Oger::_("Stein"),
			"silexCountId" => Oger::_("Silex"),
			"mortarCountId" => Oger::_("Mörtel"),
			"timberCountId" => Oger::_("Holz"),
			"organic" => Oger::_("Organisch"),
			"archFindOther" => Oger::_("Sonstiger Fund"),
			"sedimentSampleCountId" => Oger::_("Sedimentprobe"),
			"slurrySampleCountId" => Oger::_("Schlämmprobe"),
			"charcoalSampleCountId" => Oger::_("Holzkohleprobe"),
			"mortarSampleCountId" => Oger::_("Mörtelprobe"),
			"slagSampleCountId" => Oger::_("Schlackenprobe"),
			"sampleOther" => Oger::_("Sonstige Probe"),
			);

		return $values;
	}  // eo get item labels


	/**
	* Get item abbrevs
	*/
	public static function getItemAbbrevs() {

		$values = array(
			"specialArchFind" => Oger::_("SO"),
			"ceramicsCountId" => Oger::_("KE"),
			"animalBoneCountId" => Oger::_("TK"),
			"humanBoneCountId" => Oger::_("MK"),
			"ferrousCountId" => Oger::_("FE"),
			"nonFerrousMetalCountId" => Oger::_("BM"),
			"glassCountId" => Oger::_("GL"),
			"architecturalCeramicsCountId" => Oger::_("BK"),
			"daubCountId" => Oger::_("HL"),
			"stoneCountId" => Oger::_("ST"),
			"silexCountId" => Oger::_("SI"),
			"mortarCountId" => Oger::_("MÖ"),
			"timberCountId" => Oger::_("HO"),
			"organic" => Oger::_("OR"),
			"archFindOther" => Oger::_("SF"),
			"sedimentSampleCountId" => Oger::_("se"),
			"slurrySampleCountId" => Oger::_("sc"),
			"charcoalSampleCountId" => Oger::_("hk"),
			"mortarSampleCountId" => Oger::_("mp"),
			"slagSampleCountId" => Oger::_("sl"),
			"sampleOther" => Oger::_("sp"),
			);

		return $values;
	}  // eo get abbrevs



	/**
	* Has find item
	*/
	public static function hasFindItem($row, $fieldNames = null) {

		// default to all items
		if (!$fieldNames) {
			$fieldNames = static::$findItemFields;
		}
		elseif (!is_array($fieldNames)) {
			$fieldNames = (array)$fieldNames;
		}

		foreach ($fieldNames as $fieldName) {
			if ($row[$fieldName]) {
				return true;
			}
		}

		return $false;
	} // eo set has find item


	/**
	* Has find item
	* Include non exact fields.
	*/
	public static function hasFindItemOrText($row) {

		if (static::hasFindItem($row) ||
				$row['specialArchFind'] ||
				$row['organic'] ||
				$row['archFindOther']) {
			return true;
		}

		return false;
	}  // eo has find item (extendend)



	/**
	* Has sample item
	*/
	public static function hasSampleItem($row, $fieldNames = null) {

		// default to all items
		if (!$fieldNames) {
			$fieldNames = static::$sampleItemFields;
		}
		elseif (!is_array($fieldNames)) {
			$fieldNames = (array)$fieldNames;
		}

		foreach ($fieldNames as $fieldName) {
			if ($row[$fieldName]) {
				return true;
			}
		}

		return $false;
	} // eo set has sample item



	/**
	* Has sample item
	* Include non exact fields.
	*/
	public static function hasSampleItemOrText($row) {

		if (static::hasSampleItem($row) || $row['sampleOther']) {
			return true;
		}

		return false;
	}  // eo has sample item (extendend)


}  // end of class

?>
