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
 * MEMOS
 * Complexes are only used for building clusters, but not for relationships between stratums.
 * Relations of complexes are ignored at all.
 *
 * Maybe we should skip partOfComplex and complexPartId collection in nodeListFromDb and joining equal nodes
 * and defer that till cluster building like we do with getting object ids.
 * We decide this when we code the cluster building for complexes.
 *
 * Maybe we should store the outernodes and innernodes ids with target cluster level to avoid name collisions.
 * For example if a basenode is named "Obj_xxx" and there is a object with id "xxx" too we have a problem.
 * But because this is very unlikely we defer the maintaining of this extra info.
 *
 */


/**
* Stratum matrix node for harris matrix
*/
class MatrixNode  {

	public static $log2 = true;

	public static $opts = array();

	public $nodeId;
	public $nodeName;
	public $nodeIdOri;
	public $nodeNameOri;

	public $excavId;
	public $stratumId;
	public $categoryId;

	public $matrixInfo = array();
	public $complexPartIdArray = array();
	public $partOfComplexArray = array();

	public $innerStratumNodes = array();
	public $equalHeadNode;
	public $isContempHeadNode;

	public $directLaterNodes = array();
	public $directEarlierNodes = array();
	public $indirectLaterNodesPool = array();
	public $isFinished = false;
	public $rowNum = 0;  // row nums start with 1 (and row 1 will be reserved for nodes marked as top level nodes)

	public $clusterLevel = 0;
	public $innerClusterNodes = array();
	public $outerClusterNodes = array();

	public static $relationNames = array();
	public static $allNodes = array();
	public static $nodePool = array();
	public static $stratumNodes = array();
	public static $complexNodes = array();

	public static $topNodes = array();
	public static $contempWithHeadNodes = array();

	public static $harrisNodes = array();
	public static $harrisTopNodes = array();

	public static $clusterTree = array();
	public static $isMultiClusterTree = false;

	public static $cycleNodes = array();
	public static $cwLaterErr = array();

	public static $errorCount;
	public static $startTime;
	public static $meanTime;


	// ###

	public static $fieldNames = array(
		'nodeId',
		'nodeName',
		'excavId',
		'stratumId',
		'categoryId',
		'typeId',
		'isTopEdge',
		'isBottomEdge',
		'hasAutoInterface',
		'datingSpec',   // for stratify only
		'datingPeriodId',   // for stratify only
	);




 /**
	* Constructor
	*/
	public function __construct($values = array()) {

		foreach(array_keys($values) as $fieldName) {
			if (in_array($fieldName, static::$fieldNames)) {
				$this->$fieldName = $values[$fieldName];
			}
		}

		// force arrays for all matrix info entries
		foreach (array_keys(StratumMatrix::getRelationNames()) as $relKey) {
			if (is_null($this->matrixInfo[$relKey])) {
				$this->matrixInfo[$relKey] = array();
			}
		}

	}  // eo constructor



	/*
	* Collect and prepare data
	*/
	public static function prepareMatrix($excavId, $range = array(), $opts = array()) {

		// preserve given opts in static variable
		static::$opts = $opts;

		static::$errorCount = 0;
		static::$startTime = time();
		static::$meanTime = static::$startTime;

		static::$relationNames = StratumMatrix::getRelationNames();

		// get node list from db
		static::nodeListFromDb($excavId, $whereVals);

		// build and check node tree
		// must be done before building clusters because we join equal-to nodes here
		static::buildHarrisTree($opts);

		// build and check node cluster
		static::buildClusterTree($opts);
	}  // eo prepare data





 /**
	* Load node list from db
	*/
	public static function nodeListFromDb($excavId, $range = array(), $opts = array()) {

		echo "<b>Matrixknoten von Stratum-Datenbank einlesen</b><br>\n";

		// get stratum categories
		$categorieRecords = StratumCategory::getRecordsWithKeys();

		// get stratum types
		$typeNames = array();
		$tmpPstmt = Db::prepare("SELECT * FROM " . StratumType::$tableName);
		$tmpPstmt->execute();
		//$stratumTypes = $tmpPstmt->fetchAll(PDO::FETCH_ASSOC);
		while ($row = $tmpPstmt->fetch(PDO::FETCH_ASSOC)) {
			$typeNames[$row['id']] = $row;
		}
		$tmpPstmt->closeCursor();


		// read matrix nodes
		static::$allNodes = array();

		$whereVals = array();
		$whereVals['excavId'] = $excavId;

		if ($range['stratumBeginId']) {
			$whereVals['stratumId#SIGNED,>=,beginId'] = $range['stratumBeginId'];
		}
		if ($range['stratumEndId']) {
			$whereVals['stratumId#SIGNED,<=,endId'] = $range['stratumEndId'];
		}
		if ($range['beginDate']) {
			$whereVals['date,>='] = $range['beginDate'];
		}
		if ($range['endDate']) {
			$whereVals['date,<='] = $range['endDate'];
		}

		// fetch from db
		$pstmt = Db::prepare(
			"SELECT stratumId,categoryId,typeId,isTopEdge,isBottomEdge,hasAutoInterface,interpretation,datingSpec,datingPeriodId" .
			" FROM " . Stratum::$tableName, $whereVals, " ORDER BY excavId,0+stratumId");
		$whereVals = Db::getCleanWhereVals($whereVals);
		$pstmt->execute($whereVals);
		while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
			$node = new self($row);
			$node->excavId = $excavId;
			$node->nodeId = $node->stratumId;
			$node->nodeIdOri = $node->stratumId;;
			$node->nodeName = $node->stratumId;
			$node->nodeNameOri = $node->stratumId;

			$node->categoryName = ($categorieRecords[$node->categoryId]['name'] ?: $node->categoryId);
			$node->typeName = ($typeNames[$node->typeId]['name'] ?: $node->typeId);

			// get matrix info, make backup and unify equal and contemp info
			$node->matrixInfo = StratumMatrix::getFullRelationsIdArray($node->excavId, $node->stratumId);
			$node->matrixInfoBak = $node->matrixInfo;

			$node->matrixInfo[StratumMatrix::THIS_IS_EQUAL_TO] =
												Oger::arrayMergeAssoc($node->matrixInfo[StratumMatrix::THIS_IS_EQUAL_TO],
																									$node->matrixInfo[StratumMatrix::THIS_IS_REVERSE_EQUAL_TO]);
			$node->matrixInfo[StratumMatrix::THIS_IS_REVERSE_EQUAL_TO] = array();

			$node->matrixInfo[StratumMatrix::THIS_IS_CONTEMP_WITH] =
												Oger::arrayMergeAssoc($node->matrixInfo[StratumMatrix::THIS_IS_CONTEMP_WITH],
																									$node->matrixInfo[StratumMatrix::THIS_IS_REVERSE_CONTEMP_WITH]);
			$node->matrixInfo[StratumMatrix::THIS_IS_REVERSE_CONTEMP_WITH] = array();

			// get complex parts info make backup and unify equal and contemp info
			$node->complexPartIdArray =
						StratumComplex::getPartIdArray($node->excavId, $node->stratumId);
			$node->complexPartIdArrayBak = $node->complexPartIdArray;

			$node->partOfComplexArray =
						StratumComplex::getPartOfComplexIdArray($node->excavId, $node->stratumId);
			$node->partOfComplexArrayBak = $node->partOfComplexArray;

			// more fields
			$node->innerStratumNodes[$node->nodeId] = $node;

			// put to collection arrays and split complex from stratum nodes
			static::$allNodes[$node->nodeId] = $node;
			if ($node->categoryId == StratumCategory::ID_COMPLEX) {
				static::$complexNodes[$node->nodeId] = $node;
			}
			else {
				$node->isStratumNode = true;
				static::$stratumNodes[$node->stratumId] = $node;
			}
		}  // eo loop over db

