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
* Skeleton tomb demage form type master
*
* Values are hardcoded without database.
*/
class SkeletonTombDemageFormType extends DbRecord {


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


	const ID_CIRCLE = 'ID_CIRCLE';
	const ID_OVAL = 'ID_OVAL';
	const ID_RECTANGLE = 'ID_RECTANGLE';
	const ID_SQUARE = 'ID_SQUARE';
	const ID_OTHER = 'ID_OTHER';

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
			static::ID_CIRCLE =>
				array('id' => static::ID_CIRCLE,
							'name' => Oger::_('Rund'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_OVAL =>
				array('id' => static::ID_OVAL,
							'name' => Oger::_('Oval'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_RECTANGLE =>
				array('id' => static::ID_RECTANGLE,
							'name' => Oger::_('Rechteckig'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_SQUARE =>
				array('id' => static::ID_SQUARE,
							'name' => Oger::_('Quadratisch'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_OTHER =>
				array('id' => static::ID_OTHER,
							'name' => Oger::_('Sonstiges'),
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
