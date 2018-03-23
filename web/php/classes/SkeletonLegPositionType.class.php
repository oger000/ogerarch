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
* Skeleton leg position type master
*
* Values are hardcoded without database.
*/
class SkeletonLegPositionType extends DbRecord {


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


	const ID_1 = 'ID_1';
	const ID_2 = 'ID_2';
	const ID_3 = 'ID_3';
	const ID_4 = 'ID_4';
	const ID_5 = 'ID_5';
	const ID_6 = 'ID_6';
	const ID_7 = 'ID_7';
	const ID_8 = 'ID_8';
	const ID_9 = 'ID_9';
	const ID_10 = 'ID_10';

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
			static::ID_1 =>
				array('id' => static::ID_1,
							'name' => Oger::_('1) R/B Gestreckt'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_2 =>
				array('id' => static::ID_2,
							'name' => Oger::_('2) R/B Leicht gespreizt'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_3 =>
				array('id' => static::ID_3,
							'name' => Oger::_('3) R/B "O-Beine"'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_4 =>
				array('id' => static::ID_4,
							'name' => Oger::_('4) R/B Knie nach rechts'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_5 =>
				array('id' => static::ID_5,
							'name' => Oger::_('5) R/B Knie nach links'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_6 =>
				array('id' => static::ID_6,
							'name' => Oger::_('6) SL Gestreckt'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_7 =>
				array('id' => static::ID_7,
							'name' => Oger::_('7) SL Leicht gewinkelt (< 90 Grad)'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_8 =>
				array('id' => static::ID_8,
							'name' => Oger::_('8) SL etwa 90 Grad'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_9 =>
				array('id' => static::ID_9,
							'name' => Oger::_('9) SL Stark gewinkelt (> 90 Grad)'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_10 =>
				array('id' => static::ID_10,
							'name' => Oger::_('10) SL Sehr stark angewinkelt'),
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
