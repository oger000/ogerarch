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
* Base class for handling one record of a database table.
* Hold values simply as strings.
* Presumes/requires an field named 'id' with unique option on the database
* which optimally is an index for this table.
* ---
* ATTENTION: Values array can be incomplete to store only changed values to database !!!
*/
class DbRecord {

	public static $tableName;

	// static variables are inherited in a crazy way in php 5.3.x
	// so use object variables instead (even if memory consuming)

	public static  $fieldNames = array();
	public static  $keyFieldNames = array();
	public static  $primaryKeyFieldNames = array();

	public static  $textFieldNames = array();
	public static  $numberFieldNames = array();
	public static  $boolFieldNames = array();
	public static  $dateFieldNames = array();
	public static  $timeFieldNames = array();

	// manually managed field names and formats
	public static  $durationFieldNames = array();
	public static  $durationFormat = 'H:i';

	// set this fields to blank when empty
	public static  $blankEmptyFieldNames = array();


	// values (mostly string representations as fetched from database)
	public $values = array();



	/**
	* Constructor
	*/
	public function __construct($newValues = null) {
		if ($newValues) {
			// a scalar is assumed to be the id field
			if (is_string($newValues) || is_numeric($newValues)) {
				$newValues = array('id' => $newValues);
			}  // eo scalar
			if (is_object($newValues)) {
				$newValues = get_object_vars($newValues);
			}  // eo obj
			$this->setValues($newValues);
		}  // eo new values given
	}  // eo constructor



	/**
	* Clear values.
	*/
	public function clearValues() {
		$this->values = array();
	}  // eo clear values



	/**
	* Fake object vars from values.
	*/
	public function fakeObjVars() {
		foreach ($this->values as $key => $value) {
			$this->$key = $value;
		}
	}  // eo fake object vars
	public function values2ObjVars() {
		$this->fakeObjVars();
	}


	/**
	* Create values from object vars
	*/
	public function objVars2Values() {
		foreach ($this->values as $key => $value) {
			$this->values[$key] = $this->$key;
		}
	}  // eo values from obj vars


	/**
	* Clear fakee object vars.
	*/
	public function clearFakedObjVars() {
		foreach (static::$fieldNames as $key) {
			unset($this->$key);
		}
	}  // eo clear faked obj vars



	/**
	* Get primary key values.
	*/
	public function getPrimaryKeyValues($fieldNames = array()) {
		if (!$fieldNames) {
			$fieldNames = static::$primaryKeyFieldNames;
		}
		return $this->getKeyValues($fieldNames);
	}  // eo get primary key values



	/**
	* Get key values.
	*/
	public function getKeyValues($fieldNames = array()) {
		if (!$fieldNames) {
			$fieldNames = static::$keyFieldNames;
		}
		$keyValues = array();
		foreach ($fieldNames as $key) {
			$keyValues[$key] = $this->values[$key];
		}

		return $keyValues;
	}  // eo get key values



	/**
	* Set the values from an array
	* @newValues: associative array with fieldname (key) value pairs.
	* @appendNew: handles known fieldNames present in newValues but missed in current values array
	*             true  : fieldnames and their value are added
	*             false : fieldnames and their value are skiped
	* @complete: true  : fieldNames missed in current values array are set to empty string
	*            false : fieldNames missed in current values array are not set at all
	*/
	public function setValues($newValues, $appendNew = true, $complete = false) {

		// set new values
		foreach ($newValues as $key => $value) {
			// skip empty keys (including 0), because 0 is treated as valid fieldName - dont know why
			if (!$key) {
				continue;
			}
			// only update if key is a "known field" for this record
			if (in_array($key, static::$fieldNames)) {
				// if key already in values or appendNew is set
				if (array_key_exists($key, $this->values) || $appendNew) {
					$this->values[$key] = $this->prepareField($key, $value);
				}
			}  // eo known field
		}  // eo new values

		// set values for missing keys to empty
		if ($complete) {
			foreach (static::$fieldNames as $key) {
				if (!array_key_exists($key, $this->values)) {
					$this->values[$key] = '';
				}
			}
		}  // eo complete

	}  // eo update from array



	/**
	* Unformat values. Transform "known" formatted values to raw
	*/
	public static function unformatValues($values) {

		$tmp = new static;

		foreach ($values as $key => $value) {
			if (in_array($key, static::$durationFieldNames)) {
				$values[$key] = Duration::parse($value, static::$durationFormat);
			}
		}

		return $values;

	} // eo unformatte values



	/**
	* Format values. Process "known" formats
	*/
	public static function formatValues($values) {

		$tmp = new static;

		foreach ($values as $key => $value) {
			if (in_array($key, static::$durationFieldNames)) {
				$values[$key] = Duration::format($value, static::$durationFormat);
			}
		}

		return $values;

	} // eo format values



	/**
	* Get extended values.
	* Dummy stub for child classes.
	* Hint: Use this in child classes to get formatted values
	*/
	public function getExtendedValues($opts = array()) {
		return $this->values;
	} // eo get extended values



	/**
	* Prepare values as static function.
	* Like setValues, but static to work without explicit instance.
	*/
	public static function prepareBypassValues($newValues) {
		$tmp = new static;
		$tmp->setValues($newValues);
		return $tmp->values;
	} // eo prepare values



