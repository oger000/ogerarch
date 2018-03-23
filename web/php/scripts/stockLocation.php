<?php
/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


require_once(__DIR__ . "/../init.inc.php");



// load full tree for one excavation
// includin ALL reusable locations as well
if ($_REQUEST['_action'] == "loadExcavStockLocation") {

	// we provide an empty children array for every row,
	// (see merge loop below) because otherwise children are
	// requested and destroy the tree with endless recursion.
	// This is because we always deliver the full tree and not
	// only the requested parts.

	// this is an extra sanity check (see comment above) and should never be called
	// as long as empty children arrays mark the final nodes of the tree
	if ($_REQUEST['stockLocationId'] != StockLocation12::ROOT_ID) {
		$children = StockLocation12::getInnerLoc(
			$_REQUEST['stockLocationId'],
			array("filter" => array("excavId" => $_REQUEST['excavId']))
		);
		echo Extjs::encData($children, null, "children");
		exit;
	}


	// first load all reusable locations (as possible target for moving nodes)
	$seleVals = array();
	$sql = StockLocation12::getSql("REUSABLES", $seleVals);
	$pstmt = Dbw::checkedExecute($sql, $seleVals);
	$dbRows = $pstmt->fetchAll(PDO::FETCH_ASSOC);
	$pstmt->closeCursor();


	// fetch all locations used by a given excav
	// translate from tree store convention to internal

	$seleVals = array();
	$sql = StockLocation12::getSql("EXCAVSTOCKTREE", $seleVals);

	$pstmt = Dbw::checkedExecute($sql, $seleVals);
	while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
		$dbRows[] = $row;
	}
	$pstmt->closeCursor();

	// merge by id as index
	$rows = array();
	foreach ($dbRows as $row) {
		$row['expanded'] = true;
		// set "final node" by default. If childs exists they are added.
		// see also comment at the begin of this function
		$row['children'] = array();
		$rows[$row['stockLocationId']] = $row;
	}
	unset($dbRows);

	try {
		$tree = StockLocation12::rows2Tree($rows);
	}
	catch (Exception $ex) {
		echo Extjs::errorMsg($ex->getMessage());
		exit;
	}


	// remove root itself - see loadInnerLoc
	if ($tree[0]['stockLocationId'] == StockLocation12::ROOT_ID) {  // realy root
		$tree = $tree[0]['children'];
	}

	echo Extjs::encData($tree, null, "children");
	exit;

}  // eo loading tree for one excav



// load a location record with arch find content
if ($_REQUEST['_action'] == "loadLocContent") {

	$seleVals = array();
	$sql = StockLocation12::getSql("FORM", $seleVals);

	$rec = Dbw::fetchRow1($sql, $seleVals);
	if ($rec === false) {
		echo Extjs::errorMsg(Oger::_("Datensatz nicht gefunden"));
		exit;
	}
	$rec['stockLocationId'] = $rec['stockLocationId'];

	// add excavid from request to response,
	// because not part of stock location (only content has excav id)
	$rec['excavId'] = $_REQUEST['excavId'];

	// load arch find content ids
	$seleVals = array();
	$sql = OgerExtjSqlTpl::_prepare(
		"SELECT archFindId,archFindSubId FROM prepFindTMPNEW" .
		" WHERE excavId=:excavId AND stockLocationId=:stockLocationId",
		$seleVals);
	$pstmt = Dbw::checkedExecute($sql, $seleVals);
	$archFindIds = array();
	while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
		$archFindIds[] = ExcavHelper::xidPrepareSubId($row['archFindId'], $row['archFindSubId']);
	}
	$pstmt->closeCursor();

	$rec['archFindIdList'] = ExcavHelper::multiXidPrepare($archFindIds);

	echo Extjs::encData($rec);
	exit;
}  // eo loading one record



/*
* Save arch find content for acontainer
*/
if ($_REQUEST['_action'] == "saveLocContent") {

	$loc = StockLocation12::getNode($_REQUEST['stockLocationId']);
	if (!$loc['canItem']) {
		echo Extjs::errorMsg(Oger::_("Dieser Lagerort kann keine Funde aufnehmen."));
		exit;
	}

	try {

		StockLocation12::storeArchFindIds(
			$_REQUEST['excavId'], $_REQUEST['stockLocationId'], $_REQUEST['archFindIdList'], $_REQUEST['dbAction']);

		// postupdate content comment by bypass db-rec checks and store directly
		StockLocation12::store(
			"UPDATE",
			array(
			  "contentComment" => $_REQUEST['contentComment'],
			),
			array(
				"excavId" => $_REQUEST['excavId'],
			  "stockLocationId" => $_REQUEST['stockLocationId'],
			)
		);
	}
	catch (Exception $ex) {
		echo Extjs::errorMsg($ex->getMessage());
		exit;
	}

	// return dummy
	echo Extjs::enc();
	exit;
}  // eo save posted data to database




