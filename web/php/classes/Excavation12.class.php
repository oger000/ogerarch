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
*/
class Excavation12 extends DbRec {

	public static $tableName = "excavation";

	const EXCAVMETHODID_STRATUM = 'STRATUM';
	const EXCAVMETHODID_PLANUM = 'PLANUM';


	/**
	* Get SELECT template.
	*/
	public static function getSqlTpl($target, &$opts = array()) {

		$listDelim = ExcavHelper::$xidDelimiterOut;


		$seleBeginDate =
			"(CASE " .
			"  WHEN SUBSTRING(beginDate, 1, 4 ) = '0000' THEN '' " .
			"  ELSE beginDate " .
			"END)";

		$seleExcavMethodName =
			"(CASE excavation.excavMethodId " .
			"  WHEN '" . static::EXCAVMETHODID_STRATUM . "' THEN '" . Oger::_('Stratum') . "'" .
			"  WHEN '" . static::EXCAVMETHODID_PLANUM  . "' THEN '" . Oger::_('Planum') . "'" .
			"  ELSE '?' " .
			" END)";

		$seleArchFindCount =
			"(SELECT COUNT(*) FROM archFind WHERE archFind.excavId=excavation.id)";
		$seleStratumCount =
			"(SELECT COUNT(*) FROM stratum WHERE stratum.excavId=excavation.id)";
		$seleArchObjectCount =
			"(SELECT COUNT(*) FROM archObject WHERE archObject.excavId=excavation.id)";
		$seleArchObjGroupCount =
			"(SELECT COUNT(*) FROM archObjGroup WHERE archObjGroup.excavId=excavation.id)";
		$selePrepFindCount =
			"(SELECT COUNT(*) FROM prepFindTMPNEW WHERE prepFindTMPNEW.excavId=excavation.id)";


		$seleOverwriteCols =
			"(CASE WHEN SUBSTR(excavation.beginDate, 1, 10)='0000-00-00' THEN '' ELSE excavation.beginDate END) AS beginDate," .
			"(CASE WHEN SUBSTR(excavation.endDate, 1, 10)='0000-00-00' THEN '' ELSE excavation.endDate END) AS endDate" .
			"";


		$seleExtraCols =
			" {$seleExcavMethodName} AS excavMethodName" .
			"";

		$seleExtraGridCols =
			" {$seleArchFindCount} AS archFindCount" .
			",{$seleStratumCount} AS stratumCount" .
			",{$seleArchObjectCount} AS archObjectCount" .
			",{$seleArchObjGroupCount} AS archObjGroupCount" .
			",{$selePrepFindCount} AS prepFindCount" .
			"";



		$seleJoins = "";

		$seleFrom = "" .
			"FROM excavation " .
			" $seleJoins ";


		$extjsWhere .=
			" (inactive=0 OR :?showInactive inactive!=0)" .
			" AND NOT (" .
					" (YEAR(endDate) < :@filterYear AND :?@filterYear YEAR(endDate) > 0)" .
					" OR" .
					" (YEAR(beginDate) > :@filterYear AND :?@filterYear YEAR(beginDate) > 0)" .
			 ")" .
			" AND (name LIKE :@searchText" .
				" OR authorizedPerson LIKE :@searchText" .
				" OR originator LIKE :@searchText" .
				" OR officialId LIKE :@searchText" .
				" OR officialId2 LIKE :@searchText" .
				" OR countryName LIKE :@searchText" .
				" OR regionName LIKE :@searchText" .
				" OR districtName LIKE :@searchText" .
				" OR communeName LIKE :@searchText" .
				" OR cadastralCommunityName LIKE :@searchText" .
				" OR fieldName LIKE :@searchText" .
				" OR plotName LIKE :@searchText" .
				" OR comment LIKE :@searchText" .
				" OR id LIKE :@searchText" .
			")";


		$extjsOrder =
			"=name; " .
			//     "archFindCount=CAST(archFindCount AS SIGNED); " .
			"id;" .
			"name;" .
			"excavMethodId;" .
			"beginDate;" .
			"endDate;" .
			"authorizedPerson;" .
			"originator;" .
			"officialId;" .
			"officialId2;" .
			"countryName;" .
			"regionName;" .
			"districtName;" .
			"communeName;" .
			"cadastralCommunityName;" .
			"fieldName;" .
			"plotName;" .
			"datingSpec;" .
			"datingPeriodId;" .
			"gpsX;" .
			"gpsY;" .
			"gpsZ;" .
			"comment;" .
			"archFindCount;" .
			"stratumCount;" .
			"archStratumCount;" .
			"archObjectCount;" .
			"archObjGroupCount=;" .
			"prepFindCount;" .
			"";


		// ######


		if ($target == "DEFAULT") {
			return "SELECT * FROM excavation ";
		}

		if ($target == "GRIDCOUNT") {
			return
				"SELECT COUNT(*) AS recordCount " .
				"{$seleFrom} " .
				"{WHERE $extjsWhere}";
		}


		if ($target == "GRID") {
			return
				"SELECT *,{$seleExtraCols},{$seleExtraGridCols},{$seleOverwriteCols} " .
				"{$seleFrom} " .
				"{WHERE $extjsWhere}" .
				"{ORDER BY $extjsOrder} " .
				"__EXTJS_LIMIT__";
		}

		if ($target == "FORM") {
			return
				"SELECT *,{$seleExtraCols},{$seleOverwriteCols} " .
				"{$seleFrom} " .
				"{WHERE id=:!id}";
		}


		// for next/prev we need name + id to create uniq sort, otherwise
		// multiple excavs with same name and random id make problems
		$jumpBaseCol = "CONCAT(RPAD(name,500,' '),trim(id))";
		$jumpSql =
			"SELECT *,{$seleExtraCols},{$seleOverwriteCols} " .
			"{$seleFrom} " .
			"{WHERE $jumpBaseCol {__DIRSIGN__} (SELECT $jumpBaseCol FROM excavation WHERE id=:!id) {__FILTER__}} " .
			"ORDER BY $jumpBaseCol {__DIR__} " .
			"__EXTJS_LIMIT__";

		if ($target == "FORM-OFFSET-PREV") {
			$jumpSql = str_replace("{__DIRSIGN__}", "<", $jumpSql);
			$jumpSql = str_replace("{__DIR__}", "DESC", $jumpSql);
			$jumpSql = str_replace("{__FILTER__}", "", $jumpSql);
			return $jumpSql;
		}
		if ($target == "FORM-OFFSET-NEXT") {
			$jumpSql = str_replace("{__DIRSIGN__}", ">", $jumpSql);
			$jumpSql = str_replace("{__DIR__}", "ASC", $jumpSql);
			$jumpSql = str_replace("{__FILTER__}", "", $jumpSql);
			return $jumpSql;
		}
		if ($target == "FORM-OFFSET-PREV-FILTER") {
			$jumpSql = str_replace("{__DIRSIGN__}", "<", $jumpSql);
			$jumpSql = str_replace("{__DIR__}", "DESC", $jumpSql);
			$jumpSql = str_replace("{__FILTER__}", "AND $extjsWhere", $jumpSql);
			return $jumpSql;
		}
		if ($target == "FORM-OFFSET-NEXT-FILTER") {
			$jumpSql = str_replace("{__DIRSIGN__}", ">", $jumpSql);
			$jumpSql = str_replace("{__DIR__}", "ASC", $jumpSql);
			$jumpSql = str_replace("{__FILTER__}", "AND $extjsWhere", $jumpSql);
			return $jumpSql;
		}


		throw new Exception("Invalid id $target for sql template.");
	}  // eo get select template




