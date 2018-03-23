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
* Stratum. Common part.
* CONVENTION: Substratums must have the same id to make this class working correct!
*/
class Stratum extends DbRecord {

	public static $tableName = 'stratum';

	#FIELDDEF BEGIN
	# Table: stratum
	# Fielddef created: 2013-10-09 14:22

	public static $fieldNames = array(
		'id',
		'excavId',
		'stratumId',
		'stratumIdSort',
		'categoryId',
		'date',
		'originator',
		'fieldName',
		'plotName',
		'section',
		'area',
		'profile',
		'typeId',
		'interpretation',
		'datingSpec',
		'datingPeriodId',
		'pictureReference',
		'planDigital',
		'planAnalog',
		'photogrammetry',
		'photoDigital',
		'photoSlide',
		'photoPrint',
		'lengthValue',
		'width',
		'height',
		'diaMeter',
		'hasArchFind',
		'hasSample',
		'hasArchObject',
		'hasArchObjGroup',
		'comment',
		'listComment',
		'isTopEdge',
		'isBottomEdge',
		'hasAutoInterface'
	);

	public static $keyFieldNames = array(
		'excavId',
		'stratumId',
		'id',
		'stratumIdSort'
	);

	public static $primaryKeyFieldNames = array(
		'id'
	);


	public static $textFieldNames = array(
		'stratumId',
		'stratumIdSort',
		'categoryId',
		'originator',
		'fieldName',
		'plotName',
		'section',
		'area',
		'profile',
		'typeId',
		'interpretation',
		'datingSpec',
		'datingPeriodId',
		'pictureReference',
		'lengthValue',
		'width',
		'height',
		'diaMeter',
		'comment',
		'listComment'
	);

	public static $numberFieldNames = array(
		'id',
		'excavId',
		'planDigital',
		'planAnalog',
		'photogrammetry',
		'photoDigital',
		'photoSlide',
		'photoPrint',
		'hasArchFind',
		'hasSample',
		'hasArchObject',
		'hasArchObjGroup',
		'isTopEdge',
		'isBottomEdge',
		'hasAutoInterface'
	);

	public static $boolFieldNames = array(

	);

	public static $dateFieldNames = array(
		'date'
	);

	public static $timeFieldNames = array(

	);

	#FIELDDEF END


	public $stratumSub = null;

	private $categoryObj;
	private $typeObj;

	private $matrixInfo = array();
	private $complexPartIdArray = array();




	/**
	* Clear values.
	* Including substratum and other special objects.
	*/
	public function clearValues() {
		parent::clearValues();
		$this->stratumSub = null;
		$this->categoryObj = null;
		$this->typeObj = null;
		$this->matrixInfo = array();
		$this->complexPartIdArray = array();
	}  // clear values



	/**
	* Get extended values.
	*/
	public function getExtendedValues($opts = array()) {

		$values = $this->values;

		$categoryObj = $this->getCategoryObj();
		$values['categoryName'] = ($categoryObj->values ? $categoryObj->values['name'] : $values['categoryId']);

		$typeObj = $this->getTypeObj();
		$values['typeName'] = ($typeObj->values['name'] ?: $values['typeId']);
		$values['typeCode'] = ($typeObj->values['code'] ?: '');


		// export mode
		if ($opts['export']) {

			$tmp = '';
			$archObjects = $this->getArchObjectObjects();
			foreach ($archObjects as $archObject) {
				$tmpValues = $archObject->getExtendedValues();
				$tmp .= ($tmp ? ', ' : '') . $tmpValues['archObjectId'] . ' ' . $tmpValues['typeName'];
			}
			$values['archObjectReferenceList'] = $tmp;

			$tmp = '';
			$archObjGroups = $this->getArchObjGroupObjects();
			foreach ($archObjGroups as $archObjGroup) {
				$tmpValues = $archObjGroup->getExtendedValues();
				$tmp .= ($tmp ? ', ' : '') . $tmpValues['archObjGroupId'] . ' ' . $tmpValues['typeName'];
			}
			$values['archObjGroupReferenceList'] = $tmp;
		}  // eo export


		return $values;
	}  // eo extended values



	/**
	* Get type object
	*/
	public function getTypeObj() {
		if ($this->values['typeId'] && $this->typeObj === null) {
			$this->typeObj = StratumType::newFromDb(array('id' => $this->values['typeId']));
		}
		return $this->typeObj;
	} // eo type obj



	/**
	* Get category object
	*/
	public function getCategoryObj() {
		if ($this->values['categoryId'] && $this->categoryObj === null) {
			$this->categoryObj = StratumCategory::newFromDb(array('id' => $this->values['categoryId']));
		}
		return $this->categoryObj;
	} // eo category obj