/*
* Move location
*/
if ($_REQUEST['_action'] == "moveLoc") {

	if (!$_REQUEST['excavId']) {
		echo Extjs::errorMsg(Oger::_("Interner Fehler: Grabungsnummer fehlt."));
		exit;
	}

	$loc = StockLocation12::getNode($_REQUEST['stockLocationId']);

	// handle moving of inner nodes
	if ($_REQUEST['moveInnerLoc']) {
		$innerOpts = array("recursive" => true);
		$innerOpts['orFilter'] = array("reusable" => StockLocation12::REUSABLE_YES, "excavId" => $_REQUEST['excavId']);
	}
	$innerLocRows = StockLocation12::getInnerLoc($_REQUEST['stockLocationId'], $innerOpts);

	// add current node to inner nodes to unify processing
	$allLoc = $innerLocRows;
	array_push($allLoc, $loc);
	$tree = StockLocation12::rows2Tree($allLoc);

	$feedback = array("proto" => "", "moveLocCount" => 0, "moveArchFindCount" => 0, "moveSkipCount" => 0);
	$toLoc = StockLocation12::getNode($_REQUEST['moveTo']);
	moveLocRecursive($tree[0], $toLoc, $feedback);
	$proto = $feedback['proto'];

	$proto .= sprintf(
		Oger::_("%d Behälter verschoben.\n%d Unverpackte Funde verschoben.\n"),
		$feedback['moveLocCount'], $feedback['moveArchFindCount']);

	if ($_REQUEST['moveApplyMode'] != "apply") {
		$proto = Oger::_("*** ACHTUNG ***\nDas Verschieben wurden nicht durchgeführt, sondern nur simmuliert.\n\n") . $proto;
	}

	echo Extjs::enc(array("moveApplyMode" => $_REQUEST['moveApplyMode'],
											 "proto" => $proto,
											 "moveLocCount" => $feedback['moveLocCount'], "moveArchFindCount" => $feedback['moveArchFindCount']));
	exit;
}  // eo move loc action

/*
 * move helper function to perform move of location and children
 * Use $_REQUEST values directly
 */
function moveLocRecursive($loc, $toLoc, &$feedback) {


	// some prechecks, that make recursion to inner locs unnecessary if failing

	// we can stop recursion at excav specific locs
	if ($loc['excavId'] != $_REQUEST['excavId'] && !$loc['reusable']) {
		if ($_REQUEST['extendedProto']) {
			$feedback['proto'] .=
				$loc['fullName'] . "\n" .
				Oger::_("*** Der grabungsspezifische Lagerort {$loc['name']} kann nicht verschoben werden, " .
					"weil er zu einer anderen Grabung ({$loc['excavId']}) gehört. " .
					"Keine weitere Rekursion in diese Richtung.\n\n");
		}
		$feedback['moveSkipCount']++;
		return false;
	}

	// ##################################################################

	// check inner locs for being movable
	$movableChildren = array();
	foreach ((array)$loc['children'] as $key => $child) {
		if (moveLocRecursive($child, $toLoc, $feedback)) {
			$movableChildren[] = $child;
		}
	}

	$canMoveThis = true;
	if (count($movableChildren) < count($loc['children'])) {
		$canMoveThis = false;
	}
	else {
		$canMoveThis = isMovableLocByItself($loc, $feedback);
	}


	// handle outest from-node (the root node of the to-be-moved tree) to be moved now
	// this is the original starting node and we reach it again if all children are checked
	if ($loc['stockLocationId'] == $_REQUEST['stockLocationId'] && $canMoveThis) {
		$isStartNode = true;
		// we fake this node to be a movable child to perform the move
		$movableChildren = array($loc);
	}

	// if this node is movable (including children), then we do not move
	// but we delegate to the outer node to be checked, because this node
	// can be part of a larger tree move, if the outer node is also movable
	if ($canMoveThis && !$isStartNode) {
		return true;
	}


	// if not movable we first move all movable children
	foreach ($movableChildren as $child) {

		if ($_REQUEST['moveApplyMode'] == "apply") {
			$moveOpts = array();
			try {
				StockLocation12::moveNode($child['stockLocationId'], $_REQUEST['moveTo'], $moveOpts);
			}
			catch (Exception $ex) {
				echo Extjs::errorMsg($ex->getMessage());
				exit;
			}
		}

		$feedback['proto'] .=
			$child['fullName'] . "\n" .
			Oger::_("*** Lagerort wird nach {$toLoc['name']} verschoben.\n\n");
		$feedback['moveLocCount']++;

	}  // eo loop to process move for movable children


	// if not can move this loc, then we move all directly assigned arch finds
	// of this excav to the target loc if this can contain arch finds.
	// Movable marked locs can not be separated from their arch finds,
	// so we exclude them
	if (!$canMoveThis && $_REQUEST['moveArchFind'] &&
			$loc['archFindCount'] && !$loc['movable']) {

		$tmpSeleVals =
			array("excavId" => $_REQUEST['excavId'], "oldStockLocationId" => $loc['stockLocationId']);

		$tmpFindCount = Dbw::fetchValue1(
			"SELECT COUNT(*) FROM prepFindTMPNEW" .
			" WHERE stockLocationId=:oldStockLocationId AND excavId=:excavId",
			$tmpSeleVals);

		if ($tmpFindCount) {

			if ($toLoc['canItem']) {

				if ($_REQUEST['moveApplyMode'] == "apply") {
					$pstmt = Dbw::$conn->prepare(
						"UPDATE prepFindTMPNEW SET stockLocationId=:newStockLocationId " .
						" WHERE stockLocationId=:oldStockLocationId AND excavId=:excavId ");
					$tmpSeleVals['newStockLocationId'] = $_REQUEST['moveTo'];
					$pstmt->execute($tmpSeleVals);
				}

				$feedback['moveArchFindCount'] += $tmpFindCount;
				$feedback['proto'] .=
					$loc['fullName'] . "\n" .
					Oger::_("*** {$tmpFindCount} unverpackte Funde werden nach {$toLoc['name']} verschoben.\n\n");

			}
			else {
				if ($_REQUEST['extendedProto']) {
					$feedback['proto'] .=
						$loc['fullName'] . "\n" .
						Oger::_("*** {$tmpFindCount} unverpackte Funde werden nicht verschoben, " .
							"weil {$toLoc['name']} keine Funde aufnehmen kann.\n\n");
				}
			}
		}
	}  // eo move loose arch finds

	// finaly we report this node as not moved/movable
	return false;
}  // eo check and move loc recursive

