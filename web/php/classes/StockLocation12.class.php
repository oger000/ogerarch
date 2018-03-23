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
 * memo:
 *
 * outerId ( = implicit parentId on ext tree)
 *  fixed values:
 *  negative values are system defaults
 *  0 = unused (or only as pseudo-outer-id of the root item)
 *  1 = root id
 *  positive values are created by user input
 */


/**
* Stock location
**/
class StockLocation12 extends DbRec {

	public static $tableName = "stockLocation";

	const ROOT_ID = "1";

	const MOVABLE_YES = 1;
	const REUSABLE_YES = 1;

	CONST REUSABLES_EXCAV_ID = null;
	CONST REUSABLES_EXCAV_MARKER = -1;



	/**
	* Get select template.
	*/
	public static function getSqlTpl($target, &$opts = array()) {

		$listDelim = ExcavHelper::$xidDelimiterOut;
		$movableYes = static::MOVABLE_YES;
		$reusableYes = static::REUSABLE_YES;
		$tableName = static::$tableName;


		$seleOuterName =
			"(SELECT name FROM stockLocation AS stl2 " .
			" WHERE stl2.stockLocationId=stockLocation.outerId " .
			")";

		$seleSizeClass =
			"(SELECT sizeClass FROM stockLocationType AS slt " .
			" WHERE slt.id=stockLocation.typeId " .
			")";

		$seleMaxInnerSizeClass =
			"(SELECT sizeClass FROM stockLocationType AS slt " .
			" WHERE slt.id=stockLocation.maxInnerTypeId " .
			")";

		$seleArchFindCount =
			"(SELECT COUNT(*) FROM prepFindTMPNEW AS PF " .
			" WHERE PF.stockLocationId=stockLocation.stockLocationId " .
			")";


		$seleExtraCols =
			" {$seleOuterName} AS outerName" .
			",{$seleSizeClass} AS sizeClass" .
			",{$seleMaxInnerSizeClass} AS maxInnerSizeClass" .
			",{$seleArchFindCount} AS archFindCount" .
			"";


		$extjsOrder =
			"=name; " .
			"";


		// ######


		if ($target == "GRIDCOUNT") {
			return "SELECT COUNT(*) AS recordCount " .
						 "FROM {$tableName} " .
						 "";
		}

		if ($target == "GRID") {
			return
				"SELECT *,{$seleExtraCols} " .
				"FROM {$tableName} " .
				"{ORDER BY $extjsOrder} " .
				"__EXTJS_LIMIT__";
		}


		if ($target == "FULLTREE") {
			return
				"SELECT *,{$seleExtraCols} " .
				"FROM {$tableName} " .
				"";
		}


		if ($target == "FORM") {
			return
				"SELECT *,{$seleExtraCols} " .
				"FROM {$tableName} " .
				"{WHERE stockLocationId=:!stockLocationId} " .
				"";
		}

		if ($target == "REUSABLES") {
			return
				"SELECT *,{$seleExtraCols} " .
				"FROM {$tableName} " .
				"{WHERE reusable='" . static::REUSABLE_YES . "'} " .
				"";
		}


		if ($target == "EXCAVSTOCKTREE") {
			return
				"SELECT stockLocation.* " .
				" FROM {$tableName} " .
				" {WHERE excavId=:!excavId}" .
				"";
		}


		if ($target == "EXTRACOLSONLY") {
			return $seleExtraCols;
		}




		throw new Exception("Invalid id $target for sql template.");
	}  // get select





	/**
	* Prepare for extjs (grid, form)
	*/
	public static function prep4Extjs($row) {

		//$outerRow = Dbw::fetchRow1(
		//  "SELECT * FROM stockLocation WHERE stockLocationId=:stockLocationId",
		//  array("stockLocationId" => $row['outerId']));
		//$row['outerName'] = $outerRow['name'];

		return $row;
	}  // eo prep row for extjs



