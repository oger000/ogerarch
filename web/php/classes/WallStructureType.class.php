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
* Wall structure type master
*
* Values are hardcoded without database.
*/
class WallStructureType extends DbRecord {


	public static $tableName;

	// static variables are inherited in a crazy way in php 5.3.x
	// so use object variables instead (even if memory consuming)

	public static  $fieldNames = array('id', 'name', 'code', 'beginDate', 'endDate');
	public static  $keyFieldNames = array('id');
	public static  $primaryKeyFieldNames = array('id');

	public static  $textFieldNames = array('id', 'name', 'code');
	public static  $numberFieldNames = array();
	public static  $boolFieldNames = array();
	public static  $dateFieldNames = array('beginDate', 'endDate');
	public static  $timeFieldNames = array();

	// manually managed field names and formats
	public static  $durationFieldNames = array();
	public static  $durationFormat = 'H:i';

	// set this fields to blank when empty
	public static  $blankEmptyFieldNames = array();


	############################


	const ID_LAYER = 'ID_LAYER';
	const ID_COMPARTMENT = 'ID_COMPARTMENT';
	const ID_PENDENTIVE = 'ID_PENDENTIVE';
	const ID_PENDENTIVEFILLED = 'ID_PENDENTIVEFILLED';
	const ID_MESH = 'ID_MESH';
	const ID_NONE = 'ID_NONE';
	const ID_UNRECOGNIZABLE = 'ID_UNRECOGNIZABLE';


	private static $records = array();


	/**
	* Constructor
	*/
	public function __construct($newValues = null) {
		static::createRecords();
		parent::__construct($newValues);
	}  // eo constructor





	/**
	* Create record list
	*/
	private static function createRecords() {

		if (static::$records) {
			return;
		}

		static::$records = array(
			static::ID_LAYER =>
				array('id' => static::ID_LAYER,
							'name' => Oger::_('Lagen'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_COMPARTMENT =>
				array('id' => static::ID_COMPARTMENT,
							'name' => Oger::_('Kompartimente'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_PENDENTIVEFILLED =>
				array('id' => static::ID_PENDENTIVEFILLED,
							'name' => Oger::_('Ausgezwickelt'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_PENDENTIVE =>
				array('id' => static::ID_PENDENTIVE,
							'name' => Oger::_('Zwickel'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_MESH =>
				array('id' => static::ID_MESH,
							'name' => Oger::_('Netz'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_NONE =>
				array('id' => static::ID_NONE,
							'name' => Oger::_('Keine Struktur'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
				static::ID_UNRECOGNIZABLE =>
				array('id' => static::ID_UNRECOGNIZABLE,
							'name' => Oger::_('Nicht erkennbar'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
	);

	}  // eo create records




	/**
	* Get record list
	*/
	public static function getRecords() {
		static::createRecords();
		// remove keys, because they result in unwanted json
		return array_values(static::$records);
	}



	/**
	* Get new object from db
	*/
	public static function newFromDb($whereValues = array(), $moreStmt = null) {
		return static::fromDbStatic($whereValues);
	}  // eo new obj from db




	/**
	* Fake "Get record from db"
	*/
	public static function fromDbStatic($whereValues = array(), $moreStmt = null) {
		static::createRecords();
		$obj = new self();

		foreach (static::$records as $record) {
			$found = true;
			foreach ($whereValues as $whereKey => $whereValue) {
				if ($record[$whereKey] != $whereValue) {
					$found = false;
					break;
				}
			}
			if ($found) {
				$obj->values = $record;  // brute force without setValues method
				return $obj;
			}
		}
		return $obj;
	}  // eo from db




}  // end of class



?>