	/**
	* Write record values to db
	*/
	public function toDb($dbAction, $whereValues = null, $opts = array()) {
		parent::toDb($dbAction, $whereValues, $opts);

		StratumMatrix::updDbRelationIdArray($this->values['excavId'], $this->values['stratumId'],
			StratumMatrix::THIS_IS_EARLIER_THAN, $this->matrixInfo[StratumMatrix::THIS_IS_EARLIER_THAN], $opts['dbAction2']);
		StratumMatrix::updDbRelationIdArray($this->values['excavId'], $this->values['stratumId'],
			StratumMatrix::THIS_IS_REVERSE_EARLIER_THAN, $this->matrixInfo[StratumMatrix::THIS_IS_REVERSE_EARLIER_THAN], $opts['dbAction2']);
		StratumMatrix::updDbRelationIdArray($this->values['excavId'], $this->values['stratumId'],
			StratumMatrix::THIS_IS_EQUAL_TO, $this->matrixInfo[StratumMatrix::THIS_IS_EQUAL_TO], $opts['dbAction2']);
		StratumMatrix::updDbRelationIdArray($this->values['excavId'], $this->values['stratumId'],
			StratumMatrix::THIS_IS_CONTEMP_WITH, $this->matrixInfo[StratumMatrix::THIS_IS_CONTEMP_WITH], $opts['dbAction2']);

		StratumComplex::updDbPartIdArray($this->values['excavId'],
																		 $this->values['stratumId'], $this->complexPartIdArray, $opts['dbAction2']);

		if ($this->stratumSub) {
			// again force id of substratum to be identically with mainstratum
			$this->stratumSub->values['id'] = $this->values['id'];
			// if something went wrong with the substratum when we inserted the mainstratum
			// we have to insert the substratum now even if we do an update on the mainstratum
			if ($dbAction == Db::ACTION_UPDATE && !$this->stratumSub->exists(array('id' => $this->values['id']))) {
				$dbAction = Db::ACTION_INSERT;
			}
			$this->stratumSub->toDb($dbAction, $whereValues);
		}
	}  // eo to db




	/*
	 * Create sub stratum from given value array - including matrix info
	*/
	public function createStratumSub($values = null, $categoryId = null) {

		if (!$values) {
			$values = array();
		}

		// force category over existing categoryId if given
		if ($categoryId) {
			$this->values['categoryId'] = $categoryId;
		}

		// force id of substratum to be identically with mainstratum
		$values['id'] = $this->values['id'];

		// save matrix info always if present - it is NOT a substratum but part of the main stratum
		// but is handled here for convenience reasons
		$this->createStratumMatrix($values);

		// sub stratum creation depends on category
		$categoryInfo = StratumCategory::getStrucInfo($this->values['categoryId']);
		$stratumSubClassName = $categoryInfo['className'];

		switch ($this->values['categoryId']) {
		case  StratumCategory::ID_INTERFACE:
		case  StratumCategory::ID_DEPOSIT:
		case  StratumCategory::ID_SKELETON:
		case  StratumCategory::ID_WALL:
		case  StratumCategory::ID_TIMBER:
			$this->stratumSub = new $stratumSubClassName($values);
			break;
		case  StratumCategory::ID_COMPLEX:
			if (array_key_exists('complexPartIdList', $values)) {
				$this->complexPartIdArray = ExcavHelper::multiXidSplit($values['complexPartIdList']);
			}
			break;
		}  // eo category switch


	}  // create new substratum from given values


	/*
	 * Create matrix info from given value array
	*/
	public function createStratumMatrix($values, $opts = array()) {

		if (!$values) {
			$values = array();
		}

		if (array_key_exists('earlierThanIdList', $values)) {
			$this->matrixInfo[StratumMatrix::THIS_IS_EARLIER_THAN] = ExcavHelper::multiXidSplit($values['earlierThanIdList']);
		}
		if (array_key_exists('reverseEarlierThanIdList', $values)) {
			$this->matrixInfo[StratumMatrix::THIS_IS_REVERSE_EARLIER_THAN] = ExcavHelper::multiXidSplit($values['reverseEarlierThanIdList']);
		}
		if (array_key_exists('equalToIdList', $values)) {
			$this->matrixInfo[StratumMatrix::THIS_IS_EQUAL_TO] = ExcavHelper::multiXidSplit($values['equalToIdList']);
		}
		if (array_key_exists('contempWithIdList', $values)) {
			$this->matrixInfo[StratumMatrix::THIS_IS_CONTEMP_WITH] = ExcavHelper::multiXidSplit($values['contempWithIdList']);
		}

		if ($opts['reportErrors']) {
			$relationNames = StratumMatrix::getRelationNames();
			$matrixSum = array();
			foreach (array_keys($this->matrixInfo) as $relationKey) {
				foreach ($this->matrixInfo[$relationKey] as $otherStratumId) {
					$matrixSum[$otherStratumId][$relationKey] = $relationKey;
				}
			}
			$errorMsg = "";
			foreach ($matrixSum as $otherStratumId => $relationKeys) {
				if ($otherStratumId == $this->values['stratumId']) {
					$errorMsg .= "Bezug auf sich selbst in ";
					$delim = "";
					foreach ($relationKeys as $relationKey) {
						$errorMsg .= "'$delim{$relationNames[$relationKey]}'";
						$delim = ", ";
					}
					$errorMsg .= ". <br>";
				}  // eo multi relation check
				if (count($relationKeys) > 1) {
					$errorMsg .= "Bezugs-Stratum '$otherStratumId' gleichzeitig in ";
					$delim = "";
					$i = 0;
					foreach ($relationKeys as $relationKey) {
						$errorMsg .= "$delim'{$relationNames[$relationKey]}'";
						$delim = ", ";
						if ($i++ == count($relationKeys) - 2) {
							$delim = " und ";
						}
					}
					$errorMsg .= ". <br>";
				}  // eo multi relation check
			}  // eo check all relation stratums

			if ($errorMsg) {
				return $errorMsg;
			}
			return null;
		}  // eo report errors

	}  // create matrix info from given values




