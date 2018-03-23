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
* Arch object master.
*/
class ArchObject extends DbRecord {

	public static $tableName = 'archObject';

	#FIELDDEF BEGIN
	# Table: archObject
	# Fielddef created: 2012-03-29 08:54

	public static $fieldNames = array(
		'id',
		'excavId',
		'archObjectId',
		'typeId',
		'typeSerial',
		'interpretation',
		'datingSpec',
		'datingPeriodId',
		'comment',
		'listComment'
	);

	public static $keyFieldNames = array(
		'excavId',
		'archObjectId',
		'id'
	);

	public static $primaryKeyFieldNames = array(
		'id'
	);


	public static $textFieldNames = array(
		'archObjectId',
		'typeId',
		'typeSerial',
		'interpretation',
		'datingSpec',
		'datingPeriodId',
		'comment',
		'listComment'
	);

	public static $numberFieldNames = array(
		'id',
		'excavId'
	);

	public static $boolFieldNames = array(

	);

	public static $dateFieldNames = array(

	);

	public static $timeFieldNames = array(

	);

	#FIELDDEF END


	private $stratumIdArray = null;


	####################################################



	/**
	* Clear values.
	* Including special vars.
	*/
	public function clearValues() {
		parent::clearValues();
		$this->stratumIdArray = null;
	}  // clear values


	/**
	* Get extended values.
	* Use this to decode fields.
	*/
	public function getExtendedValues($opts = array()) {

		$values = $this->values;

		$values['stratumIdList'] = implode(ExcavHelper::$xidDelimiterOut, $this->getStratumIdArray());

		$objType = ArchObjectType::newFromDb(array('id' => $values['typeId']));
		$values['typeName'] = ($objType->values['name'] ?: $values['typeId']);
		$values['typeCode'] = $objType->values['code'];

		$datingPeriods = DatingPeriod::getRecordsWithKeys();
		$values['datingPeriodName'] = ($datingPeriods[$values['datingPeriodId']]['name'] ?: $values['datingPeriodId']);

		$values['archObjGroupIdList'] =
			implode(ExcavHelper::$xidDelimiterOut,
							ArchObjGroupToArchObject::getArchObjGroupIdArray($values['excavId'], $values['archObjectId']));

		return $values;
	} // eo set extended values


	/**
	* Get stratum list
	*/
	public function getStratumIdArray() {

		if ($this->stratumIdArray === null) {
			$this->stratumIdArray = ArchObjectToStratum::getStratumIdArray($this->values['excavId'], $this->values['archObjectId']);
		}
		return $this->stratumIdArray;

	} // eo stratum list



	/**
	* Get stratum objects
	*/
	public function getStratumObjects() {

		$stratumObjects = array();

		$stratumIdArray = $this->getStratumIdArray();
		foreach ($stratumIdArray as $stratumId) {
			$stratum = Stratum::newFromDb(array('excavId' => $this->values['excavId'], 'stratumId' => $stratumId));
			if (!$stratum->values['stratumId']) {
				$stratum->values['stratumId'] = '? ' . $stratumId;
			}
			$stratumObjects[$stratum->values['stratumId']] = $stratum;
		}

		return $stratumObjects;

	} // eo stratum objects



