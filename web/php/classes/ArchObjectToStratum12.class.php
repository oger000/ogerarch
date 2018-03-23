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
class ArchObjectToStratum12 extends DbRec {

	public static $tableName = "archObjectToStratum";


	/**
	* Store stratum ids for given arch object
	*/
	public static function storeStratumIds($excavId, $archObjectId, $ids, $dbAction) {

		if (is_string($ids)) {
			$ids = ExcavHelper::multiXidSplit($ids);
		}

		$newIds = array();
		foreach($ids as $id) {
			$newIds[$id] = $id;
		}


		$seleVals = array("excavId" => $excavId, "archObjectId" => $archObjectId);

		// read already existing entries
		$oldIds = array();
		$pstmt = Dbw::$conn->prepare(
			"SELECT * FROM archObjectToStratum WHERE excavId=:excavId AND archObjectId=:archObjectId");
		$pstmt->execute($seleVals);
		while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
			$refId = $row['stratumId'];
			$oldIds[$refId] = $refId;
		}
		$pstmt->closeCursor();


		// store new entries
		$values = $seleVals;
		foreach($newIds as $id) {
			// skip existing entries
			if ($oldIds[$id]) {
				continue;
			}
			$values['id'] = Dbw::fetchValue1("SELECT MAX(id) FROM archObjectToStratum") + 1;
			$values['stratumId'] = $id;
			static::store("INSERT", $values);
		}


		// on update remove surplus entries
		// this could be done with a single WHERE stratumId IN (...) statement
		// but we pay the performance price for a simpler statement creation
		if ($dbAction == "UPDATE") {

			$pstmt = Dbw::$conn->prepare(
				"DELETE FROM archObjectToStratum " .
				"WHERE excavId=:excavId AND stratumId=:stratumId AND archObjectId=:archObjectId AND BINARY stratumId=:stratumId AND BINARY archObjectId=:archObjectId");

			$seleValsDel = $seleVals;
			foreach($oldIds as $id) {
				// skip entries present in input
				if ($newIds[$id]) {
					continue;
				}
				$seleValsDel['stratumId'] = $id;
				$pstmt->execute($seleValsDel);
			}
			$pstmt->closeCursor();
		}

	}  // eo store stratum ids



	/**
	* Store arch object ids for given stratum
	*/
	public static function storeArchObjectIds($excavId, $stratumId, $ids, $dbAction) {

		if (is_string($ids)) {
			$ids = ExcavHelper::multiXidSplit($ids);
		}

		$newIds = array();
		foreach($ids as $id) {
			$newIds[$id] = $id;
		}


		$seleVals = array("excavId" => $excavId, "stratumId" => $stratumId);

		// read already existing entries
		$oldIds = array();
		$pstmt = Dbw::$conn->prepare(
			"SELECT * FROM archObjectToStratum WHERE excavId=:excavId AND stratumId=:stratumId");
		$pstmt->execute($seleVals);
		while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
			$refId = $row['archObjectId'];
			$oldIds[$refId] = $refId;
		}
		$pstmt->closeCursor();


		// store new entries
		$values = $seleVals;
		foreach($newIds as $id) {
			// skip existing entries
			if ($oldIds[$id]) {
				continue;
			}
			$values['id'] = Dbw::fetchValue1("SELECT MAX(id) FROM archObjectToStratum") + 1;
			$values['archObjectId'] = $id;
			static::store("INSERT", $values);
		}


		// on update remove surplus entries
		// this could be done with a single WHERE stratum2Id IN (...) statement
		// but we pay the performance price for a simpler statement creation
		if ($dbAction == "UPDATE") {

			$pstmt = Dbw::$conn->prepare(
				"DELETE FROM archObjectToStratum " .
				"WHERE excavId=:excavId AND stratumId=:stratumId AND archObjectId=:archObjectId AND BINARY stratumId=:stratumId AND BINARY archObjectId=:archObjectId");

			$seleValsDel = $seleVals;
			foreach($oldIds as $id) {
				// skip entries present in input
				if ($newIds[$id]) {
					continue;
				}
				$seleValsDel['archObjectId'] = $id;
				$pstmt->execute($seleValsDel);
			}
			$pstmt->closeCursor();
		}

	}  // eo store arch object ids



}  // end of class


?>
