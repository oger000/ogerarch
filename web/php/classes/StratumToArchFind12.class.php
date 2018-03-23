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
class StratumToArchFind12 extends DbRec {

	public static $tableName = "stratumToArchFind";




	/**
	* Store stratum ids for given archfind
	*/
	public static function storeStratumIds($excavId, $archFindId, $ids, $dbAction) {

		if (is_string($ids)) {
			$ids = ExcavHelper::multiXidSplit($ids);
		}

		$newIds = array();
		foreach($ids as $id) {
			$newIds[$id] = $id;
		}


		$seleVals = array("excavId" => $excavId, "archFindId" => $archFindId);

		// read already existing entries
		$oldIds = array();
		$pstmt = Dbw::$conn->prepare(
			"SELECT * FROM stratumToArchFind WHERE excavId=:excavId AND archFindId=:archFindId");
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
			$values['id'] = Dbw::fetchValue1("SELECT MAX(id) FROM stratumToArchFind") + 1;
			$values['stratumId'] = $id;
			static::store("INSERT", $values);
		}


		// on update remove surplus entries
		// this could be done with a single WHERE stratumId IN (...) statement
		// but we pay the performance price for a simpler statement creation
		if ($dbAction == "UPDATE") {

			$pstmt = Dbw::$conn->prepare(
				"DELETE FROM stratumToArchFind " .
				"WHERE excavId=:excavId AND stratumId=:stratumId AND archFindId=:archFindId AND BINARY stratumId=:stratumId AND BINARY archFindId=:archFindId");

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
	* Store arch find ids for given stratum
	*/
	public static function storeArchFindIds($excavId, $stratumId, $ids, $dbAction) {

		if (is_string($ids)) {
			$ids = ExcavHelper::multiXidSplit($ids);
		}

		$newIds = array();
		foreach((array)$ids as $id) {
			$newIds[$id] = $id;
		}


		$seleVals = array("excavId" => $excavId, "stratumId" => $stratumId);

		// read already existing entries
		$oldIds = array();
		$pstmt = Dbw::$conn->prepare(
			"SELECT * FROM stratumToArchFind WHERE excavId=:excavId AND stratumId=:stratumId");
		$pstmt->execute($seleVals);
		while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
			$refId = $row['archFindId'];
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
			$values['id'] = Dbw::fetchValue1("SELECT MAX(id) FROM stratumToArchFind") + 1;
			$values['archFindId'] = $id;
			static::store("INSERT", $values);
		}


		// on update remove surplus entries
		// this could be done with a single WHERE stratum2Id IN (...) statement
		// but we pay the performance price for a simpler statement creation
		if ($dbAction == "UPDATE") {

			$pstmt = Dbw::$conn->prepare(
				"DELETE FROM stratumToArchFind " .
				"WHERE excavId=:excavId AND stratumId=:stratumId AND archFindId=:archFindId AND BINARY stratumId=:stratumId AND BINARY archFindId=:archFindId");

			$seleValsDel = $seleVals;
			foreach($oldIds as $id) {
				// skip entries present in input
				if ($newIds[$id]) {
					continue;
				}
				$seleValsDel['archFindId'] = $id;
				$pstmt->execute($seleValsDel);
			}
			$pstmt->closeCursor();
		}

	}  // eo store arch find ids



}  // end of class


?>
