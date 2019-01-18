<?PHP
/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/



/*
* --> Handling of conflicting and otherwise unlucky field naming:
* field -> sql alias in stratum-joins -> form (=> export = same as field without table name)
*
* deposit.orientation  -> DEPOSIT___orientation  -> DEPOSIT___orientation  (=> orientation)
* skeleton.orientation -> SKELETON___orientation -> SKELETON___orientation (=> orientation)
* timber.orientation   -> TIMBER___orientation   -> TIMBER___orientation   (=> orientation)
*
* wall.relationDescription   -> WALL___relationDescription    -> WALL___relationDescription    (=> relationDescription)
* timber.relationDescription -> TIMBER___.relationDescription -> TIMBER___.relationDescription (=> relationDescription)
*
* wall.lengthApplyTo   -> WALL___lengthApplyTo   (=> lengthApplyTo)
* timber.lengthApplyTo -> TIMBER___lengthApplyTo (=> lengthApplyTo)
*
* wall.widthApplyTo   -> WALL___widthApplyTo   -> widthApplyTo (=> widthApplyTo)
* timber.widthApplyTo -> TIMBER___widthApplyTo -> widthApplyTo (=> widthApplyTo)
*
*/

/**
* Stratum. Common part.
* CONVENTION: Substratums must have the same id to make this class working correct!
**/
class Stratum12 extends DbRec {

	public static $tableName = "stratum";




