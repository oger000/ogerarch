<?php
/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/***
* Database helper for creating selection statements.
*/
class DbSeleHelper {

	/*
	* Prepare selection array from value array
	* HIGHLY CONVENTION DEPENDENT so use with care
	* (for example that an unique id field is present)
	*/
	public static function prepareSeleOpts($sele = array(), $newOpts = null) {

		// if newopts are missing use $_REQUEST
		if ($newOpts === null) {
			$newOpts = $_REQUEST;
		}

		// respect remote filter object
		if ($_REQUEST['filter']) {
			$jFilters = json_decode($_REQUEST['filter']);
			foreach ($jFilters as $jFilter) {
				$sele['where'][$jFilter->property] = $jFilter->value;
			}
		}


		// ATTENTION: we blindly presume start statement if limit is given
		if ($newOpts['limit']) {
			$sele['limit'] = array('start' => $newOpts['start'], 'limit' => $newOpts['limit']);
		}

		if ($newOpts['jumpTo']) {
			if ($newOpts['jumpTo'] == 'first') {
				$sele['limit'] = 1;
			}
			elseif ($newOpts['jumpTo'] == 'last') {
				$sele['orderBy'] = Db::reverseOrderByStmt($sele['orderBy']);
				$sele['limit'] = 1;
			}
			elseif (substr($newOpts['jumpTo'], 0, 6) == 'offset') {
				$idSele = explode('~', $newOpts['jumpTo']);
				$offset = substr(array_shift($idSele), 6);
				$idFields = array();
				foreach ($idSele as $idSeleItem) {
					list($field, $value) = explode('=', $idSeleItem);
					$idFields[$field] = $value;
				}

				// get ordered list of ALL ids
				$seleAll = $sele;
				$seleAll['fields'] = $idFields;
				$stmt = Db::createSelectStmt($seleAll);
				$pstmt = Db::prepare($stmt);
				$pstmt->execute($seleAll['where']);
				$allIds = $pstmt->fetchAll(); //PDO::FETCH_ASSOC);
				$pstmt->closeCursor();

				// get position of old record and calc pos of new id
				$pos = null;
				$posCount = -1;
				foreach ($allIds as $record) {
					$posCount++;
					$found = true;
					foreach ($idFields as $idField => $idValue) {
						if ($record[$idField] != $idValue) {
							$found = false;
							break;
						}
					}
					if ($found) {
						$pos = $posCount;
						break;
					}
				}
				if ($pos === null) { // nothing found (probably we start the jump from a new/empty record)
					if ($offset < 0) {
						$pos = count($allIds) - 1;   // jump to last record
					}
					else {
						$pos = 0;   // jump to first record
					}
				}
				else {
					$pos += $offset;
				}

				if ($pos < 0) {
					$pos = count($allIds) - 1;   // cycle to last record if we jump before the first record
				}
				if ($pos > count($allIds) - 1) {
					$pos = 0;             // cycle to first record if we jump behind the last record
				}
				$sele['where'] = array();
				foreach ($idFields as $idField => $idValue) {
					$sele['where'][$idField] = $allIds[$pos][$idField];
				}
				$sele['limit'] = 1;
			}
		}

		return $sele;
	} // eo create selection options



	/*
	* Create sql fragment for range selection
	* @range: An assoziative array where the keynames are the fieldnames
	*         and the values are the corresponding begin and end values.
	*         The variable names given to the DBO::execute statement must match the fieldnames.
	*         NULL is used as unlimited while other empty values are not.
	*/
	public static function sqlRange($range, $extraDateEmptyCheck = false) {
		$fieldNames = array_keys($range);
		$beginName = $fieldNames[0];
		$endName = $fieldNames[1];
		$beginValue = $range[$beginName];
		$endValue = $range[$endName];

		// unlimited begin and end value
		if ($beginValue === null && $endValue === null) {
			return "1";   // WHERE 1 is always true
		}

		$stmt = "";
		// if beginvalue is null we do not check this
		// collect all db records out of range
		// that means: where endvalue is set (not null) and less than wanted begin value
		if ($beginValue !== null) {
			$stmt .= "($endName < :$beginName AND $endName IS NOT NULL";
			if ($extraDateEmptyCheck) {
				$stmt .= " AND SUBSTR($endName, 1, 10) != '0000-00-00' AND TRIM($endName) != ''";
			}
			$stmt .= ")";
		}

		// if endvalue is null we do not check this
		// collect all db records out of range
		// that means: where beginvalue is set (not null) and greater than wanted end value
		if ($endValue !== null) {
			if ($stmt) {
				$stmt .= " OR";
			}
			$stmt .= " ($beginName > :$endName AND $beginName IS NOT NULL";
			if ($extraDateEmptyCheck) {
				$stmt .= " AND SUBSTR($beginName, 1, 10) != '0000-00-00' AND TRIM($beginName) != ''";
			}
			$stmt .= ")";
		}

		// exclude collected values out of range
		$stmt = "NOT ($stmt)";
		return $stmt;
	}  // eo create sql range fragment


}  // end of class

?>
