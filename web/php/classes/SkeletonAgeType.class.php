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
* Skeleton age type master
*
* Values are hardcoded without database.
*/
class SkeletonAgeType extends DbRecord {


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


	const ID_PRAENATAL = 'ID_PRAENATAL';
	const ID_NEONATUS = 'ID_NEONATUS';
	const ID_INFANT1 = 'ID_INFANT1';
	const ID_INFANT2 = 'ID_INFANT2';
	const ID_JUVENIL = 'ID_JUVENIL';
	const ID_SUBADULT = 'ID_SUBADULT';
	const ID_ADULT = 'ID_ADULT';
	const ID_MATURE = 'ID_MATURE';
	const ID_SENIL = 'ID_SENIL';
	const ID_INDETERMINABLE = 'ID_INDETERMINABLE';

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
			static::ID_PRAENATAL =>
				array('id' => static::ID_PRAENATAL,
							'name' => Oger::_('Pränatal'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_NEONATUS =>
				array('id' => static::ID_NEONATUS,
							'name' => Oger::_('Neonatus'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_INFANT1 =>
				array('id' => static::ID_INFANT1,
							'name' => Oger::_('Infans I'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_INFANT2 =>
				array('id' => static::ID_INFANT2,
							'name' => Oger::_('Infans II'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_JUVENIL =>
				array('id' => static::ID_JUVENIL,
							'name' => Oger::_('Juvenil'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_SUBADULT =>
				array('id' => static::ID_SUBADULT,
							'name' => Oger::_('Subadult'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_ADULT =>
				array('id' => static::ID_ADULT,
							'name' => Oger::_('Adult'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_MATURE =>
				array('id' => static::ID_MATURE,
							'name' => Oger::_('Matur'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_SENIL =>
				array('id' => static::ID_SENIL,
							'name' => Oger::_('Senil'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_INDETERMINABLE =>
				array('id' => static::ID_INDETERMINABLE,
							'name' => Oger::_('Nicht erkennbar'),
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