/*
 * check if loc is movable by itself - without children check
 * We use $_REQUEST values directly here
 */
function isMovableLocByItself($loc, &$feedback) {

	if ($loc['stockLocationId'] <= StockLocation12::ROOT_ID) {
		if ($_REQUEST['extendedProto']) {
			$feedback['proto'] .=
				$loc['fullName'] . "\n" .
				Oger::_("*** Der System-Lagerort {$loc['name']} kann nicht verschoben werden.\n\n");
		}
		$feedback['moveSkipCount']++;
		return false;
	}

	if (!$loc['movable']) {
		if ($_REQUEST['extendedProto']) {
			$feedback['proto'] .=
				$loc['fullName'] . "\n" .
				Oger::_("*** Der Lagerort {$loc['name']} ist nicht beweglich.\n\n");
		}
		$feedback['moveSkipCount']++;
		return false;
	}

	// for reusable and movable locations that contain arch finds
	// check if arch finds from other excavs are included
	if ($loc['reusable'] && $loc['movable']) {

		$thisExcavCount = 0;
		if ($loc['archFindCount']) {
			$thisExcavCount = Dbw::fetchValue1(
				"SELECT COUNT(*) FROM prepFindLocation " .
				" WHERE stockLocationId=:stockLocationId AND excavId=:excavId",
				array("stockLocationId" => $loc['stockLocationId'], "excavId" => $_REQUEST['excavId']));
		}

		if (!$thisExcavCount) {
			if ($_REQUEST['extendedProto']) {
				$feedback['proto'] .=
					$loc['fullName'] . "\n" .
					Oger::_("*** Der wiederverwendbare Lagerort {$loc['name']} wird nicht verschoben, " .
						"weil er keine Funde von dieser Grabung enthält.\n\n");
			}
			$feedback['moveSkipCount']++;
			return false;
		}

		// Maybe we need an extraparameter to allow this, but for now we deny
		$otherExcavCount = $loc['archFindCount'] - $thisExcavCount;
		if ($otherExcavCount) {
			//if ($_REQUEST['extendedProto']) {
				$feedback['proto'] .=
					$loc['fullName'] . "\n" .
					Oger::_("*** Der wiederverwendbare Lagerort {$loc['name']} wird nicht verschoben, " .
						"weil er {$otherExcavCount} Funde von anderen Grabungen enthält.\n\n");
			//}
			$feedback['moveSkipCount']++;
			return false;
		}
	}  // eo reusable movable locs


	return true;
}  // eo movable-by-itself helper function



// load inner tree from database (without node itself)
if ($_REQUEST['_action'] == "loadTree") {

	// fake loop for initial records check with sanity limit
	while ($initalCheckCount < 2) {

		$rows = StockLocation12::getInnerLoc(
			$_REQUEST['stockLocationId'],
			array("recursive" => true, "filter" => array("reusable" => StockLocation12::REUSABLE_YES)));

		foreach ($rows as &$row) {
			$row['expanded'] = true;
		}

		// create tree from rows
		try {
			$tree = StockLocation12::rows2Tree($rows);
		}
		catch (Exception $ex) {
			echo Extjs::errorMsg($ex->getMessage());
			exit;
		}

		// if the root node is requested and does not exist
		// than create initial records and loop back to read requested record
		if ($_REQUEST['stockLocationId'] == StockLocation12::ROOT_ID && count($tree) == 0) {
			StockLocation12::createInitialRecords();
			$initialCheckCount++;
			continue;
		}

		break;
	}  // eo fake loop for inital node check

	// remove root itself - see loadInnerLoc
	if ($tree[0]['stockLocationId'] == StockLocation12::ROOT_ID) {  // realy root
		$tree = $tree[0]['children'];
	}

	echo Extjs::encData($tree, null, "children");
	exit;
}  // eo loading node children




// load one record from db
if ($_REQUEST['_action'] == "loadRecord") {

	$seleVals = array();
	$sql = StockLocation12::getSql("FORM", $seleVals);

	$row = Dbw::fetchRow1($sql, $seleVals);
	if ($row === false) {
		echo Extjs::errorMsg(Oger::_("Datensatz nicht gefunden"));
		exit;
	}

	$row = StockLocation12::prep4Extjs($row);
	echo Extjs::encData($row);
	exit;
}  // eo loading one record




/*
* Save input
*/
if ($_REQUEST['_action'] == "save") {

	if ($_REQUEST['massAddMode']) {

		if ($_REQUEST['dbAction'] != "INSERT") {
			echo Extjs::errorMsg(Oger::_("Massenanlage nur im Hinzufüge-Modus erlaubt."));
			exit;
		}

		$massNames = ExcavHelper::multiXidSplit($_REQUEST['massNames']);

		$names = array();
		foreach ($massNames as $namePart) {

			$fullName = $_REQUEST['prefixName'];
			if ($_REQUEST['prefixName'] && $_REQUEST['prefixSpace']) {
				$fullName .= " ";
			}

			$fullName .= $namePart;

			if ($_REQUEST['postfixName'] && $_REQUEST['postfixSpace']) {
				$fullName .= " ";
			}
			$fullName .= $_REQUEST['postfixName'];

			$names[] = $fullName;
		}

		if (!$names) {
			echo Extjs::errorMsg(Oger::_("Keine Bezeichnungen gefunden."));
			exit;
		}

		if ($_REQUEST['massApplyMode'] != "apply") {
			echo Extjs::enc(array("isDemo" => true, "demoNames" => implode("\n", $names)));
			exit;
		}
	}
	else {  // fake names for single container mode
		$names = array($_REQUEST['name']);
	}

	try {
		foreach ($names as $name) {
			$_REQUEST['name'] = $name;
			$row = StockLocation12::storeInput($_REQUEST, $_REQUEST['dbAction']);
		}
	}
	catch (Exception $ex) {
		echo Extjs::errorMsg($ex->getMessage());
		exit;
	}

	echo Extjs::encData($row);
	exit;
}  // eo save posted data to database