	/**
	* Get select template.
	*/
	public static function getSqlTpl($target, &$opts = array()) {

		$listDelim = ExcavHelper::$xidDelimiterOut;

		$stratumCategories = StratumCategory12::getRecArray();
		$seleCategoryName =
			"(CASE stratum.categoryId ".
			"  WHEN '" . StratumCategory12::ID_INTERFACE . "' THEN '" . $stratumCategories[StratumCategory12::ID_INTERFACE]['name'] . "'" .
			"  WHEN '" . StratumCategory12::ID_DEPOSIT . "' THEN '" . $stratumCategories[StratumCategory12::ID_DEPOSIT]['name'] . "'" .
			"  WHEN '" . StratumCategory12::ID_SKELETON . "' THEN '" . $stratumCategories[StratumCategory12::ID_SKELETON]['name'] . "'" .
			"  WHEN '" . StratumCategory12::ID_WALL . "' THEN '" . $stratumCategories[StratumCategory12::ID_WALL]['name'] . "'" .
			"  WHEN '" . StratumCategory12::ID_TIMBER . "' THEN '" . $stratumCategories[StratumCategory12::ID_TIMBER]['name'] . "'" .
			"  ELSE '?' " .
			" END)";

		$seleExcavName =
			"(SELECT name " .
			" FROM excavation AS ex " .
			" WHERE ex.id=stratum.excavId " .
			")";

		// TODO typename and typecode should go into a outer joined subquery ???
		$seleTypeName =
			"COALESCE(" .
			"  (SELECT name " .
			"   FROM stratumType AS stType " .
			"   WHERE stType.id=stratum.typeId), " .
			"  stratum.typeId " .
			")";
		$seleTypeCode =
			"COALESCE(" .
			"  (SELECT code " .
			"   FROM stratumType AS stType " .
			"   WHERE stType.id=stratum.typeId), " .
			"  '' " .
			")";


		// matrix

		$seleEarlierThanIdList =
			"COALESCE (" .
			"(SELECT GROUP_CONCAT(stratum2Id ORDER BY CAST(stratum2Id AS UNSIGNED) SEPARATOR '{$listDelim}') " .
			" FROM stratumMatrix as stMtrx " .
			" WHERE stMtrx.excavId=stratum.excavId AND stMtrx.stratumId=stratum.stratumId AND " .
			"       stMtrx.relation='" . StratumMatrix12::THIS_IS_EARLIER_THAN . "' " .
			")" .
			",'')";

		$seleReverseEarlierThanIdList =  // aka later than id list
			"COALESCE (" .
			"(SELECT GROUP_CONCAT(stratumId ORDER BY CAST(stratumId AS UNSIGNED) SEPARATOR '{$listDelim}') " .
			" FROM stratumMatrix as stMtrx " .
			" WHERE stMtrx.excavId=stratum.excavId AND stMtrx.stratum2Id=stratum.stratumId AND " .
			"       stMtrx.relation='" . StratumMatrix12::THIS_IS_EARLIER_THAN . "' " .
			")" .
			",'')";

		$seleEqualToIdList =  // DISTINCT not necessary, because duplicates should be handled by store-to-db
		/* --- FIRST ATTEMPT
		 * This does not work in mysql because of (bug?) #8019, #63501
		 * see <http://bugs.mysql.com/bug.php?id=8019>
			"(SELECT GROUP_CONCAT(m.stratumId0 ORDER BY CAST(m.stratumId0 AS UNSIGNED) SEPARATOR '{$listDelim}') " .
			" FROM (SELECT stratum2Id AS stratumId0" .
			"       FROM stratumMatrix as stMtrx " .
			"       WHERE stMtrx.excavId=stratum.excavId AND " .
			"             stMtrx.stratumId=stratum.stratumId AND " .
			"             stMtrx.relation='" . StratumMatrix12::THIS_IS_EQUAL_TO . "' " .
			"       UNION SELECT stratumId " .
			"       FROM stratumMatrix as stMtrx " .
			"       WHERE stMtrx.excavId=stratum.excavId AND " .
			"             stMtrx.stratum2Id=stratum.stratumId AND " .
			"             stMtrx.relation='" . StratumMatrix12::THIS_IS_EQUAL_TO . "' " .
			"      ) AS m " .
			")";
			*/
			// --- SECOND ATTEMPT
			// final sort of concat_ws result not possible - has to be done in php
			"COALESCE (" .
			"CONCAT_WS('{$listDelim}', " .
			"  (SELECT GROUP_CONCAT(stratum2Id) " .
			"   FROM stratumMatrix as stMtrx " .
			"   WHERE stMtrx.excavId=stratum.excavId AND " .
			"         stMtrx.stratumId=stratum.stratumId AND " .
			"         stMtrx.relation='" . StratumMatrix12::THIS_IS_EQUAL_TO . "') " .
			"  , " .
			"  (SELECT GROUP_CONCAT(stratumId) " .
			"   FROM stratumMatrix as stMtrx " .
			"   WHERE stMtrx.excavId=stratum.excavId AND " .
			"         stMtrx.stratum2Id=stratum.stratumId AND " .
			"         stMtrx.relation='" . StratumMatrix12::THIS_IS_EQUAL_TO . "') " .
			")" .
			",'')";
			/* --- THIRD ATTEMPT
			 * does not work because CONCAT_WS does not accept multiple rows
			"CONCAT_WS('{$listDelim}', " .
			"  (SELECT stratum2Id FROM stratumMatrix as stMtrx " .
			"   WHERE stMtrx.excavId=stratum.excavId AND " .
			"         stMtrx.stratumId=stratum.stratumId AND " .
			"         stMtrx.relation='" . StratumMatrix12::THIS_IS_EQUAL_TO . "' " .
			"   UNION " .
			"   SELECT stratumId FROM stratumMatrix as stMtrx " .
			"   WHERE stMtrx.excavId=stratum.excavId AND " .
			"         stMtrx.stratum2Id=stratum.stratumId AND " .
			"         stMtrx.relation='" . StratumMatrix12::THIS_IS_EQUAL_TO . "' " .
			"  ) " .
			")";
			*/

		$seleContempWithIdList =  // DISTINCT not necessary, because duplicates should be handled by store-to-db
			// note on first attempt see at seleEqualToIdList
			// final sort of concat_ws result not possible - has to be done in php
			"COALESCE (" .
			"CONCAT_WS('{$listDelim}', " .
			"  (SELECT GROUP_CONCAT(stratum2Id) " .
			"   FROM stratumMatrix as stMtrx " .
			"   WHERE stMtrx.excavId=stratum.excavId AND " .
			"         stMtrx.stratumId=stratum.stratumId AND " .
			"         stMtrx.relation='" . StratumMatrix12::THIS_IS_CONTEMP_WITH . "') " .
			"  , " .
			"  (SELECT GROUP_CONCAT(stratumId) " .
			"   FROM stratumMatrix as stMtrx " .
			"   WHERE stMtrx.excavId=stratum.excavId AND " .
			"         stMtrx.stratum2Id=stratum.stratumId AND " .
			"         stMtrx.relation='" . StratumMatrix12::THIS_IS_CONTEMP_WITH . "') " .
			")" .
			",'')";

		// matrix collection

		$seleMatrixCols =
			" {$seleEarlierThanIdList} AS earlierThanIdList\n" .
			",{$seleReverseEarlierThanIdList} AS reverseEarlierThanIdList\n" .
			",{$seleEqualToIdList} AS equalToIdList\n" .
			",{$seleContempWithIdList} AS contempWithIdList\n" .
			"";


		// common joins

		$seleArchFindIdList =
			"COALESCE ( " .
			"(SELECT GROUP_CONCAT(archFindId ORDER BY CAST(archFindId AS UNSIGNED) SEPARATOR '{$listDelim}') " .
			"  FROM stratumToArchFind AS stToAf " .
			"  WHERE stToAf.excavId=stratum.excavId AND stToAf.stratumId=stratum.stratumId " .
			")" .
			",'')";

		$seleArchObjectIdList =
			"COALESCE ( " .
			"(SELECT GROUP_CONCAT(archObjectId ORDER BY CAST(archObjectId AS UNSIGNED) SEPARATOR '{$listDelim}') " .
			"  FROM archObjectToStratum AS objToSt " .
			"  WHERE objToSt.excavId=stratum.excavId AND objToSt.stratumId=stratum.stratumId " .
			")" .
			",'')";


		// overwrites (format or restore cols - php use last occurance)

		$seleOverwriteCols =
			" stratum.id AS id" .
			",stratum.excavId AS excavId" .
			",stratum.stratumId AS stratumId" .
			",(CASE WHEN SUBSTR(stratum.date, 1, 10)='0000-00-00' THEN '' ELSE stratum.date END) AS date" .
			",stDepo.orientation AS DEPOSIT___orientation" .
			",stSkel.orientation AS SKELETON___orientation" .
			",stTimb.orientation AS TIMBER___orientation" .
			",stTimb.relationDescription AS TIMBER___relationDescription" .
			",stWall.relationDescription AS WALL___relationDescription" .
			",stTimb.lengthApplyTo AS TIMBER___lengthApplyTo" .
			",stWall.lengthApplyTo AS WALL___lengthApplyTo" .
			",stTimb.widthApplyTo AS TIMBER___widthApplyTo" .
			",stWall.widthApplyTo AS WALL___widthApplyTo" .
			"";

		$seleExtraCols =
			" {$seleExcavName} AS excavName\n" .
			",{$seleCategoryName} AS categoryName\n" .
			",{$seleTypeName} AS typeName\n" .
			",{$seleTypeCode} AS typeCode\n" .                  // export only
			",{$seleArchFindIdList} AS archFindIdList\n" .
			",{$seleArchObjectIdList} AS archObjectIdList\n" .
			"";


		$seleJoins =
			"LEFT OUTER JOIN stratumInterface AS stIntf " .
			"  ON stIntf.excavId=stratum.excavId " .
			"     AND stIntf.stratumId=stratum.stratumId " .
			"LEFT OUTER JOIN stratumDeposit AS stDepo " .
			"  ON stDepo.excavId=stratum.excavId " .
			"     AND stDepo.stratumId=stratum.stratumId " .
			"LEFT OUTER JOIN stratumSkeleton AS stSkel " .
			"  ON stSkel.excavId=stratum.excavId " .
			"     AND stSkel.stratumId=stratum.stratumId " .
			"LEFT OUTER JOIN stratumWall AS stWall " .
			"  ON stWall.excavId=stratum.excavId " .
			"     AND stWall.stratumId=stratum.stratumId " .
			"LEFT OUTER JOIN stratumTimber AS stTimb " .
			"  ON stTimb.excavId=stratum.excavId " .
			"     AND stTimb.stratumId=stratum.stratumId ";

		$seleFrom = "" .
			"\n" .
			"FROM stratum " .
			" $seleJoins ";


		$extjsWhere .=
			"(stratum.interpretation LIKE :@searchText" .
			" OR {$seleTypeName} LIKE :@searchText" .
			" OR datingSpec LIKE :@searchText" .
			" OR pictureReference LIKE :@searchText" .
			" OR comment LIKE :@searchText" .
			" OR listComment LIKE :@searchText" .
			")" .
			" AND categoryId=:@filterCategoryId " .

			" AND stratumIdSort >=:@stratumBeginId " .
			" AND stratumIdSort <=:@stratumEndId " .
			" AND stratumIdSort >=:@beginId " .
			" AND stratumIdSort <=:@endId " .
			" AND date >=:@beginDate " .
			" AND date <=:@endDate " .
			"";


		$extjsOrder =
			"=stratum.stratumIdSort; " .
			"stratumId=; ";


		// ######


		if ($target == "DEFAULT") {
			return "SELECT * FROM stratum ";
		}

		if ($target == "GRIDCOUNT") {
			return "SELECT COUNT(*) AS recordCount " .
						 "{$seleFrom} " .
						 "{WHERE stratum.excavId=:!excavId AND $extjsWhere}";
		}

		if ($target == "GRID" || $target == "EXPORT") {
			return
				"SELECT *,{$seleExtraCols},{$seleMatrixCols},{$seleOverwriteCols} " .
				"{$seleFrom} " .
				"{WHERE stratum.excavId=:!excavId AND $extjsWhere} " .
				"{ORDER BY $extjsOrder} " .
				"__EXTJS_LIMIT__";
		}

		if ($target == "FORM") {
			return
				"SELECT *,{$seleExtraCols},{$seleMatrixCols},{$seleOverwriteCols} " .
				"{$seleFrom} " .
				"{WHERE stratum.excavId=:!excavId AND stratum.stratumId=:!stratumId} ";
		}


		if ($target == "FORM-OFFSET-NEXT") {
			return
				"SELECT *,{$seleExtraCols},{$seleMatrixCols},{$seleOverwriteCols} " .
				"{$seleFrom} " .
				"{WHERE stratum.excavId=:!excavId AND stratum.stratumIdSort > :!stratumIdSort} " .
				"{ORDER BY $extjsOrder} " .  // overwritten in calling script
				"__EXTJS_LIMIT__";
		}
		if ($target == "FORM-OFFSET-PREV") {
			return
				"SELECT *,{$seleExtraCols},{$seleMatrixCols},{$seleOverwriteCols} " .
				"{$seleFrom} " .
				"{WHERE stratum.excavId=:!excavId AND stratum.stratumIdSort < :!stratumIdSort} " .
				"{ORDER BY $extjsOrder} " .  // overwritten in calling script
				"__EXTJS_LIMIT__";
		}
		if ($target == "FORM-OFFSET-NEXT-FILTER") {
			return
				"SELECT *,{$seleExtraCols},{$seleMatrixCols},{$seleOverwriteCols} " .
				"{$seleFrom} " .
				"{WHERE stratum.excavId=:!excavId AND stratum.stratumIdSort > :!stratumIdSort AND $extjsWhere} " .
				"{ORDER BY $extjsOrder} " .  // overwritten in calling script
				"__EXTJS_LIMIT__";
		}
		if ($target == "FORM-OFFSET-PREV-FILTER") {
			return
				"SELECT *,{$seleExtraCols},{$seleMatrixCols},{$seleOverwriteCols} " .
				"{$seleFrom} " .
				"{WHERE stratum.excavId=:!excavId AND stratum.stratumIdSort < :!stratumIdSort AND $extjsWhere} " .
				"{ORDER BY $extjsOrder} " .  // overwritten in calling script
				"__EXTJS_LIMIT__";
		}

		throw new Exception("Invalid id $target for sql template.");
	}  // get select





