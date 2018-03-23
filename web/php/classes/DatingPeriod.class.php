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
* Dating periods
*
* Values are hardcoded without database.
*/
class DatingPeriod extends DbRecord {


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


	const ID_PALEOLITHIC = 'PALEOLITHIC';
	const ID_EARLY_NEOLITHIC = 'EARLY_NEOLITHIC';
	const ID_MIDDLE_NEOLITHIC = 'MIDDLE_NEOLITHIC';

	const ID_COPPER_AGE = 'COPPER_AGE';
	const ID_EARLY_BRONZE_AGE = 'EARLY_BRONZE_AGE';
	const ID_MIDDLE_BRONZE_AGE = 'MIDDLE_BRONZE_AGE';
	const ID_URNFIELD_CULTURE = 'URNFIELD_CULTURE';

	const ID_EARLY_IRON_AGE = 'EARLY_IRON_AGE';
	const ID_LATE_IRON_AGE = 'LATE_IRON_AGE';

	const ID_ROMAN_PERIOD = 'ROMAN_PERIOD';
	const ID_LATE_ANTIQUITY = 'LATE_ANTIQUITY';
	const ID_MIGRATION_PERIOD = 'MIGRATION_PERIOD';

	const ID_EARLY_MIDDLE_AGES = 'EARLY_MIDDLE_AGES';
	const ID_HIGH_MIDDLE_AGES = 'HIGH_MIDDLE_AGES';
	const ID_LATE_MIDDLE_AGES = 'LATE_MIDDLE_AGES';

	const ID_16_17_CENTURY = '16_17_CENTURY';
	const ID_18_19_CENTURY = '18_19_CENTURY';
	const ID_RECENT = 'RECENT';

	const ID_NOT_DATEABLE = 'NOT_DATEABLE';


	#######################

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
			static::ID_PALEOLITHIC =>
				array('id' => static::ID_PALEOLITHIC,
							'name' => Oger::_('Paläolithikum'),
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_EARLY_NEOLITHIC =>
				array('id' => static::ID_EARLY_NEOLITHIC,
							'name' => Oger::_('Frühneolithikum'),
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_MIDDLE_NEOLITHIC =>
				array('id' => static::ID_MIDDLE_NEOLITHIC,
							'name' => Oger::_('Mittelneolithikum'),
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_COPPER_AGE =>
				array('id' => static::ID_COPPER_AGE,
							'name' => Oger::_('Kupferzeit'),
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_EARLY_BRONZE_AGE =>
				array('id' => static::ID_EARLY_BRONZE_AGE,
							'name' => Oger::_('Frühbronzezeit'),
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_MIDDLE_BRONZE_AGE =>
				array('id' => static::ID_MIDDLE_BRONZE_AGE,
							'name' => Oger::_('Mittelbronzezeit'),
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_URNFIELD_CULTURE =>
				array('id' => static::ID_URNFIELD_CULTURE,
							'name' => Oger::_('Urnenfelderkultur'),
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_EARLY_IRON_AGE =>
				array('id' => static::ID_EARLY_IRON_AGE,
							'name' => Oger::_('Hallstattzeit'),
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_LATE_IRON_AGE =>
				array('id' => static::ID_LATE_IRON_AGE,
							'name' => Oger::_('La-Tene-Zeit'),
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_ROMAN_PERIOD =>
				array('id' => static::ID_ROMAN_PERIOD,
							'name' => Oger::_('Römische Kaiserzeit'),
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_LATE_ANTIQUITY =>
				array('id' => static::ID_LATE_ANTIQUITY,
							'name' => Oger::_('Spätantike'),
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_MIGRATION_PERIOD =>
				array('id' => static::ID_MIGRATION_PERIOD,
							'name' => Oger::_('Völkerwanderungszeit'),
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_EARLY_MIDDLE_AGES =>
				array('id' => static::ID_EARLY_MIDDLE_AGES,
							'name' => Oger::_('Frühmittelalter'),
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_HIGH_MIDDLE_AGES =>
				array('id' => static::ID_HIGH_MIDDLE_AGES,
							'name' => Oger::_('Hochmittelalter'),
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_LATE_MIDDLE_AGES =>
				array('id' => static::ID_LATE_MIDDLE_AGES,
							'name' => Oger::_('Spätmittelalter'),
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_16_17_CENTURY =>
				array('id' => static::ID_16_17_CENTURY,
							'name' => Oger::_('16./17. Jahrhundert'),
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_18_19_CENTURY =>
				array('id' => static::ID_18_19_CENTURY,
							'name' => Oger::_('18./19. Jahrhundert'),
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_RECENT =>
				array('id' => static::ID_RECENT,
							'name' => Oger::_('Rezent'),
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_NOT_DATEABLE =>
				array('id' => static::ID_NOT_DATEABLE,
							'name' => Oger::_('Undatierbar'),
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
