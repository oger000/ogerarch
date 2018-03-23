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
* Excavation
*/
class Excavation extends DbRecord {

	public static $tableName = 'excavation';

	#FIELDDEF BEGIN
	# Table: excavation
	# Fielddef created: 2013-06-13 12:18

	public static $fieldNames = array(
		'id',
		'name',
		'excavMethodId',
		'beginDate',
		'endDate',
		'authorizedPerson',
		'originator',
		'officialId',
		'officialId2',
		'countryName',
		'regionName',
		'districtName',
		'communeName',
		'cadastralCommunityName',
		'fieldName',
		'plotName',
		'datingSpec',
		'datingPeriodId',
		'gpsX',
		'gpsY',
		'gpsZ',
		'comment',
		'projectBaseDir',
		'inactive'
	);

	public static $keyFieldNames = array(
		'id'
	);

	public static $primaryKeyFieldNames = array(
		'id'
	);


	public static $textFieldNames = array(
		'name',
		'excavMethodId',
		'authorizedPerson',
		'originator',
		'officialId',
		'officialId2',
		'countryName',
		'regionName',
		'districtName',
		'communeName',
		'cadastralCommunityName',
		'fieldName',
		'plotName',
		'datingSpec',
		'datingPeriodId',
		'comment',
		'projectBaseDir'
	);

	public static $numberFieldNames = array(
		'id',
		'gpsX',
		'gpsY',
		'gpsZ',
		'inactive'
	);

	public static $boolFieldNames = array(

	);

	public static $dateFieldNames = array(
		'beginDate',
		'endDate'
	);

	public static $timeFieldNames = array(

	);

	#FIELDDEF END


	const EXCAVMETHODID_STRATUM = 'STRATUM';
	const EXCAVMETHODID_PLANUM = 'PLANUM';


	/**
	* Get extended values.
	* Use this to decode fields.
	*/
	public function getExtendedValues($opts = array()) {

		$values = $this->values;

		switch ($values['excavMethodId']) {
		case self::EXCAVMETHODID_STRATUM:
			$values['excavMethodName'] = Oger::_('Stratum');
			break;
		case self::EXCAVMETHODID_PLANUM:
			$values['excavMethodName'] = Oger::_('Planum');
			break;
		default:
			$values['excavMethodName'] = '?' . $values['excavMethodId'];
		}

		return $values;
	} // eo set extended values



	/**
	* Save input to db (including subtables)
	*/
	public static function saveInput($input, $dbAction, $opts = array()) {

		// create new excavation
		$record = new Excavation($input);

		// check for required fields
		if (!$record->values['name']) {
			return array('errorMsg' => Oger::_("Name der Grabung fehlt."));
		}
		if (!$record->values['excavMethodId']) {
			return array('errorMsg' => Oger::_("Grabungsmethode fehlt."));
		}


		// construct new id for insert
		if ($dbAction == Db::ACTION_INSERT) {
			// extjs4.grid has problems when id type changes between string (fromDb) and int (from calculation), so force string
			$record->values['id'] = (string)(Excavation::getMaxValue('id') + 1);
		}

		// check for unchanged excavMethodId (if there was already an method on old record)
		if ($dbAction == Db::ACTION_UPDATE) {
			$oldRecord = Excavation::newFromDb(array('id' => $record->values['id']));
			// allow changing of excav method if not set or if numeric (remaining from old encoding [1..2])
			if ($oldRecord->values['excavMethodId'] && !is_numeric($oldRecord->values['excavMethodId']) &&
					$record->values['excavMethodId'] != $oldRecord->values['excavMethodId']) {
				// allow change silently if forceExcavMethodChange is set
				if (!$opts['forceExcavMethodChange']) {
					return array('errorMsg' => Oger::_("Grabungsmethode kann nur mit Extraparameter geändert werden."));
				}
			}
		}

		// on check-only return here
		if ($opts['checkOnly']) {
			return;
		}


		$record->toDb($dbAction);

		return array('data' => $record->getExtendedValues());
	}  // eo save input





}  // end of class



?>
