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
* Burial cremation types
*
* Values are hardcoded without database.
*/
class SkeletonBurialCremationType extends DbRecord {


	public static $tableName;

	// static variables are inherited in a crazy way in php 5.3.x
	// so use object variables instead (even if memory consuming)

	public static  $fieldNames = array('id', 'name', 'beginDate', 'endDate');
	public static  $keyFieldNames = array('id');
	public static  $primaryKeyFieldNames = array('id');

	public static  $textFieldNames = array('name');
	public static  $numberFieldNames = array('id');
	public static  $boolFieldNames = array();
	public static  $dateFieldNames = array('beginDate', 'endDate');
	public static  $timeFieldNames = array();

	// manually managed field names and formats
	public static  $durationFieldNames = array();
	public static  $durationFormat = 'H:i';

	// set this fields to blank when empty
	public static  $blankEmptyFieldNames = array();


	############################


	const ID_IN_CONTAINER = 'ID_IN_CONTAINER';
	const ID_LUMP_NO_CONTAINER = 'ID_LUMP_NO_CONTAINER';
	const ID_SCATTER_ON_BASE = 'ID_SCATTER_ON_BASE';
	const ID_SCATTER_ABOVE_BASE = 'ID_SCATTER_ABOVE_BASE';
	const ID_OTHER = 'OTHER';


	#######################

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
			static::ID_IN_CONTAINER =>
				array('id' => static::ID_IN_CONTAINER,
							'name' => Oger::_('In Gefäss'),
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_LUMP_NO_CONTAINER =>
				array('id' => static::ID_LUMP_NO_CONTAINER,
							'name' => Oger::_('Konzentration ohne Gefäss'),
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_SCATTER_ON_BASE =>
				array('id' => static::ID_SCATTER_ON_BASE,
							'name' => Oger::_('Streuung an Sohle'),
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_SCATTER_ABOVE_BASE =>
				array('id' => static::ID_SCATTER_ABOVE_BASE,
							'name' => Oger::_('Streuung über Sohle'),
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_OTHER =>
				array('id' => static::ID_OTHER,
							'name' => Oger::_('Sonstiges'),
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