// move node
if ($_REQUEST['_action'] == "moveNode") {

	$opts['_usecase'] = "MASTER";

	try {
		StockLocation12::moveNode($_REQUEST['stockLocationId'], $_REQUEST['moveTo'], $opts);
	}
	catch (Exception $ex) {
		echo Extjs::errorMsg($ex->getMessage());
		exit;
	}

	echo Extjs::enc();
	exit;
}  // eo move node


// delete location
if ($_REQUEST['_action'] == 'delete') {

	$loc = StockLocation12::getNode($_REQUEST['stockLocationId']);

	/*
	if ($loc['excavId'] != $_REQUEST['excavId']) {
		echo Extjs::errorMsg(Oger::_("Interner Fehler: Grabungsnummer stimmt nicht überein."));
		exit;
	}
	*/

	// handle deleting of inner nodes
	if ($_REQUEST['deleteInnerLoc']) {
		$innerOpts = array("recursive" => true);
	}
	$innerLocRows = StockLocation12::getInnerLoc($_REQUEST['stockLocationId'], $innerOpts);

	// add current node to inner nodes to unify processing
	$allLoc = $innerLocRows;
	array_push($allLoc, $loc);
	$tree = StockLocation12::rows2Tree($allLoc);

	$feedback = array("proto" => "", "deleCount" => 0, "deleSkipCount" => 0);
	deleteLocRecursive($tree[0], $feedback);
	$proto = $feedback['proto'];

	$proto .= sprintf(
		Oger::_("%d Lagerorte gelöscht.\n%d Lagerorte nicht gelöscht.\n"),
		$feedback['deleCount'], $feedback['deleSkipCount']);

	if ($_REQUEST['deleteApplyMode'] != "apply") {
		$proto = Oger::_("*** ACHTUNG ***\nLöschungen wurden nicht durchgeführt, sondern nur simmuliert.\n\n") . $proto;
	}

	echo Extjs::enc(array("deleteApplyMode" => $_REQUEST['deleteApplyMode'],
											 "proto" => $proto,
											 "deleCount" => $feedback['deleCount'], "deleSkipCount" => $feedback['deleSkipCount']));
	exit;
}  // eo delete action




/*
 * delete helper function to delete location and children
 * Use $_REQUEST values directly
 */
function deleteLocRecursive(&$loc, &$feedback) {

	// check for children is only useful if deletion of inner locations is not requested
	// otherwise we try to delete the inner locs and errors are reported there
	if (!$_REQUEST['deleteInnerLoc'] && $loc['children']) {
		$feedback['proto'] .=
			$loc['fullName'] . "\n" .
			Oger::_("*** Löschen nicht möglich, weil untergeordnete Lagerorte vorhanden sind.\n\n");
			$feedback['deleSkipCount']++;
		return false;
	}


	// try to delete inner locs before checking the current one
	foreach ($loc['children'] as $key => &$child) {
		if (deleteLocRecursive($child, $feedback)) {
			unset($loc['children'][$key]);
		}
	}

	// if there are children left after the prior children deletion loop
	// then we cannot delete this location. Error message is already in proto.
	if ($loc['children']) {
		$feedback['deleSkipCount']++;
		return false;
	}

	// #####################################################

	// if no children, then we are at a leaf or all children are deleted
	// and we can check the current location for deletion criterias

	if ($loc['stockLocationId'] <= StockLocation12::ROOT_ID) {
		$feedback['proto'] .=
			$loc['fullName'] . "\n" .
			Oger::_("*** System-Lagerorte können nicht gelöscht werden.\n\n");
		$feedback['deleSkipCount']++;
		return false;
	}

	// check for input center mode
	if ($_REQUEST['_usecase'] != "MASTER") {

		if ($loc['reusable'] || !$loc['movable']) {
			$feedback['proto'] .=
				$loc['fullName'] . "\n" .
				Oger::_("*** Wiederverwendbare und unbewegliche Lagerorte können nur im Stammdaten-Modus gelöscht werden.\n\n");
			$feedback['deleSkipCount']++;
			return false;
		}

		if ($loc['excavId'] != $_REQUEST['excavId']) {
			$feedback['proto'] .=
				$loc['fullName'] . "\n" .
				Oger::_("*** Dieser Lagerort kann nicht gelöscht werden, weil er zu einer anderen Grabung ({$loc['excavId']}) gehört.\n\n");
			$feedback['deleSkipCount']++;
			return false;
		}

	}  // eo  not master ( = input center mode)

	if ($loc['archFindCount']) {
		$feedback['proto'] .=
			$loc['fullName'] . "\n" .
			sprintf(Oger::_("*** Löschen nicht möglich, weil %d Funde enthalten sind.\n\n"), $loc['archFindCount']);
		$feedback['deleSkipCount']++;
		return false;
	}

	if ($loc['excavId'] != StockLocation12::REUSABLES_EXCAV_ID) {
		if (!$_REQUEST['deleteExcavLoc']) {
			$feedback['proto'] .=
				$loc['fullName'] . "\n" .
				Oger::_("*** Grabungsspezifische Lagerorte wurden nicht zum Löschen ausgewählt.\n\n");
			$feedback['deleSkipCount']++;
			return false;
		}
	}

	if ($_REQUEST['deleteApplyMode'] == "apply") {
		try {
			$psql = Dbw::$conn->prepare("DELETE FROM stockLocation WHERE stockLocationId=:stockLocationId");
			$psql->execute(array("stockLocationId" => $loc['stockLocationId']));
		}
		catch (Exception $ex) {
			echo Extjs::errorMsg($ex->getMessage());
			exit;
		}
	}

	$feedback['deleCount']++;

	$feedback['proto'] .=
		$loc['fullName'] . "\n" .
		Oger::_("Lagerort erfolgreich gelöscht.\n\n");

	return true;
}  // eo delete helper function



