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
class StratumMatrix extends DbRecord {

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

	#FIELDDEF BEGIN
	# Table: stratumMatrix
	# Fielddef created: 2011-11-22 17:35

	public static $fieldNames = array(
		'id',
		'excavId',
		'stratumId',
		'relation',
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
		'relation',
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


	public static $relationNames;

	/**
	* Get all stratums for the given "relation" field
	*/
	public static function getRelationIdArray($excavId, $stratumId, $relation) {

		$array  = array();

		$whereVals = array('excavId' => $excavId, 'stratumId' => $stratumId, 'relation' => $relation);
		$pstmt = Db::prepare('SELECT stratum2Id FROM ' . self::$tableName, $whereVals);

		$pstmt->execute($whereVals);
		while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
			$array[$row['stratum2Id']] = $row['stratum2Id'];
		}
		$pstmt->closeCursor();

		asort($array, SORT_NUMERIC);

		return $array;
	}  // eo stratum list



	/**
	* Get all REVERSE stratums for the given "relation" field
	*/
	public static function getReverseRelationIdArray($excavId, $stratum2Id, $relation) {

		$array  = array();

		$whereVals = array('excavId' => $excavId, 'stratum2Id' => $stratum2Id, 'relation' => $relation);
		$pstmt = Db::prepare('SELECT stratumId FROM ' . self::$tableName, $whereVals);

		$pstmt->execute($whereVals);
		while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
			$array[$row['stratumId']] = $row['stratumId'];
		}
		$pstmt->closeCursor();

		asort($array, SORT_NUMERIC);