	/**
	* Get object data from db - including substratums
	*/
	public function allFromDb($whereValues = array(), $moreStmt = null) {
		$this->fromDb($whereValues, $moreStmt);
		$this->stratumSubFromDb();
	}  // all values from db



	/*
	* Get substratum values from db - according to category
	* Get matrix info from db
	*/
	public function stratumSubFromDb() {

		$this->matrixInfo = StratumMatrix::getFullRelationsIdArray($this->values['excavId'], $this->values['stratumId']);
		$this->complexPartIdArray = StratumComplex::getPartIdArray($this->values['excavId'], $this->values['stratumId']);

		if (!$this->stratumSub) {
			$this->createStratumSub();
		}
		if ($this->stratumSub) {
			$this->stratumSub->fromDb(array('id' => $this->values['id']));
		}
	}  // substratum from db



	/*
	* Get all values - including substratum
	*/
	public function getAllValues() {
		if (!$this->stratumSub) {
			$this->createStratumSub();
		}
		$values = $this->values;
		if ($this->stratumSub) {
			$values = array_merge($this->stratumSub->values, $values);
		}
		return $values;
	}


	/*
	* Get all extended values - including substratum
	*/
	public function getAllExtendedValues($opts = array()) {

		$values = $this->getExtendedValues($opts);

		// matrix info
		$values = array_merge($values, StratumMatrix::getRelationIdListsFromMatrixInfo($this->matrixInfo, array('mergeReverseAll' => true)));


		// --- get matrix extra info sets all extrainfos on

		if ($opts['getMatrixExtraInfo']) {
			$opts['getContainedInInterfaceIdList'] = true;
			$opts['getContainsStratumIdList'] = true;  // only processed if this category is interface
			$opts['getContainingInterfaceContainsStratumIdList'] = true;
		}

		$interfaceNodeList = array();
		if ($this->values['categoryId'] == StratumCategory::ID_INTERFACE ||
				$opts['getContainedInInterfaceIdList'] || $opts['getContainsStratumIdList'] ||
				$opts['getContainingInterfaceContainsStratumIdList']) {
			$interfaceNodeList = $this->getContainedInInterfaceArray();
		}

		$stratumNodeList = array();
		if (($this->values['categoryId'] == StratumCategory::ID_INTERFACE && $opts['getContainsStratumIdList']) ||
				$opts['getContainingInterfaceContainsStratumIdList']) {

			// if no interface is present for stratumcollection in same interface
			// then we use the current stratum as startnode
			$interfaceStartNodes = $interfaceNodeList;
			// check for "overflow"
			if ($interfaceStartNodes[-1]) {
				unset($interfaceStartNodes[-1]);
			}
			if ($opts['getContainingInterfaceContainsStratumIdList'] && !$interfaceStartNodes) {
				$interfaceStartNodes = array($this->values['stratumId'] => $this->values['stratumId']);
			}
			$prevChain = array();
			foreach ($interfaceStartNodes as $interfaceStartNode) {
				$node = self::newFromDb(array('excavId' => $this->values['excavId'], 'stratumId' => $interfaceStartNode));
				$node->getContainsStratumArray($prevChain, $stratumNodeList, array('isStartNode' => true));
			}
		}

		if ($opts['getContainedInInterfaceIdList']) {
			$tmpOut = $interfaceNodeList;
			ksort($tmpOut, SORT_NUMERIC);
			// check for "overflow"
			if ($tmpOut[-1]) {
				unset($tmpOut[-1]);
				$tmpOut[] = ",...";
			}
			$values['containedInInterfaceIdList'] = implode(ExcavHelper::$xidDelimiterOut, $tmpOut);
		}

		if ($opts['getContainsStratumIdList'] || $opts['getContainingInterfaceContainsStratumIdList']) {
			$tmpOut = $stratumNodeList;
			ksort($tmpOut, SORT_NUMERIC);
			// check for "overflow"
			if ($tmpOut[-1]) {
				unset($tmpOut[-1]);
				$tmpOut[] = ",...";
			}
			$values['containsStratumIdList'] = implode(ExcavHelper::$xidDelimiterOut, $tmpOut);
		}

		// --- eo matrix extra info


		$values['complexPartIdList'] = implode(ExcavHelper::$xidDelimiterOut, ($this->complexPartIdArray ?: array()));
		$values['partOfComplexIdList'] =
			implode(ExcavHelper::$xidDelimiterOut,
							StratumComplex::getPartOfComplexIdArray($this->values['excavId'], $this->values['stratumId']));

		// arch find list, arch object list, arch object GROUP list
		$values['archFindIdList'] =
			implode(ExcavHelper::$xidDelimiterOut,
							StratumToArchFind::getArchFindIdArray($this->values['excavId'], $this->values['stratumId']));
		$archObjectIdArray = ArchObjectToStratum::getArchObjectIdArray($this->values['excavId'], $this->values['stratumId']);
		$values['archObjectIdList'] = implode(ExcavHelper::$xidDelimiterOut, $archObjectIdArray);
		$archObjGroupIdArray = array();
		foreach ($archObjectIdArray as $archObjectId) {
			$tmpList = ArchObjGroupToArchObject::getArchObjGroupIdArray($this->values['excavId'], $archObjectId);
			// avoid duplicates
			foreach ($tmpList as $archObjGroupId) {
				$archObjGroupIdArray[$archObjGroupId] = $archObjGroupId;
			}
		}
		asort($archObjGroupIdArray);
		$values['archObjGroupIdList'] = implode(ExcavHelper::$xidDelimiterOut, $archObjGroupIdArray);


		// subvalus
		if (!$this->stratumSub) {
			$this->createStratumSub();
		}
		if ($this->stratumSub) {
			$values = array_merge($this->stratumSub->getExtendedValues($opts), $values);
		}

		return $values;
	}



