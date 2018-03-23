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
* Wall plaster surface type master
*
* Values are hardcoded without database.
*/
class WallPlasterSurface extends DbRecord {


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


	const ID_TROWELED = 'ID_TROWELED';
	const ID_RUBBED = 'ID_RUBBED';
	const ID_TRICKLE = 'ID_TRICKLE';
	const ID_MUDDLED = 'ID_MUDDLED';
	const ID_PAINT = 'ID_PAINT';

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
			static::ID_TROWELED =>
				array('id' => static::ID_TROWELED,
							'name' => Oger::_('Geglättet (Kelle)'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_RUBBED =>
				array('id' => static::ID_RUBBED,
							'name' => Oger::_('Überrieben'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_TRICKLE =>
				array('id' => static::ID_TRICKLE,
							'name' => Oger::_('Riesel'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_MUDDLED =>
				array('id' => static::ID_MUDDLED,
							'name' => Oger::_('Geschlämmt'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_PAINT =>
				array('id' => static::ID_PAINT,
							'name' => Oger::_('Farbe'),
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
