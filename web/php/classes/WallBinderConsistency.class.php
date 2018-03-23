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
* Wall binder consistency master
*
* Values are hardcoded without database.
*/
class WallBinderConsistency extends DbRecord {


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


	const ID_VERY_COMPACT = 'ID_VERY_COMPACT';
	const ID_COMPACT = 'ID_COMPACT';
	const ID_LOOSELY = 'ID_LOOSELY';
	const ID_VERY_LOOSELY = 'ID_VERY_LOOSELY';
	const ID_CRUMBLY = 'ID_CRUMBLY';

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
			static::ID_VERY_COMPACT =>
				array('id' => static::ID_VERY_COMPACT,
							'name' => Oger::_('Sehr fest'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_COMPACT =>
				array('id' => static::ID_COMPACT,
							'name' => Oger::_('Fest'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_LOOSELY =>
				array('id' => static::ID_LOOSELY,
							'name' => Oger::_('Locker'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_VERY_LOOSELY =>
				array('id' => static::ID_VERY_LOOSELY,
							'name' => Oger::_('Sehr locker'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_CRUMBLY =>
				array('id' => static::ID_CRUMBLY,
							'name' => Oger::_('Bröselig'),
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