	/*
	* Get all fieldnames for extended values (NOT normalized - no special order!)
	*/
	public static function getAllExtendedFieldNames($opts = array()) {

		$allCategories = StratumCategory::getStrucInfo(null);
		array_unshift($allCategories, array('id' => 'STRATUM', 'className' => 'Stratum'));

		$allFieldNames = array();
		foreach($allCategories as $key => $category) {
			$className = $category['className'];
			foreach($className::$fieldNames as $fieldName) {
				if (!in_array($fieldName, $allFieldNames)) {
					$allFieldNames[] = $fieldName;
				}
			}
			$obj = new $className();
			foreach(array_keys($obj->getExtendedValues($opts)) as $fieldName) {
				if (!in_array($fieldName, $allFieldNames)) {
					$allFieldNames[] = $fieldName;
				}
			}
		}

		return $allFieldNames;
	} // eo collect fieldnames


	/*
	* Get interfaces for this stratum
	*/
	public function getContainedInInterfaceArray($prevChain = array(), $nodeList = array(), $opts = array()) {

		// abort when more then x nodes - because it is only a extrainfo for now
		$countLimit = 100;
		if ($opts['getAll']) {
			$countLimit = 10000;  // sanity limit should never be exeeded
		}
		// if count exeeds limit then set "more" mark by faking an interface "-1"
		if (count($nodeList) > $countLimit) {
			$nodeList[-1] = -1;
			return $nodeList;
		}

		if ($this->values['categoryId'] == StratumCategory::ID_INTERFACE || $this->values['hasAutoInterface']) {
			$nodeList[$this->values['stratumId']] = $this->values['stratumId'];
			return $nodeList;
		}

		$nextStratumIds = StratumMatrix::getReverseRelationIdArray(
			$this->values['excavId'], $this->values['stratumId'], StratumMatrix::THIS_IS_EARLIER_THAN);

		// iterate over the next stratums in this direction
		$prevChain[$this->values['stratumId']] = $this->values['stratumId'];
		foreach ($nextStratumIds as $nextStratumId) {

			// check for cycle or already in nodelist
			if ($prevChain[$nextStratumId] || $nodeList[$nextStratumId]) {
				continue;
			}

			$nextNode = Stratum::newFromDb(array('excavId' => $this->values['excavId'], 'stratumId' => $nextStratumId));
			$nextNode->getContainedInInterfaceArray($prevChain, $nodeList, $opts);
		}  // eo loop over next nodes

		return $nodeList;
	}  // eo get interface array