	/**
	* Store input
	*/
	public static function storeInput($values, $dbAction, $opts = array()) {

		// check for required fields
		if (!$values['name']) {
			throw new Exception(Oger::_("Name der Grabung fehlt."));
		}
		if (!$values['excavMethodId']) {
			throw new Exception(Oger::_("Grabungsmethode fehlt."));
		}


		// construct new id for insert
		if ($dbAction == "INSERT") {
			$values['id'] = Dbw::fetchValue1("SELECT MAX(id) FROM excavation") + 1;
		}

		// check for unchanged excavMethodId (if there was already an method on old record)
		if ($dbAction == "UPDATE") {
			$oldValues = Dbw::fetchRow1(static::getSql("FORM"), array('id' => $values['id']));
			if ($values['excavMethodId'] != $oldValues['excavMethodId']) {
				// allow change only if forceExcavMethodChange is set
				if (!$values['forceExcavMethodChange']) {
					throw new Exception(Oger::_("Grabungsmethode kann nur mit Extraparameter geändert werden."));
				}
			}
		}

		// on check-only return here
		if ($opts['checkOnly']) {
			return;
		}


		static::store($dbAction, $values, array('id' => $values['id']));
		return Dbw::fetchRow1(static::getSql("FORM"), array('id' => $values['id']));
	}  // eo store input



}  // end of class



?>