// list content for a location (can include inner tree)
// for one or all excavations
if ($_REQUEST['_action'] == "locContentList") {

	HtmlHelper::htmlStart(true);

	if (!$_REQUEST['stockLocationId']) {
		echo Extjs::errorMsg(Oger._("Lagerort ID fehlt."));
		exit;
	}


	try {

		$rows[] = StockLocation12::getNode($_REQUEST['stockLocationId']);

		// if inner loc is requested load ALL inner locs - independend
		// of excavation id (because reusable locations have no excav id)
		// wrong excav ids are removed later
		if ($_REQUEST['listInnerLoc']) {
			$children = StockLocation12::getInnerLoc($_REQUEST['stockLocationId'], array("recursive" => true));
			$rows = array_merge($children, $rows);
			unset($children);
		}

		$tree = StockLocation12::rows2Tree($rows);

		// remove root itself - see loadInnerLoc
		if ($tree[0]['stockLocationId'] == StockLocation12::ROOT_ID) {  // realy root
			$tree = $tree[0]['children'];
		}

		$out = "<H2>Lagerstandsliste vom " . date("d.m.Y") . "</H2>";
		foreach ($tree as $node) {
			$node['fullName'] = StockLocation12::getFullName($node['stockLocationId']);
			$node['isOgerTopNode'] = true;
			$out .= listLocContentRecursive($node);
		}
		echo nl2br($out);

	}
	catch (Exception $ex) {
		echo Extjs::errorMsg($ex->getMessage());
		exit;
	}

	exit;
}  // eo location content list

/*
 * list location content recursive
 */
function listLocContentRecursive(&$node) {

	$nbsp = "&nbsp;";
	$node['fullName'] = str_replace(" ", $nbsp, $node['fullName']);

	// get arch finds per excav
	$seleValsArchFind = array("stockLocationId" => $node['stockLocationId']);
	if ($_REQUEST['excavScope'] != "all") {
		$seleValsArchFind['excavId'] = $_REQUEST['excavId'];
		$sqlArchFindWhereExtra = " AND excavId=:excavId";
	}
	$sqlArchFind =
		"SELECT excavId,archFindId,archFindSubId FROM prepFindTMPNEW" .
		" WHERE stockLocationId=:stockLocationId {$sqlArchFindWhereExtra}" .
		" ORDER BY excavId, archFindId, archFindSubId";
	$psqlArchFind = Dbw::checkedExecute($sqlArchFind, $seleValsArchFind);

	$archFindIds = array();
	while ($row = $psqlArchFind->fetch(PDO::FETCH_ASSOC)) {
		$excavId = $row['excavId'];
		if ($oldExcavId != $excavId) {
			$archFindIds[$excavId] = array();
			$oldExcavId = $excavId;
		}
		$archFindIds[$excavId][] = ExcavHelper::xidPrepareSubId($row['archFindId'], $row['archFindSubId']);
	}

	// list conditionally
	if ($node['isOgerTopNode'] || $_REQUEST['listEmptyInnerLoc'] || $archFindIds) {
		$out .=  "\n\n";
		$out .=  $node['fullName'];

		// add excav info
		foreach ($archFindIds as $excavId => $excavArchFindIds) {
			$excavRow = Dbw::fetchRow1(
				"SELECT * FROM excavation WHERE id=:excavId",
				array("excavId" => $excavId));
			$out .= "* Grabung {$excavRow['name']} [ " .
				date("d.m.Y", strtotime($excavRow['beginDate'])) . " bis " .
				(substr($excavRow['endDate'], 0, 4) != "0000" ?
					date("d.m.Y", strtotime($excavRow['endDate'])) : "laufend") .
				" ] : " .
				ExcavHelper::multiXidPrepare(
					$excavArchFindIds, array("hideSubId" => $_REQUEST['hideArchFindSubId'])) .
				"\n";
		}
	}  // eo conditionally listening

	// process children
	if ($node['children']) {
		foreach ($node['children'] as &$child) {

			// complete full name
			$child['fullName'] = $node['fullName'] .
				str_repeat($nbsp, (count(explode("\n", $node['fullName'])) - 1) * 2) .
				"- {$child['name']}\n";

			$out .= listLocContentRecursive($child);
		}
	}
	else {
		//echo "<br> und aus"; var_export($node);exit;
	}

	return $out;
}  // eo list location content recursive