	/*
	* Get stratums contained in interface of this stratum
	*/
	public function getContainsStratumArray($prevChain = array(), &$nodeList = array(), $opts = array()) {

		// abort when more then x nodes - because it is only a extrainfo for now
		// and set "more" mark by faking an interface "-1"
		if (count($nodeList) > 100) {
			$nodeList[-1] = -1;
			return $nodeList;
		}


		// we stop at interface level - but not at the starting inteface of course
		if ($this->values['categoryId'] == StratumCategory::ID_INTERFACE || $this->values['hasAutoInterface']) {
			if (!$opts['isStartNode']) {
				return $nodeList;
			}
		}

		// all non-interfaces (including hasAutoInterface stratums) are collected
		if ($this->values['categoryId'] != StratumCategory::ID_INTERFACE) {
			$nodeList[$this->values['stratumId']] = $this->values['stratumId'];
		}

		// unset start options
		unset($opts['isStartNode']);


		$nextStratumIds = StratumMatrix::getRelationIdArray(
			$this->values['excavId'], $this->values['stratumId'], StratumMatrix::THIS_IS_EARLIER_THAN);

		// iterate over the next stratums in this direction
		$prevChain[$this->values['stratumId']] = $this->values['stratumId'];
		foreach ($nextStratumIds as $nextStratumId) {

			// check for cycle or already in nodelist
			if ($prevChain[$nextStratumId] || $nodeList[$nextStratumId]) {
				continue;
			}

			$nextNode = Stratum::newFromDb(array('excavId' => $this->values['excavId'], 'stratumId' => $nextStratumId));
			$nextNode->getContainsStratumArray($prevChain, $nodeList, $opts);
		}  // eo loop over next nodes

		return $nodeList;
	}  // eo get stratum array contained in interface



	// get arch find objects for stratum
	public function getArchFindObjects() {

	$records = array();

	$stmt = "SELECT * FROM " . StratumToArchFind::$tableName;

	$whereVals = array();
	$whereVals['excavId'] = $this->values['excavId'];
	$whereVals['stratumId'] = $this->values['stratumId'];

	$pstmt = Db::prepare($stmt, $whereVals, "ORDER BY 0+archFindId");
	$pstmt->execute($whereVals);
	while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
		$obj = ArchFind::newFromDb(array('excavId' => $row['excavId'], 'archFindId' => $row['archFindId']));
		if (!$obj->values['archFindId']) {
			$obj->values['archFindId'] = '? ' . $row['archFindId'];
		}
		$records[] = $obj;
	}
	$pstmt->closeCursor();

