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
* Arch object group to arch object connection
*/
class ArchObjGroupToArchObject extends DbRecord {

	public static $tableName = 'archObjGroupToArchObject';

	#FIELDDEF BEGIN
	# Table: archObjGroupToArchObject
	# Fielddef created: 2012-02-07 16:35

	public static $fieldNames = array(
		'id',
		'excavId',
		'archObjGroupId',
		'archObjectId'
	);

	public static $keyFieldNames = array(
		'excavId',
		'archObjectId',
		'archObjGroupId',
		'id'
	);

	public static $primaryKeyFieldNames = array(
		'id'
	);


	public static $textFieldNames = array(
		'archObjGroupId',
		'archObjectId'
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
	* Get all arch objects for one arch object group
	*/
	public static function getArchObjectIdArray($excavId, $archObjGroupId) {

		$archObjectIdArray = array();

		$whereVals = array('excavId' => $excavId, 'archObjGroupId' => $archObjGroupId);
		$pstmt = Db::prepare('SELECT * FROM ' . self::$tableName, $whereVals, 'ORDER BY 0+archObjectId');

		$pstmt->execute($whereVals);
		while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
			$archObjectIdArray[] = $row['archObjectId'];
		}
		$pstmt->closeCursor();

		return $archObjectIdArray;
	}  // eo object list


	/**
	* Get all object groups for one arch object
	*/
	public static function getArchObjGroupIdArray($excavId, $archObjectId) {

		$whereVals = array('excavId' => $excavId, 'archObjectId' => $archObjectId);
		$pstmt = Db::prepare('SELECT * FROM ' . self::$tableName, $whereVals, 'ORDER BY 0+archObjGroupId');

		$archObjGroupArray  = array();

		$pstmt->execute($whereVals);
		while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
			$archObjGroupArray[] = $row['archObjGroupId'];
		}
		$pstmt->closeCursor();

		return $archObjGroupArray;

	}  // eo arch object group list


	/**
	* Update arch object list for an arch object GROUP
	*/
	public static function updDbArchObjectIdArray($excavId, $archObjGroupId, $newArchObjectIdArray, $dbAction) {

		$oldArchObjectIdArray = self::getArchObjectIdArray($excavId, $archObjGroupId);

		// delete items only on update, but not on new arch object groups (maybe objects are missing)
		if ($_REQUEST['dbAction'] == Db::ACTION_UPDATE) {
			$delArray = array_diff($oldArchObjectIdArray, $newArchObjectIdArray);
			if (count($delArray) > 0) {
				$whereVals = array('excavId', 'archObjGroupId', 'archObjectId');
				$pstmt = Db::prepare('DELETE FROM ' . self::$tableName, $whereVals);
				foreach ($delArray as $archObjectId) {
					$whereVals = array('excavId' => $excavId, 'archObjGroupId' => $archObjGroupId, 'archObjectId' => $archObjectId);
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
				$tmp->setValues(array('id' => $id, 'excavId' => $excavId,
															'archObjGroupId' => $archObjGroupId, 'archObjectId' => $archObjectId));
				$tmp->toDb(Db::ACTION_INSERT);
			}
		}

	}  // eo upd arch object list



	/**
	* Update object group list for one arch object
	*/
	public static function updDbArchObjGroupIdArray($excavId, $archObjectId, $newArchObjGroupIdArray, $dbAction) {

		$oldArchObjGroupIdArray = self::getArchObjGroupIdArray($excavId, $archObjectId);

		// delete items only on update, but not on new object group (maybe arch objects are missing)
		if ($_REQUEST['dbAction'] == Db::ACTION_UPDATE) {
			$delArray = array_diff($oldArchObjGroupIdArray, $newArchObjGroupIdArray);
			if (count($delArray) > 0) {
				$whereVals = array('excavId', 'archObjGroupId', 'archObjectId');
				$pstmt = Db::prepare('DELETE FROM ' . self::$tableName, $whereVals);
				foreach ($delArray as $archObjGroupId) {
					$whereVals = array('excavId' => $excavId, 'archObjGroupId' => $archObjGroupId, 'archObjectId' => $archObjectId);
					$pstmt->execute($whereVals);
				}
				$pstmt->closeCursor();
			}
		}  // eo del

		$addArray = array_diff($newArchObjGroupIdArray, $oldArchObjGroupIdArray);
		if (count($addArray) > 0) {
			$tmp = new self;
			foreach ($addArray as $archObjGroupId) {
				$id = self::getMaxValue('id') + 1;
				$tmp->setValues(array('id' => $id, 'excavId' => $excavId,
															'archObjGroupId' => $archObjGroupId, 'archObjectId' => $archObjectId));
				$tmp->toDb(Db::ACTION_INSERT);
			}
		}

	}  // eo upd object GROUP list



}  // end of class


?>
