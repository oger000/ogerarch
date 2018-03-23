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
class Trash extends DbRecord {

	public static $tableName = 'trash';

	#FIELDDEF BEGIN
	# Table: trash
	# Fielddef created: 2012-07-19 10:04

	public static $fieldNames = array(
		'id',
		'userId',
		'userName',
		'time',
		'type',
		'content'
	);

	public static $keyFieldNames = array(
		'id'
	);

	public static $primaryKeyFieldNames = array(
		'id'
	);


	public static $textFieldNames = array(
		'userName',
		'type',
		'content'
	);

	public static $numberFieldNames = array(
		'id',
		'userId'
	);

	public static $boolFieldNames = array(

	);

	public static $dateFieldNames = array(
		'time'
	);

	public static $timeFieldNames = array(

	);

	#FIELDDEF END



	/**
	* Save input to db (including subtables)
	*/
	public static function saveInput($input, $dbAction, $opts = array()) {

		// create new company
		$record = new self($input);

		// check for required fields
		if (!$record->values['name1']) {
			return array('errorMsg' => Oger::_("Name1 muss angegeben werden."));
		}

		// only one record possible - always has id=1
		$oldRecord = self::newFromDb(array('id' => 1));

		// construct new id for insert
		if ($dbAction == Db::ACTION_INSERT) {
			if ($oldRecord->values) {
				return array('errorMsg' => Oger::_("Firmenstamm ist breits vorhanden - Neuanlage fehlgeschlagen."));
			}
			$record->values['id'] = '1';    // (string)(self::getMaxValue('id') + 1);
		}

		if ($dbAction == Db::ACTION_UPDATE) {
			if (!$oldRecord->values) {
				return array('errorMsg' => Oger::_("Kein Firmenstamm vorhanden - Update fehlgeschlagen."));
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