	/**
	* Save input to db (including subtables)
	*/
	public static function saveInput($input, $dbAction, $opts = array()) {

		// precheck and prepare input
		$errorMsg = ExcavHelper::xidValidErr($input['archObjectId']);
		if ($errorMsg) {
			return array('errorMsg' => Oger::_('Objektnummer: ') . $errorMsg);
		}
		$errorMsg = ExcavHelper::multiXidValidErr($input['stratumIdList'], array('allowBlank' => true));
		if ($errorMsg) {
			return array('errorMsg' => Oger::_('Stratum: ') . $errorMsg);
		}

		// create new arch object
		$record = new self($input);

		// check for required fields
		if (!$record->values['excavId']) {
			return array('errorMsg' => Oger::_("Interne ID der Grabung fehlt."));
		}
		if (!$record->values['archObjectId']) {
			return array('errorMsg' => Oger::_("Objektnummer fehlt."));
		}
		if (!$record->values['typeId']) {
			return array('errorMsg' => Oger::_("Objektart/Bezeichnung fehlt."));
		}

		// on check-only return here
		// should only happen for import, so exists-already-check and rename-check are not necessary
		if ($opts['checkOnly']) {
			return;
		}


		// construct new id for insert
		if ($dbAction == Db::ACTION_INSERT) {
			if ($record->exists(array('excavId', 'archObjectId'))) {
				return array('errorMsg' => Oger::_("Objektnummer ist breits vorhanden - Neuanlage fehlgeschlagen."));
			}
			$record->values['id'] = (string)(ArchObject::getMaxValue('id') + 1);
		}

		// prevent or handle changing of main ids
		if ($dbAction == Db::ACTION_UPDATE) {
			$oldRecord = ArchObject::newFromDb(array('id' => $record->values['id']));
			if ($record->values['excavId'] != $oldRecord->values['excavId']) {
				return array('errorMsg' => Oger::_("Interner Fehler: Grabungs-ID darf nicht geändert werden."));
			}
			if ($record->values['archObjectId'] != $oldRecord->values['archObjectId']) {
				if (ArchObject::existsStatic(array('excavId' => $record->values['excavId'], 'archObjectId' => $record->values['archObjectId']))) {
					return array('errorMsg' => Oger::_("Objektnummer ist breits vorhanden - Umbenennen fehlgeschlagen."));
				}
				$renameWhereVals = array('excavId' => $oldRecord->values['excavId'], 'archObjectId' => $oldRecord->values['archObjectId']);
				$renameNewVals = $renameWhereVals;
				$renameNewVals['archObjectIdNew'] = $record->values['archObjectId'];
				Db::getConn()->beginTransaction();
				try {
					$stmt = "UPDATE " . ArchObject::$tableName . " SET archObjectId=:archObjectIdNew";
					$pstmt = Db::prepare($stmt, $renameWhereVals);
					$pstmt->execute($renameNewVals);
					$pstmt->closeCursor();

					$stmt = "UPDATE " . ArchObjectToStratum::$tableName . " SET archObjectId=:archObjectIdNew";
					$pstmt = Db::prepare($stmt, $renameWhereVals);
					$pstmt->execute($renameNewVals);
					$pstmt->closeCursor();

					$stmt = "UPDATE " . ArchObjGroupToArchObject::$tableName . " SET archObjectId=:archObjectIdNew";
					$pstmt = Db::prepare($stmt, $renameWhereVals);
					$pstmt->execute($renameNewVals);
					$pstmt->closeCursor();

					Db::getConn()->commit();
				}
				catch (Exception $ex) {
					Db::getConn()->rollback();
					return array('errorMsg' => Oger::_("Umbenennen fehlgeschlagen. Datenbankfehler: " . $ex->getMessage() . "."));
				}
				$oldRecord = ArchObject::newFromDb(array('id' => $record->values['id']));
			}
		}


		// store record and stratum list, otherwise getExtendedValues() contains an empty stratumIdList
		$record->toDb($dbAction);

		// if remove not forced we fake an insert for the reference tables
		$dbAction2 = $dbAction;
		if (!$opts['removeRefs']) {
			$dbAction2 = Db::ACTION_INSERT;
		}

		// prepare and save stratum id list (remove empty)
		$stratumIdArray = ExcavHelper::multiXidSplit($input['stratumIdList']);
		ArchObjectToStratum::updDbStratumIdArray($record->values['excavId'], $record->values['archObjectId'],
																						 $stratumIdArray, $dbAction2);
		// prepare and save object group id list (remove empty)
		$archObjGroupIdArray = ExcavHelper::multiXidSplit($input['archObjGroupIdList']);
		ArchObjGroupToArchObject::updDbArchObjGroupIdArray($record->values['excavId'], $record->values['archObjectId'],
																											 $archObjGroupIdArray, $dbAction2);

		// reply with core ids
		$values = array('id' => $record->values['id'], 'excavId' => $record->values['excavId'],
										'archObjectId' => $record->values['archObjectId'],);
		return array('data' => $values);
	}  // eo save input



}  // end of class



?>