	/**
	* Prepare for extjs (grid, form)
	*/
	public static function prep4Extjs($row) {

		// unify and resort id lists
		if (array_key_exists("equalToIdList", $row)) {
			$row['equalToIdList'] = ExcavHelper::multiXidPrepare($row['equalToIdList']);
		}
		if (array_key_exists("contempWithIdList", $row)) {
			$row['contempWithIdList'] = ExcavHelper::multiXidPrepare($row['contempWithIdList']);
		}

		// merge field aliases when only one field used in grid/form
		switch ($row['categoryId']) {
		case StratumCategory12::ID_INTERFACE:
			break;

		case StratumCategory12::ID_DEPOSIT:
			break;

		case StratumCategory12::ID_SKELETON:
			break;

		case StratumCategory12::ID_WALL:
			if (array_key_exists("WALL___lengthApplyTo", $row)) {
				$row['lengthApplyTo'] = $row['WALL___lengthApplyTo'];
				unset($row['WALL___lengthApplyTo']);
			}
			if (array_key_exists("WALL___widthApplyTo", $row)) {
				$row['widthApplyTo'] = $row['WALL___widthApplyTo'];
				unset($row['WALL___widthApplyTo']);
			}
			break;

		case StratumCategory12::ID_TIMBER:
			if (array_key_exists("TIMBER___lengthApplyTo", $row)) {
				$row['lengthApplyTo'] = $row['TIMBER___lengthApplyTo'];
				unset($row['TIMBER___lengthApplyTo']);
			}
			if (array_key_exists("TIMBER___widthApplyTo", $row)) {
				$row['widthApplyTo'] = $row['TIMBER___widthApplyTo'];
				unset($row['TIMBER___widthApplyTo']);
			}
			break;
		}

		// add indirect infos (contained in interface, interface contains, arch finds, arch obj groups

		return $row;
	}  // eo prep row for extjs


