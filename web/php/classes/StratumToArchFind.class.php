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
* Stratum archFind connection
*/
class StratumToArchFind extends DbRecord {

	public static $tableName = 'stratumToArchFind';

	#FIELDDEF BEGIN
	# Table: stratumToArchFind
	# Fielddef created: 2011-11-22 17:35

	public static $fieldNames = array(
		'id',
		'excavId',
		'stratumId',
		'archFindId'
	);

	public static $keyFieldNames = array(
		'excavId',
		'archFindId',
		'stratumId',
		'id'
	);

	public static $primaryKeyFieldNames = array(
		'id'
	);


	public static $textFieldNames = array(
		'stratumId',
		'archFindId'
	);

	public static $numberFieldNames = array(
		'id',
		'excavId'
	);

	public static $boolFieldNames = array(

	);

	public static $dateFieldNames = array(

	);

	public static $timeFieldNames = array(

	);

	#FIELDDEF END



	/**
	* Get all stratums for a arch find
	*/
	public static function getStratumIdArray($excavId, $archFindId) {

		$stratumIdArray = array();

		$whereVals = array('excavId' => $excavId, 'archFindId' => $archFindId);
		$pstmt = Db::prepare('SELECT stratumId FROM ' . self::$tableName, $whereVals);

		$pstmt->execute($whereVals);
		while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
			$stratumIdArray[] = $row['stratumId'];
		}
		$pstmt->closeCursor();

		return $stratumIdArray;
	}  // eo stratum list


	/**
	* Get all archfinds for a stratum
	*/
	public static function getArchFindIdArray($excavId, $stratumId) {

		$whereVals = array('excavId' => $excavId, 'stratumId' => $stratumId);
		$pstmt = Db::prepare('SELECT * FROM ' . self::$tableName, $whereVals);

		$archFindArray  = array();

		$pstmt->execute($whereVals);
		while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
			$archFindArray[] = $row['archFindId'];
		}
		$pstmt->closeCursor();

		return $archFindArray;

	}  // eo arch find list


	/**
	* Update stratum list for an arch find
	*/
	public static function updDbStratumIdArray($excavId, $archFindId, $newStratumIdArray, $dbAction) {

		$oldStratumIdArray = self::getStratumIdArray($excavId, $archFindId);

		// delete items only on update, but not on new arch finds (maybe stratums are missing)
		if ($_REQUEST['dbAction'] == Db::ACTION_UPDATE) {
			$delArray = array_diff($oldStratumIdArray, $newStratumIdArray);
			if (count($delArray) > 0) {
				$whereVals = array('excavId', 'archFindId', 'stratumId');
				$pstmt = Db::prepare('DELETE FROM ' . self::$tableName, $whereVals);
				foreach ($delArray as $stratumId) {
					$whereVals = array('excavId' => $excavId, 'archFindId' => $archFindId, 'stratumId' => $stratumId);
					$pstmt->execute($whereVals);
				}
				$pstmt->closeCursor();
			}
		}  // eo del

		$addArray = array_diff($newStratumIdArray, $oldStratumIdArray);
		if (count($addArray) > 0) {
			$tmp = new self;
			foreach ($addArray as $stratumId) {
				$id = self::getMaxValue('id') + 1;
				$tmp->setValues(array('id' => $id, 'excavId' => $excavId, 'archFindId' => $archFindId, 'stratumId' => $stratumId));
				$tmp->toDb(Db::ACTION_INSERT);
			}
		}

	}  // eo upd arch find list


	/**
	* Update arch find list for an stratum
	*/
	public static function updDbArchFindIdArray($excavId, $stratumId, $newArchFindIdArray, $dbAction) {

		$oldArchFindIdArray = self::getArchFindIdArray($excavId, $stratumId);

		// delete items only on update, but not on new stratum (maybe arch finds are missing)
		if ($_REQUEST['dbAction'] == Db::ACTION_UPDATE) {
			$delArray = array_diff($oldArchFindIdArray, $newArchFindIdArray);
			if (count($delArray) > 0) {
				$whereVals = array('excavId', 'archFindId', 'stratumId');
				$pstmt = Db::prepare('DELETE FROM ' . self::$tableName, $whereVals);
				foreach ($delArray as $archFindId) {
					$whereVals = array('excavId' => $excavId, 'archFindId' => $archFindId, 'stratumId' => $stratumId);
					$pstmt->execute($whereVals);
				}
				$pstmt->closeCursor();
			}
		}  // eo del

		$addArray = array_diff($newArchFindIdArray, $oldArchFindIdArray);
		if (count($addArray) > 0) {
			$tmp = new self;
			foreach ($addArray as $archFindId) {
				$id = self::getMaxValue('id') + 1;
				$tmp->setValues(array('id' => $id, 'excavId' => $excavId, 'archFindId' => $archFindId, 'stratumId' => $stratumId));
				$tmp->toDb(Db::ACTION_INSERT);
			}
		}

	}  // eo upd arch find list




}  // end of class


?>