// create packing list for a location (can include inner tree)
// for one or all excavations
if ($_REQUEST['_action'] == "locPackingList") {

	if (!$_REQUEST['stockLocationId']) {
		echo Extjs::errorMsg(Oger._("Lagerort ID fehlt."));
		exit;
	}

	$statusFields = array(
		'washStatusId' => "gereinigt",
		'labelStatusId' => "beschriftet",
		'restoreStatusId' => "restauriert",
		'photographStatusId' => "fotografiert",
		'drawStatusId' => "gezeichnet",
		'layoutStatusId' => "gesetzt",
		'scientificStatusId' => "datiert",
		'publishStatusId' => "publiziert");

	$materialFields = array(
		'ceramicsCountId' => "Keramik",
		'animalBoneCountId' => "Tierknochen",
		'humanBoneCountId' => "Menschenknochen",
		'ferrousCountId' => "Eisen",
		'nonFerrousMetalCountId' => "Buntmetall",
		'glassCountId' => "Glas",
		'architecturalCeramicsCountId' => "Baukeramik",
		'daubCountId' => "Hüttenlehm",
		'stoneCountId' => "Stein",
		'silexCountId' => "Silex",
		'mortarCountId' => "Mörtel",
		'timberCountId' => "Holz");

	$sampleFields = array();  // TODO - NOT IMPLEMENTED


	try {

		$locRows[] = StockLocation12::getNode($_REQUEST['stockLocationId']);

		// if inner loc is requested load ALL inner locs - independend
		// of excavation id (because reusable locations have no excav id)
		// wrong excav ids are removed later
		if ($_REQUEST['listInnerLoc']) {
			$children = StockLocation12::getInnerLoc($_REQUEST['stockLocationId'], array("recursive" => true));
			$locRows = array_merge($children, $locRows);
			unset($children);
		}


		// get arch finds per excav
		// ATTENTION: scope=all is NOT implemented
		if ($_REQUEST['excavScope'] != "all") {
			$seleValsArchFind['excavId'] = $_REQUEST['excavId'];
			$sqlArchFindWhereExtra = " AND excavId=:excavId";
		}
		$sqlArchFind =
			"SELECT * FROM prepFindTMPNEW" .
			" WHERE stockLocationId=:stockLocationId {$sqlArchFindWhereExtra}" .
			" ORDER BY excavId, archFindId, archFindSubId";
		$psqlArchFindPrep = Dbw::$conn->prepare($sqlArchFind);

		$packRows = array();
		foreach ($locRows as $locRow) {

			// skip internal / real root
			if ($locRow['stockLocationId'] == StockLocation12::ROOT_ID) {
				continue;
			}

			// skip foreign excavs
			if ($locRow['excavId'] != $_REQUEST['excavId']) {
				continue;
			}

			// skip non-movable container
			// TODO checkbox to include arch finds of non-movable containers too?
			if ($locRow['movable'] != StockLocation12::MOVABLE_YES) {
				continue;
			}

			// collect arch find info per excav
			$seleValsArchFind['stockLocationId'] = $locRow['stockLocationId'];
			$psqlArchFind = Dbw::checkedExecute($psqlArchFindPrep, $seleValsArchFind);

			$archFindIds = array();
			$prepFindStatus = array();
			$prepFindMaterial = array();
			$prepFindSample = array();
			while ($archFindRow = $psqlArchFind->fetch(PDO::FETCH_ASSOC)) {
				$archFindIds[] = ExcavHelper::xidPrepareSubId($archFindRow['archFindId'], $archFindRow['archFindSubId']);
				foreach (array_keys($statusFields) as $fieldName) {
					$prepFindStatus[$fieldName][$archFindRow[$fieldName]] += 1;
				}
				foreach (array_keys($materialFields) as $fieldName) {
					if ($archFindRow[$fieldName]) {
						$prepFindMaterial[$fieldName] += 1;
					}
				}
				foreach (array_keys($sampleFields) as $fieldName) {
					if ($archFindRow[$fieldName]) {
						$prepFindSample[$fieldName] += 1;
					}
				}
			}
			$psqlArchFind->closeCursor();

			// skip empty container
			if (!$archFindIds) {
				continue;
			}

			// compose output
			$locRow['archFindIdList'] = ExcavHelper::multiXidPrepare(
				$archFindIds,	array("hideSubId" => $_REQUEST['hideArchFindSubId']));
			if ($locRow['archFindIdList']) {
				$locRow['archFindIdList'] .= "\n\n";
			}

			// material and sample
			if ($_REQUEST['printMaterialList'] && $prepFindMaterial) {
				$locRow['archFindIdList'] .= "* Material: ";
				$tmpArr = array();
				foreach ($prepFindMaterial as $fieldName => $count) {
					$tmpArr[] = $materialFields[$fieldName];
				}
				$locRow['archFindIdList'] .= implode(", ", $tmpArr) . "\n";
			}

			if ($_REQUEST['printSampleList'] && $prepFindSample) {
				$locRow['archFindIdList'] .= "* Proben: ";
				$tmpArr = array();
				foreach ($prepFindSample as $fieldName => $count) {
					$tmpArr[] = $sampleFields[$fieldName];
				}
				$locRow['archFindIdList'] .= implode(", ", $tmpArr) . "\n";
			}

			// status
			$prepFindCount = count($archFindIds);
			$statusTextArr = array();
			foreach ($prepFindStatus as $fieldName => $statusMode) {
				if ($statusMode[PrepFind12::STATUS_READY] == $prepFindCount) {
					$statusTextArr[] = $statusFields[$fieldName];
				}
				elseif ($statusMode[PrepFind12::STATUS_READY] || $statusMode[PrepFind12::STATUS_PARTIAL]) {
					$statusTextArr[] = "teilweise " . $statusFields[$fieldName];
				}
				else {
					//$statusTextArr[] = "nicht " . $statusFields[$fieldName];
				}
			}
			if ($_REQUEST['printStatusList'] && $statusTextArr) {
				$locRow['archFindIdList'] .= "* Bearbeitungsstatus: " . implode(", ", $statusTextArr) . "\n";
			}

			// print comment
			if ($locRow['contentComment']) {
				$locRow['contentComment'] = "* Anmerkung: " . $locRow['contentComment'];
			}

			$locRow['locationName'] = $locRow['name'];

			$packRows[$locRow['name']] = $locRow;
		}  // eo arch find collection

		// sort
		ksort($packRows, SORT_NATURAL);

		// get main data
		$companyRow = Dbw::fetchRow1("SELECT * FROM company LIMIT 1");
		$excavRow = Dbw::fetchRow1(
				"SELECT * FROM excavation WHERE id=:excavId",
				array("excavId" => $_REQUEST['excavId']));

		// pdf output
		$pdf = new OgerPdf0();
		$tpl = PdfTemplate::getTemplate('PackingList', "stock");
		$pdf->tplSet($tpl);
		$pdf->tplUse('init');

		$hfVals = array();
		$hfVals['dateTime'] = date("d.m.Y H:i");
		$hfVals['companyShortName'] = $companyRow['shortName'];
		$hfVals['excavName'] = $excavRow['name'];
		$hfVals['excavOfficialId'] = $excavRow['officialId'];


		$pdf->tplSetHeaderValues($hfVals);
		$pdf->tplSetFooterValues($hfVals);

		$pdf->addPage();
		foreach ($packRows as $loc) {
			$pdf->tplUse('body', $loc);
		}
		$pdf->tplUse('body_end', $loc);

		//$loc['pos'] = $pdf->getY();
		if ($pdf->getY() > 200) {
			$pdf->addPage();
		}
		$pdf->tplUse('sign_block', $loc);

		$pdf->Output(Oger::_('Ausfolgeschein'), 'I');

	}
	catch (Exception $ex) {
		echo Extjs::errorMsg($ex->getMessage());
		exit;
	}

	exit;
}  // eo packing list