	/**
	* Add interface relations
	* - containsStratumIdList for interfaces and
	* - containedInInterfaceIdList for non-interfaces
	*/
	public static function addInterfaceRelations($row) {
		if ($row['categoryId'] == StratumCategory12::ID_INTERFACE || $row['hasAutoInterface']) {
			$row['containsStratumIdList'] =
				ExcavHelper::multiXidPrepare(static::getContainsStratumArray($row));
			if ($row['containedInInterfaceIdList'] === null) {
				$row['containedInInterfaceIdList'] = "";
			}
		}
		else {
			if ($row['containsStratumIdList'] === null) {
				$row['containsStratumIdList'] = "";
			}
			$row['containedInInterfaceIdList'] =
				ExcavHelper::multiXidPrepare(static::getContainedInInterfaceArray($row));
		}

		return $row;
	}



	/**
	* Prepare for export
	*/
	public static function prep4Export($row) {

		$listDelim = ExcavHelper::$xidDelimiterOut;

		$row = static::prep4Extjs($row);

		// add verbose ids for reports
		// hardcoded "," instead input-delimiter because only for pdf

		// arch object group list, arch object reference, arch object group reference

		$pstmtObj = Dbw::$conn->prepare(
			// TODO replace when ArchObject12 is working
			"SELECT *," .
			"  COALESCE((SELECT name FROM archObjectType AS objType WHERE objType.id=archObject.typeId),archObject.typeId) " .
			"    AS typeName, " .
			"  (SELECT GROUP_CONCAT(archObjGroupId ORDER BY CAST(archObjGroupId AS UNSIGNED) SEPARATOR '{$listDelim}') " .
			"   FROM archObjGroupToArchObject AS grpToObj " .
			"   WHERE grpToObj.excavId=archObject.excavId AND grpToObj.archObjectId=archObject.archObjectId " .
			"  ) " .
			"    AS archObjGroupId " .
			"FROM archObject WHERE excavId=:excavId AND archObjectId=:archObjectId"
		);
		$pstmtGrp = Dbw::$conn->prepare(
			// TODO replace when ArchObjGroup12 is working
			"SELECT *," .
			"  COALESCE((SELECT name FROM archObjGroupType AS objType WHERE objType.id=archObjGroup.typeId),archObjGroup.typeId) " .
			"    AS typeName, " .
			"FROM archObjGroup WHERE excavId=:excavId AND archObjGroupId=:archObjGroupId"
		);

		$tmpObjRef = "";
		$tmpGrpRef = "";
		$grpIds = array();

		$objIds = ExcavHelper::multiXidSplit($row['archObjectIdList']);
		foreach($objIds as $objId) {
			$pstmtObj->execute(array("excavId" => $row['excavId'], "archObjectId" => $objId));
			$objVals = $pstmtObj->fetch(PDO::FETCH_ASSOC);
			$tmpObjRef .= ($tmpObjRef ? ', ' : '') . $objVals['archObjectId'] . ' ' . $objVals['typeName'];
			$grpIds = array_merge($grpIds, ExcavHelper::multiXidSplit($objVals['archObjGroupIdList']));
		}
		$pstmtObj->closeCursor();

		$tmpGrpIdList = "";
		$grpIds = ExcavHelper::multiXidSplit(implode($listDelim, $grpIds));
		foreach ($grpIds as $grpId) {
			$pstmtGrp->execute(array("excavId" => $row['excavId'], "archObjGroupId" => $grpId));
			$grpVals = $pstmtGrp->fetch(PDO::FETCH_ASSOC);
			$tmpGrpRef .= ($tmpGrpRef ? ', ' : '') . $grpVals['archObjGroupId'] . ' ' . $grpVals['typeName'];
		}
		$pstmtGrp->closeCursor();

		$row['archObjectReferenceList'] = $tmpObjRef;
		$row['archObjGroupIdList'] = $tmpGrpIdList;
		$row['archObjGroupReferenceList'] = $tmpGrpRef;


		// -----------------------------------
		// skeleton - non-database info

		if ($row['categoryId'] == StratumCategory12::ID_SKELETON) {

			// --- skeleton

			$masterRec = SkeletonBodyPositionType12::getRecByKey($row['bodyPosition']);
			$row['bodyPositionName'] = ($masterRec['name'] ?: $row['bodyPosition']);
			$row['bodyPositionCode'] = $masterRec['code'];

			$masterRec = SkeletonArmPositionType12::getRecByKey($row['armPosition']);
			$row['armPositionName'] = ($masterRec['name'] ?: $row['armPosition']);
			$row['armPositionCode'] = $masterRec['code'];

			$masterRec = SkeletonLegPositionType12::getRecByKey($row['legPosition']);
			$row['legPositionName'] = ($masterRec['name'] ?: $row['legPosition']);
			$row['legPositionCode'] = $masterRec['code'];

			$masterRec = SkeletonBoneQualityType12::getRecByKey($row['boneQuality']);
			$row['boneQualityName'] = ($masterRec['name'] ?: $row['boneQuality']);
			$row['boneQualityCode'] = $masterRec['code'];

			// --- anthro

			$masterRec = SkeletonSexType12::getRecByKey($row['sex']);
			$row['sexName'] = ($masterRec['name'] ?: $row['sex']);
			$row['sexCode'] = $masterRec['code'];

			$masterRec = SkeletonSexType12::getRecByKey($row['gender']);
			$row['genderName'] = ($masterRec['name'] ?: $row['gender']);
			$row['genderCode'] = $masterRec['code'];

			$row['ageName'] = '';
			$row['ageCode'] = '';
			foreach (explode(',', $row['age']) as $ageId) {
				$masterRec = SkeletonAgeType12::getRecByKey($ageId);
				$row['ageName'] .= ($row['ageName'] ? ', ' : '') . ($masterRec['name'] ?: $ageId);
				$row['ageCode'] .= ($row['ageCode'] ? ',' : '') . $masterRec['code'];
			}

			// --- burial

			$masterRec = SkeletonBurialCremationType12::getRecByKey($row['burialCremationId']);
			$row['burialCremationName'] = ($masterRec['name'] ?: $row['burialCremationId']);
			$row['burialCremationIdCode'] = $masterRec['code'];

			// --- demage

			$masterRec = SkeletonTombDemageFormType12::getRecByKey($row['tombDemageFormId']);
			$row['tombDemageFormName'] = ($masterRec['name'] ?: $row['tombDemageFormId']);
			$row['tombDemageFormCode'] = $masterRec['code'];

		}  // eo skeleton


		// -----------------------------------
		// timber - non-database info

		if ($row['categoryId'] == StratumCategory12::ID_TIMBER) {

			$masterRec = WallSizeApplyToType12::getRecByKey($row['lengthApplyTo']);
			$row['lengthApplyToName'] = ($masterRec['name'] ?: $row['lengthApplyTo']);

			$masterRec = WallSizeApplyToType12::getRecByKey($row['widthApplyTo']);
			$row['widthApplyToName'] = ($masterRec['name'] ?: $row['widthApplyTo']);

			$masterRec = WallSizeApplyToType12::getRecByKey($row['heightApplyTo']);
			$row['heightApplyToName'] = ($masterRec['name'] ?: $row['heightApplyTo']);

		}  // eo timber


		// -----------------------------------
		// wall - non-database info

		if ($row['categoryId'] == StratumCategory12::ID_WALL) {

			$masterRec = WallConstructionType12::getRecByKey($row['constructionType']);
			$row['constructionTypeName'] = ($masterRec['name'] ?: $row['constructionType']);
			$row['constructionTypeCode'] = $masterRec['code'];

			$masterRec = WallBaseType12::getRecByKey($row['wallBaseType']);
			$row['wallBaseTypeName'] = ($masterRec['name'] ?: $row['wallBaseType']);
			$row['wallBaseTypeCode'] = $masterRec['code'];

			$masterRec = WallStructureType12::getRecByKey($row['structureType']);
			$row['structureTypeName'] = ($masterRec['name'] ?: $row['structureType']);
			$row['structureTypeCode'] = $masterRec['code'];

			$masterRec = WallMaterialType12::getRecByKey($row['materialType']);
			$row['materialTypeName'] = ($masterRec['name'] ?: $row['materialType']);
			$row['materialTypeCode'] = $masterRec['code'];

			$masterRec = WallBinderType12::getRecByKey($row['binderType']);
			$row['binderTypeName'] = ($masterRec['name'] ?: $row['binderType']);
			$row['binderTypeCode'] = $masterRec['code'];

			$masterRec = WallBinderState12::getRecByKey($row['binderState']);
			$row['binderStateName'] = ($masterRec['name'] ?: $row['binderState']);
			$row['binderStateCode'] = $masterRec['code'];

			$masterRec = WallBinderGrainSize12::getRecByKey($row['binderGrainSize']);
			$row['binderGrainSizeName'] = ($masterRec['name'] ?: $row['binderGrainSize']);
			$row['binderGrainSizeCode'] = $masterRec['code'];

			$masterRec = WallBinderConsistency12::getRecByKey($row['binderConsistency']);
			$row['binderConsistencyName'] = ($masterRec['name'] ?: $row['binderConsistency']);
			$row['binderConsistencyCode'] = $masterRec['code'];

			$masterRec = WallAbreuvoirType12::getRecByKey($row['abreuvoirType']);
			$row['abreuvoirTypeName'] = ($masterRec['name'] ?: $row['abreuvoirType']);
			$row['abreuvoirTypeCode'] = $masterRec['code'];

			$masterRec = WallPlasterSurface12::getRecByKey($row['plasterSurface']);
			$row['plasterSurfaceName'] = ($masterRec['name'] ?: $row['plasterSurface']);
			$row['plasterSurfaceCode'] = $masterRec['code'];

			// ---

			$masterRec = WallSizeApplyToType12::getRecByKey($row['lengthApplyTo']);
			$row['lengthApplyToName'] = ($masterRec['name'] ?: $row['lengthApplyTo']);

			$masterRec = WallSizeApplyToType12::getRecByKey($row['widthApplyTo']);
			$row['widthApplyToName'] = ($masterRec['name'] ?: $row['widthApplyTo']);

			$masterRec = WallSizeApplyToType12::getRecByKey($row['heightRaisingApplyTo']);
			$row['heightRaisingApplyToName'] = ($masterRec['name'] ?: $row['heightRaisingApplyTo']);

			$masterRec = WallSizeApplyToType12::getRecByKey($row['heightFootingApplyTo']);
			$row['heightFootingApplyToName'] = ($masterRec['name'] ?: $row['heightFootingApplyTo']);

		}  // eo wall


		// merge field aliases when only one field necessary for export
		switch ($row['categoryId']) {
		case StratumCategory12::ID_INTERFACE:
			break;

		case StratumCategory12::ID_DEPOSIT:
			if (array_key_exists("DEPOSIT___orientation", $row)) {
				$row['orientation'] = $row['DEPOSIT___orientation'];
				unset($row['DEPOSIT___orientation']);
			}
			break;

		case StratumCategory12::ID_SKELETON:
			if (array_key_exists("SKELETON___orientation", $row)) {
				$row['orientation'] = $row['SKELETON___orientation'];
				unset($row['SKELETON___orientation']);
			}
			break;

		case StratumCategory12::ID_WALL:
			if (array_key_exists("WALL___relationDescription", $row)) {
				$row['relationDescription'] = $row['WALL___relationDescription'];
				unset($row['WALL___relationDescription']);
			}
			break;

		case StratumCategory12::ID_TIMBER:
			if (array_key_exists("TIMBER___orientation", $row)) {
				$row['orientation'] = $row['TIMBER___orientation'];
				unset($row['TIMBER___orientation']);
			}
			if (array_key_exists("TIMBER___relationDescription", $row)) {
				$row['relationDescription'] = $row['TIMBER___relationDescription'];
				unset($row['TIMBER___relationDescription']);
			}
			break;
		}  // eo case category



		// -----------------------------------
		// for backward compatibility
		// field rename: tombOtherMaterialStratumId -> tombOtherMaterialStratumIdList
		// populate old name for import into old (field not renamed yet) databases

		$row['tombOtherMaterialStratumId'] = $row['tombOtherMaterialStratumIdList'];

		// -----------------------------------
		// DO NOT remove fields with NULL values here,
		// because we need for csv-export to have identical columns


		// remove internal values
		unset($row['id']);
		unset($row['stratumIdSort']);

		// -----------------------------------
		return $row;
	}  // eo prep row for export