		return $array;
	}  // eo stratum list


	/**
	* Get all stratums relations (including reverse relations)
	* Use this method to minimize db access if all relations are needed.
	*/
	public static function getFullRelationsIdArray($excavId, $stratumId) {

		$array  = array();
		$array[self::THIS_IS_EARLIER_THAN] = array();
		$array[self::THIS_IS_EQUAL_TO] = array();
		$array[self::THIS_IS_CONTEMP_WITH] = array();
		$array[self::THIS_IS_REVERSE_EARLIER_THAN] = array();
		$array[self::THIS_IS_REVERSE_EQUAL_TO] = array();
		$array[self::THIS_IS_REVERSE_CONTEMP_WITH] = array();

		$whereVals = array('excavId' => $excavId, 'stratumId' => $stratumId);
		$pstmt = Db::prepare('SELECT * FROM ' . self::$tableName .
												 ' WHERE excavId=:excavId AND (stratumId=:stratumId OR stratum2Id=:stratumId)');

		$pstmt->execute($whereVals);
		while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
			if ($row['stratumId'] == $stratumId) {
				$array[$row['relation']][$row['stratum2Id']] = $row['stratum2Id'];
			}
			else {
				$array['REVERSE_' . $row['relation']][$row['stratumId']] = $row['stratumId'];
			}
		}
		$pstmt->closeCursor();

		asort($array[self::THIS_IS_EARLIER_THAN], SORT_NUMERIC);
		asort($array[self::THIS_IS_EQUAL_TO], SORT_NUMERIC);
		asort($array[self::THIS_IS_CONTEMP_WITH], SORT_NUMERIC);
		asort($array[self::THIS_IS_REVERSE_EARLIER_THAN], SORT_NUMERIC);
		asort($array[self::THIS_IS_REVERSE_EQUAL_TO], SORT_NUMERIC);
		asort($array[self::THIS_IS_REVERSE_CONTEMP_WITH], SORT_NUMERIC);

		return $array;
	}  // eo stratum list



	/**
	* Get id lists for relation arrays
	*/
	public static function getRelationIdListsFromMatrixInfo($matrixInfo, $opts = array()) {

		$delim = ExcavHelper::$xidDelimiterOut;

		$values = array();

		$equalTo = ($matrixInfo[self::THIS_IS_EQUAL_TO] ?: array());
		if ($opts['mergeReverseEqualTo'] || $opts['mergeReverseAll']) {
			$equalTo = Oger::arrayMergeAssoc($matrixInfo[self::THIS_IS_REVERSE_EQUAL_TO], $equalTo);
			asort($equalTo, SORT_NUMERIC);
		}

		$contempWith = ($matrixInfo[self::THIS_IS_CONTEMP_WITH] ?: array());
		if ($opts['mergeReverseContempWith'] || $opts['mergeReverseAll']) {
			$contempWith = Oger::arrayMergeAssoc($matrixInfo[self::THIS_IS_REVERSE_CONTEMP_WITH], $contempWith);
			asort($contempWith, SORT_NUMERIC);
		}

		$values['earlierThanIdList'] = implode($delim, ($matrixInfo[StratumMatrix::THIS_IS_EARLIER_THAN] ?: array()));
		$values['equalToIdList'] = implode($delim, $equalTo);
		$values['contempWithIdList'] = implode($delim, $contempWith);

		$values['reverseEarlierThanIdList'] = implode($delim, ($matrixInfo[self::THIS_IS_REVERSE_EARLIER_THAN] ?: array()));
		$values['reverseEqualToIdList'] = implode($delim, ($matrixInfo[self::THIS_IS_REVERSE_EQUAL_TO] ?: array()));
		$values['reverseContempWithIdList'] = implode($delim, ($matrixInfo[self::THIS_IS_REVERSE_CONTEMP_WITH] ?: array()));

		return $values;
	}  // eo relation arrays to id lists



	/**
	* Update relation list for given stratum and given relation
	*/
	public static function updDbRelationIdArray($excavId, $stratumId, $relation, $newStratumIdArray, $dbAction) {

		// unify all empty (null, etc) to an empty array
		if (!$newStratumIdArray) {
			$newStratumIdArray = array();
		}

		if (is_string($newStratumIdArray)) {
			$newStratumIdArray = ExcavHelper::multiXidSplit($newStratumIdArray);
		}

		$relationOri = $relation;
		if ($relationOri == self::THIS_IS_REVERSE_EARLIER_THAN) {
			$relation = self::THIS_IS_EARLIER_THAN;
			$oldStratumIdArray = static::getReverseRelationIdArray($excavId, $stratumId, $relation);
			$dbField1 = 'stratum2Id';
			$dbField2 = 'stratumId';
		}
		else {
			$oldStratumIdArray = static::getRelationIdArray($excavId, $stratumId, $relation);
			$dbField1 = 'stratumId';
			$dbField2 = 'stratum2Id';
		}

		$oldStratumIdArrayExtended = $oldStratumIdArray;
		if ($relation == self::THIS_IS_EQUAL_TO) {
			$isEgalityRelation = true;
		}
		if ($relation == self::THIS_IS_CONTEMP_WITH) {
			$isEgalityRelation = true;
		}
		if ($isEgalityRelation) {
			$oldStratumIdArrayExtended =
				Oger::arrayMergeAssoc(static::getReverseRelationIdArray($excavId, $stratumId, $relation),
																	$oldStratumIdArrayExtended);
		}

		// delete items only on update, but not on new stratums
		// (maybe relations are missing - in particular that comes from reverse info)
		if ($dbAction == Db::ACTION_UPDATE) {
			$delArray = array_diff($oldStratumIdArrayExtended, $newStratumIdArray);
			if (count($delArray) > 0) {
				$whereVals = array('excavId', 'stratumId', 'relation', 'stratum2Id');
				$pstmt = Db::prepare('DELETE FROM ' . self::$tableName, $whereVals);
				foreach ($delArray as $stratum2Id) {
					$whereVals = array('excavId' => $excavId, $dbField1 => $stratumId, 'relation' => $relation, $dbField2 => $stratum2Id);
					$pstmt->execute($whereVals);
					// for equality relations (equal-to and contemp-with) also delete the reverse entry
					// even if this is not in the table it does no harm and force consistency
					if ($isEgalityRelation) {
						$whereVals = array('excavId' => $excavId, $dbField2 => $stratumId, 'relation' => $relation, $dbField1 => $stratum2Id);
						$pstmt->execute($whereVals);
					}
				}
				$pstmt->closeCursor();
			}
		}

		// we add also ids that are eventually pulled in from the reverse relation,
		// so do not use oldStratumIdArrayExtended for comparation
		$addArray = array_diff($newStratumIdArray, $oldStratumIdArray);
		if (count($addArray) > 0) {
			$tmp = new self;
			foreach ($addArray as $stratum2Id) {
				$id = self::getMaxValue('id') + 1;
				$tmp->setValues(array('id' => $id,
															'excavId' => $excavId,
															$dbField1 => $stratumId,
															'relation' => $relation,
															$dbField2 => $stratum2Id));
				$tmp->toDb(Db::ACTION_INSERT);
			}
		}

	}  // eo upd stratum relation



	/**
	* Get relation names
	*/
	public static function getRelationNames() {

		if (!self::$relationNames) {
			self::$relationNames[self::THIS_IS_EARLIER_THAN] = Oger::_('Früher als');
			self::$relationNames[self::THIS_IS_EQUAL_TO] = Oger::_('Ist Ident mit');
			self::$relationNames[self::THIS_IS_CONTEMP_WITH] = Oger::_('Zeitgleich mit');
			self::$relationNames[self::THIS_IS_REVERSE_EARLIER_THAN] = Oger::_('Später als');
			self::$relationNames[self::THIS_IS_REVERSE_EQUAL_TO] = Oger::_('Reverse Ident mit');
			self::$relationNames[self::THIS_IS_REVERSE_CONTEMP_WITH] = Oger::_('Reverse Zeitgleich');
		}

		return self::$relationNames;
	}  // eo get relation names


	/**
	* Get relation name for one id
	*/
	public static function getRelationName($id) {
		self::getRelationNames();
		return self::$relationNames[$id];
	}  // eo get relation name




}  // end of class


?>