	/**
	* Create initial records (stock location tree root setting)
	* ATTENTION contains hardcoded ids !!!
	*
	* TODO check what happens with empty children:[{}] ? - dynamic loading???
	*/
	public static function createInitialRecords() {

		$pstmt = Dbw::checkedExecute(
			"SELECT * FROM stockLocation WHERE stockLocationId <= '" . static::ROOT_ID . "'");
		$rows = array();
		while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
			$rows[$row['stockLocationId']] = $row;
		}
		$pstmt->closeCursor();

		if (!$rows[static::ROOT_ID]) {
			static::store("INSERT", array(
				"stockLocationId" => static::ROOT_ID,
				"name" => "TheDbRootEntry",
				"excavId" => static::REUSABLES_EXCAV_ID,
				"outerId" => "0",
				"reusable" => static::REUSABLE_YES,
			));
		}  // eo the main root node

		if (!$rows['-11']) {
			static::store("INSERT", array(
				"stockLocationId" => "-11",
				"name" => Oger::_("Internes Lager"),
				"excavId" => static::REUSABLES_EXCAV_ID,
				"outerId" => static::ROOT_ID,
				"reusable" => static::REUSABLE_YES,
			));
		}  // eo root for internal stock location nodes

		if (!$rows['-12']) {
			static::store("INSERT", array(
				"stockLocationId" => "-12",
				"name" => Oger::_("Extern"),
				"excavId" => static::REUSABLES_EXCAV_ID,
				"outerId" => static::ROOT_ID,
				"reusable" => static::REUSABLE_YES,
			));
		}  // eo root for external stock location nodes