	/**
	* Store input to db (including subtables)
	*/
	public static function storeInput($values, $dbAction, $opts = array()) {

		// autointerface setting does not make sense on an interface - so unset by default (or set to zero)
		if ($values['categoryId'] == StratumCategory12::ID_INTERFACE) {
			$values['hasAutoInterface'] = "0";
		}

		// precheck input
		$values['stratumId'] = trim($values['stratumId']);

		$errorMsg = ExcavHelper::xidValidErr($values['stratumId']);
		if ($errorMsg) {
			throw new Exception(Oger::_("Stratum-Nummer: ") . $errorMsg);
		}




		// create new
		$record = new self($values);

		// check for required fields
		if (!$values['excavId']) {
			throw new Exception(Oger::_("Interne ID der Grabung fehlt."));
		}
		if (!$values['stratumId']) {
			throw new Exception(Oger::_("Stratum-Nummer fehlt."));
		}
		if (!$values['categoryId']) {
			throw new Exception(Oger::_("Kategorieangabe fehlt."));
		}
		$categoryRecord = StratumCategory12::getRecByKey($values['categoryId']);
		if (!$categoryRecord) {
			throw new Exception(Oger::_("Ungültige Kategorieangabe {$values['categoryId']}."));
		}


		// we do not check matrix at input!!!

		// on check-only return here
		if ($opts['checkOnly']) {
			return;
		}



		$seleVals = array("excavId" => $values['excavId'], "stratumId" => $values['stratumId']);


		// check for existing entry and construct new id for insert
		if ($dbAction == "INSERT") {
			// insert of duplicate excavid/stratumid fails on uniq index, so do not check
			$values['id'] = Dbw::fetchValue1("SELECT MAX(id) FROM stratum") + 1;
		}


		// store main record
		$values['stratumIdSort'] = Oger::getNatSortId($values['stratumId']);
		static::store($dbAction, $values, $seleVals);

		// store sub stratum
		$dbActionSub = $dbAction;
		switch ($values['categoryId']) {
		case StratumCategory12::ID_INTERFACE:
			if ($dbAction == "UPDATE" &&
					Dbw::fetchValue1("SELECT COUNT(*) FROM stratumInterface ".
													 "WHERE excavId=:excavId AND stratumId=:stratumId",
													 $seleVals) == 0) {
				$dbActionSub = "INSERT";
			}
			$tmpPstmt = StratumInterface12::store($dbActionSub, $values, $seleVals);
			break;

		case StratumCategory12::ID_DEPOSIT:
			if ($dbAction == "UPDATE" &&
					Dbw::fetchValue1("SELECT COUNT(*) FROM stratumDeposit ".
													 "WHERE excavId=:excavId AND stratumId=:stratumId",
													 $seleVals) == 0) {
				$dbActionSub = "INSERT";
			}
			$tmpPstmt = StratumDeposit12::store($dbActionSub, $values, $seleVals);
			break;

		case StratumCategory12::ID_SKELETON:
			if ($dbAction == "UPDATE" &&
					Dbw::fetchValue1("SELECT COUNT(*) FROM stratumSkeleton ".
													 "WHERE excavId=:excavId AND stratumId=:stratumId",
													 $seleVals) == 0) {
				$dbActionSub = "INSERT";
			}
			$tmpPstmt = StratumSkeleton12::store($dbActionSub, $values, $seleVals);
			break;

		case StratumCategory12::ID_WALL:
			if ($dbAction == "UPDATE" &&
					Dbw::fetchValue1("SELECT COUNT(*) FROM stratumWall ".
													 "WHERE excavId=:excavId AND stratumId=:stratumId",
													 $seleVals) == 0) {
				$dbActionSub = "INSERT";
			}
			$tmpPstmt = StratumWall12::store($dbActionSub, $values, $seleVals);
			break;

		case StratumCategory12::ID_TIMBER:
			if ($dbAction == "UPDATE" &&
					Dbw::fetchValue1("SELECT COUNT(*) FROM stratumTimber ".
													 "WHERE excavId=:excavId AND stratumId=:stratumId",
													 $seleVals) == 0) {
				$dbActionSub = "INSERT";
			}
			$tmpPstmt = StratumTimber12::store($dbActionSub, $values, $seleVals);
			break;

		default:
			throw new Exception("Unbekannte Kategorie {$values['categoryId']}.");
		}  // eo category switch


		// if category is changed we have to delete the now obsolete substratum
		if ($values['oldCategoryId'] && $values['categoryId'] != $values['oldCategoryId']) {

			switch ($values['oldCategoryId']) {
			case StratumCategory12::ID_INTERFACE:
				$oldSubTable = StratumInterface12::$tableName;
				break;
			case StratumCategory12::ID_DEPOSIT:
				$oldSubTable = StratumDeposit12::$tableName;
				break;
			case StratumCategory12::ID_SKELETON:
				$oldSubTable = StratumSkeleton12::$tableName;
				break;
			case StratumCategory12::ID_WALL:
				$oldSubTable = StratumWall12::$tableName;
				break;
			case StratumCategory12::ID_TIMBER:
				$oldSubTable = StratumTimber12::$tableName;
				break;
			default:
				throw new Exception("Unbekannte Kategorie {$values['categoryId']}.");
			}

			$pstmt = Dbw::$conn->prepare("DELETE FROM {$oldSubTable} WHERE excavId=:excavId AND stratumId=:stratumId");
			$pstmt->execute($seleVals);
			$pstmt->closeCursor();
		}  // eo delete old sub stratum after change category






		// if remove not forced we fake an insert for the reference tables
		$dbAction2 = $dbAction;
		if (!$opts['removeRefs']) {
			$dbAction2 = "INSERT";
		}


		// matrix info
		StratumMatrix12::storeEarlierThan(
			$values['excavId'], $values['stratumId'], $values['earlierThanIdList'], $dbAction2);
		StratumMatrix12::storeReverseEarlierThan(
			$values['excavId'], $values['stratumId'], $values['reverseEarlierThanIdList'], $dbAction2);
		StratumMatrix12::storeEqualTo(
			$values['excavId'], $values['stratumId'], $values['equalToIdList'], $dbAction2);
		StratumMatrix12::storeContempWith(
			$values['excavId'], $values['stratumId'], $values['contempWithIdList'], $dbAction2);


		// store arch find ids and arch object ids
		$warnMsg .= StratumToArchFind12::storeArchFindIds(
			$values['excavId'], $values['stratumId'],$values['archFindIdList'], $dbAction2);
		ArchObjectToStratum12::storeArchObjectIds(
			$values['excavId'], $values['stratumId'], $values['archObjectIdList'], $dbAction2);

		// reply with core ids, but add warn message
		if ($warnMsg) {
			$seleVals['_warnMsg'] = "Stratum erfolgreich gespeichert, aber:<br>" . $warnMsg;
		}

		return $seleVals;
	}  // eo save input




