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
* Skeleton bone quality type master
*
* Values are hardcoded without database.
*/
class SkeletonBoneQualityType extends DbRecord {


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
							'name' => Oger::_('1 Sehr gut'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_2 =>
				array('id' => static::ID_2,
							'name' => Oger::_('2 Gut'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_3 =>
				array('id' => static::ID_3,
							'name' => Oger::_('3 Durchschnittlich'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_4 =>
				array('id' => static::ID_4,
							'name' => Oger::_('4 Schlecht'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_5 =>
				array('id' => static::ID_5,
							'name' => Oger::_('5 Sehr schlecht'),
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
