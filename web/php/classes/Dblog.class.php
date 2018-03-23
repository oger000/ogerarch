<?PHP
/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/

/*
* Log database modifications.
*/
class Dblog {

	const MODE_INSERT = 'INSERT';
	const MODE_UPDATE = 'UPDATE';

	private $table;
	private $recId;
	private $mode;
	private $oldRecord;
	private $newRecord;


	/**
	* construct logger
	*/
	public function __construct($table, $recId) {

		// DEACTIVATED FOR NOW
		return;

		$this->table = $table;
		$this->recId = $recId;

		// detect mode
		$this->mode = self::MODE_INSERT;
		$tmpRecord = $this->getRecord();
		if ($tmpRecord !== false) {
			$this->mode = self::MODE_UPDATE;
			$this->oldRecord = $tmpRecord;
		}

	}  // end of constructor


	/**
	* get record
	*/
	private function getRecord() {

		$stmt = 'SELECT * FROM ' . $this->table . ' WHERE id=:id';

		try{
			$pstmt = Db::prepare($stmt);
			$pstmt->execute(array(':id' => $this->recId));
			$obj = $pstmt->fetchObject();
			$pstmt->closeCursor();
		}
		catch (Exception $ex) {
			$errMsg = "Error in Dblog::getRecord() " . $stmt . " with id=" . $this->recId . ".\n" . $ex->getMessage();
			Config::$logger->error($errMsg);
			throw  new Exception($errMsg);
		}

		return $obj;
	}  // end of get record



	/**
	* write log
	*/
	public function writeLog() {

		// DEACTIVATED FOR NOW
		return;


		$stmt = "INSERT INTO dblog ( userId,`time`,`table`,`recId`,`mode`,`field`,`value`)".
						' VALUES           (:userId,:time, :table, :recId, :mode, :field, :value)';
		$pstmt = Db::prepare($stmt);

		// *TODO* the timestamp format may be is database dependend?
		$timeStr = TimeHelper::format(time(), 'c');

		// get new record and compare with old record
		$this->newRecord = $this->getRecord();
		$dbChanges = array();
		if ($this->mode == self::MODE_UPDATE) {
			foreach($this->newRecord as $key => $value) {
				if ($value != $this->oldRecord->$key) {
					$dbChanges[$key] = $value;
				}
			}
		} else {  /* MODE_INSERT */
			$dbChanges = (array) $this->newRecord;
		}

		// log wrong record id
		if (!$this->newRecord) {
			$dbChanges['*'] = 'ERROR: No Record found in ' . $this->table . ' for record id ' . $this->recId . '.';
		}

		// log every changed field
		try {
			foreach ($dbChanges as $field => $value) {
				$pstmt->execute(array('userId' => ($_SESSION[Logon::$_id]['logon'] ? $_SESSION[Logon::$_id]['logon']->user->values['id'] : 0),
															'time' => $timeStr,
															'table' => $this->table,
															'recId' => $this->recId,
															'mode' => $this->mode,
															'field' => $field,
															'value' => $value));
			}  // end of field loop
		}
		catch (Exception $ex) {
			$errMsg = "Error in Dblog::writeLog() " . $stmt . ".\n" . $ex->getMessage();
			Config::$logger->error($errMsg);
			throw  new Exception($errMsg);
		}
		$pstmt->closeCursor();

	}  // end of writeLog


	/**
	* return mode
	*/
	public function getMode() {
		return $this->mode;
	}  // end of get mode



}  // end of class

?>