	/*
	* Get interfaces for this stratum
	* @param $prevChain Contains the chain back to the starting node to avoid cycles.
	*/
	public static function getContainedInInterfaceArray($row, $prevChain = array(), &$nodeList = array(), $opts = array()) {

		// abort if more than x nodes - because it is only a extrainfo for now
		$countLimit = 100;
		if ($opts['getAll']) {
			$countLimit = 10000;  // sanity limit should never be exeeded
		}
		// if count exeeds limit then set a "more" mark
		if (count($nodeList) > $countLimit) {
			$nodeList[] = "~...";
			return $nodeList;
		}

		// we reached an interface, so we can stop here
		if ($row['categoryId'] == StratumCategory12::ID_INTERFACE || $row['hasAutoInterface']) {
			$nodeList[$row['stratumId']] = $row['stratumId'];
			return $nodeList;
		}

		$nextStratumIds = array();
		$pstmtNextStratumIds =
			Dbw::$conn->prepare("SELECT * FROM stratumMatrix " .
				"WHERE excavId=:excavId AND stratum2Id=:stratumId AND relation=:relation");
		$pstmtNextStratumIds->execute(array("excavId" => $row['excavId'], "stratumId" => $row['stratumId'],
			"relation" => StratumMatrix12::THIS_IS_EARLIER_THAN));
		while ($rowMatrix = $pstmtNextStratumIds->fetch(PDO::FETCH_ASSOC)) {
			$nextStratumIds[] = $rowMatrix['stratumId'];
		}
		$pstmtNextStratumIds->closeCursor();

		// iterate over the next stratums in this direction
		$prevChain[$row['stratumId']] = $row['stratumId'];
		foreach ($nextStratumIds as $nextStratumId) {

			// check for cycle or already in nodelist
			if ($prevChain[$nextStratumId] || $nodeList[$nextStratumId]) {
				continue;
			}

			$nextRow = Dbw::fetchRow1("SELECT * FROM stratum WHERE excavId=:excavId AND stratumId=:stratumId",
																array("excavId" => $row['excavId'], "stratumId" => $nextStratumId));
			static::getContainedInInterfaceArray($nextRow, $prevChain, $nodeList, $opts);
		}  // eo loop over next nodes

		return $nodeList;
	}  // eo get interface array



