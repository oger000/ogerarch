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
* Stratum matrix info
*/
class StratumMatrix12 extends DbRec {

	const THIS_IS_EARLIER_THAN = 'ET';
	const THIS_IS_EQUAL_TO = 'EQ';
	const THIS_IS_CONTEMP_WITH = 'CW';

	// This fake constants are NOT stored in the database and are only used
	// for internal calculations - so use with care! They are here for convenience reason.
	// We use the normal relation constants prefixed with 'REVERSE_' string
	const THIS_IS_REVERSE_EARLIER_THAN = 'REVERSE_ET';
	const THIS_IS_REVERSE_EQUAL_TO = 'REVERSE_EQ';
	const THIS_IS_REVERSE_CONTEMP_WITH = 'REVERSE_CW';
	// another convenience constant - primarily intended for matrix building
	const THIS_IS_LATER_THAN = 'REVERSE_ET';


	public static $tableName = 'stratumMatrix';
	public static $relationNames;






	/**
	* Update relation list for given stratum and given relation
	*/
	/*
	public static function XXXupdRelation($excavId, $stratumId, $relation, $ids, $dbAction) {

		if (is_string($ids) {
			$ids = ExcavHelper::multiXidSplit($ids);
		}

		switch ($relation) {


		}

	}  // eo update relation
	*/



	/**
	* Store earlier than relation for given stratum
	*/
	public static function storeEarlierThan($excavId, $stratumId, $ids, $dbAction) {

		if (is_string($ids)) {
			$ids = ExcavHelper::multiXidSplit($ids);
		}

		$newIds = array();
		foreach($ids as $id) {
			$newIds[$id] = $id;
		}

		// silenty remove self references
		unset($newIds[$stratumId]);


		$seleVals = array(
			"excavId" => $excavId,
			"relation" => static::THIS_IS_EARLIER_THAN,
			"stratumIdMain" => $stratumId);

		// read already existing entries
		$oldIds = array();
		$pstmt = Dbw::$conn->prepare(
			"SELECT * FROM stratumMatrix " .
			"WHERE excavId=:excavId AND relation=:relation AND stratumId=:stratumIdMain");
		$pstmt->execute($seleVals);
		while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
			$refStratumId = $row['stratum2Id'];
			$oldIds[$refStratumId] = $refStratumId;
		}
		$pstmt->closeCursor();


		// store new entries
		$values = $seleVals;
		$values['stratumId'] = $stratumId;
		foreach($newIds as $id) {
			// skip existing entries
			if ($oldIds[$id]) {
				continue;
			}
			$values['id'] = Dbw::fetchValue1("SELECT MAX(id) FROM stratumMatrix") + 1;
			$values['stratum2Id'] = $id;
			static::store("INSERT", $values);
		}