	/**
	* Prepare field value
	* (was stable when fielddefs where stable)
	*/
	public function prepareField($key, $value) {

		// for number fields
		if (in_array($key, static::$numberFieldNames)) {
			// convert boolan strings to numbers
			if (is_string($value)) {
				$value = trim($value);
				if (strtolower($value) === 'false' || strtolower($value) === 'off') { $value = '0'; }
				if (strtolower($value) === 'true' || strtolower($value) === 'on') { $value = '1'; }
				// convert decimals from comma to point
				if (strpos($value, ',') !== false) {
					$value = str_replace(',', '.', $value);
				}
				// set empty numberSTRING to NULL
				/*
				 * DISABLED 2013-06-25 because there remain only 3 fields
				 * (gpsX, gpsY and gpsZ on excavation table) that accept NULL for now.
				 * So we better have inconsistency there than many access violations
				 * when storing empty values (e.g "") to the database.
				if ($value === '') {
					$value = null;
				}
				*/
			}  // eo boolean strings to numbers
		}  // eo number preprocessing

		// for boolean fields
		elseif (in_array($key, static::$boolFieldNames)) {
			// convert boolan strings to boolean values
			if (is_string($value)) {
				 if (strtolower($value) === 'false' || strtolower($value) === 'off') { $value = false; }
				 if (strtolower($value) === 'true' || strtolower($value) === 'on') { $value = true; }
			}  // eo boolean strings to booleans
		}  // eo boolean preprocessing

		// preprocess date values (set "empty (my)sql date" to empty string
		elseif (in_array($key, static::$dateFieldNames)) {
			if (is_string($value) && substr($value, 0, 10) === '0000-00-00') {
				$value = '';
			}
		}  // eo date preprocessing


		// set empty fields to blank
		if (in_array($key, static::$blankEmptyFieldNames) && !$value) {
			$value = '';
		}

		// return prepared value
		return $value;

	}  // eo prepare field



	/**
	* Get max value
	*/
	public static function getMaxValue($fieldName, $whereValues = array()) {
		$pstmt = Db::prepare("SELECT MAX($fieldName) FROM " . static::$tableName, $whereValues);
		$pstmt->execute(Db::getCleanWhereVals($whereValues));
		$maxVal = $pstmt->fetchColumn();
		$pstmt->closeCursor();

		return $maxVal;
	}  // eo max value



	/**
	* Exists record with this where values. Static version.
	*/
	public static function existsStatic($whereValues) {
		return static::getCount($whereValues) > 0;
	}  // eo record exists



	/**
	* Exists record with this where values.
	*
	*/
	public function exists($whereValues) {

		// if it is not an associative array than only the
		// keys are given and has to be completeted with the
		if (!Oger::isAssocArray($whereValues)) {
			$whereValues = array_flip($whereValues);
			foreach ($whereValues as $key => $value) {
				$whereValues[$key] = $this->values[$key];
			}
		}

		return static::existsStatic($whereValues);

	}  // eo record exists



	/**
	* Get count for this where values
	*/
	public static function getCount($whereValues) {

		$pstmt = Db::prepare("SELECT COUNT(*) FROM " . static::$tableName, $whereValues);
		$pstmt->execute(Db::getCleanWhereVals($whereValues));
		$count = $pstmt->fetchColumn();
		$pstmt->closeCursor();

		return $count;
	}  // eo get count




	/**
	* Get object data from db
	*/
	public function fromDb($whereValues = array(), $moreStmt = null) {

		if (!$whereValues) {
			$whereValues = $this->getPrimaryKeyValues();
		}

		$pstmt = Db::prepare('SELECT * FROM `' . static::$tableName . '`', $whereValues, $moreStmt);
		$pstmt->execute(Db::getCleanWhereVals($whereValues));
		$row = $pstmt->fetch(PDO::FETCH_ASSOC);
		$pstmt->closeCursor();

		// if fetch failed
		if ($row === false) {
			$row = array();
		}

		// assign db row to values array
		$this->setValues($row);

	}  // eo from db



	/**
	* Get new object from db
	*/
	public static function newFromDb($whereValues = array(), $moreStmt = null) {
		$obj = new static;
		$obj->fromDb($whereValues, $moreStmt);
		return $obj;
	}  // eo new obj from db



	/**
	* Write record values to db
	*/
	public function toDb($dbAction, $whereValues = null, $opts = array()) {

		try {

			$values = $this->values;

			// if fields are excluded remove them from values array
			if ($opts['excludeFields']) {
				foreach ($opts['excludeFields'] as $field) {
					unset($values[$field]);
				}
			}

			if ($dbAction == Db::ACTION_UPDATE) {
				if (!$whereValues) {
					$whereValues = $this->getPrimaryKeyValues();
				}
				$where = Db::createWhereStmt($whereValues);
				// TODO unset key values from values array???
			}
			elseif ($dbAction == Db::ACTION_INSERT) {
				// TODO make shure the key fields exists ???
			}
			else {
				throw new Exception('DbRecord::toDb(): Unexpected dbAction: ' . $dbAction . '.');
			}

			$stmt = Db::createStmt($dbAction, static::$tableName, array_keys($values), $where);

			// create db history log
			$dbLog = new Dblog(static::$tableName, $this->values['id']);

			// write record
			$pstmt = Db::prepare($stmt);
			$result = $pstmt->execute(Db::getCleanWhereVals($values));
			$pstmt->closeCursor();

			// fake PDO::ERRMODE_EXCEPTION if not set
			if ($result === false) {
				throw new Exception('PDO::execute() failed with error code ' . Db::getConn()->errorCode() . '.');
			}

			// write db history log
			$dbLog->writeLog();

		}
		catch (Exception $ex) {
			echo Extjs::errorMsg('DbRecord::toDb(). ' . $ex->getMessage());
			exit;
		}

	}  // eo write to db



}  // end of class

?>