		echo count(static::$stratumNodes) . " Knoten eingelesen.<br>\n";
		static::log2();
		echo "<hr>\n";
	}  // eo node list from db



	/**
	* Perform base checks (as part of building harris tree)
	*/
	private static function nodeBaseCheck($opts = array(), $localNodeList, $checkJoinedNodes = false) {

		if ($checkJoinedNodes) {
			$extraMsg = " für zusammengefasste Knoten";
		}

		// check relations
		echo "<b>Prüfung auf nicht existierende oder selbstreflexive Beziehungen$extraMsg</b><br>\n";
		foreach($localNodeList as $curNode) {

			foreach($curNode->matrixInfo as $mi_key => $matrixPart) {

				// do not check self reference for qual-to relation for joined nodes
				if ($checkJoinedNodes && $mi_key == StratumMatrix::THIS_IS_EQUAL_TO) {
					continue;
				}

				$relationName = static::$relationNames[$mi_key];

				foreach($matrixPart as $stratumId) {

					if (!static::$stratumNodes[$stratumId] || $stratumId == $curNode->nodeId) {
						echo "FEHLER: Stratum {$curNode->stratumId}: Bezugs-Stratum $stratumId in Matrix-Referenz '{$relationName}' ";
						if (!static::$stratumNodes[$stratumId]) {
							echo "existiert nicht.<br>\n";
						}
						elseif ($stratumId == $curNode->nodeId) {
							echo "zeigt auf sich selbst.<br>\n";
						}
						static::checkErrorCount();
						if ($opts['autoCorrect']) {
							echo "&nbsp;&nbsp;UMGEHUNG: Stratum {$curNode->stratumId}: Bezugs-Stratum $stratumId in Matrix-Referenz '{$relationName}' wird ignoriert.<br>\n";
							unset($curNode->matrixInfo[$mi_key][$stratumId]);
						}
					}

				}  // eo loop over matrix info parts
			}  // eo matrixinfo


			// check if one reference stratum is used in multiple matrix relations
			// There is NO autocorrect done !!!
			// FIXME cleanup multiple usage of refernces, because maybe this is a source for endless loops
			$tmpStratum = new Stratum(array('stratumid' => $curNode->stratumId));
			$tmpError = $tmpStratum->createStratumMatrix(
				StratumMatrix::getRelationIdListsFromMatrixInfo($curNode->matrixInfo, array('mergeReverseAll' => true)),
				array('reportErrors' => true));
			if ($tmpError) {
				echo "FEHLER: Knoten {$curNode->nodeName}: $tmpError";
				static::checkErrorCount();
			}


			// complex stratum list info
			foreach($curNode->complexPartIdArray as $stratumId) {

				$relationName = "Stratumliste zu Komplex";

				if (!static::$stratumNodes[$stratumId] || $stratumId == $curNode->nodeId) {
					echo "FEHLER: Stratum {$curNode->stratumId}: Bezugs-Stratum $stratumId in '{$relationName}' ";
					if (!static::$stratumNodes[$stratumId]) {
						echo "existiert nicht.<br>\n";
					}
					elseif ($stratumId == $curNode->nodeId) {
						echo "zeigt auf sich selbst.<br>\n";
					}

					static::checkErrorCount();
					if ($opts['autoCorrect']) {
						echo "&nbsp;&nbsp;UMGEHUNG: Stratum {$curNode->stratumId}: Bezugs-Stratum $stratumId in '{$relationName}' wird ignoriert.<br>\n";
						unset($curNode->complexPartIdArray[$stratumId]);
					}
				}
			}  // eo loop over complex stratum list

			// part of complex info
			foreach($curNode->partOfComplexArray as $stratumId) {

				$relationName = "Teil von Komplex";

				if (!static::$stratumNodes[$stratumId] || $stratumId == $curNode->nodeId) {
					echo "FEHLER: Stratum {$curNode->stratumId}: Bezugs-Stratum $stratumId in '{$relationName}' ";
					if (!static::$stratumNodes[$stratumId]) {
						echo "existiert nicht.<br>\n";
					}
					elseif ($stratumId == $curNode->nodeId) {
						echo "zeigt auf sich selbst.<br>\n";
					}

					static::checkErrorCount();
					if ($opts['autoCorrect']) {
						echo "&nbsp;&nbsp;UMGEHUNG: Stratum {$curNode->stratumId}: Bezugs-Stratum $stratumId in '{$relationName}' wird ignoriert.<br>\n";
						unset($curNode->partOfComplexArray[$stratumId]);
					}
				}
			}  // eo loop over part of complex


			// check is-top and is-bottom
			if ($curNode->isTopEdge && count($curNode->matrixInfo[StratumMatrix::THIS_IS_EARLIER_THAN])) {
				echo "FEHLER: Stratum {$curNode->nodeName} ist als Grabungsoberkante markiert, hat aber '" .
						 static::$relationNames[StratumMatrix::THIS_IS_EARLIER_THAN] . "' Beziehungen.<br>";
				static::checkErrorCount();
			}
			if ($curNode->isBottomEdge && count($curNode->matrixInfo[StratumMatrix::THIS_IS_LATER_THAN])) {
				echo "FEHLER: Stratum {$curNode->nodeName} ist als Grabungsunterkante markiert, hat aber '" .
						 static::$relationNames[StratumMatrix::THIS_IS_LATER_THAN] . "' Beziehungen.<br>";
				static::checkErrorCount();
			}

		}  // eo check relations

		static::log2();
		echo "<hr>\n";
	}  // eo node base check


	/**
	* Build tree for nodes
	*/
	public static function buildHarrisTree($opts = array()) {

		// do base checks for stratum nodes
		static::nodeBaseCheck($opts, static::$stratumNodes, false);

		static::$nodePool = static::$stratumNodes;
		static::$harrisNodes = array();


		echo "<b>Zusammenfassung von Knoten über die '" . static::$relationNames[StratumMatrix::THIS_IS_EQUAL_TO] . "' Beziehung</b><br>\n";
		if (!$opts['joinEqual']) {
			echo " - wurde nicht ausgewählt.<hr>\n";
		}
		else {
			static::joinEqualToNodes($opts);
		}


		echo "<b>Die '" . static::$relationNames[StratumMatrix::THIS_IS_CONTEMP_WITH] . "' Beziehung synchronisieren</b><br>\n";
		static::syncContempWithNodes($opts);


		echo "<b>Die Knoten in vertikale Ketten eingliedern</b><br>\n";
		static::buildHarrisChains($opts);


		echo "<b>Redundante Direkt-Beziehungen entfernen</b><br>\n";
		if (!$opts['removeRedundant']) {
			echo " - wurde nicht ausgewählt.<br>\n";
		}
		else {
			static::removeRedundantRelations($opts);
		}

	}  // eo node tree



	/**
	* Join equal relations
	*/
	public static function joinEqualToNodes($opts = array()) {

		$joinHeadNodeCount = 0;
		$joinSubNodeCount = 0;
		$joinHeadRefs = array();
		$equalHeadNodeList = array();

		// perform join
		foreach(static::$nodePool as $curNode) {

			// if a node is already removed from nodepool skip to next
			if (!static::$nodePool[$curNode->nodeId]) {
				continue;
			}
			// the current node is not part of any equal-to relation
			if (!$curNode->matrixInfo[StratumMatrix::THIS_IS_EQUAL_TO]) {
				continue;
			}

			// start equal-to relation with current node
			$allJoinNodeIds = array();
			$allJoinNodeIds[$curNode->nodeId] = $curNode->nodeId;

			// collect equal info recursive from from equal-to ids
			$addJoinNodeIds = $allJoinNodeIds;
			while ($addJoinNodeIds) {

				$newJoinNodeIds = array();

				// collection loop for the current node
				foreach($addJoinNodeIds as $joinNodeId) {

					// remove non existent nodes from equal node collection
					if (!static::$stratumNodes[$joinNodeId]) {
						unset($allJoinNodeIds[$joinNodeId]);
						echo "Knoten {$joinNodeId} existiert nicht und kann daher nicht mit Knoten {$curNode->nodeName} zusammengeführt werden.<br>\n";
						// do not add to error counter, because already counted
						continue;
					}

					$tmpNode = static::$stratumNodes[$joinNodeId];
					foreach ($tmpNode->matrixInfo[StratumMatrix::THIS_IS_EQUAL_TO] as $tmpJoinNodeId) {
						if (!$allJoinNodeIds[$tmpJoinNodeId]) {
							$allJoinNodeIds[$tmpJoinNodeId] = $tmpJoinNodeId;
							$newJoinNodeIds[$tmpJoinNodeId] = $tmpJoinNodeId;
						}
					}
				}
				// pass new joined nodes out for next loop
				$addJoinNodeIds = $newJoinNodeIds;
			}  // eo collection loop


			// if no equal nodes collected, then loop
			if (!count($allJoinNodeIds)) {
				continue;
			}

			// prepare merge - use the "first" node in numeric order as head node
			ksort($allJoinNodeIds, SORT_NUMERIC);
			$headNodeId = reset($allJoinNodeIds);

			// if the current node is the only one, then loop
			if (count($allJoinNodeIds) == 1 && $headNodeId == $curNode->nodeId) {
				continue;
			}


			// mark headnode
			$headNode = static::$allNodes[$headNodeId];
			$equalHeadNodeList[$headNode->nodeId] = $headNode;

			$joinHeadNodeCount++;
			$joinSubNodeCount += count($allJoinNodeIds);

			$headNode->equalHeadNode = $headNode;

			// merge all infos into equal head node - avoid self references
			// and remove sub nodes from node pool
			unset($allJoinNodeIds[$headNodeId]);
			foreach($allJoinNodeIds as $joinNodeId) {

				$subNode = static::$stratumNodes[$joinNodeId];

				// set head node and maintain equal head refs
				$subNode->equalHeadNode = $headNode;
				$joinHeadRefs[$subNode->nodeId] = $subNode->equalHeadNode->nodeId;

				// merge node names and inner stratum nodes
				$headNode->nodeName .= "=" . $subNode->nodeName;
				$headNode->innerStratumNodes[$subNode->nodeId] = $subNode;

				// show error on merge conflicts
				if ($headNode->categoryId != $subNode->categoryId) {
					echo "FEHLER: Kategorie-Konflikt: {$headNode->nodeNameOri}={$headNode->categoryName} / {$subNode->nodeNameOri}={$subNode->categoryName}. Kategorie {$subNode->categoryName} wird ignoriert.<br>\n";
					static::checkErrorCount();
				}

				// merge is-top and is-bottom info
				$headNode->isTopEdge = intval($headNode->isTopEdge || $subNode->isTopEdge);
				$headNode->isBottomEdge = intval($headNode->isBottomEdge || $subNode->isBottomEdge);

				// merge matrix info
				foreach($subNode->matrixInfo as $mi_key => $matrixPart) {
					foreach($matrixPart as $tmpNodeId) {
						if ($tmpNodeId != $headNode->nodeId) {
							$headNode->matrixInfo[$mi_key][$tmpNodeId] = $tmpNodeId;
						}
					}
				}  // eo merge matrix info

				// merge complex info
				foreach($subNode->partOfComplexArray as $tmpNodeId) {
					if ($tmpNodeId != $headNode->nodeId) {
						$headNode->partOfComplexArray[$tmpNodeId] = $tmpNodeId;
					}
				}
				// complexPartIdArray should never be needed, because we
				// excluded complex nodes here, but we do the merge anyway
				foreach($subNode->complexPartIdArray as $tmpNodeId) {
					if ($tmpNodeId != $headNode->nodeId) {
						$headNode->complexPartIdArray[$tmpNodeId] = $tmpNodeId;
					}
				}

				// finaly remove sub nodes from node pool
				unset(static::$nodePool[$subNode->nodeId]);

			}  // eo merge sub nodes into equal head node

			echo "Erstelle neuen Knoten '{$headNode->nodeName}' und entferne die Detailknoten aus der Matrix.<br>\n";

		}  // eo join equals loop


		// postprocess equal-to relations join
		// replace all referencec to a equal-sub node to the corresponding head node id
		// if we find a ref to a node that has a reference to a head node
		// we change the node id to that of the head node
		foreach(static::$nodePool as $curNode) {
			// TODO maybe we can exclude nodes that ARE headnodes?
			// adjust matrix info
			foreach ($curNode->matrixInfo as $mi_key => $matrixPart) {
				foreach ($matrixPart as $tmpNodeId) {
					if ($joinHeadRefs[$tmpNodeId]) {
						unset($curNode->matrixInfo[$mi_key][$tmpNodeId]);
						$curNode->matrixInfo[$mi_key][$joinHeadRefs[$tmpNodeId]] = $joinHeadRefs[$tmpNodeId];
					}
				}
			}
			// adjust complex info
			foreach($curNode->partOfComplexArray as $tmpNodeId) {
				if ($joinHeadRefs[$tmpNodeId]) {
					unset($curNode->partOfComplexArray[$tmpNodeId]);
					$curNode->partOfComplexArray[$joinHeadRefs[$tmpNodeId]] = $joinHeadRefs[$tmpNodeId];
				}
			}
			foreach($curNode->complexPartIdArray as $tmpNodeId) {
				if ($joinHeadRefs[$tmpNodeId]) {
					unset($curNode->complexPartIdArray[$tmpNodeId]);
					$curNode->complexPartIdArray[$joinHeadRefs[$tmpNodeId]] = $joinHeadRefs[$tmpNodeId];
				}
			}
		}
		unset($joinHeadRefs);

		echo "$joinSubNodeCount Knoten über die '" . static::$relationNames[StratumMatrix::THIS_IS_EQUAL_TO] . "' Beziehung zu $joinHeadNodeCount Knoten zusammengefasst.<br>\n";
		static::log2();
		echo "<hr>\n";


		// do base checks  -now for joined nodes
		static::nodeBaseCheck($opts, $equalHeadNodeList, true);

	}  // eo if join equal



	/**
	* Sync contemp with nodes (traverse contemp with relations)
	*/
	public static function syncContempWithNodes($opts = array()) {

		$joinHeadNodeCount = 0;
		$joinSubNodeCount = 0;

		// perform contemp traversation
		foreach(static::$nodePool as $curNode) {

			// if a node is already removed from nodepool skip to next
			if (!static::$nodePool[$curNode->nodeId]) {
				continue;
			}
			// the current node is not part of any contemp with relation
			if (!$curNode->matrixInfo[StratumMatrix::THIS_IS_CONTEMP_WITH]) {
				continue;
			}

			// start contemp with relation with current node
			$allJoinNodeIds = array();
			$allJoinNodeIds[$curNode->nodeId] = $curNode->nodeId;

			// collect contemp info recursive from from contemp with ids
			$addJoinNodeIds = $allJoinNodeIds;
			while ($addJoinNodeIds) {

				$newJoinNodeIds = array();

				// collection loop for the current node
				foreach($addJoinNodeIds as $joinNodeId) {

					// remove non existent nodes from contemp node collection
					if (!static::$stratumNodes[$joinNodeId]) {
						unset($allJoinNodeIds[$joinNodeId]);
						echo "Knoten {$joinNodeId} exist nicht und kann daher nicht mit Knoten {$curNode->nodeName} Zeitgleich gesetzt werden.<br>\n";
						// do not add to error counter, because already counted
						continue;
					}

					$tmpNode = static::$stratumNodes[$joinNodeId];
					foreach ($tmpNode->matrixInfo[StratumMatrix::THIS_IS_CONTEMP_WITH] as $tmpJoinNodeId) {
						if (!$allJoinNodeIds[$tmpJoinNodeId]) {
							$allJoinNodeIds[$tmpJoinNodeId] = $tmpJoinNodeId;
							$newJoinNodeIds[$tmpJoinNodeId] = $tmpJoinNodeId;
						}
					}
				}
				// pass new joined nodes out for next loop
				$addJoinNodeIds = $newJoinNodeIds;
			}  // eo collection loop


			// if no contemp nodes collected, then loop
			if (!count($allJoinNodeIds)) {
				continue;
			}

			// prepare sync - use the "first" node in numeric order as head node
			ksort($allJoinNodeIds, SORT_NUMERIC);
			$headNodeId = reset($allJoinNodeIds);

			// if the current node is the only one, then loop
			if (count($allJoinNodeIds) == 1 && $headNodeId == $curNode->nodeId) {
				continue;
			}

			// mark first node as headnode
			$headNode = static::$allNodes[$headNodeId];
			$headNode->isContempHeadNode = true;
			static::$contempWithHeadNodes[$headNodeId] = $headNode;

			// spread contemp-with across all nodes - avoid self references
			foreach($allJoinNodeIds as $joinNodeId) {
				$joinSubNodeCount++;
				$subNode = static::$stratumNodes[$joinNodeId];
				$subNode->matrixInfo[StratumMatrix::THIS_IS_CONTEMP_WITH] = $allJoinNodeIds;
				unset($subNode->matrixInfo[StratumMatrix::THIS_IS_CONTEMP_WITH][$joinNodeId]);
			}  // eo spread contemp info

		}  // eo spread contemp-with loop

		echo "Die '" . static::$relationNames[StratumMatrix::THIS_IS_CONTEMP_WITH] . "' Beziehung bei $joinSubNodeCount Knoten synchronisiert.<br>\n";
		static::log2();
		echo "<hr>\n";

	}  // eo sync contemp with



	/**
	* Build vertical chains
	*/
	public static function buildHarrisChains($opts = array()) {


		foreach (static::$nodePool as $curNode) {
			// if a node is already removed from nodepool skip to next
			if (!static::$nodePool[$curNode->nodeId]) {
				continue;
			}
			// if we have a top node (nothing above/later) then we start a tree
			if (!$curNode->matrixInfo[StratumMatrix::THIS_IS_EARLIER_THAN]) {
				static::buildEarlierTree($curNode, null, null, $opts);
			}
		}


		// ####################################
		// ### list unused nodes ###
		// this are nodes that have earlier than ids (are not detected as top nodes)
		// but are not used in the harris matrix for now

		if (static::$nodePool) {
			echo "<b>" . count(static::$nodePool) . " nicht zugeordnete Knoten vorhanden</b><br>\n";
			$delim = '';
			foreach (static::$nodePool as $curNode) {
				echo $delim . $curNode->nodeName;
				$delim = ", ";
			}
			echo  "<br>Für diese Knoten wird ein zweiter Versuch ohne Prüfung auf die Startlage unternommen.<hr>\n";

			echo "<b>Zweiter Versuch ohne Prüfung auf die Startlage</b><br>\n";
			foreach (static::$nodePool as $curNode) {
				// if a node is already removed from nodepool skip to next
				if (!static::$nodePool[$curNode->nodeId]) {
					continue;
				}
				// if there are later nodes in matrix info we report that fact
				if ($curNode->matrixInfo[StratumMatrix::THIS_IS_EARLIER_THAN]) {
					echo "Das Stratum {$curNode->nodeName} wird jetzt in der obersten Ebene angeordnet, " .
							 "obwohl die Bezugsknoten '" . implode(", ", $curNode->matrixInfo[StratumMatrix::THIS_IS_EARLIER_THAN]) .
							 "' in der '" . static::$relationNames[StratumMatrix::THIS_IS_EARLIER_THAN] .
							 "' Beziehung angegeben wurden.<br>\n";
				}
				// we start a tree and do not check if there are later nodes
				static::buildEarlierTree($curNode, null, null, $opts);
			}
			static::log2();
			static::checkErrorCount();
			echo "<hr>\n";
		}


		// ####################################
		// ### list absolutely lost nodes ###
		// this are nodes that have earlier than ids (are not top nodes)
		// but are not used in the harris matrix for now

		if (static::$nodePool) {
			echo "<b>" . count(static::$nodePool) . " nicht zuordenbare Knoten in der Harris-Matrix</b><br>\n";
			$delim = '';
			foreach (static::$nodePool as $curNode) {
				echo $delim . $curNode->nodeName;
				$delim = ", ";
				unset(static::$nodePool[$curNode->nodeId]);
				static::$harrisNodes[$curNode->nodeId] = $curNode;

				static::$topNodes[$curNode->nodeId] = $curNode;
			}
			echo  "<br>Diese Knoten werden ohne weitere Prüfung zur Matrix hinzugefügt.<hr>\n";
		}

		// count harris nodes.
		// There are duplicates because one node can be in many chains
		foreach (static::$harrisNodes as $tmpNode) {
			$tmpExtraNodeCount += count($tmpNode->indirectLaterNodesPool);
		}
		echo "<b>Harris Matrix mit " . count(static::$harrisNodes) . " Knoten erstellt. ({$tmpExtraNodeCount} Knoten in Indirekt-Beziehungen).</b><br>\n";
		static::log2();
		echo "<hr>\n";

	}  // eo build harris chains



	/**
	* Remove redundant relations
	*/
	public static function removeRedundantRelations($opts = array()) {

		$redundantCount = 0;
		foreach (static::$harrisNodes as $curNodeId => $curNode) {

			$removeDirectLaterNodes = array();
			foreach ($curNode->directLaterNodes as $directLaterNodeId => $directLaterNode) {

				// if we have a direct later node in the indirect pool
				// we remove all direct connections
				if ($curNode->indirectLaterNodesPool[$directLaterNodeId]) {

					echo "Entferne Direkt-Beziehung {$directLaterNode->nodeName} -&gt; {$curNode->nodeName}, weil indirekt vorhanden.<br>\n";

					// remove from direct later relation and reverse relation
					unset($curNode->directLaterNodes[$directLaterNodeId]);
					unset($curNode->matrixInfo[StratumMatrix::THIS_IS_EARLIER_THAN][$directLaterNodeId]);
					unset($directLaterNode->matrixInfo[StratumMatrix::THIS_IS_LATER_THAN][$curNodeId]);

					$redundantCount++;
					break;
				}
			}  // eo check direct later relations

			// indirect nodes pool can be removed after this check
			unset($curNode->indirectLaterNodesPool);

		}  // eo node loop
		echo "$redundantCount redundante Direkt-Beziehungen entfernt.<br>\n";
		static::log2();
		echo "<hr>\n";

	}  // eo remove redundant



	/**
	* Build cluster
	* TODO check for not existing references (cluster references)
	*/
	public static function buildClusterTree($opts = array()) {

		echo "<b>Clusterknoten erstellen</b><br>\n";

		$outerLevel = 0;
		static::$clusterTree = array();

		// loop over prepared harris nodes - build base group level
		foreach(static::$harrisNodes as $outerNode) {
			static::$clusterTree[$outerLevel][$outerNode->nodeId] = $outerNode;
		}  // stratum loop


		// interface cluster
		// for now we only build a one level interface cluster !!!
		// interfaces inside interfaces are not handled.
		// The interface cluster level has a buggy design and is only
		// more a design study and not suggested for productive use !!!
		if ($opts['buildInterfaceCluster']) {

			$innerLevel = $outerLevel;
			$outerLevel++;

			// loop over stratum nodes
			foreach(static::$clusterTree[$innerLevel] as $innerNode) {

				$row = get_object_vars($innerNode);

				// all interfaces are contained in their own interface cluster
				// interfaces without non-interface stratums look somewhat ugly
				// but this way we can unify the processing
				$tmpDummy = array();
				$containedInInterfaces = Stratum12::getContainedInInterfaceArray($row, array(), $tmpDummy, array('getAll' => true));

				// if this stratum is not contained in any interface we
				// shift the full stratum to the next outer cluster level
				if (!$containedInInterfaces) {
					//static::$clusterTree[$outerLevel][$innerNode->stratumId] = $innerNode;
					//unset(static::$clusterTree[$innerLevel][$innerNode->stratumId]);
					continue;
				}

				// create / update interface nodes
				foreach($containedInInterfaces as $outerNodeIdOri) {
					$outerNodeId = "..IF.." . $outerNodeIdOri;  // avoid duplicate ids (here for interface ids)
					$newOuterNode = false;
					if (static::$clusterTree[$outerLevel][$outerNodeId]) {
						$outerNode = static::$clusterTree[$outerLevel][$outerNodeId];
					}
					else {
						$newOuterNode = true;
						$outerNode = new self();
						$outerNode->excavId = $innerNode->excavId;
						$outerNode->nodeId = $outerNodeId;
						$outerNode->nodeIdOri = $outerNodeIdOri;
						$outerNode->nodeName = "If_" . $outerNodeIdOri;
						$outerNode->clusterLevel = $outerLevel;
					}

					// bubble up stratum ids for each outer node id
					foreach($innerNode->innerStratumNodes as $stratumNode) {
						$outerNode->innerStratumNodes[$stratumNode->stratumId] = $stratumNode;
					}

					// create cross links and add outer node only if it has an inner node crosslinked
					static::outerClusterPush($innerNode, $outerNode, $innerLevel, $opts);
					if ($newOuterNode && $outerNode->innerClusterNodes) {
						static::$clusterTree[$outerLevel][$outerNodeId] = $outerNode;
						static::$allNodes[$outerNodeId] = $outerNode;
					}
				}
			}  // loop over stratum nodes
		}  // eo interface cluster


		// object frame
		if ($opts['buildArchObjectCluster']) {

			// get arch object types
			$typeNames = array();
			$tmpPstmt = Db::prepare("SELECT * FROM " . ArchObjectType::$tableName);
			$tmpPstmt->execute();
			while ($row = $tmpPstmt->fetch(PDO::FETCH_ASSOC)) {
				$typeNames[$row['id']] = $row;
			}
			$tmpPstmt->closeCursor();

			// build arch object nodes
			$innerLevel = $outerLevel;
			$outerLevel++;

			$levelInfo[$outerLevel]['isArchObjectLevel'] = true;

			// loop over inner nodes (stratum or interface)
			foreach(static::$clusterTree[$innerLevel] as $innerNode) {

				$archObjectIdArray = array();

				// get arch object ids by looping over all stratums contained in inner node
				foreach($innerNode->innerStratumNodes as $stratumNode) {
					$tmpArchObjectIdArray = ArchObjectToStratum::getArchObjectIdArray($innerNode->excavId, $stratumNode->stratumId);
					foreach($tmpArchObjectIdArray as $archObjectId) {
						$archObjectIdArray[$archObjectId] = $archObjectId;
					}
				}

				// create / update arch object nodes
				foreach($archObjectIdArray as $outerNodeIdOri) {
					$outerNodeId = "..OBJ.." . $outerNodeIdOri;  // avoid duplicate ids (collisions between stratum and object id)
					$newOuterNode = false;
					if (static::$clusterTree[$outerLevel][$outerNodeId]) {
						$outerNode = static::$clusterTree[$outerLevel][$outerNodeId];
					}
					else {
						$newOuterNode = true;
						$outerNode = new self();
						$outerNode->excavId = $innerNode->excavId;
						$outerNode->nodeId = $outerNodeId;
						$outerNode->nodeIdOri = $outerNodeIdOri;
						$outerNode->nodeName = "Obj_" . $outerNodeIdOri;
						$outerNode->clusterLevel = $outerLevel;
						$outerNode->isArchObjectNode = true;

						if ($opts['labelArchObjectTypeName']) {
							$archObjectNode = ArchObject::newFromDb(array('excavId' => $outerNode->excavId, 'archObjectId' => $outerNode->nodeIdOri));
							$outerNode->typeId = $archObjectNode->values['typeId'];
							if ($archObjectNode) {
								$outerNode->typeName = ($typeNames[$outerNode->typeId]['name'] ?: $outerNode->typeId);
							}
							else {
								echo "FEHLER: Knoten {$innerNode->nodeName}: Objekt {$outerNode->nodeName} existiert nicht - Art/Bezeichnung kann daher nicht ermittelt werden.";
								static::checkErrorCount();
							}
						}
					}  // eo new outer node

					// bubble up stratum ids for each outer node id
					foreach($innerNode->innerStratumNodes as $stratumNode) {
						$outerNode->innerStratumNodes[$stratumNode->stratumId] = $stratumNode;
					}

					// create cross links and add outer node only if it has an inner node crosslinked
					static::outerClusterPush($innerNode, $outerNode, $innerLevel, $opts);
					if ($newOuterNode && $outerNode->innerClusterNodes) {
						static::$clusterTree[$outerLevel][$outerNodeId] = $outerNode;
						static::$allNodes[$outerNodeId] = $outerNode;
					}
				}
			}  // eo loop over inner nodes (stratum or interface)

		}  // eo arch object cluster


		// object group cluster
		if ($opts['buildArchObjGroupCluster']) {

			$innerLevel = $outerLevel;
			$outerLevel++;

			// loop over inner nodes (stratum or interface or object)
			foreach(static::$clusterTree[$innerLevel] as $innerNode) {

				$archObjGroupIdArray = array();

				// get object group id
				// if the inner level is the object level then the node id is the object id
				// otherwise we have to build up from stratum level
				if ($levelInfo[$innerLevel]['isArchObjectLevel']) {
					$archObjGroupIdArray = ArchObjGroupToArchObject::getArchObjGroupIdArray($innerNode->excavId, $innerNode->nodeIdOri);
				}
				else {
					// loop over all stratums contained in inner node
					foreach($innerNode->innerStratumNodes as $stratumNode) {
						$archObjectIdArray = ArchObjectToStratum::getArchObjectIdArray($innerNode->excavId, $stratumNode->stratumId);
						foreach($archObjectIdArray as $archObjectId) {
							$tmpArchObjGroupIdArray = ArchObjGroupToArchObject::getArchObjGroupIdArray($innerNode->excavId, $archObjectId);
							foreach($tmpArchObjGroupIdArray as $archObjGroupId) {
								$archObjGroupIdArray[$tmpArchObjGroupId] = $archObjGroupId;
							}
						}
					}
				}
				// eo get group id

				// create / update arch object group nodes
				foreach($archObjGroupIdArray as $outerNodeIdOri) {
					$outerNodeId = "..OBGR.." . $outerNodeIdOri;  // avoid duplicate ids (collisions between stratum and object group id)
					$newOuterNode = false;
					if (static::$clusterTree[$outerLevel][$outerNodeId]) {
						$outerNode = static::$clusterTree[$outerLevel][$outerNodeId];
					}
					else {
						$newOuterNode = true;
						$outerNode = new self();
						$outerNode->excavId = $innerNode->excavId;
						$outerNode->nodeId = $outerNodeId;
						$outerNode->nodeIdOri = $outerNodeIdOri;
						$outerNode->nodeName = "ObGr_" . $outerNodeIdOri;
						$outerNode->clusterLevel = $outerLevel;
						// TODO get object group types
					}

					// bubble up stratum ids for each outer node id
					foreach($innerNode->innerStratumNodes as $stratumNode) {
						$outerNode->innerStratumNodes[$stratumNode->stratumId] = $stratumNode;
					}

					// create cross links and add outer node only if it has an inner node crosslinked
					static::outerClusterPush($innerNode, $outerNode, $innerLevel, $opts);
					if ($newOuterNode && $outerNode->innerClusterNodes) {
						static::$clusterTree[$outerLevel][$outerNodeId] = $outerNode;
						static::$allNodes[$outerNodeId] = $outerNode;
					}
				}
			}  // eo loop over inner nodes (stratum or interface or object)

		}  // eo arch object cluster


		// finisch protocol
		$clusterCount = 0;
		for ($clusterLevel = 1; $clusterLevel < count(static::$clusterTree); $clusterLevel++) {
			echo count(static::$clusterTree[$clusterLevel]) . " Clusterknoten erstellt auf Ebene $clusterLevel.<br>\n";
			$clusterCount += count(static::$clusterTree[$clusterLevel]);
		}
		echo "$clusterCount Clusterknoten erstellt (Summe aller Ebenen).<br>\n";
		static::log2();
		echo "<hr>\n";


		// ####################################

		if (static::$isMultiClusterTree) {
			static::buildCollectorNodes($opts);
		}

	}  // eo node clusters


	/**
	* Push node to outer cluster with prechecks
	*/
	private static function outerClusterPush($innerNode, $outerNode, $innerLevel, $opts) {

		// check if multiple outer cluster are allowed
		if ($innerNode->outerClusterNodes && !$opts['allowMultiCluster']) {
			$tmpIdList = "";
			foreach($innerNode->outerClusterNodes as $tmpNode) {
				$tmpIdList .= ($tmpIdList ? "," : "") . $tmpNode->nodeName;
			}
			echo "CLUSTER-FEHLER: Knoten {$innerNode->nodeName} (Ebene $innerLevel): Zuordnung zu Cluster {$outerNode->nodeName} gefunden, aber Knoten ist bereits Teil von $tmpIdList.<br>\n";
			static::checkErrorCount();
			if ($opts['autoCorrect']) {
				echo "&nbsp;&nbsp;UMGEHUNG: Knoten {$innerNode->nodeName} (Ebene $innerLevel): Zuordnung zu Cluster {$outerNode->nodeName} wird ignoriert.<br>\n";
				return;
			}
		}  // eo check multiple outer cluster

		// crosslinks
		$outerNode->innerClusterNodes[$innerNode->nodeId] = $innerNode;
		$innerNode->outerClusterNodes[$outerNode->nodeId] = $outerNode;

		if (count($innerNode->outerClusterNodes) > 1) {
			static::$isMultiClusterTree = true;
		}
	}  // eo prechecked push to outer cluster




	/**
	* Build collector nodes. Flatten cluster hierarchy down to stratum level.
	*/
	private static function buildCollectorNodes($opts) {

		echo "<br><b>Clusterknoten als Sammelkonten darstellen</b><br>\n";

		$stratumLevel = 0;
		$colNodeCount = 0;

		echo "Es sind Knoten mit mehrfacher Gruppenzugehörigkeit vorhanden. Diese Gruppen können nur als Sammelknoten dargestellt werden.<br>\n";

		// work down-up and start at stratumlevel + 1 because we always look down one inner level
		for($clusterLevel = 1; $clusterLevel < count(static::$clusterTree); $clusterLevel++) {

			$collectorNodes = array();

			// collect which nodes to build as collector node
			foreach (static::$clusterTree[$clusterLevel] as $node) {

				// if an inner node of this node is a multi cluster node we need a collector node
				$collectorThis = false;
				foreach ($node->innerClusterNodes as $innerNode) {
					if (count($innerNode->outerClusterNodes) > 1) {
						$collectorThis = true;
						break;
					}
				}  // inner node check

				// if this is a collector node then add to list
				if ($collectorThis) {
					$collectorNodes[$node->nodeId] = $node;
				}

			}  // eo detect collector nodes


			// loop over collector nodes
			foreach ($collectorNodes as $node) {

				$colNodeCount++;

				// hand over inner and outer cluster node list
				foreach ($node->innerClusterNodes as $innerNode) {
					$innerNode->outerClusterNodes = Oger::arrayMergeAssoc($innerNode->outerClusterNodes, $node->outerClusterNodes);
					unset($innerNode->outerClusterNodes[$node->nodeId]);
				}
				foreach ($node->outerClusterNodes as $outerNode) {
					$outerNode->innerClusterNodes = Oger::arrayMergeAssoc($outerNode->innerClusterNodes, $node->innerClusterNodes);
					$outerNode->innerStratumNodes = Oger::arrayMergeAssoc($outerNode->innerStratumNodes, $node->innerStratumNodes);
					// this node stays part of the outer node's inner cluster nodes list!
					// unset($outerNode->innerClusterNodes[$node->nodeId]);
				}

				// mark node and create node name list of direct inner nodes (level - 1)
				$node->isCollectorNode = true;
				$tmp = array();
				foreach ($node->innerClusterNodes as $tmpNode) {
					if ($tmpNode->clusterLevel == $node->clusterLevel - 1) {
						$tmp[] = $tmpNode->nodeName;
					}
				}
				asort($tmp, SORT_NUMERIC);
				$node->innerNodeNameList = implode(",", $tmp);

				// backup and cleanup inner nodes info
				$node->innerClusterNodesBak = $node->innerClusterNodes;
				$node->innerClusterNodes = array();
				$node->innerStratumNodesBak = $node->innerStratumNodes;
				$node->innerStratumNodes = array();

				// remove this node from cluster tree level and insert on stratum level
				unset(static::$clusterTree[$clusterLevel][$node->nodeId]);
				static::$clusterTree[$stratumLevel][$node->nodeId] = $node;

			}  // eo collector nodes loop

		}  // eo draw level

		echo "{$colNodeCount} Clusterkonten werden als Sammelknoten dargestellt.<hr>\n";
	}  // eo build collector nodes



	/**
	* Build earlier/below tree
	*/
	public static function buildEarlierTree($curNode, $directLaterNode, $indirectLaterNodesChain, $opts = array()) {

		// if there is no direct later node it is a top node
		if (!$directLaterNode) {
			static::$topNodes[$curNode->nodeId] = $curNode;
		}

		if ($indirectLaterNodesChain === null) {
			$indirectLaterNodesChain = array();
		}

		// create full later node chain (indirect + direct)
		$laterNodesChain = $indirectLaterNodesChain;
		if ($directLaterNode) {
			$laterNodesChain[$directLaterNode->nodeId] = $directLaterNode;
		}

		// check for cycles
		// ----------------
		// we always check for cycle even if there should not be the possiblility of a
		// cycle in drawMode = POSTDRAW and in other cases
		// but the check is cheap and detecting and avoiding endless loops has high priority
		// check:
		// 1) if this node is already in the later node list we have a cycle
		// 2) stop processing also if the node is already part of a detected cycle,
		//    because this will result in (another) cycle
		if ($laterNodesChain[$curNode->nodeId] ||
				static::$cycleNodes[$curNode->nodeId]) {

			if ($laterNodesChain[$curNode->nodeId]) {
				echo "FEHLER: Zirkelbezug bei Knoten {$curNode->nodeName}: ";
			}
			elseif (static::$cycleNodes[$curNode->nodeId]) {
				echo "FEHLER: Knoten {$curNode->nodeName} ist Teil eines bereits protokollierten Zirkelbezuges. ";
			}
			else {
				echo "FEHLER: Unbekannte Zirkelbezug-Art bei Knoten {$curNode->nodeName}: ";
			}

			$inCycle = false;
			$delim = "";
			echo "Kette: ";
			foreach($laterNodesChain as $tmpNode) {
				echo $delim;
				if ($tmpNode->nodeId == $curNode->nodeId) {
					$inCycle = true;
					echo "<b>";
				}
				echo $tmpNode->nodeName;
				if ($tmpNode->nodeId == $curNode->nodeId) {
					echo "</b>";
				}
				$delim = " -&gt; ";

				// remember all nodes that are part of a cycle
				if ($inCycle) {
					static::$cycleNodes[$curNode->nodeId] = $curNode;
				}
			}
			echo "$delim<b>$curNode->nodeName</b>.<br>\n";

			static::checkErrorCount();

			// save chain and stop processing
			echo "&nbsp;&nbsp;UMGEHUNG: Beende diese Kette mit Knoten {$tmpNode->nodeName}.<br>\n";

			// return even if no autocorrect is set to avoid endless loops
			// this node is already in the harris nodes and removed from the node pool, so nothing left to do
			// ATTENTION: the relation that creates the cycle is NOT removed, so the cyle will be drawn !!!
			return;
		}  // eo cycle detected


		// check for contemp with in later nodes chain
		if ($curNode->matrixInfo[StratumMatrix::THIS_IS_CONTEMP_WITH]) {
			foreach ($curNode->matrixInfo[StratumMatrix::THIS_IS_CONTEMP_WITH] as $cwNodeId) {
				if ($laterNodesChain[$cwNodeId]) {
					$cwNode = static::$allNodes[$cwNodeId];
					// report only once
					if (static::$cwLaterErr[$curNode->nodeId][$cwNode->nodeId] ||
							static::$cwLaterErr[$cwNode->nodeId][$curNode->nodeId]) {
						continue;
					}
					echo "FEHLER bei Stratum {$curNode->nodeName}: Das Bezugsstratum {$cwNode->nodeName} ist sowohl in der '" .
							 static::$relationNames[StratumMatrix::THIS_IS_CONTEMP_WITH] . "' Beziehung, als auch indirekt in der '" .
							 static::$relationNames[StratumMatrix::THIS_IS_LATER_THAN] . "' Beziehung enthalten.<br>";
					static::checkErrorCount();
					static::$cwLaterErr[$curNode->nodeId][$cwNode->nodeId] = 1;
				}
			}
		}  // eo contemp/later check



		// all checks passed


		// init row num by guessing
		// add 1 level for each entry in the later nodes chain + 1 for the own row + 1 for reserved row 1
		$curNode->rowNum = max($curNode->rowNum, count($laterNodesChain) + 1 + 1);


		// remove this node from the node pool if not already done
		if (static::$nodePool[$curNode->nodeId]) {
			unset(static::$nodePool[$curNode->nodeId]);
			static::$harrisNodes[$curNode->nodeId] = $curNode;
		}

		// remember top nodes for later use in building rows
		if (!$directLaterNode && !$indirectLaterNodesChain) {
			static::$harrisTopNodes[$curNode->nodeId] = $curNode;
		}

		// create direct and indirect later info
		if ($directLaterNode) {
			$curNode->directLaterNodes[$directLaterNode->nodeId] = $directLaterNode;
			// remember indirect later info even if empty to have a unified
			// route to the direct later nodes
			//$curNode->indirectLaterInfo[] = array('indirectChain' => $indirectLaterNodesChain, 'directNode' => $directLaterNode);
		}
		if ($indirectLaterNodesChain) {
			// we now store only a indirect later pool, because individual
			// indirect chains are too memory consuming and the only benefit of
			// individual chains would be a better (node-for-node chain) log when
			// removing redundant direct connections
			foreach ($indirectLaterNodesChain as $tmpNode) {
				if (!$curNode->indirectLaterNodesPool[$tmpNode->nodeId]) {
					$curNode->indirectLaterNodesPool[$tmpNode->nodeId] = $tmpNode;
				}
			}
		}


		// loop recursive over all earlier = lower = next nodes (where this node is later-than ;-)
		foreach ($curNode->matrixInfo[StratumMatrix::THIS_IS_LATER_THAN] as $earlierNodeId) {
			$earlierNode = static::$allNodes[$earlierNodeId];
			static::buildEarlierTree($earlierNode, $curNode, $laterNodesChain, $opts);
		}  // eo loop over all earlier ids


		// mark as finished for follow up calls
		$curNode->isFinished = true;

	}  // eo build earlier stratum tree



	/**
	* Build rows
	* We use a separate tmpRowNum variable to let guessed numRow
	* from buildEarlierTree unchanged if something goes wrong
	*/
	public static function buildNodeRows() {

		if (static::$cwLaterErr) {
			echo "Es sind " . count(static::$cwLaterErr) . " Fehler in '" .
						static::$relationNames[StratumMatrix::THIS_IS_CONTEMP_WITH] . "' Beziehungen gefunden worden. " .
					 "Eine Anordnung in Reihen ist daher nicht möglich.<hr>\n";
			return;
		}


		// transfer direct later relation as direct earlier to the peer
		foreach (static::$harrisNodes as $curNode) {
			foreach ($curNode->directLaterNodes as $otherNode) {
				$otherNode->directEarlierNodes[$curNode->nodeId] = $curNode;
			}
		}


		$rowNodesPool = static::$harrisNodes;
		$localCwHeadNodess = static::$contempWithHeadNodes;


		$nodesInRow = count(static::$topNodes);  // fake to miss abort condition
		$curRowNum = 1;  // is increased immideately - we start with 2 and move back special top nodes to row 1 conditionally later
		$curRowNodes = static::$topNodes;
		while ($curRowNodes && $nodesInRow) {
			$curRowNum++;
			$nodesInRow = 0;
			$nextRowNodes = array();
			foreach ($curRowNodes as $curNode) {

				$unresolvedLaterNodes = false;
				$nodesToCheck = array();
				$nodesToCheck[$curNode->nodeId] = $curNode;

				// if there are contemp with nodes check them all
				if ($curNode->matrixInfo[StratumMatrix::THIS_IS_CONTEMP_WITH]) {
					foreach ($curNode->matrixInfo[StratumMatrix::THIS_IS_CONTEMP_WITH] as $cwNodeId) {
						$nodesToCheck[$cwNodeId] = static::$allNodes[$cwNodeId];
					}
				}

				// check if direct later for this node is still in pool
				foreach ($nodesToCheck as $tmpNode) {
					foreach ($tmpNode->directLaterNodes as $laterNode) {
						if ($rowNodesPool[$laterNode->nodeId]) {
							$unresolvedLaterNodes = true;
							break;
						}
					}
					if ($unresolvedLaterNodes) {
						break;
					}
				}
				// if unresulfed later nodes exist we delay for next row
				if ($unresolvedLaterNodes) {
					$nextRowNodes[$curNode->nodeId] = $curNode;
					continue;
				}

				// if unresulfed later nodes exist we delay for next row
				if ($pendingLaterCount) {
					$nextRowNodes[$curNode->nodeId] = $curNode;
					continue;
				}

				// assign node to row
				$nodesInRow++;
				$curNode->tmpRowNum = $curRowNum;
				unset($rowNodesPool[$curNode->nodeId]);
				foreach ($curNode->directEarlierNodes as $nextNode) {
					$nextRowNodes[$nextNode->nodeId] = $nextNode;
				}
			}  // next node in row
			$curRowNodes = $nextRowNodes;
		}  // eo masterloop


		// test for remaining nodes or contemp packages
		if ($rowNodesPool) {
			echo count($rowNodesPool) . " Knoten konnten nicht in Reihen eingeordnet werden. " .
					 "Die Reihananordnung wird daher verworfen.<br>\n";
			// TODO info about contemp-with
			return;
		}


		// all tests passed


		// single out special top nodes for row 1
		/*
		foreach (static::$topNodes as $curNode) {
			if ($curNode->isTopEdge && !$curNode->matrixInfo[StratumMatrix::THIS_IS_EARLIER_THAN] &&
					!$curNode->matrixInfo[StratumMatrix::THIS_IS_CONTEMP_WITH]) {
				$curNode->tmpRowNum = 1;
			}
		}
		*/

		// write back tmp row nums to final row nums
		foreach (static::$harrisNodes as $curNode) {
			$curNode->rowNum = $curNode->tmpRowNum;
		}

		// handle collector node row assigning
		// all collectornodes are moved to stratum level ( = 0) by buildCollectorNodes
		// move the collector mode to the top row of its assigned stratums
		$stratumLevel = 0;
		foreach (static::$clusterTree[$stratumLevel] as $curNode) {
			if ($curNode->isCollectorNode) {
				foreach ($curNode->innerStratumNodesBak as $tmpNode) {
					if ($tmpNode->rowNum > 0 && ($curNode->rowNum == 0 || $tmpNode->rowNum < $curNode->rowNum)) {
						$curNode->rowNum = $tmpNode->rowNum;
					}
				}
			}
		}

		echo count(static::$harrisNodes) . " Knoten in etwa {$curRowNum} Reihen angeordnet.<br>\n";
		static::log2();
		echo "<hr>\n";
	}  // eo build  node rows


	/**
	* Get node name list from id array
	*/
	public static function nodeNameListFromIds($array) {
		$array2 = array();
		foreach ($array as $tmp) {
			$array2[$tmp] = static::$allNodes[$tmp];
		}
		return static::nodeNameListFromNodes($array2);
	}  // eo node name list from ids

	/**
	* Get node name list from node array
	*/
	public static function nodeNameListFromNodes($array) {
		$list = "";
		foreach ($array as $tmp) {
			$list .= ($list ? "," : "") . $tmp->nodeName;
		}
		return $list;
	}  // eo node name list from nodes



	/**
	* Check error count
	* maxErrorCount=0 means unlimited
	*/
	public static function checkErrorCount($count = 1) {
		static::$errorCount += $count;
		if (static::$opts['maxErrorCount'] && static::$errorCount >= static::$opts['maxErrorCount']) {
			echo "*** ABBRUCH ***<br>\n";
			echo sprintf("Die maximale Fehleranzahl von %1\$s wurde erreicht.<br>", static::$opts['maxErrorCount']);
			exit;
		}
	}  // eo check error count



	/**
	* Log
	*/
	public static function log() {

		return;

		echo "<br><b>clustertree:</b><br>\n";
		if (static::$clusterTree) {
			for($clusterLevel = 0; $clusterLevel < count(static::$clusterTree); $clusterLevel++) {
				foreach (static::$clusterTree[$clusterLevel] as $nodeId => $node) {
					echo "* drawlevel: $clusterLevel, key: $nodeId, node: {$node->nodeId}/{$node->nodeName}, clusterlevel: {$node->clusterLevel}<br>\n";
					echo "&nbsp;&nbsp;* outer cluster: ";
					foreach ($node->outerClusterNodes as $refId => $refNode) {
						echo "$refId={$refNode->nodeId}/{$refNode->nodeName},";
					}
					echo "<br>\n";
					echo "&nbsp;&nbsp;* inner cluster: ";
					foreach ($node->innerClusterNodes as $refId => $refNode) {
						echo "$refId={$refNode->nodeId}/{$refNode->nodeName},";
					}
					echo "<br>\n";
					echo "&nbsp;&nbsp;* inner stratum: ";
					foreach ($node->innerStratumNodes as $refId => $refNode) {
						echo "$refId={$refNode->nodeId}/{$refNode->nodeName},";
					}
					echo "<br>\n";
				}
			}
		}
		else {
			echo "leer (count=" . count(static::$clusterTree) . ").<br>\n";
		}

		/*
		echo "<br><b>node-to-chain:</b><br>\n";
		if (static::$nodeToChainKey) {
			foreach (static::$nodeToChainKey as $stratumId => $tmp1) {
				foreach ($tmp1 as $chainKey => $chainKeyVal) {
					echo "stratum: $stratumId, chain: $chainKey, val: $chainKeyVal<br>\n";
				}
			}
		}
		else {
			echo "leer (count=" . count(static::$nodeToChainKey) . ").<br>\n";
		}
		*/


	}  // oe log


	/**
	* Log2
	*/
	public static function log2($msg = null) {
		if ($msg) {
			echo "{$msg}\n";
		}
		if (static::$log2) {
			echo "Memory usage: " . number_format(memory_get_usage()) .
					 " (max " . number_format(memory_get_peak_usage()) . "). / ";
			$now = time();
			echo "Time: " . number_format($now - static::$meanTime) .  " seconds " .
					 " (total " . number_format($now - static::$startTime) . ").<br>\n";
			static::$meanTime = $now;
		}
	}  // eo log2


}  // end of class


?>