		// on update remove surplus entries
		// this could be done with a single WHERE stratum2Id IN (...) statement
		// but we pay the performance price for a simpler statement creation
		if ($dbAction == "UPDATE") {

			$pstmt = Dbw::$conn->prepare(
				"DELETE FROM stratumMatrix " .
				"WHERE excavId=:excavId AND relation=:relation" .
					" AND stratumId=:stratumIdMain AND stratum2Id=:stratum2Id" .
					" AND BINARY stratumId=:stratumIdMain AND BINARY stratum2Id=:stratum2Id");

			$seleValsDel = $seleVals;
			foreach($oldIds as $id) {
				// skip entries present in input
				if ($newIds[$id]) {
					continue;
				}
				$seleValsDel['stratum2Id'] = $id;
				$pstmt->execute($seleValsDel);
			}
			$pstmt->closeCursor();
		}

	}  // eo store earlier than



	/**
	* Store reverse earlier than (later than) relation for given stratum
	*/
	public static function storeReverseEarlierThan($excavId, $stratumId, $ids, $dbAction) {

		if (is_string($ids)) {
			$ids = ExcavHelper::multiXidSplit($ids);
		}

		$newIds = array();
		foreach($ids as $id) {
			$newIds[$id] = $id;
		}

		// silenty remove self references
		unset($newIds[$stratumId]);


		$seleVals = array(
			"excavId" => $excavId,
			"relation" => static::THIS_IS_EARLIER_THAN,
			"stratumIdMain" => $stratumId);

		// read already existing entries
		$oldIds = array();
		$pstmt = Dbw::$conn->prepare(
			"SELECT * FROM stratumMatrix " .
			"WHERE excavId=:excavId AND relation=:relation AND stratum2Id=:stratumIdMain");
		$pstmt->execute($seleVals);
		while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
			$refStratumId = $row['stratumId'];
			$oldIds[$refStratumId] = $refStratumId;
		}
		$pstmt->closeCursor();


		// store new entries
		$values = $seleVals;
		$values['stratum2Id'] = $stratumId;
		foreach($newIds as $id) {
			// skip existing entries
			if ($oldIds[$id]) {
				continue;
			}
			$values['id'] = Dbw::fetchValue1("SELECT MAX(id) FROM stratumMatrix") + 1;
			$values['stratumId'] = $id;
			static::store("INSERT", $values);
		}


		// on update remove surplus entries
		// this could be done with a single WHERE stratum2Id IN (...) statement
		// but we pay the performance price for a simpler statement creation
		if ($dbAction == "UPDATE") {

			$pstmt = Dbw::$conn->prepare(
				"DELETE FROM stratumMatrix " .
				"WHERE excavId=:excavId AND relation=:relation" .
					" AND stratumId=:stratumId AND stratum2Id=:stratumIdMain" .
					" AND BINARY stratumId=:stratumId AND BINARY stratum2Id=:stratumIdMain");

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

	}  // eo store reverse earlier than



	/**
	* Store equal to relation for given stratum
	*/
	public static function storeEqualTo($excavId, $stratumId, $ids, $dbAction) {

		if (is_string($ids)) {
			$ids = ExcavHelper::multiXidSplit($ids);
		}

		// silenty remove self references
		unset($newIds[$stratumId]);


		$newIds = array();
		foreach($ids as $id) {
			$newIds[$id] = $id;
		}


		$seleVals = array(
			"excavId" => $excavId,
			"relation" => static::THIS_IS_EQUAL_TO,
			"stratumIdMain" => $stratumId);

		// read already existing entries and count
		$oldIds = array();
		$oldIdCount = array();
		$oldRows = array();
		$pstmt = Dbw::$conn->prepare(
			"SELECT * FROM stratumMatrix " .
			"WHERE excavId=:excavId AND relation=:relation AND " .
				"(stratumId=:stratumIdMain OR stratum2Id=:stratumIdMain)");
		$pstmt->execute($seleVals);
		while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
			$oldRows[] = $row;
			$refStratumId = ($row['stratumId'] == $stratumId ? $row['stratum2Id'] : $row['stratumId']);
			$oldIds[$refStratumId] = $refStratumId;
			$oldIdCount[$refStratumId] = $oldIdCount[$refStratumId] + 1;
		}
		$pstmt->closeCursor();

		// TODO if count for an oldId > 1 we should remove all exept one


		// store new entries
		$values = $seleVals;
		$values['stratumId'] = $stratumId;
		foreach($newIds as $id) {
			// skip existing entries
			if ($oldIds[$id]) {
				continue;
			}
			$values['id'] = Dbw::fetchValue1("SELECT MAX(id) FROM stratumMatrix") + 1;
			$values['stratum2Id'] = $id;
			static::store("INSERT", $values);
		}


		// on update remove surplus entries
		// this could be done with a single WHERE stratum2Id IN (...) statement
		// but we pay the performance price for a simpler statement creation
		if ($dbAction == "UPDATE") {

			$pstmt = Dbw::$conn->prepare(
				"DELETE FROM stratumMatrix " .
				"WHERE excavId=:excavId AND relation=:relation AND " .
					"((stratumId=:stratumIdMain AND stratum2Id=:stratumIdRef AND BINARY stratumId=:stratumIdMain AND BINARY stratum2Id=:stratumIdRef) OR ".
					 "(stratumId=:stratumIdRef AND stratum2Id=:stratumIdMain AND BINARY stratumId=:stratumIdRef AND BINARY stratum2Id=:stratumIdMain))");

			$seleValsDel = $seleVals;
			foreach($oldIds as $id) {
				// skip entries present in input
				if ($newIds[$id]) {
					continue;
				}
				$seleValsDel['stratumIdRef'] = $id;
				$pstmt->execute($seleValsDel);
			}
			$pstmt->closeCursor();
		}

	}  // eo store equal to



	/**
	* Store contemp with relation for given stratum
	*/
	public static function storeContempWith($excavId, $stratumId, $ids, $dbAction) {

		if (is_string($ids)) {
			$ids = ExcavHelper::multiXidSplit($ids);
		}

		$newIds = array();
		foreach($ids as $id) {
			$newIds[$id] = $id;
		}

		// silenty remove self references
		unset($newIds[$stratumId]);


		$seleVals = array(
			"excavId" => $excavId,
			"relation" => static::THIS_IS_CONTEMP_WITH,
			"stratumIdMain" => $stratumId);

		// read already existing entries and count
		$oldIds = array();
		$oldIdCount = array();
		$oldRows = array();
		$pstmt = Dbw::$conn->prepare(
			"SELECT * FROM stratumMatrix " .
			"WHERE excavId=:excavId AND relation=:relation AND " .
				"(stratumId=:stratumIdMain OR stratum2Id=:stratumIdMain)");
		$pstmt->execute($seleVals);
		while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
			$oldRows[] = $row;
			$refStratumId = ($row['stratumId'] == $stratumId ? $row['stratum2Id'] : $row['stratumId']);
			$oldIds[$refStratumId] = $refStratumId;
			$oldIdCount[$refStratumId] = $oldIdCount[$refStratumId] + 1;
		}
		$pstmt->closeCursor();

		// TODO if count for an oldId > 1 we should remove all exept one


		// store new entries
		$values = $seleVals;
		$values['stratumId'] = $stratumId;
		foreach($newIds as $id) {
			// skip existing entries
			if ($oldIds[$id]) {
				continue;
			}
			$values['id'] = Dbw::fetchValue1("SELECT MAX(id) FROM stratumMatrix") + 1;
			$values['stratum2Id'] = $id;
			static::store("INSERT", $values);
		}


		// on update remove surplus entries
		// this could be done with a single WHERE stratum2Id IN (...) statement
		// but we pay the performance price for a simpler statement creation
		if ($dbAction == "UPDATE") {

			$pstmt = Dbw::$conn->prepare(
				"DELETE FROM stratumMatrix " .
				"WHERE excavId=:excavId AND relation=:relation AND " .
					"((stratumId=:stratumIdMain AND stratum2Id=:stratumIdRef AND BINARY stratumId=:stratumIdMain AND BINARY stratum2Id=:stratumIdRef) OR ".
					 "(stratumId=:stratumIdRef AND stratum2Id=:stratumIdMain AND BINARY stratumId=:stratumIdRef AND BINARY stratum2Id=:stratumIdMain))");

			$seleValsDel = $seleVals;
			foreach($oldIds as $id) {
				// skip entries present in input
				if ($newIds[$id]) {
					continue;
				}
				$seleValsDel['stratumIdRef'] = $id;
				$pstmt->execute($seleValsDel);
			}
			$pstmt->closeCursor();
		}

	}  // eo store contemp with



}  // end of class


?>
