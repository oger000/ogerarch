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
* Stratum category master
*
* Values are hardcoded without database.
*/
class StratumCategory extends DbRecord {


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


	const ID_INTERFACE = 'INTERFACE';
	const ID_DEPOSIT = 'DEPOSIT';
	const ID_SKELETON = 'SKELETON';
	const ID_WALL = 'WALL';
	const ID_TIMBER = 'TIMBER';
	// const ID_COFFIN = 'COFFIN';   // sarg not used for now

	const ID_COMPLEX = 'COMPLEX';

	private static $records = array();
	private static $strucInfo = array();


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
			static::ID_INTERFACE =>
				array('id' => static::ID_INTERFACE,
							'name' => Oger::_('Interface'),
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_DEPOSIT =>
				array('id' => static::ID_DEPOSIT,
							'name' => Oger::_('Schicht'),
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_SKELETON =>
				array('id' => static::ID_SKELETON,
							'name' => Oger::_('Skelett'),
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_WALL =>
				array('id' => static::ID_WALL,
							'name' => Oger::_('Mauer'),
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_TIMBER =>
				array('id' => static::ID_TIMBER,
							'name' => Oger::_('Holz'),
							'beginDate' => '',
							'endDate' => '',
						 ),
			/*
			 * deactivate complex, because we have to code
			static::ID_COMPLEX =>
				array('id' => static::ID_COMPLEX,
							'name' => Oger::_('Komplex'),
							'beginDate' => '',
							'endDate' => '',
						 ),
			*/
		);

	}  // eo create records



	/**
	* Create info
	*/
	private static function createStrucInfo() {

		if (static::$strucInfo) {
			return;
		}

		static::$strucInfo = array(
			static::ID_DEPOSIT =>
				array('id' => static::ID_DEPOSIT,
							'className' => 'StratumDeposit',
						 ),
			static::ID_INTERFACE =>
				array('id' => static::ID_INTERFACE,
							'className' => 'StratumInterface',
						 ),
			static::ID_WALL =>
				array('id' => static::ID_WALL,
							'className' => 'StratumWall',
						 ),
			static::ID_SKELETON =>
				array('id' => static::ID_SKELETON,
							'className' => 'StratumSkeleton',
						 ),
			/*
			 * Complex is handled direct from Stratum class WITHOUT subclass object
			 * only with some static methods from StratumComplex (like Matrix)
			 * But we need the name of the table - for example for renaming the stratum id.
			 */
			static::ID_COMPLEX =>
				array('id' => static::ID_COMPLEX,
							'className' => 'StratumComplex',
						 ),
			static::ID_TIMBER =>
				array('id' => static::ID_TIMBER,
							'className' => 'StratumTimber',
						 ),
		);

	}  // eo create strucInfo


	/**
	* Get structure info
	* If id is given than for a single category otherwise return full list.
	*/
	public static function getStrucInfo($id) {
		static::createStrucInfo();
		if ($id) {
			return static::$strucInfo[$id];
		}
		else {
			return static::$strucInfo;
		}
	}  // eo get structure info




	/**
	* Get record list
	*/
	public static function getRecords() {
		static::createRecords();
		// remove keys, because they result in unwanted json
		return array_values(static::$records);
	}

	/**
	* Get record list with keys
	*/
	public static function getRecordsWithKeys() {
		static::createRecords();
		return static::$records;
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
