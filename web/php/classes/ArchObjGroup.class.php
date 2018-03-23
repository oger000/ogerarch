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
* Arch object group master.
*/
class ArchObjGroup extends DbRecord {

	public static $tableName = 'archObjGroup';

	#FIELDDEF BEGIN
	# Table: archObjGroup
	# Fielddef created: 2012-03-29 08:54

	public static $fieldNames = array(
		'id',
		'excavId',
		'archObjGroupId',
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
		'archObjGroupId',
		'id'
	);

	public static $primaryKeyFieldNames = array(
		'id'
	);


	public static $textFieldNames = array(
		'archObjGroupId',
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


	private $archObjectIdArray = null;


	####################################################


	/**
	* Clear values.
	* Including special vars.
	*/
	public function clearValues() {
		parent::clearValues();
		$this->archObjectIdArray = null;
	}  // clear values


	/**
	* Get extended values.
	* Use this to decode fields.
	*/
	public function getExtendedValues($opts = array()) {

		$values = $this->values;

		$values['archObjectIdList'] = implode(ExcavHelper::$xidDelimiterOut, $this->getArchObjectIdArray());

		$objGrpType = ArchObjGroupType::newFromDb(array('id' => $values['typeId']));
		$values['typeName'] = ($objGrpType->values['name'] ?: $values['typeId']);
		$values['typeCode'] = $objGrpType->values['code'];

		return $values;
	} // eo set extended values


	/**
	* Get object list
	*/
	public function getArchObjectIdArray() {

		if ($this->archObjectIdArray === null) {
			$this->archObjectIdArray = ArchObjGroupToArchObject::getArchObjectIdArray(
																	$this->values['excavId'], $this->values['archObjGroupId']);
		}
		return $this->archObjectIdArray;

	} // eo object list



	/**
	* Save input to db (including subtables)
	*/
	public static function saveInput($input, $dbAction, $opts = array()) {

		// precheck and prepare input
		$errorMsg = ExcavHelper::xidValidErr($input['archObjGroupId']);
		if ($errorMsg) {
			return array('errorMsg' => Oger::_('Objektgruppen-Nummer: ') . $errorMsg);
		}
		$errorMsg = ExcavHelper::multiXidValidErr($input['archObjectIdList'], array('allowBlank' => true));
		if ($errorMsg) {
			return array('errorMsg' => Oger::_('Objektliste: ') . $errorMsg);
		}

		// create new arch object group
		$record = new self($input);

		// check for required fields
		if (!$record->values['excavId']) {
			return array('errorMsg' => Oger::_("Interne ID der Grabung fehlt."));
		}
		if (!$record->values['archObjGroupId']) {
			return array('errorMsg' => Oger::_("Objektgruppen-Nummer fehlt."));
		}
		if (!$record->values['typeId']) {
			return array('errorMsg' => Oger::_("Objektgruppenart/Bezeichnung fehlt."));
		}

		// on check-only return here
		// should only happen for import, so exists-already-check and rename-check are not necessary
		if ($opts['checkOnly']) {
			return;
		}


		// construct new id for insert
		if ($dbAction == Db::ACTION_INSERT) {
			if ($record->exists(array('excavId', 'archObjGroupId'))) {
				return array('errorMsg' => Oger::_("Objektgruppen-Nummer ist breits vorhanden - Neuanlage fehlgeschlagen."));
			}
			$record->values['id'] = (string)(ArchObjGroup::getMaxValue('id') + 1);
		}

		// prevent or handle changing of main ids
		if ($dbAction == Db::ACTION_UPDATE) {
			$oldRecord = ArchObjGroup::newFromDb(array('id' => $record->values['id']));
			if ($record->values['excavId'] != $oldRecord->values['excavId']) {
				return array('errorMsg' => Oger::_("Interner Fehler: Grabungs-ID darf nicht geändert werden."));
			}
			if ($record->values['archObjGroupId'] != $oldRecord->values['archObjGroupId']) {
				if (ArchObjGroup::existsStatic(array('excavId' => $record->values['excavId'], 'archObjGroupId' => $record->values['archObjGroupId']))) {
					return array('errorMsg' => Oger::_("Objektgruppen-Nummer ist breits vorhanden - Umbenennen fehlgeschlagen."));
				}
				$renameWhereVals = array('excavId' => $oldRecord->values['excavId'], 'archObjGroupId' => $oldRecord->values['archObjGroupId']);
				$renameNewVals = $renameWhereVals;
				$renameNewVals['archObjGroupIdNew'] = $record->values['archObjGroupId'];
				Db::getConn()->beginTransaction();
				try {
					$stmt = "UPDATE " . ArchObjGroup::$tableName . " SET archObjGroupId=:archObjGroupIdNew";
					$pstmt = Db::prepare($stmt, $renameWhereVals);
					$pstmt->execute($renameNewVals);
					$pstmt->closeCursor();

					$stmt = "UPDATE " . ArchObjGroupToArchObject::$tableName . " SET archObjGroupId=:archObjGroupIdNew";
					$pstmt = Db::prepare($stmt, $renameWhereVals);
					$pstmt->execute($renameNewVals);
					$pstmt->closeCursor();
					Db::getConn()->commit();
				}
				catch (Exception $ex) {
					Db::getConn()->rollback();
					return array('errorMsg' => Oger::_("Umbenennen fehlgeschlagen. Datenbankfehler: " . $ex->getMessage() . "."));
				}
				$oldRecord = ArchObjGroup::newFromDb(array('id' => $record->values['id']));
			}
		}


		// store record and object list, otherwise getExtendedValues() contains an empty objectIdList
		$record->toDb($dbAction);

		// if remove not forced we fake an insert for the reference tables
		$dbAction2 = $dbAction;
		if (!$opts['removeRefs']) {
			$dbAction2 = Db::ACTION_INSERT;
		}

		// prepare and save object id list (remove empty)
		$archObjectIdArray = ExcavHelper::multiXidSplit($input['archObjectIdList']);
		ArchObjGroupToArchObject::updDbArchObjectIdArray($record->values['excavId'], $record->values['archObjGroupId'],
																										 $archObjectIdArray, $dbAction2);

		// reply with core ids
		$values = array('id' => $record->values['id'], 'excavId' => $record->values['excavId'],
										'archObjGroupId' => $record->values['archObjGroupId'],);
		return array('data' => $values);
	}  // eo save input





}  // end of class



?>