// create content sheet for a location (can include inner tree)
// for one or all excavations
if ($_REQUEST['_action'] == "locContentSheet") {


	if (!$_REQUEST['stockLocationId']) {
		echo Extjs::errorMsg(Oger._("Lagerort ID fehlt."));
		exit;
	}

	$pdf = new OgerPdf0();
	$tpl = PdfTemplate::getTemplate('ContentSheet', "stock");
	$pdf->tplSet($tpl);
	$pdf->tplUse('init');

	// get offsets for one sheet
	$offsets = array();
	$offsetsBlock = $pdf->tplGetBlock('offsets');
	$offsetsBlock = str_replace("\r", "\n", $offsetsBlock);
	$lines = explode("\n", $tpl);
	for ($i=0; $i < count($lines); $i++) {
		list($cmd, $opts) = explode(":", $lines[$i], 2);
		$maxSheetDef = 0;
		$cmd = trim($cmd);
		if ($cmd == "SHEETSPERPAGE") {
			$sheetsPerPage = trim($opts);
		}
		if ($cmd == "SHEET") {
			list($pageNo, $offsetX, $offsetY) = explode(",", $opts);
			$pageNo = trim($pageNo);
			$offsets[$pageNo] = array($offsetX, $offsetY);
			$maxSheetDef = max($maxSheetDef, $pageNo + 1);
		}
	}
	if ($sheetsPerPage == 0) {
		$sheetsPerPage = $maxSheetDef;
	}

	$opts['sheetsPerPage'] = $sheetsPerPage;
	$opts['offsets'] = $offsets;

	try {

		$rows[] = StockLocation12::getNode($_REQUEST['stockLocationId']);

		// if inner loc is requested load ALL inner locs - independend
		// of excavation id (because reusable locations have no excav id)
		// wrong excav ids are removed later
		if ($_REQUEST['listInnerLoc']) {
			$children = StockLocation12::getInnerLoc($_REQUEST['stockLocationId'], array("recursive" => true));
			$rows = array_merge($children, $rows);
			unset($children);
		}

		$tree = StockLocation12::rows2Tree($rows);

		// remove root itself - see loadInnerLoc
		if ($tree[0]['stockLocationId'] == StockLocation12::ROOT_ID) {  // realy root
			$tree = $tree[0]['children'];
		}

		foreach ($tree as $node) {
			listLocContentSheetRecursive($pdf, $node, $opts, $layout);
		}

	}
	catch (Exception $ex) {
		echo Extjs::errorMsg($ex->getMessage());
		exit;
	}

	$pdf->Output(Oger::_('Lagerzettel'), 'I');
	exit;
}  // eo location content sheet

/*
 * list location content sheet recursive
 */