	/*
	* Get stratums contained in interface of this stratum
	* @param $prevChain Contains the chain back to the starting node to avoid cycles.
	*/
	public static function getContainsStratumArray($row, $prevChain = array(), &$nodeList = array(), $opts = array()) {

		// abort if more than x nodes - because it is only a extrainfo for now
		// and set "more" mark
		if (count($nodeList) > 100) {
			$nodeList[] = "~...";
			return $nodeList;
		}


		// if prev chain is not empty (so we are not at the starting stratum)
		// and we reach another interface, then we stop
		if (count($prevChain) > 0 &&
				($row['categoryId'] == StratumCategory12::ID_INTERFACE || $row['hasAutoInterface'])
			 ) {
			return $nodeList;
		}


		// all non-interfaces and FRIST hasAutoInterface are collected
		// if the first stratum is an interface we skip this too and
		// later interfaces will not reach this point, because we return before
		if ($row['categoryId'] != StratumCategory12::ID_INTERFACE) {
			$nodeList[$row['stratumId']] = $row['stratumId'];
		}

		$nextStratumIds = array();
		$pstmtNextStratumIds =
			Dbw::$conn->prepare("SELECT * FROM stratumMatrix " .
				"WHERE excavId=:excavId AND stratumId=:stratumId AND relation=:relation");
		$pstmtNextStratumIds->execute(array("excavId" => $row['excavId'], "stratumId" => $row['stratumId'],
			"relation" => StratumMatrix12::THIS_IS_EARLIER_THAN));
		while ($rowMatrix = $pstmtNextStratumIds->fetch(PDO::FETCH_ASSOC)) {
			$nextStratumIds[] = $rowMatrix['stratum2Id'];
		}
		$pstmtNextStratumIds->closeCursor();


		// iterate over the next stratums in this direction
		$prevChain[$row['stratumId']] = $row['stratumId'];
		foreach ($nextStratumIds as $nextStratumId) {

			// check for cycle or already in nodelist
			if ($prevChain[$nextStratumId] || $nodeList[$nextStratumId]) {
				continue;
			}

			$nextRow = Dbw::fetchRow1("SELECT * FROM stratum WHERE excavId=:excavId AND stratumId=:stratumId",
																array("excavId" => $row['excavId'], "stratumId" => $nextStratumId));
			static::getContainsStratumArray($nextRow, $prevChain, $nodeList, $opts);
		}  // eo loop over next nodes

		return $nodeList;
	}  // eo get stratum array contained in interface



}  // end of class



?>
