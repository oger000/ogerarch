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
* Levels for consistency check
*
* Values are hardcoded without database.
*/
class CheckConsistencyLevel extends DbRecord {


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


	const ID_INTERNAL = -2;
	const ID_FATAL = -1;
	const ID_ERROR = 1;
	const ID_WARN = 2;
	const ID_INFO = 3;
	const ID_VERBOSE = 4;
	const ID_DEBUG = 9;


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
			static::ID_INTERNAL =>
				array('id' => static::ID_INTERNAL,
							'name' => Oger::_('Interne Fehler'),
							'code' => 'INTERNAL',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_FATAL =>
				array('id' => static::ID_FATAL,
							'name' => Oger::_('Fatale Fehler'),
							'code' => 'FATAL',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_ERROR =>
				array('id' => static::ID_ERROR,
							'name' => Oger::_('Fehler'),
							'code' => 'ERROR',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_WARN =>
				array('id' => static::ID_WARN,
							'name' => Oger::_('Warnungen'),
							'code' => 'WARN',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_INFO =>
				array('id' => static::ID_INFO,
							'name' => Oger::_('Hinweise'),
							'code' => 'INFO',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_VERBOSE =>
				array('id' => static::ID_VERBOSE,
							'name' => Oger::_('Extrameldungen'),
							'code' => 'VERBOSE',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_DEBUG =>
				array('id' => static::ID_DEBUG,
							'name' => Oger::_('Debug Meldungen'),
							'code' => 'DEBUG',
							'beginDate' => '',
							'endDate' => '',
						 ),
		);

	}  // eo create records




	/**
	* Get record list
	*/
	public static function getRecords($raw = false) {
		static::createRecords();
		if ($raw) {
			return static::$records;
		}
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