function listLocContentSheetRecursive($pdf, $node, $opts, &$layout) {

	// get arch finds per excav
	$seleValsArchFind = array("stockLocationId" => $node['stockLocationId']);
	if ($_REQUEST['excavScope'] != "all") {
		$seleValsArchFind['excavId'] = $_REQUEST['excavId'];
		$sqlArchFindWhereExtra = " AND excavId=:excavId";
	}
	$sqlArchFind =
		"SELECT * FROM prepFindTMPNEW" .
		" WHERE stockLocationId=:stockLocationId {$sqlArchFindWhereExtra}" .
		" ORDER BY excavId, archFindId, archFindSubId";
	$psqlArchFind = Dbw::checkedExecute($sqlArchFind, $seleValsArchFind);

	$data = array();
	while ($row = $psqlArchFind->fetch(PDO::FETCH_ASSOC)) {
		$excavId = $row['excavId'];
		if ($oldExcavId != $excavId) {
			$data[$excavId] = array();
			$oldExcavId = $excavId;
		}
		$data[$excavId][$node['stockLocationId']]['stockLocation'] = $node;
		$tmpArchFindId = $row['archFindId'];
		$tmpArchFindSubId = ExcavHelper::xidPrepareSubId($row['archFindId'], $row['archFindSubId']);
		$data[$excavId][$node['stockLocationId']]['archFind'][$tmpArchFindSubId] = $row;
	}

	// fake empty location
	if (!$data && $_REQUEST['listEmptyInnerLoc']) {
		$data[$excavId][$node['stockLocationId']]['stockLocation'] = $node;
		$data[$excavId][$node['stockLocationId']]['archFind'] = array();
	}

	// pdf output
	$excavs = array();
	foreach ($data as $excavId => $stockLocation) {

		if (!$excavs[$excavId]) {
			$excavs[$excavId] = Dbw::fetchRow1(
				"SELECT * FROM excavation WHERE id=:excavId",
				array("excavId" => $excavId));
		}

		foreach ($stockLocation as $stockLocationId => $details) {

			$details['archFind'] = ($details['archFind'] ?: array());

			$vals = array(
				'excavName' => $excavs[$excavId]['name'],
				'officialId' => $excavs[$excavId]['officialId'],
				'locationName' => $details['stockLocation']['name'],
				'archFindIdList' => ExcavHelper::multiXidPrepare(
					array_keys($details['archFind']),
					array("hideSubId" => $_REQUEST['hideArchFindSubId'])),
				'contentComment' => $details['stockLocation']['contentComment'],
				//'X' => var_export($details, true),
			);


			$statusFields = array('washStatusId', 'labelStatusId', 'restoreStatusId', 'photographStatusId',
				'drawStatusId', 'layoutStatusId', 'scientificStatusId', 'publishStatusId');

			$materialFields = array(
				'ceramicsCountId' => "Keramik",
				'animalBoneCountId' => "Tierknochen",
				'humanBoneCountId' => "Menschenknochen",
				'ferrousCountId' => "Eisen",
				'nonFerrousMetalCountId' => "Buntmetall",
				'glassCountId' => "Glas",
				'architecturalCeramicsCountId' => "Baukeramik",
				'daubCountId' => "Hüttenlehm",
				'stoneCountId' => "Stein",
				'silexCountId' => "Silex",
				'mortarCountId' => "Mörtel",
				'timberCountId' => "Holz");

			$sampleFields = array();  // TODO - NOT IMPLEMENTED

			// count prep find status per status-level for each location content
			$prepFindStatus = array();
			$prepFindMaterial = array();
			$prepFindSample = array();
			foreach ($details['archFind'] as $prepFindDetail) {
				foreach ($statusFields as $fieldName) {
					$prepFindStatus[$fieldName][$prepFindDetail[$fieldName]] += 1;
				}
				foreach (array_keys($materialFields) as $fieldName) {
					if ($prepFindDetail[$fieldName]) {
						$prepFindMaterial[$fieldName] += 1;
					}
				}
				foreach (array_keys($sampleFields) as $fieldName) {
					if ($prepFindDetail[$fieldName]) {
						$prepFindSample[$fieldName] += 1;
					}
				}
			}

			$prepFindCount = count($details['archFind']);
			foreach ($prepFindStatus as $fieldName => $statusMode) {
				if ($statusMode[PrepFind12::STATUS_READY] == $prepFindCount) {
					//$vals[$fieldName] = "[x]";
					//$vals[$fieldName] = html_entity_decode("&#10004;", ENT_COMPAT | ENT_HTML401, "UTF-8");
					$vals[$fieldName] = html_entity_decode("&#10004;");
				}
				elseif ($statusMode[PrepFind12::STATUS_READY] || $statusMode[PrepFind12::STATUS_PARTIAL]) {
					//Oger::_("teilweise\n"); &#12316, &#11605, &#11569, &#8776,  . " " . html_entity_decode("&#8776;") . " ~\n"
					//$vals[$fieldName] = html_entity_decode("&#9680;");  // halfmoon
					$vals[$fieldName] = Oger::_("teilweise\n");
				}
				else {
					$vals[$fieldName] = html_entity_decode("&#9675;");  // "o";
				}
			}


			if ($_REQUEST['printMaterialList'] && $prepFindMaterial) {
				$tmpArr = array();
				foreach ($prepFindMaterial as $fieldName => $count) {
					$tmpArr[] = $materialFields[$fieldName];
				}
				//$vals['archFindIdList'] .= "\n\nMaterial:\n" .implode(", ", $tmpArr);
				$vals['contentComment'] .= "\nMaterial: " .implode(", ", $tmpArr);
			}

			if ($_REQUEST['printSampleList'] && $prepFindSample) {
				$tmpArr = array();
				foreach ($prepFindSample as $fieldName => $count) {
					$tmpArr[] = $sampleFields[$fieldName];
				}
				//$vals['archFindIdList'] .= "\n\nProben:\n" . implode(", ", $tmpArr);
				$vals['contentComment'] .= "\nProben: " .implode(", ", $tmpArr);
			}

			// number of copies for one location id
			for ($count = 0; $count < $_REQUEST['numCopies']; $count++) {

				$pos = ($layout['sheetCount']++) % $opts['sheetsPerPage'];
				if ($pos == 0) {
					$pdf->addPage();
				}
				$pdf->startTransform();
				$pdf->translate($opts['offsets'][$pos][0], $opts['offsets'][$pos][1]);
				$pdf->tplUse('body', $vals);
				if ($_REQUEST['printLogo']) {
					// TODO extend pdf template to move image selection from code to template
					$pdf->Image("img/logo.gif", 101, 161, 23, 18,
					"", "", "", false, 0, "", "", false, "", "CM");
				}
				$pdf->stopTransform();
			}
		}
	}  // eo  pdf output of data array


	// process children
	if ($node['children'] && $_REQUEST['listInnerLoc']) {
		foreach ($node['children'] as $child) {
			listLocContentSheetRecursive($pdf, $child, $opts, $layout);
		}
	}

}  // eo list location content sheet recursive








echo Extjs::errorMsg(sprintf("Invalid request action '%s' in '%s'.", $_REQUEST['_action'], $_SERVER['PHP_SELF']));
exit;
