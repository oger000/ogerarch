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
* Stratum. Complex info.
*/
class StratumComplex extends DbRecord {

	public static $tableName = 'stratumComplex';

	#FIELDDEF BEGIN
	# Table: stratumComplex
	# Fielddef created: 2011-11-23 13:12

	public static $fieldNames = array(
		'id',
		'excavId',
		'stratumId',
		'stratum2Id'
	);

	public static $keyFieldNames = array(
		'excavId',
		'stratumId',
		'id'
	);

	public static $primaryKeyFieldNames = array(
		'id'
	);


	public static $textFieldNames = array(
		'stratumId',
		'stratum2Id'
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
	* Get all stratums that are part of this complex
	*/
	public static function getPartIdArray($excavId, $stratumId) {

		$array  = array();

		$whereVals = array('excavId' => $excavId, 'stratumId' => $stratumId);
		$pstmt = Db::prepare('SELECT stratum2Id FROM ' . self::$tableName, $whereVals);

		$pstmt->execute($whereVals);
		while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
			$array[$row['stratum2Id']] = $row['stratum2Id'];
		}
		$pstmt->closeCursor();

		asort($array);

		return $array;
	}  // eo stratum list of parts



	/**
	* Get all complexes where this stratums is part of (reverse part list)
	*/
	public static function getPartOfComplexIdArray($excavId, $stratum2Id) {

		$array  = array();

		$whereVals = array('excavId' => $excavId, 'stratum2Id' => $stratum2Id);
		$pstmt = Db::prepare('SELECT stratumId FROM ' . self::$tableName, $whereVals);

		$pstmt->execute($whereVals);
		while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
			$array[$row['stratumId']] = $row['stratumId'];
		}
		$pstmt->closeCursor();

		asort($array);

		return $array;
	}  // eo complex for stratum





	/**
	* Update list of parts for given stratum
	*/
	public static function updDbPartIdArray($excavId, $stratumId, $newStratumIdArray, $dbAction) {

		if (is_string($newStratumIdArray)) {
			$newStratumIdArray = ExcavHelper::multiXidSplit($newStratumIdArray);
		}

		$oldStratumIdArray = static::getPartIdArray($excavId, $stratumId);

		// delete items only on update, but not on new stratums (maybe complex parts are missing)
		if ($dbAction == Db::ACTION_UPDATE) {
			$delArray = array_diff($oldStratumIdArray, $newStratumIdArray);
			if (count($delArray) > 0) {
				$whereVals = array('excavId', 'stratumId', 'stratum2Id');
				$pstmt = Db::prepare('DELETE FROM ' . self::$tableName, $whereVals);
				foreach ($delArray as $stratum2Id) {
					$whereVals = array('excavId' => $excavId, 'stratumId' => $stratumId, 'stratum2Id' => $stratum2Id);
					$pstmt->execute($whereVals);
				}
				$pstmt->closeCursor();
			}
		}

		$addArray = array_diff($newStratumIdArray, $oldStratumIdArray);
		if (count($addArray) > 0) {
			$tmp = new self;
			foreach ($addArray as $stratum2Id) {
				// silently skip if stratum is part of itself ;-)
				if ($stratum2Id == $stratumId) {
					continue;
				}
				$id = self::getMaxValue('id') + 1;
				$tmp->setValues(array('id' => $id,
															'excavId' => $excavId, 'stratumId' => $stratumId,
															'stratum2Id' => $stratum2Id));
				$tmp->toDb(Db::ACTION_INSERT);
			}
		}

	}  // eo upd stratum part list




}  // end of class



?>
