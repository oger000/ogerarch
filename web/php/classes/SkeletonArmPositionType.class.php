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
* Skeleton arm position type master
*
* Values are hardcoded without database.
*/
class SkeletonArmPositionType extends DbRecord {


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


	const ID_A = 'ID_A';
	const ID_B = 'ID_B';
	const ID_C = 'ID_C';
	const ID_D = 'ID_D';
	const ID_E = 'ID_E';
	const ID_F = 'ID_F';
	const ID_G = 'ID_G';
	const ID_H = 'ID_H';
	const ID_I = 'ID_I';

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
			static::ID_A =>
				array('id' => static::ID_A,
							'name' => Oger::_('A) R/B Gestreckt'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_B =>
				array('id' => static::ID_B,
							'name' => Oger::_('B) R/B Leicht Gewinkelt (< 90 Grad)'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_C =>
				array('id' => static::ID_C,
							'name' => Oger::_('C) R/B Ungefähr 90 Grad'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_D =>
				array('id' => static::ID_D,
							'name' => Oger::_('D) R/B Stark Gewinkelt (> 90 Grad)'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_E =>
				array('id' => static::ID_E,
							'name' => Oger::_('E) R/B Unterarme über Kreuz'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_F =>
				array('id' => static::ID_F,
							'name' => Oger::_('F) SL Gestreckt'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_G =>
				array('id' => static::ID_G,
							'name' => Oger::_('G) SL Leicht gewinkelt (< 90 Grad)'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_H =>
				array('id' => static::ID_H,
							'name' => Oger::_('H) SL Stark gewinkelt (> 90 Grad)'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_I =>
				array('id' => static::ID_I,
							'name' => Oger::_('I) SL Sehr stark gewinkelt (fast 180 Grad)'),
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