		/*
		if (!$rows['-13']) {
			static::store("INSERT", array(
				"stockLocationId" => "-13",
				"name" => Oger::_("Extras"),
				"excavId" => static::REUSABLES_EXCAV_ID,
				"outerId" => static::ROOT_ID,
				"reusable" => static::REUSABLE_YES,
			));
		}  // eo root for extra/system nodes

		if (!$rows['-131']) {
			static::store("INSERT", array(
				"stockLocationId" => "-131",
				"name" => Oger::_("Von Eingangslieferschein"),
				"excavId" => static::REUSABLES_EXCAV_ID,
				"outerId" => "-13",
				"reusable" => static::REUSABLE_YES,
			));
		}  // eo root for incoming delivery notes

		if (!$rows['-132']) {
			static::store("INSERT", array(
				"stockLocationId" => "-132",
				"name" => Oger::_("Für Ausgangslieferschein"),
				"excavId" => static::REUSABLES_EXCAV_ID,
				"outerId" => "-13",
				"reusable" => static::REUSABLE_YES,
			));
		}  // eo root for outgoing delivery notes
		*/

	}  // eo create initial records



	/**
	* Create tree from rows
	*/
	public static function rows2Tree($rows, &$finalNodes = array()) {

		// create associative array with stock location id as key
		$idRows = array();
		$rows = (array)$rows;
		foreach ($rows as &$row) {

			//$row['text'] = $row['name'];  // text is the default display field for tree items
			//$row['dbData']['name'] = $row['name'];  // nested levels not supported - see StockLocation model

			// avoid duplicate ids
			if ($idRows[$row['stockLocationId']]) {
				throw new Exception("Duplicate stock location id: {$row['stockLocationId']}.");
			}

			$idRows[$row['stockLocationId']] = $row;
		}
		unset($rows);

		// find top level nodes. This are the root-node or
		// any other nodes where the outer loc is not present in the given rows.
		$nodes = array();
		foreach ($idRows as $row) {
			if (!$idRows[$row['outerId']]) {
				$nodes[] = $row;
			}
		}
		// remove top level rows from available rows
		// if done earlier there could be false top level nodes if
		// the removed node is outer loc of another row
		foreach ($nodes as $row) {
			unset($idRows[$row['stockLocationId']]);
		}

		// add children to top level nodes and recurse down the tree
		static::addChildren2Nodes($nodes, $idRows, $finalNodes);

		// if rows remain something went wrong
		// maybe we can silently ignore ???
		if (count($rows)) {
			$tmp = implode(",", array_keys($idRows));
			throw new Exception("Unused stock location entries: {$tmp}.");
		}


		return $nodes;
	}  // create tree



	/**
	* Explode tree to rows - recursive
	* should be obsolete??? Was used to explode root nodes
	* not stored in database - see static::createInitialRecords
	*/
	/*
	protected static function tree2Rows($tree, $outerId = "") {

		$rows = array();

		foreach ((array)$tree as $node) {
			$children = $node['children'];
			if (!array_key_exists('outerId', $node)) {
				$node['outerId'] = $outerId;
			}
			unset($node['children']);
			// add this node and childs recursive
			$rows[] = $node;
			$rows = array_merge(static::tree2Rows($children, $node['stockLocationId']), $rows);
		}

		return $rows;
	}  // eo convert node to row
	*/



	/**
	* Get node info - optional with children info (but not recursive!)
	*/
	public static function getNode($stockLocationId, $opts = array()) {

		$seleExtraCols = static::getSqlTpl("EXTRACOLSONLY");

		$seleVals['stockLocationId'] = $stockLocationId;
		$sql = "SELECT *,{$seleExtraCols} FROM stockLocation WHERE stockLocationId=:stockLocationId";

		if ($opts['filter']) {
			foreach ($opts['filter'] as $key => $value) {
				$sql .= " AND {$key}=:{$key}";
			}
			$seleVals = array_merge($opts['filter'], $seleVals);
		}

		$row = Dbw::fetchRow1($sql, $seleVals);
		$node = $row;

		if ($opts['addChildren']) {
			$node['children'] = static::getInnerLoc($stockLocationId);
		}

		return $node;
	}  // eo get node


	/**
	* Get children nodes info for given node id
	* Opts: recursive, filter
	*/
	public static function getInnerLoc($stockLocationId, $opts = array()) {

		$seleExtraCols = static::getSqlTpl("EXTRACOLSONLY");

		$seleVals['stockLocationId'] = $stockLocationId;
		$sql = "SELECT *,{$seleExtraCols} FROM stockLocation WHERE outerId=:stockLocationId";

		foreach ((array)$opts['filter'] as $key => $value) {
			$sql .= " AND {$key}=:{$key}";
			$seleVals[$key] = $value;
		}

		if ($opts['orFilter']) {
			$orSql = "";
			foreach ($opts['orFilter'] as $key => $value) {
				$orSql .= ($orSql ? " OR " : "") . "{$key}=:{$key}";
				$seleVals[$key] = $value;
			}
			if ($orSql) {
				$sql .= " AND ({$orSql})";
			}
		}


		$pstmt = Dbw::checkedExecute($sql, $seleVals);
		$rows = $pstmt->fetchAll(PDO::FETCH_ASSOC);
		$pstmt->closeCursor();

		if ($opts['recursive']) {
			$allMoreRows = array();
			foreach ($rows as &$row) {
				$moreRows = static::getInnerLoc($row['stockLocationId'], $opts);
				if ($moreRows) {
					$allMoreRows = array_merge($allMoreRows, $moreRows);
				}
				else {
					// an empty children array avoids requesting children
					// while a missing children array triggers requesting children
					// when clicked on the node expander in the extjs user interface
					$row['children'] = array();
				}
			}
			$rows = array_merge($rows, $allMoreRows);
		}

		$rows = (array)$rows;
		return $rows;
	}  // eo get children



	/**
	* Get outer location node info for given node
	* Opts: recursive, filter
	*/
	public static function getOuterLoc($stockLocationId, $opts = array()) {

		if (!$stockLocationId) {
			throw new Exception("Interner Fehler: Die Lagerort ID fehlt.");
		}

		// root has no outer loc
		if ($stockLocationId == static::ROOT_ID) {
			throw new Exception("Interner Fehler: Der 'Root Node' {$stockLocationId} hat keine übergeordneten Lagerorte.");
		}

		$node = static::getNode($stockLocationId);

		$rows = array();
		// exclude root from outer loc tree ???
		if ($node['outerId'] != static::ROOT_ID) {
			$rows[] = static::getNode($node['outerId']);
		}

		if ($opts['recursive']) {
			$nextStockId = $node['outerId'];
			// exclude root node
			if ($nextStockId != static::ROOT_ID) {
				$moreRows = static::getOuterLoc($nextStockId, $opts);
			}
			if ($moreRows) {
				$rows = array_merge($rows, $moreRows);
			}
		}

		return $rows;
	}  // eo get outer loc



	/**
	* Get full name for a stock location
	*/
	public static function getFullName($stockLocationId) {

		$nodes[] = static::getNode($stockLocationId);
		$nodes = array_merge($nodes, static::getOuterLoc($stockLocationId, array("recursive" => true)));
		$nodes = array_reverse($nodes);

		$node = array_shift($nodes);
		$name = "- " . $node['name'] . "\n";

		foreach ($nodes as $node) {
			$indent = count(explode("\n", $name));
			$name .= str_repeat(" ", ($indent -1) * 2) . "- " . $node['name'] . "\n";
		}

		return $name;
	}  // eo get full name



	/**
	* Add rows to nodes array
	* @param: $finalNodes An array collecting nodes without children for external use.
	*         E.g. inner to outer location traversion.
	*/
	protected static function addChildren2Nodes(&$nodes, &$rows, &$finalNodes = array()) {

		if ($nodes === null) {
			return;
		}

		foreach ($nodes as &$node) {

			if (!$node['fullName'] && $node['stockLocationId'] != static::ROOT_ID) {
				$node['fullName'] = "- " . $node['name'];
			}

			if ($node['fullName']) {
				$indent = count(explode("\n", $node['fullName'])) + 1;
			}

			// collect children for this node
			foreach ((array)$rows as $row) {
				if ($row['outerId'] == $node['stockLocationId']) {
					$row['fullName'] = $node['fullName'] . "\n" . str_repeat(" ", $indent * 2) . "- " . $row['name'];
					/*
					 * getFullName() does not include excav name, so we do not here
					if ($row['excavId'] != static::REUSABLES_EXCAV_ID) {
						$excavName = Dbw::fetchValue1(
							"SELECT name FROM excavation WHERE id=:excavId",
							array("excavId" => $row['excavId']));
						$row['fullName'] .= " ({$excavName})";
					}
					*/
					$node['children'][] = $row;
					unset($rows[$row['stockLocationId']]);  // remove node from available rows
				}
			}

			// add nodes without children to the finalNodes array and handle next node
			if (!$node['children']) {
				$finalNodes[$node['stockLocationId']] = $node;
				continue;
			}

			// natural sort
			usort ($node['children'] , function ($a, $b) {
				return strnatcmp($a['name'], $b['name']);  // natural sort
			});

			// recursive call
			static::addChildren2Nodes($node['children'], $rows, $finalNodes);
		}  // eo node loop

	}  // eo add rows to nodes


	/**
	 * Check outer tree (sizeclass, movable, ...)
	 * ATTENTION: We do not start with the node to be checked, but with
	 * the outer node. Otherwise a new node could not be processed because
	 * it is not in the database when being checked (before insert).
	 * @param $outerId Outer id of the node in question.
	 * @param $node Node data to be checked.
	 */
	public static function checkOuterTree($outerId, $node, $opts = array()) {

		// we are a direct child of the root
		if ($outerId == static::ROOT_ID) {
			return true;
		}

		// check propterties specific to the direct outer node
		$otherNode = static::getNode($outerId);

		if ($node['movable']) {
			if ($node['excavId'] != static::REUSABLES_EXCAV_ID && !$otherNode['canExcavMovable']) {
				throw new Exception("Der übergeordnete Lagerort '{$otherNode['name']}' ({$otherNode['stockLocationId']}) kann grabungsspezifischen Behälter nicht direkt aufnehmen.");
			}
			if ($node['excavId'] == static::REUSABLES_EXCAV_ID && !$otherNode['canReusableMovable']) {
				throw new Exception("Der übergeordnete Lagerort '{$otherNode['name']}' ({$otherNode['stockLocationId']}) kann wiederverwendbare Behälter nicht direkt aufnehmen.");
			}
		}  // movable extrachecks

		// include the starting node, because getOuterLoc gets
		// the outer loc from the start node, but not start node itself
		$rows[] = $otherNode;
		if ($opts['recursive']) {
			$moreRows = static::getOuterLoc($outerId, array("recursive" => true));
		}
		if ($moreRows) {
			$rows = array_merge($rows, $moreRows);
		}

		foreach ($rows as $otherNode) {

			if ($otherNode['maxInnerSizeClass'] < $node['sizeClass']) {
				throw new Exception("Der übergeordnete Lagerort '{$otherNode['name']}' ({$otherNode['stockLocationId']}) kann keine Grössenklasse {$node['sizeClass']} aufnehmen.");
			}

			if ($otherNode['movable'] && !$node['movable']) {
				throw new Exception("Der übergeordnete Lagerort '{$otherNode['name']}' ({$otherNode['stockLocationId']}) ist beweglich und kann keine unbeweglichen Lageorte aufnehmen.");
			}

			if (!$otherNode['reusable'] && $node['reusable']) {
				throw new Exception("Der übergeordnete Lagerort '{$otherNode['name']}' ({$otherNode['stockLocationId']}) " .
					"ist grabungsspezifisch und kann daher keine wiederverwendbaren Lageorte aufnehmen.");
			}

			if ($otherNode['outerId'] == static::ROOT_ID) {
				$rootFound = true;
			}
		}

		if ($opts['recursive'] && !$rootFound) {
			throw new Exception("Interner Fehler: Übergeordnete Kette geht nicht bis zum Basisknoten.");
		}

		return true;
	}  // eo check up


	/**
	 * check downtree (sizeclass, movable, ...)
	 */
	public static function checkInnerTree($stockLocationId, $node, $opts = array()) {

		if ($opts['recursive']) {
			$myOpts = array("recursive" => true);
		}
		$rows = static::getInnerLoc($stockLocationId, $myOpts);

		if (!$node['maxInnerTypeId'] && $rows) {
			throw new Exception("Untergeordnete Lagerorte sind vorhanden. Eine Grössenklasse für aufzunehmende Lagerorte ist daher erforderlich.");
		}

		foreach ($rows as $otherNode) {
			if ($otherNode['sizeClass'] > $node['maxInnerSizeClass']) {
				throw new Exception("Der untergeordnete Lagerort '{$otherNode['name']}' ({$otherNode['stockLocationId']}) " .
					"hat die Grössenklasse {$node['sizeClass']}, daher muss dieser Lagerort " .
					"mehr als die Grössenklasse {$node['maxInnerSizeClass']} aufnehmen können.");
			}
			if (!$otherNode['movable'] && $node['movable']) {
				throw new Exception("Der untergeordnete Lagerort '{$otherNode['name']}' ({$otherNode['stockLocationId']}) " .
					"ist unbeweglich, daher kann dieser Lagerort nicht beweglich sein.");
			}
			if ($otherNode['reusable'] && !$node['reusable']) {
				throw new Exception("Der untergeordnete Lagerort '{$otherNode['name']}' ({$otherNode['stockLocationId']}) " .
					"ist wiederverwendbar, daher kann dieser Lagerort nicht grabungsspezifisch sein.");
			}
		}

		return true;
	}  // eo check up


	/**
	* store input to db
	*/
	public static function storeInput($values, $dbAction, $opts = array()) {

		// check for required fields and more
		if (!$values['_usecase']) {
			throw new Exception(Oger::_("Interner Fehler: Angabe zu _usecase fehlt."));
		}

		if (!$values['excavId']) {
			if ($values['stockLocationId'] > static::ROOT_ID) {
				throw new Exception(Oger::_("Interner Fehler: Grabungsnummer fehlt."));
			}
			if (array_key_exists("excavId", $values)) {
				$values['excavId'] = null;
			}
		}
		if ($values['excavId'] == static::REUSABLES_EXCAV_MARKER && $values['_usecase'] == "MASTER") {
			$values['excavId'] = static::REUSABLES_EXCAV_ID;
		}

		if (!$values['name']) {
			throw new Exception(Oger::_("Name/Bezeichnung fehlt."));
		}
		if (!$values['outerId']) {
			throw new Exception(Oger::_("ID des übergeordneten Lagerorts fehlt."));
		}
		if (!$values['typeId']) {
			throw new Exception(Oger::_("Typ/Grössenklasse des Lagerorts fehlt."));
		}

		if (!($values['maxInnerTypeId'] || $values['canItem'])) {
			throw new Exception(Oger::_("Ein Lagerort, der weder Funde noch andere Lagerorte aufnehmen kann ist nutzlos."));
		}

		if (!$values['movable'] && !$values['reusable']) {
			throw new Exception(Oger::_("Unbewegliche Lagerorte müssen wiederverwendbar sein."));
		}
		if ($values['reusable'] == static::REUSABLE_YES && $values['excavId'] != static::REUSABLES_EXCAV_ID) {
			throw new Exception(Oger::_("Interner Fehler: Sonderbehälter müssen spezielle Grabungsnummer haben."));
		}

		if ($values['_usecase'] != "MASTER" &&
				(!$values['movable'] || $values['reusable'])) {
			throw new Exception(Oger::_("Unbewegliche und wiederverwendbare Lagerorte können hier nicht verändert werden."));
		}

		if (!Dbw::fetchRow1("SELECT * FROM stockLocation WHERE stockLocationId=:stockLocationId",
												array("stockLocationId" => $values['outerId']))) {
			throw new Exception(Oger::_("Übergeordneter Knoten {$values['outerId']} {$values['outerName']} existiert nicht."));
		}

		// add sizeclass for up/down checks and do precheck
		$values['sizeClass'] = Dbw::fetchValue1(
			"SELECT sizeClass FROM stockLocationType WHERE id=:id",
			array("id" => $values['typeId']));
		$values['maxInnerSizeClass'] = Dbw::fetchValue1(
			"SELECT sizeClass FROM stockLocationType WHERE id=:id",
			array("id" => $values['maxInnerTypeId']));

		if ($values['maxInnerSizeClass'] &&
				$values['maxInnerSizeClass'] > $values['sizeClass']) {
			throw new Exception(Oger::_("Die Lagerort Grössenklasse ({$values['sizeClass']}) ist kleiner als die maximal aufzunehmende ({$values['maxInnerSizeClass']})."));
		}


		// check outer tree. Maybe it is not necessary to check recursively, but
		// we do in this case
		static::checkOuterTree($values['outerId'], $values, array("recursive" => true));

		// some properties cannot change on update
		if ($dbAction == "UPDATE") {
			$oldLoc = static::getNode($values['stockLocationId']);
			if ($values['excavId'] != $oldLoc['excavId']) {
				throw new Exception(Oger::_("Interner Fehler: Grabungsnummer darf nicht von {$oldLoc['excavId']} auf {$values['excavId']} wechseln."));
			}
			if (!$values['canItem'] && $oldLoc['archFindCount']) {
				throw new Exception(Oger::_("Lagerort enthält direkt Funde. Diese Eigenschaft kann daher nicht entfernt werden."));
			}
			// check inner tree (only direct children in this case - not recursively)
			static::checkInnerTree($values['stockLocationId'], $values);
		}


		// on check-only return here
		// should only happen for import, so exists-already-check and rename-check are not necessary
		if ($opts['checkOnly']) {
			return;
		}


		$seleVals = array();
		if ($dbAction == "UPDATE") {
			$seleVals['stockLocationId'] = $values['stockLocationId'];
		}  // eo update

		static::store($dbAction, $values, $seleVals);
		if ($dbAction == "INSERT") {
			$seleVals['stockLocationId'] = (string)Dbw::fetchValue1("SELECT LAST_INSERT_ID()");
		}

		// reply with core ids
		return $seleVals;
	}  // eo save input



	/**
	* Store the content (arch find ids) for given location
	*/
	public static function storeArchFindIds($excavId, $stockLocationId, $ids, $dbAction) {

		if (!$excavId) {
			throw new Exception(Oger::_("INTERNER FEHLER: Grabungsnummer fehlt."));
		}
		if (!$stockLocationId) {
			throw new Exception(Oger::_("INTERNER FEHLER: Lagerort-Nummer fehlt."));
		}


		if (is_string($ids)) {
			$ids = ExcavHelper::multiXidSplit($ids);
		}

		$newIds = array();
		foreach($ids as $id) {
			$newIds[$id] = $id;
		}


		$seleVals = array("excavId" => $excavId, "stockLocationId" => $stockLocationId);

		// read already existing entries for this location
		$oldIds = array();
		$pstmt = Dbw::$conn->prepare(
			"SELECT archFindId,archFindSubId FROM prepFindTMPNEW WHERE excavId=:excavId AND stockLocationId=:stockLocationId");
		$pstmt->execute($seleVals);
		while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
			$oldId = ExcavHelper::xidPrepareSubId($row['archFindId'], $row['archFindSubId']);
			$oldIds[$oldId] = $oldId;
		}
		$pstmt->closeCursor();


		// init values
		$values = $seleVals;

		// store new entries
		foreach($newIds as $id) {
			// skip existing entries
			if ($oldIds[$id]) {
				unset($oldIds[$id]);  // remove used id/sub so that only unused remain
				continue;
			}
			list($values['archFindId'], $values['archFindSubId']) =
				ExcavHelper::xidSubIdSplit($id);
			PrepFind12::storeInput($values, "INSERT");
		}


		// on update remove remaining surplus entries
		// this could be done with a single WHERE stratum2Id IN (...) statement
		// but we pay the performance price for a simpler statement creation
		if ($dbAction == "UPDATE") {

			$seleVals = array("excavId" => $excavId, "stockLocationId" => $stockLocationId);

			$pstmtDele = Dbw::$conn->prepare(
				"DELETE FROM prepFindTMPNEW WHERE excavId=:excavId" .
				" AND archFindId=:archFindId AND archFindSubId=:archFindSubId AND stockLocationId=:stockLocationId" .
				" AND BINARY archFindId=:archFindId AND BINARY archFindSubId=:archFindSubId AND BINARY stockLocationId=:stockLocationId");

			foreach ($oldIds as $id) {
				list($seleVals['archFindId'], $seleVals['archFindSubId']) =
					ExcavHelper::xidSubIdSplit($id);
					$pstmtDele->execute($seleVals);
			}

		}  // eo update handling

	}  // eo store arch find ids


	/**
	* Move node
	*/
	public static function moveNode($stockLocationId, $toLocId, $opts = array()) {

		// cannot move node to itself
		if ($stockLocationId == $toLocId) {
			throw new Exception(Oger::_("Kann nicht Lagerort zu sich selbst verschieben."));
		}

		if (!$toLocId) {
			throw new Exception(Oger::_("Ziel-Lagerort für Verschiebeaktion fehlt."));
		}

		// system nodes cannot be moved
		if ($stockLocationId <= static::ROOT_ID) {
			throw new Exception(Oger::_("System-Lagerorte können nicht verschoben werden."));
		}

		$node = static::getNode($stockLocationId);

		// immobile nodes cannot be moved - except in master mode
		if (!$node['movable'] && $opts['_usecase'] != "MASTER") {
			throw new Exception(Oger::_("Unbewegliche Lagerorte können nicht verschoben werden."));
		}

		if ($node['outerId'] == $toLocId) {
			throw new Exception(Oger::_("Lagerort ist bereits an vorgesehener Zielstelle."));
		}

		// node cannot be moved to one of its descendants, because this would result in
		// 1) a cycle and 2) a broken chain above children (no path to root)
		$desc = static::getInnerLoc($toLocId, array("recursive" => true));
		foreach ($desc as $ancestor) {
			if ($desc['stockLocationId'] == $stockLocationId) {
				throw new Exception(Oger::_("Lagerort kann nicht an eine untergeordnete Stelle verschoben werden."));
			}
		}

		// check uptree. Downtree does not change - so we do not check
		// it is not necessary to check recusively
		static::checkOuterTree($toLocId, $node);


		// apply move
		$pstmt = Dbw::checkedExecute(
			"UPDATE stockLocation SET outerId=:to WHERE stockLocationId=:stockLocationId",
			array("stockLocationId" => $stockLocationId, "to" => $toLocId)
		);

	}  // eo move noede


}  // end of class

?>
