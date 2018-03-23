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
* Arch object to stratum connection
*/
class ArchObjectToStratum extends DbRecord {

	public static $tableName = 'archObjectToStratum';

	#FIELDDEF BEGIN
	# Table: archObjectToStratum
	# Fielddef created: 2012-02-02 12:34

	public static $fieldNames = array(
		'id',
		'excavId',
		'archObjectId',
		'stratumId'
	);

	public static $keyFieldNames = array(
		'excavId',
		'archObjectId',
		'stratumId',
		'id'
	);

	public static $primaryKeyFieldNames = array(
		'id'
	);


	public static $textFieldNames = array(
		'archObjectId',
		'stratumId'
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
	* Get all stratums for one arch object
	*/
	public static function getStratumIdArray($excavId, $archObjectId) {

		$stratumIdArray = array();

		$whereVals = array('excavId' => $excavId, 'archObjectId' => $archObjectId);
		$pstmt = Db::prepare('SELECT stratumId FROM ' . self::$tableName, $whereVals, 'ORDER BY 0+stratumId');

		$pstmt->execute($whereVals);
		while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
			$stratumIdArray[] = $row['stratumId'];
		}
		$pstmt->closeCursor();

		return $stratumIdArray;
	}  // eo stratum list


	/**
	* Get all arch object for one stratum
	*/
	public static function getArchObjectIdArray($excavId, $stratumId) {

		$whereVals = array('excavId' => $excavId, 'stratumId' => $stratumId);
		$pstmt = Db::prepare('SELECT * FROM ' . self::$tableName, $whereVals, 'ORDER BY 0+archObjectId');

		$archObjectArray  = array();

		$pstmt->execute($whereVals);
		while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
			$archObjectArray[] = $row['archObjectId'];
		}
		$pstmt->closeCursor();

		return $archObjectArray;

	}  // eo arch object list


	/**
	* Update stratum list for an arch object
	*/
	public static function updDbStratumIdArray($excavId, $archObjectId, $newStratumIdArray, $dbAction) {

		$oldStratumIdArray = self::getStratumIdArray($excavId, $archObjectId);

		// delete items only on update, but not on new arch object (maybe stratums are missing)
		if ($_REQUEST['dbAction'] == Db::ACTION_UPDATE) {
			$delArray = array_diff($oldStratumIdArray, $newStratumIdArray);
			if (count($delArray) > 0) {
				$whereVals = array('excavId', 'archObjectId', 'stratumId');
				$pstmt = Db::prepare('DELETE FROM ' . self::$tableName, $whereVals);
				foreach ($delArray as $stratumId) {
					$whereVals = array('excavId' => $excavId, 'archObjectId' => $archObjectId, 'stratumId' => $stratumId);
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
				$tmp->setValues(array('id' => $id, 'excavId' => $excavId, 'archObjectId' => $archObjectId, 'stratumId' => $stratumId));
				$tmp->toDb(Db::ACTION_INSERT);
			}
		}

	}  // eo upd stratum list



	/**
	* Update object list for an stratum
	*/
	public static function updDbArchObjectIdArray($excavId, $stratumId, $newArchObjectIdArray, $dbAction) {

		$oldArchObjectIdArray = self::getArchObjectIdArray($excavId, $stratumId);

		// delete items only on update, but not on new stratum (maybe arch objects are missing)
		if ($_REQUEST['dbAction'] == Db::ACTION_UPDATE) {
			$delArray = array_diff($oldArchObjectIdArray, $newArchObjectIdArray);
			if (count($delArray) > 0) {
				$whereVals = array('excavId', 'archObjectId', 'stratumId');
				$pstmt = Db::prepare('DELETE FROM ' . self::$tableName, $whereVals);
				foreach ($delArray as $archObjectId) {
					$whereVals = array('excavId' => $excavId, 'archObjectId' => $archObjectId, 'stratumId' => $stratumId);
					$pstmt->execute($whereVals);
				}
				$pstmt->closeCursor();
			}
		}  // eo del

		$addArray = array_diff($newArchObjectIdArray, $oldArchObjectIdArray);
		if (count($addArray) > 0) {
			$tmp = new self;
			foreach ($addArray as $archObjectId) {
				$id = self::getMaxValue('id') + 1;
				$tmp->setValues(array('id' => $id, 'excavId' => $excavId, 'archObjectId' => $archObjectId, 'stratumId' => $stratumId));
				$tmp->toDb(Db::ACTION_INSERT);
			}
		}

	}  // eo upd object list



}  // end of class


?>