	return $records;

}  // eo loading arch find values




	// get arch objects for this stratum
	public function getArchObjectObjects() {

	$records = array();

	$archObjectIdArray = ArchObjectToStratum::getArchObjectIdArray($this->values['excavId'], $this->values['stratumId']);
	foreach ($archObjectIdArray as $archObjectId) {
		$records[] = ArchObject::newFromDb(array('excavId' => $this->values['excavId'], 'archObjectId' => $archObjectId));
	}

	return $records;

}  // eo loading arch find values



	// get arch object group objects for this stratum
	public function getArchObjGroupObjects() {

	$records = array();

	$archObjectIdArray = ArchObjectToStratum::getArchObjectIdArray($this->values['excavId'], $this->values['stratumId']);

	// collect arch object group objects
	$archObjGroupObjects = array();
	foreach ($archObjectIdArray as $archObjectId) {
		$tmpList = ArchObjGroupToArchObject::getArchObjGroupIdArray($this->values['excavId'], $archObjectId);
		// avoid duplicates
		foreach ($tmpList as $archObjGroupId) {
			$archObjGroup = ArchObjGroup::newFromDb(array('excavId' => $this->values['excavId'], 'archObjGroupId' => $archObjGroupId));
			if (!$archObjGroup->values['archObjGroupId']) {
				$archObjGroup->values['archObjGroupId'] = '? ' . $archObjGroupId;
			}
			$archObjGroupObjects[$archObjGroupId] = $archObjGroup;
		}
	}
	asort($archObjGroupObjects);

	return $archObjGroupObjects;

}  // eo get arch object group objects




	/**
	* Get item (field) labels
	*/
	public static function getItemLabels($categoryId = '') {

		$values = array(
			'planDigital' => Oger::_('Digitaler Plan'),
			'planAnalog' => Oger::_('Analoger Plan'),
			'photogrammetry' => Oger::_('Photogrammetrie'),
			'photoDigital' => Oger::_('Digitalfoto'),
			'photoSlide' => Oger::_('Dia'),
			'photoPrint' => Oger::_('Papierfoto'),
			);


		// merge in labels from substratums
		if ($categoryId) {
			$categoryInfo = StratumCategory::getStrucInfo($categoryId);
			$stratumSubClassName = $categoryInfo['className'];
			if (method_exists($stratumSubClassName, 'getItemLabels')) {
				$values = array_merge($values, $stratumSubClassName::getItemLabels());
			}
		}

		return $values;
	}  // eo get labels


	/**
	* Save input to db (including subtables)
	*/
	public static function saveInput($input, $dbAction, $opts = array()) {

		// precheck prepare input

		// autointerface setting does not make sense on an interface - so unset by default (or set to zero)
		if ($input['categoryId'] == StratumCategory::ID_INTERFACE) {
			unset($input['hasAutoInterface']);  //  = "0";
		}

		// precheck input
		$errorMsg = ExcavHelper::xidValidErr($input['stratumId']);
		if ($errorMsg) {
			return array('errorMsg' => Oger::_('Stratum-Nummer: ') . $errorMsg);
		}
		$errorMsg = ExcavHelper::multiXidValidErr($input['earlierThanIdList'], array('allowBlank' => true));
		if ($errorMsg) {
			return array('errorMsg' => Oger::_('Matrix - Älter als: ') . $errorMsg);
		}
		$errorMsg = ExcavHelper::multiXidValidErr($input['reverseEarlierThanIdList'], array('allowBlank' => true));
		if ($errorMsg) {
			return array('errorMsg' => Oger::_('Matrix - Jünger als: ') . $errorMsg);
		}
		$errorMsg = ExcavHelper::multiXidValidErr($input['equalToIdList'], array('allowBlank' => true));
		if ($errorMsg) {
			return array('errorMsg' => Oger::_('Matrix - Ist ident mit: ') . $errorMsg);
		}
		$errorMsg = ExcavHelper::multiXidValidErr($input['contempWithIdList'], array('allowBlank' => true));
		if ($errorMsg) {
			return array('errorMsg' => Oger::_('Matrix - Zeitgleich mit: ') . $errorMsg);
		}
		$errorMsg = ExcavHelper::multiXidValidErr($input['complexPartIdList'], array('allowBlank' => true));
		if ($errorMsg) {
			return array('errorMsg' => Oger::_('Komplex-Stratumliste: ') . $errorMsg);
		}
		$errorMsg = ExcavHelper::multiXidValidErr($input['archFindIdList'], array('allowBlank' => true));
		if ($errorMsg) {
			return array('errorMsg' => Oger::_('Komplex-Stratumliste: ') . $errorMsg);
		}
		$errorMsg = ExcavHelper::multiXidValidErr($input['archObjectIdList'], array('allowBlank' => true));
		if ($errorMsg) {
			return array('errorMsg' => Oger::_('Gehört zu Objekt: ') . $errorMsg);
		}
		$errorMsg = ExcavHelper::multiXidValidErr($input['archObjGroupIdList'], array('allowBlank' => true));
		if ($errorMsg) {
			return array('errorMsg' => Oger::_('Gehört zu Objektgruppe: ') . $errorMsg);
		}

		$errorMsg = ExcavHelper::multiXidValidErr($input['cremationDemageStratumIdList'], array('allowBlank' => true));
		if ($errorMsg) {
			return array('errorMsg' => Oger::_('Skelett - Brandbestattung - Störung - Stratum: ') . $errorMsg);
		}
		$errorMsg = ExcavHelper::multiXidValidErr($input['coffinStratumIdList'], array('allowBlank' => true));
		if ($errorMsg) {
			return array('errorMsg' => Oger::_('Skelett - Grabkonstruktion - Einbau - Sarg: ') . $errorMsg);
		}
		$errorMsg = ExcavHelper::multiXidValidErr($input['tombTimberStratumIdList'], array('allowBlank' => true));
		if ($errorMsg) {
			return array('errorMsg' => Oger::_('Skelett - Grabkonstruktion - Einbau - Holzeinbau: ') . $errorMsg);
		}
		$errorMsg = ExcavHelper::multiXidValidErr($input['tombStoneStratumIdList'], array('allowBlank' => true));
		if ($errorMsg) {
			return array('errorMsg' => Oger::_('Skelett - Grabkonstruktion - Einbau - Steineinbau: ') . $errorMsg);
		}
		$errorMsg = ExcavHelper::multiXidValidErr($input['tombBrickStratumIdList'], array('allowBlank' => true));
		if ($errorMsg) {
			return array('errorMsg' => Oger::_('Skelett - Grabkonstruktion - Einbau - Ziegeleinbau: ') . $errorMsg);
		}
		$errorMsg = ExcavHelper::multiXidValidErr($input['tombOtherMaterialStratumIdList'], array('allowBlank' => true));
		if ($errorMsg) {
			return array('errorMsg' => Oger::_('Skelett - Grabkonstruktion - Einbau - Sonstiges: ') . $errorMsg);
		}
		$errorMsg = ExcavHelper::multiXidValidErr($input['tombFormCirleStratumIdList'], array('allowBlank' => true));
		if ($errorMsg) {
			return array('errorMsg' => Oger::_('Skelett - Grabkonstruktion - Form - Rund: ') . $errorMsg);
		}
		$errorMsg = ExcavHelper::multiXidValidErr($input['tombFormOvalStratumIdList'], array('allowBlank' => true));
		if ($errorMsg) {
			return array('errorMsg' => Oger::_('Skelett - Grabkonstruktion - Form - Oval: ') . $errorMsg);
		}
		$errorMsg = ExcavHelper::multiXidValidErr($input['tombFormRectangleStratumIdList'], array('allowBlank' => true));
		if ($errorMsg) {
			return array('errorMsg' => Oger::_('Skelett - Grabkonstruktion - Form - Rechteckig: ') . $errorMsg);
		}
		$errorMsg = ExcavHelper::multiXidValidErr($input['tombFormSquareStratumIdList'], array('allowBlank' => true));
		if ($errorMsg) {
			return array('errorMsg' => Oger::_('Skelett - Grabkonstruktion - Form - Quadratisch: ') . $errorMsg);
		}
		$errorMsg = ExcavHelper::multiXidValidErr($input['tombFormOtherStratumIdList'], array('allowBlank' => true));
		if ($errorMsg) {
			return array('errorMsg' => Oger::_('Skelett - Grabkonstruktion - Form - Sonstiges: ') . $errorMsg);
		}
		$errorMsg = ExcavHelper::multiXidValidErr($input['tombDemageStratumIdList'], array('allowBlank' => true));
		if ($errorMsg) {
			return array('errorMsg' => Oger::_('Skelett - Grabkonstruktion - Störung - Stratum: ') . $errorMsg);
		}
		$errorMsg = ExcavHelper::multiXidValidErr($input['burialObjectArchFindIdList'], array('allowBlank' => true));
		if ($errorMsg) {
			return array('errorMsg' => Oger::_('Skelett - Grabfunde - Fundnummern zu Beigaben: ') . $errorMsg);
		}
		$errorMsg = ExcavHelper::multiXidValidErr($input['costumeArchFindIdList'], array('allowBlank' => true));
		if ($errorMsg) {
			return array('errorMsg' => Oger::_('Skelett - Grabfunde - Fundnummern zu Trachtbestandteilen: ') . $errorMsg);
		}
		$errorMsg = ExcavHelper::multiXidValidErr($input['depositArchFindIdList'], array('allowBlank' => true));
		if ($errorMsg) {
			return array('errorMsg' => Oger::_('Skelett - Grabfunde - Fundnummern zu Verfüllung: ') . $errorMsg);
		}
		$errorMsg = ExcavHelper::multiXidValidErr($input['tombConstructArchFindIdList'], array('allowBlank' => true));
		if ($errorMsg) {
			return array('errorMsg' => Oger::_('Skelett - Grabfunde - Fundnummern zu Bestandteile der Grabkonstruktion: ') . $errorMsg);
		}


		// create new
		$input['stratumIdSort'] = Oger::getNatSortId($input['stratumId']);
		$record = new self($input);

		// check for required fields
		if (!$record->values['excavId']) {
			return array('errorMsg' => Oger::_("Interne ID der Grabung fehlt."));
		}
		if (!$record->values['stratumId']) {
			return array('errorMsg' => Oger::_("Stratum-Nummer fehlt."));
		}
		if (!$record->values['categoryId']) {
			return array('errorMsg' => Oger::_("Kategorieangabe fehlt."));
		}
		$categoryRecord = StratumCategory::fromDbStatic(array('id' => $record->values['categoryId']));
		if (!$categoryRecord->values) {
			return array('errorMsg' => Oger::_("Ungültige Kategorieangabe " .  $record->values['categoryId'] . "."));
		}


		// precheck matrix, avoid selfreferences and multireferences
		$errorMsg = $record->createStratumMatrix($input, array('reportErrors' => true));
		if ($errorMsg) {
			return array('errorMsg' => $errorMsg);
		}


		// on check-only return here
		// should only happen for import, so exists-already-check and rename-check are not necessary
		if ($opts['checkOnly']) {
			return;
		}


		// construct new id for insert
		if ($dbAction == Db::ACTION_INSERT) {
			if ($record->exists(array('excavId', 'stratumId'))) {
				return array('errorMsg' => Oger::_("Stratum-Nummer " . $record->values['stratumId'] . " ist bereits vorhanden - Neuanlage fehlgeschlagen."));
			}
			$record->values['id'] = Stratum::getMaxValue('id') + 1;
		}

		// prevent or handle changing of main ids
		if ($dbAction == Db::ACTION_UPDATE) {
			$oldRecord = Stratum::newFromDb(array('id' => $record->values['id']));
			if ($record->values['excavId'] != $oldRecord->values['excavId']) {
				return array('errorMsg' => Oger::_("Interner Fehler: Grabungs-ID darf nicht geändert werden."));
			}
			if ($record->values['stratumId'] != $oldRecord->values['stratumId']) {
				if (Stratum::existsStatic(array('excavId' => $record->values['excavId'], 'stratumId' => $record->values['stratumId']))) {
					return array('errorMsg' => Oger::_("Stratum-Nummer ist breits vorhanden - Umbenennen fehlgeschlagen."));
				}
				$renameWhereVals = array('excavId' => $oldRecord->values['excavId'], 'stratumId' => $oldRecord->values['stratumId']);
				$renameNewVals = $renameWhereVals;
				$renameNewVals['stratumIdNew'] = $record->values['stratumId'];
				Db::getConn()->beginTransaction();
				try {
					$stmt = "UPDATE " . Stratum::$tableName . " SET stratumId=:stratumIdNew";
					$pstmt = Db::prepare($stmt, $renameWhereVals);
					$pstmt->execute($renameNewVals);
					$pstmt->closeCursor();

					$stmt = "UPDATE " . StratumMatrix::$tableName . " SET stratumId=:stratumIdNew";
					$pstmt = Db::prepare($stmt, $renameWhereVals);
					$pstmt->execute($renameNewVals);
					$pstmt->closeCursor();

					// to be on the safe side update complex independent of category (even if it not a complex)
					/*  should be done in the subcategory part
					$stmt = "UPDATE " . StratumComplex::$tableName . " SET stratumId=:stratumIdNew";
					$pstmt = Db::prepare($stmt, $renameWhereVals);
					$pstmt->execute($renameNewVals);
					$pstmt->closeCursor();
					*/

					// handle rename on subclass depending on OLD category - category change is handled later
					$categoryInfo = StratumCategory::getStrucInfo($oldRecord->values['categoryId']);
					$stratumSubClassName = $categoryInfo['className'];
					if ($stratumSubClassName) {
						$stmt = "UPDATE " . $stratumSubClassName::$tableName . " SET stratumId=:stratumIdNew";
						$pstmt = Db::prepare($stmt, $renameWhereVals);
						$pstmt->execute($renameNewVals);
						$pstmt->closeCursor();
					}

					$stmt = "UPDATE " . ArchObjectToStratum::$tableName . " SET stratumId=:stratumIdNew";
					$pstmt = Db::prepare($stmt, $renameWhereVals);
					$pstmt->execute($renameNewVals);
					$pstmt->closeCursor();

					Db::getConn()->commit();
				}
				catch (Exception $ex) {
					Db::getConn()->rollback();
					return array('errorMsg' => Oger::_("Umbenennen fehlgeschlagen. Datenbankfehler: " . $ex->getMessage() . "."));
				}
				$oldRecord = Stratum::newFromDb(array('id' => $record->values['id']));
			}
		}  // eo check for update


		/*
		// prepare id lists (remove empty)
		$stratumIdArray = ExcavHelper::multiXidSplit($_REQUEST['stratumIdList']);
		if (!$stratumIdArray) {
			return array('errorMsg' => Oger::_("Stratum fehlt."));
		}
		*/


		// if category is changed we have to delete the now obsolete substratum
		if ($oldRecord->values['categoryId'] && $record->values['categoryId'] != $oldRecord->values['categoryId']) {
			$oldRecord->stratumSubFromDb();
			$stratumSubClass = get_class($oldRecord->stratumSub);
			if ($stratumSubClass) {
				/*
				$stmt = 'DELETE FROM ' . $stratumSubClass::$tableName . ' WHERE id=:id';
				$pstmt = Db::prepare($stmt);
				$pstmt->execute(array('id' => $oldRecord->values['id']));
				*/
				$stmt = 'DELETE FROM ' . $stratumSubClass::$tableName . ' WHERE excavId=:excavId AND stratumId=:stratumId';
				$pstmt = Db::prepare($stmt);
				$pstmt->execute(array('excavId' => $oldRecord->values['excavId'], 'stratumId' => $oldRecord->values['stratumId']));
				$pstmt->closeCursor();
			}
		}


		// if remove not forced we fake an insert for the reference tables
		$dbAction2 = $dbAction;
		if (!$opts['removeRefs']) {
			$dbAction2 = Db::ACTION_INSERT;
		}

		$record->createStratumSub($input);
		$record->toDb($dbAction, null, array('dbAction2' => $dbAction2));

		// prepare and save arch find id list (remove empty)
		$archFindIdArray = ExcavHelper::multiXidSplit($input['archFindIdList']);
		StratumToArchFind::updDbArchFindIdArray($record->values['excavId'], $record->values['stratumId'],
																						$archFindIdArray, $dbAction2);
		// prepare and save arch object id list (remove empty)
		$archObjectIdArray = ExcavHelper::multiXidSplit($input['archObjectIdList']);
		ArchObjectToStratum::updDbArchObjectIdArray($record->values['excavId'], $record->values['stratumId'],
																								$archObjectIdArray, $dbAction2);

		// reply with core ids
		$values = array('id' => $record->values['id'], 'excavId' => $record->values['excavId'],
										'stratumId' => $record->values['stratumId'],);
		return array('data' => $values);

	}  // eo save input





}  // end of class



?>
