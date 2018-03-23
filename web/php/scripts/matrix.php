<?php
/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/

require_once(__DIR__ . '/../init.inc.php');




/*
* Create matrix
*/
if ($_REQUEST['_action'] == 'matrix') {

	// prechecks

	if (!$_REQUEST['excavId']) {
		echo Extjs::errorMsg('Grabungs ID fehlt.<br>');
		exit;
	}

	$excav = Excavation::newFromDb(array('id' => $_REQUEST['excavId']));
	if (!$excav->values) {
		echo Extjs::errorMsg('Grabungs ID ' . $_REQUEST['excavId'] . ' nicht gefunden.<br>');
		exit;
	}

	echo HtmlHelper::htmlStart();
	echo "<h1>Matrix</h1>\n";
	echo "<h2>{$excav->values['name']} [{$excav->values['beginDate']} - {$excav->values['endDate']}] " .
			 "[Id {$excav->values['id']}]</h2>\n" .
			 "<hr>\n";


	if ($_REQUEST['fileFormat'] == 'EXPORT_GRAPHVIZ_DOT') {
		collectData();
		exportGraphvizDot($excav);
		exit;
	}

	if ($_REQUEST['fileFormat'] == 'EXPORT_GRAPHML' || $_REQUEST['fileFormat'] == 'EXPORT_GRAPHML_YED') {
		collectData();
		exportGraphMl($excav);
		exit;
	}

	if ($_REQUEST['fileFormat'] == 'EXPORT_STRATIFY_CSV') {
		collectData();
		exportStratifyCsv($excav);
		exit;
	}

	if ($_REQUEST['fileFormat'] == 'EXPORT_BASP_LST') {
		collectData();
		exportBaspLst($excav);
		exit;
	}

	if ($_REQUEST['fileFormat'] == 'EXPORT_TEXTLIST') {
		collectData();
		exportTextList($excav);
		exit;
	}

	if ($_REQUEST['fileFormat'] == 'PROTOCOL_ONLY') {
		collectData();
		exit;
	}

	echo "Ungültiges File Format " . $_REQUEST['fileFormat'] . "<br>";
	exit;

}  // precheck



/*
* Download stored matrix output
*/
if ($_REQUEST['_action'] == 'download') {

	if (!$_SESSION[Logon::$_id]['matrix'][$_REQUEST['id']]) {
		echo "Die Matrix mit ID " . $_REQUEST['id'] . " wurde nicht gefunden. ";
		echo "Eventuell wurde der Download bereits durchgeführt.";
		exit;
	}

	header("Content-type: text/plain");
	header('Content-disposition: attachment; filename="' . $_SESSION[Logon::$_id]['matrix'][$_REQUEST['id']]['fileName'] . '"');
	echo $_SESSION[Logon::$_id]['matrix'][$_REQUEST['id']]['content'];

	unset($_SESSION[Logon::$_id]['matrix'][$_REQUEST['id']]);
	exit;

}  // download



/*
* Collect data
*/
function collectData() {

	session_write_close();

	$whereVals = array();

	if ($_REQUEST['beginId']) {
		$whereVals['stratumBeginId'] = $_REQUEST['beginId'];
	}
	if ($_REQUEST['endId']) {
		$whereVals['stratumEndId'] = $_REQUEST['endId'];
	}


	// excav id does not change, so put to var
	$excavId = $_REQUEST['excavId'];
	MatrixNode::prepareMatrix($excavId, $whereVals, $_REQUEST);

	if ($_REQUEST['fileFormat'] == 'EXPORT_GRAPHML_YED') {
		echo "<b>Knoten in Reihen anordnen</b><br>\n";
		MatrixNode::buildNodeRows();
	}

	// summary
	MatrixNode::log2();
	echo "<br><b>" . MatrixNode::$errorCount . " Fehler gefunden.</b><hr>\n";

	Oger::sessionRestart();
}  // eo collect data




/*
* Export basp .lst
*/
function exportBaspLst($excav) {

	$excavId = $excav->values['id'];

	$matrix = '';
	$outCount = 0;

	echo "<b>Start Export Bonn Archaeological Software Package/BASP (lst)</b><br>\n";

	if ($_REQUEST['joinEqual']) {
		echo "HINWEIS: Die Knoten sollten NICHT in OgerArch über die 'Ist Ident mit' Beziehung zusammengefasst werden, wenn das Folgeprogramm dies auch kann. " .
				 "Programme, die das BASP Format verarbeiten (zB ArchED) sind meist dazu in der Lage.<br>\n";
	}
	if ($_REQUEST['labelCategoryName'] || $_REQUEST['labelStratumTypeName'] ||
			$_REQUEST['labelInterfaceTypeName'] || $_REQUEST['labelComplexTypeName'] ||
			$_REQUEST['labelArchObjectTypeName'] || $_REQUEST['labelArchObjGroupTypeName'] ||
			$_REQUEST['labelCollectorMembers']) {
		echo "HINWEIS: Das BASP Format verwendet den Knotennamen als Beschriftung. Eine erweiterte Beschriftung geht daher verloren.<br>\n";
	}
	if (($_REQUEST['buildInterfaceCluster'] || $_REQUEST['buildComplexCluster'] ||
			 $_REQUEST['buildArchObjectCluster'] || $_REQUEST['buildArchObjGroupCluster'])
			&& $_REQUEST['clusterVisualMode'] != 'VISUAL_COLLECTORNODE') {
		echo "HINWEIS: Das BASP Format kennt keine Gruppenzugehörigkeit. Diese kann daher nur über Sammelknoten dargestellt werden.<br>\n";
	}

	$matrix .= "            * Stratigraphic Dataset for " . $excav->values['name'] . "\n";
	$matrix .= "            * Created by ogerarch at " . date('c') . "\n";
	$matrix .= "  Name\n";


	// no grouping possible, so we output statums only
	$stratumLevel = 0;   // stratum level

	foreach (MatrixNode::$clusterTree[$stratumLevel] as $node) {

		// skip marker nodes
		if ($node->clusterLevel != $stratumLevel) {
			continue;
		}

		// output
		$matrix .= "{$node->nodeName}\n";
		$matrix .= "            above: " . MatrixNode::nodeNameListFromIds($node->matrixInfo[StratumMatrix::THIS_IS_EARLIER_THAN]) . "\n";
		$matrix .= "            contemporary with: " .
							 MatrixNode::nodeNameListFromIds($node->matrixInfo[StratumMatrix::THIS_IS_CONTEMP_WITH]). "\n";
		$matrix .= "            equal to: " . MatrixNode::nodeNameListFromIds($node->matrixInfo[StratumMatrix::THIS_IS_EQUAL_TO]) . "\n";
		$matrix .= "            below: " . MatrixNode::nodeNameListFromIds($node->matrixInfo[StratumMatrix::THIS_IS_LATER_THAN]) . "\n";

		$outCount++;
	}  // eo node loop

	// we use iso-8859-1 by default for basp lst
	$matrix = utf8_decode($matrix);

	echo "<br>";
	echo "$outCount Datensätze erstellt.<br>";
	echo "Dateigrösse: " . strlen($matrix) . " Bytes.<br>";

	if ($outCount) {
		$downloadId = time();
		$_SESSION[Logon::$_id]['matrix'][$downloadId]['content'] = $matrix;
		$_SESSION[Logon::$_id]['matrix'][$downloadId]['fileName']= "ogerarch-basp_" . date("Y-m-d") . ".lst";
		echo "<br><a href=\"matrix.php?_LOGONID={$_REQUEST['_LOGONID']}&_action=download&id={$downloadId}\">Download</a><br>\n";
	}

}  // eo stratify lst


/*
* Export STRATIFY csv
*/
function exportStratifyCsv($excav) {

	echo "<b>Start Export für Stratify 1.5 (csv)</b><br>\n";

	if ($_REQUEST['joinEqual']) {
		echo "HINWEIS: Die Knoten sollten NICHT in OgerArch über die 'Ist Ident mit' Beziehung zusammengefasst werden, weil Stratify dies selbst erledigt. " .
				 "Ausserdem dürfen die Knotennamen in Stratify nicht länger als 8 Zeichen sein, was bei zusammengefassten Knotennamen leicht überschritten wird.<br>\n";
	}
	if ($_REQUEST['labelCategoryName'] || $_REQUEST['labelStratumTypeName'] ||
			$_REQUEST['labelInterfaceTypeName'] || $_REQUEST['labelComplexTypeName'] ||
			$_REQUEST['labelArchObjectTypeName'] || $_REQUEST['labelArchObjGroupTypeName'] ||
			$_REQUEST['labelCollectorMembers']) {
		echo "HINWEIS: Stratify verwendet den Knotennamen als Beschriftung. Eine erweiterte Beschriftung geht daher verloren.<br>\n";
	}


	$datingPeriods = DatingPeriod::getRecordsWithKeys();

	$excavId = $excav->values['id'];
	$matrix = '';

	$stratumLevel = 0;

	// configure ogerCsv
	OgerCsv::$delimitEmptyFields = true;


	// header / names for field concordance
	$matrix .= "Unitname;Unitclass;Earlier than;Later than;Equal to;Contemporary with;Part of;Location;Conditions;Unittype;Period;Phase;\n";
	// dummy record to force stratify to use string fields on import
	$matrix .= OgerCsv::prepRowOut(array("DUMMY","context","DUMMY","DUMMY","DUMMY","DUMMY","DUMMY","DUMMY","DUMMY","DUMMY","DUMMY","DUMMY"));

	for($drawLevel = 0; $drawLevel < count(MatrixNode::$clusterTree); $drawLevel++) {

		$unitClass = ($drawLevel == $stratumLevel ? "context" : "group");

		foreach (MatrixNode::$clusterTree[$drawLevel] as $node) {

			if ($node->clusterLevel != $stratumLevel) {
				$node->categoryId = "CLUSTERLEVEL_{$node->clusterLevel}";
				$node->categoryName = "CLUSTERLEVEL_{$node->clusterLevel}";
			}

			$outerNodeNames = MatrixNode::nodeNameListFromNodes($node->outerClusterNodes);

			// output one line
			$matrix .= OgerCsv::prepRowOut(
									array($node->nodeName,
												$unitClass,
												MatrixNode::nodeNameListFromIds($node->matrixInfo[StratumMatrix::THIS_IS_EARLIER_THAN]),
												MatrixNode::nodeNameListFromIds($node->matrixInfo[StratumMatrix::THIS_IS_LATER_THAN]),
												MatrixNode::nodeNameListFromIds($node->matrixInfo[StratumMatrix::THIS_IS_EQUAL_TO]),
												MatrixNode::nodeNameListFromIds($node->matrixInfo[StratumMatrix::THIS_IS_CONTEMP_WITH]),
												$outerNodeNames,            // Part of field
												$node->categoryId,          // Location field
												$node->categoryName,        // Conditions field
												$node->typeName,            // Unittype field
												$node->datingSpec,          // Periode field
												($datingPeriods[$node->datingPeriodId]['name'] ?: $node->datingPeriodId),    // Phase field
									));

			$outCount++;
		}  // eo stratum loop

	}  // eo level

	// we use iso-8859-1 by default for stratify csv
	$matrix = utf8_decode($matrix);

	echo "<br>";
	echo (0 + $outCount) . " Datensätze erstellt.<br>";
	echo "Dateigrösse: " . strlen($matrix) . " Bytes.<br>";

	if ($outCount) {
		$downloadId = time();
		$_SESSION[Logon::$_id]['matrix'][$downloadId]['content'] = $matrix;
		$_SESSION[Logon::$_id]['matrix'][$downloadId]['fileName']= "ogerarch-stratify_" . date('Y-m-d') . ".csv";
		echo "<br><a href=\"matrix.php?_LOGONID={$_REQUEST['_LOGONID']}&_action=download&id={$downloadId}\">Download</a><br>\n";
	}

}  // eo stratify csv


/*
* Export GRAPHVIZ dot
*/
function exportGraphvizDot($excav) {

	echo "<b>Start Export für Graphviz (dot)</b><br>\n";

	$equalToNames = array();
	$contempWithNames = array();
	foreach (MatrixNode::$harrisNodes as $node) {
		if ($node->matrixInfo[StratumMatrix::THIS_IS_EQUAL_TO] || $node->matrixInfo[StratumMatrix::THIS_IS_REVERSE_EQUAL_TO]) {
			$equalToNames[$node->nodeName] = $node->nodeName;
		}
		if ($node->matrixInfo[StratumMatrix::THIS_IS_CONTEMP_WITH] || $node->matrixInfo[StratumMatrix::THIS_IS_REVERSE_CONTEMP_WITH]) {
			$contempWithNames[$node->nodeName] = $node->nodeName;
		}
	}
	if (count($equalToNames) && !$_REQUEST['joinEqual']) {
		echo "HINWEIS: " . count($equalToNames) . " Knoten mit 'Ist Ident mit' Beziehung gefunden (" .
				 implode(",", $equalToNames) . "). Graphviz kann diese Beziehung nicht auswerten. Die Knoten müssen bereits in OgerArch zusammengefasst werden.<br>\n";
	}
	if (count($contempWithNames) && count(MatrixNode::$clusterTree) > 1) {
		echo "HINWEIS: " . count($contempWithNames) . " Knoten mit 'Zeitgleich mit' Beziehung gefunden (" .
				 implode(",", $contempWithNames) . "). Der Graphviz-Export kann diese Beziehung nur auswerten, wenn keine Clusterbildung durchgeführt wird. Die Matrix muss eventuell händisch nachbearbeitet werden.<br>\n";
	}

	if (!$_REQUEST['removeRedundant']) {
		echo "HINWEIS: Graphviz entfernt keine redundaten Beziehungen. Dies muss bereits mit OgerArch durchgeführt werden.<br>\n";
	}


	$excavId = $excav->values['id'];

	$stratumLevel = 0;
	$indentLevel = 0;
	$outCount = 0;
	$out = '';

	// start graph
	$out = "digraph Excav {\n\n  /* nodes and subgraphs */\n";

	for($drawLevel = count(MatrixNode::$clusterTree) - 1; $drawLevel >= 0; $drawLevel--) {

		foreach (MatrixNode::$clusterTree[$drawLevel] as $node) {

			// if there are outer nodes we are a inner node and
			// output happened already as part of the outer node output
			if ($node->outerClusterNodes) {
				continue;
			}

			graphvizDotOut($node, $indentLevel, $outCount, $out);
		}  // eo stratum loop

	}  // eo level


	// output relations/edges (earlier/later nodes must exist at stratum level)
	$out .= "\n  /* edges (relations) */\n";
	foreach (MatrixNode::$clusterTree[$stratumLevel] as $node) {
		foreach($node->matrixInfo[StratumMatrix::THIS_IS_LATER_THAN] as $otherNodeId) {
			$otherNode = MatrixNode::$clusterTree[$stratumLevel][$otherNodeId];
			$out .= "  \"{$node->nodeName}\" -> \"{$otherNode->nodeName}\";\n";
		}
	}

	// output rank infos
	$out .= "\n  /* explicit rank info */\n";
	foreach (MatrixNode::$clusterTree[$stratumLevel] as $node) {
		if ($node->isTopEdge) {
			$out .= "  { rank=\"min\"; \"{$node->nodeName}\" }\n";
		}
		if ($node->isBottomEdge) {
			$out .= "  { rank=\"max\"; \"{$node->nodeName}\" }\n";
		}
		// output rank info only if there is no cluster level (only stratum level)
		// because graphviz rank does not work for cross cluster settings
		if ($node->isContempHeadNode && count(MatrixNode::$clusterTree) < 2) {
			$out .= "  { rank=\"same\"; \"{$node->nodeName}\";";
			foreach($node->matrixInfo[StratumMatrix::THIS_IS_CONTEMP_WITH] as $otherNodeId) {
				$otherNode = MatrixNode::$clusterTree[$stratumLevel][$otherNodeId];
				$out .= " \"{$otherNode->nodeName}\";";
			}
			$out .= " }\n";
		}
	}

	// finish graph
	$out .= "\n}\n";


	echo "<br>";
	echo (0 + $outCount) . " Datensätze erstellt.<br>";
	echo "Dateigrösse: " . strlen($out) . " Bytes.<br>";

	if ($outCount) {
		$downloadId = time();
		$_SESSION[Logon::$_id]['matrix'][$downloadId]['content'] = $out;
		$_SESSION[Logon::$_id]['matrix'][$downloadId]['fileName']= "ogerarch-graphviz_" . date('Y-m-d') . ".dot";
		echo "<br><a href=\"matrix.php?_LOGONID={$_REQUEST['_LOGONID']}&_action=download&id={$downloadId}\">Download</a><br>\n";
	}

}  // eo graphviz dot

/*
* Output one GRAPHVIZ dot
*/
function graphvizDotOut($node, $indentLevel, &$outCount, &$out) {

	$indent = str_repeat("  ", $indentLevel + 1);
	$outCount++;
	$stratumLevel = 0;

	$nodeNameExtended = $node->nodeName;
	if ($_REQUEST['labelCategoryName'] && $node->isStratumNode) {
		$nodeNameExtended .= "\\n{$node->categoryName}";
	}
	if ($_REQUEST['labelStratumTypeName'] && $node->isStratumNode) {
		$nodeNameExtended .= "\\n{$node->typeName}";
	}

	if ($_REQUEST['labelArchObjectTypeName'] && $node->isArchObjectNode) {
		$nodeNameExtended .= "\\n{$node->typeName}";
	}

	if ($_REQUEST['labelArchObjGroupTypeName'] && $node->isArchObjGroupNode) {
		$nodeNameExtended .= "\\n{$node->typeName}";
	}

	if ($_REQUEST['labelCollectorMembers'] && $node->isCollectorNode) {
		$nodeNameExtended .= "\\n[{$node->innerNodeNameList}]";
	}

	// set attributes
	$attrib = array();

	$attrib['label'] = "\"{$nodeNameExtended}\"";
	$attrib['shape'] = "box";

	$attrib['style'] = "filled";
	$attrib['fillcolor'] = '"#FFFFFF"';

	switch ($node->clusterLevel) {
	case 1:
		$attrib['fillcolor'] = '"#CCCCFF"';
		break;
	case 2:
		$attrib['style'] = "bold";
		$attrib['fontname'] = '"Times-Bold"';
		break;
	}

	// handle non-interfaces at stratum level
	if ($node->clusterLevel == $stratumLevel && $node->categoryId != StratumCategory::ID_INTERFACE) {
		$attrib['shape'] = "ellipse";
	}


	// if inner nodes are present we start a subgraph
	if ($node->innerClusterNodes) {
		$out .= "{$indent}subgraph \"cluster_{$node->nodeName}\" {\n";
		foreach ($attrib as $attrKey => $attrVal) {
			$out .= "{$indent}  $attrKey=$attrVal;\n";
		}
		foreach($node->innerClusterNodes as $innerNode) {
			graphvizDotOut($innerNode, $indentLevel + 1, $outCount, $out);
		}
		$out .= "{$indent}}\n";

		// earlier-info is only on innerst cluster level, so we can return here
		return;
	}

	// output node and its attributes
	$out .= "{$indent}\"{$node->nodeName}\" [ ";
	$delim = "";
	foreach ($attrib as $attrKey => $attrVal) {
		$out .= "$delim{$attrKey}=$attrVal";
		$delim = ", ";
	}
	$out .= " ];\n";

}  // eo graphiz node out



/*
* Export GraphML
*/
function exportGraphMl($excav) {

	if ($_REQUEST['fileFormat'] == 'EXPORT_GRAPHML_YED') {
		echo "<b>Start Export für yED (graphml)</b><br>\n";
	}
	else {
		echo "<b>Start Export für Standard GraphML (graphml)</b><br>\n";
	}

	$equalToNames = array();
	$contempWithNames = array();
	foreach (MatrixNode::$harrisNodes as $node) {
		if ($node->matrixInfo[StratumMatrix::THIS_IS_EQUAL_TO] || $node->matrixInfo[StratumMatrix::THIS_IS_REVERSE_EQUAL_TO]) {
			$equalToNames[$node->nodeName] = $node->nodeName;
		}
		if ($node->matrixInfo[StratumMatrix::THIS_IS_CONTEMP_WITH] || $node->matrixInfo[StratumMatrix::THIS_IS_REVERSE_CONTEMP_WITH]) {
			$contempWithNames[$node->nodeName] = $node->nodeName;
		}
	}
	if (count($equalToNames) && !$_REQUEST['joinEqual']) {
		echo "HINWEIS: " . count($equalToNames) . " Knoten mit 'Ist Ident mit' Beziehung gefunden (" .
				 implode(",", $equalToNames) . "). GraphML Programme (zB yED) können diese Beziehung nicht auswerten. Die Knoten müssen bereits in OgerArch zusammengefasst werden.<br>\n";
	}
	if (count($contempWithNames)) {
		echo "HINWEIS: " . count($contempWithNames) . " Knoten mit 'Zeitgleich mit' Beziehung gefunden (" .
				 implode(",", $contempWithNames) . "). GraphML Programme (zB yED) können diese Beziehung nicht auswerten. Die Matrix muss eventuell händisch nachbearbeitet werden.<br>\n";
		if ($_REQUEST['fileFormat'] == 'EXPORT_GRAPHML_YED') {
			echo "SONDERHINWEIS FÜR yED: Wenn die Anordnung der Konten in Reihen erfolgreich war, dann konnte eine gültige relative Verteilung auf der Y-Achse ermittelt werden. " .
					 "Diese bleibt erhalten, wenn beim Hierarchischen Layout unter Schichtzuweisung -&gt; Strategie die Option Koordinatenabhängig gewählt wird.<br>\n";
		}
	}

	if (!$_REQUEST['removeRedundant']) {
		echo "HINWEIS: GraphML Programme (zB yED) entfernen keine redundaten Beziehungen. Dies muss bereits mit OgerArch durchgeführt werden.<br>\n";
	}

	$excavId = $excav->values['id'];

	$indentLevel = 0;
	$outCount = 0;
	$out = '';
	$stratumLevel = 0;

	// xml header
	$out = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n" .
				 "  <graphml xmlns=\"http://graphml.graphdrawing.org/xmlns\"\n" .
				 "  xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"\n";


	if ($_REQUEST['fileFormat'] == 'EXPORT_GRAPHML_YED') {
		$out .= "\n" .
						"  xmlns:y=\"http://www.yworks.com/xml/graphml\"\n" .
						"  xmlns:yed=\"http://www.yworks.com/xml/yed/3\"\n" .
						"  xsi:schemaLocation=\"http://graphml.graphdrawing.org/xmlns\n" .
						"    http://www.yworks.com/xml/schema/graphml/1.1/ygraphml.xsd\">\n";
	}
	else {
		$out .= "  xsi:schemaLocation=\"http://graphml.graphdrawing.org/xmlns\n" .
						"    http://graphml.graphdrawing.org/xmlns/1.0/graphml.xsd\">\n";
	}
	$out .= "\n";


	// output attribute keys

	// node label
	$out .= "  <key id=\"d0\" attr.name=\"Label\" for=\"node\" attr.type=\"string\">\n" .
					"    <default></default>\n" .
					"  </key>\n";
	// stratum category id and name
	$out .= "  <key id=\"d2\" attr.name=\"StratumCategoryId\" for=\"node\" attr.type=\"string\">\n" .
					"    <default></default>\n" .
					"  </key>\n";
	$out .= "  <key id=\"d3\" attr.name=\"StratumCategoryName\" for=\"node\" attr.type=\"string\">\n" .
					"    <default></default>\n" .
					"  </key>\n";
	// stratum/object/objectgroup/complex type id and name
	$out .= "  <key id=\"d4\" attr.name=\"StratumTypeId\" for=\"node\" attr.type=\"string\">\n" .
					"    <default></default>\n" .
					"  </key>\n";
	$out .= "  <key id=\"d5\" attr.name=\"StratumTypeName\" for=\"node\" attr.type=\"string\">\n" .
					"    <default></default>\n" .
					"  </key>\n";
	// cluster level
	$out .= "  <key id=\"d6\" attr.name=\"ClusterLevel\" for=\"node\" attr.type=\"int\">\n" .
					"    <default>-1</default>\n" .
					"  </key>\n";
	// is marker node for cluster level
	$out .= "  <key id=\"d7\" attr.name=\"MarkerNode\" for=\"node\" attr.type=\"int\">\n" .
					"    <default>0</default>\n" .
					"  </key>\n";
	$out .= "  <key id=\"d8\" attr.name=\"Interpretation\" for=\"node\" attr.type=\"string\">\n" .
					"    <default></default>\n" .
					"  </key>\n";
	$out .= "  <key id=\"d9\" attr.name=\"DatingSpec\" for=\"node\" attr.type=\"string\">\n" .
					"    <default></default>\n" .
					"  </key>\n";
	$out .= "  <key id=\"d10\" attr.name=\"DatingPeriodId\" for=\"node\" attr.type=\"string\">\n" .
					"    <default></default>\n" .
					"  </key>\n";
	$out .= "  <key id=\"d11\" attr.name=\"DatingPeriodName\" for=\"node\" attr.type=\"string\">\n" .
					"    <default></default>\n" .
					"  </key>\n";
	$out .= "  <key id=\"d12\" attr.name=\"ExtendedLabel\" for=\"node\" attr.type=\"string\">\n" .
					"    <default></default>\n" .
					"  </key>\n";


	if ($_REQUEST['fileFormat'] == 'EXPORT_GRAPHML_YED') {
		$out .= "  <key id=\"dy0\" for=\"node\" yfiles.type=\"nodegraphics\"/>\n";
		$out .= "  <key id=\"d21\" for=\"edge\" yfiles.type=\"edgegraphics\"/>\n";
	}


	// start graph
	$out .= "\n" .
					"  <graph id=\"Excav\" edgedefault=\"directed\">\n";

	// output nodes and node cluster
	$graphMlIds = array();
	for($drawLevel = count(MatrixNode::$clusterTree) - 1; $drawLevel >= 0; $drawLevel--) {
		foreach (MatrixNode::$clusterTree[$drawLevel] as $node) {
			// if there are outer nodes we are a inner node and
			// output happened already as part of the outer node output
			if ($node->outerClusterNodes) {
				continue;
			}
			graphMlNodeOut($node, $indentLevel, $outCount, $out, $graphMlIds);
		}  // eo stratum loop
	}  // eo level


	// output relations/edges
	// ATTENTION: nodes without graph ml id are skiped SILENTLY
	$edgeCount = 0;
	foreach (MatrixNode::$clusterTree[$stratumLevel] as $node) {

		$nodeGraphMlId = getGraphMlNodeId($node, $graphMlIds);
		if (!$nodeGraphMlId) {
			continue;
		}

		// output earlier/later edges
		foreach($node->matrixInfo[StratumMatrix::THIS_IS_LATER_THAN] as $earlierNodeId) {
			$otherNode = MatrixNode::$clusterTree[$stratumLevel][$earlierNodeId];
			$otherGraphMlId = getGraphMlNodeId($otherNode, $graphMlIds);
			if (!$otherGraphMlId) {
				continue;
			}
			$out .= "    <edge id=\"e{$edgeCount}\" source=\"{$nodeGraphMlId}\" target=\"{$otherGraphMlId}\"/>\n";
			$edgeCount++;
		}

		// output multi cluster nodes - related nodes must exist at stratum level
		if ($node->isCollectorNode) {
			foreach($node->innerStratumNodesBak as $otherNode) {
				$otherGraphMlId = getGraphMlNodeId($otherNode, $graphMlIds);
				if (!$otherGraphMlId) {
					continue;
				}
				$out .=
					"    <edge id=\"e{$edgeCount}\" source=\"{$nodeGraphMlId}\" target=\"{$otherGraphMlId}\">\n" .
					"      <data key=\"d21\">\n" .
					"        <y:PolyLineEdge>\n" .
					"          <y:Path sx=\"15.0\" sy=\"0.0\" tx=\"-15.0\" ty=\"0.0\"/>\n" .
					"          <y:LineStyle color=\"#FF0000\" type=\"line\" width=\"5.0\"/>\n" .
					"          <y:Arrows source=\"none\" target=\"white_delta\"/>\n" .
					"          <y:BendStyle smoothed=\"false\"/>\n" .
					"        </y:PolyLineEdge>\n" .
					"      </data>\n" .
					"    </edge>\n" .
					"";

				$edgeCount++;
			}
		}
	}  // eo relations output

	// output contemp with relations

	if ($_REQUEST['contempWithLines'] && $_REQUEST['fileFormat'] == 'EXPORT_GRAPHML_YED') {
		foreach (MatrixNode::$contempWithHeadNodes as $node) {
			$lastGraphMlId = getGraphMlNodeId($node, $graphMlIds);
			foreach($node->matrixInfo[StratumMatrix::THIS_IS_CONTEMP_WITH] as $cwNodeId) {
				$cwNode = MatrixNode::$allNodes[$cwNodeId];
				$cwGraphMlId = getGraphMlNodeId($cwNode, $graphMlIds);
				if (!$lastGraphMlId || !$cwGraphMlId) {
					continue;
				}
				$out .= "    <edge id=\"e{$edgeCount}\" source=\"$lastGraphMlId\" target=\"{$cwGraphMlId}\">\n";
				$out .= "    <data key=\"d21\">\n" .
								"       <y:PolyLineEdge>\n" .
								"         <y:Path sx=\"0.0\" sy=\"0.0\" tx=\"0.0\" ty=\"0.0\"/>\n" .
								"         <y:LineStyle color=\"#00FF00\" type=\"dashed\" width=\"5.0\"/>\n" .
								"         <y:Arrows source=\"none\" target=\"none\"/>\n" .
								"         <y:BendStyle smoothed=\"false\"/>\n" .
								"       </y:PolyLineEdge>\n" .
								"     </data>\n" .
								"    </edge>\n" .
								"";
				$edgeCount++;
				$lastGraphMlId = $cwGraphMlId;
			}
		}
	}  // eo contemp with




	// finish graph
	$out .= "  </graph>\n" .
					"</graphml>\n";


	echo "<br>";
	echo (0 + $outCount) . " Datensätze erstellt.<br>";
	echo "Dateigrösse: " . strlen($out) . " Bytes.<br>";

	if ($_REQUEST['fileFormat'] == 'EXPORT_GRAPHML_YED') {
		$fileExtra = "yed";
	}
	else {
		$fileExtra = "graphml";
	}
	if ($outCount) {
		$downloadId = time();
		$_SESSION[Logon::$_id]['matrix'][$downloadId]['content'] = $out;
		$_SESSION[Logon::$_id]['matrix'][$downloadId]['fileName']= "ogerarch-{$fileExtra}_" . date('Y-m-d') . ".graphml";
		echo "<br><a href=\"matrix.php?_LOGONID={$_REQUEST['_LOGONID']}&_action=download&id={$downloadId}\">Download</a><br>\n";
	}

}  // eo graphml

/*
* Output one graphml node
*/
function graphMlNodeOut($node, $indentLevel, &$outCount, &$out, &$graphMlIds) {

	$indent = str_repeat("  ", $indentLevel + 2);

	$stratumLevel = 0;

	$graphMlId = "n$outCount";
	$graphMlIds[$node->nodeId] = $graphMlId;


	$nodeNameExtended = $node->nodeName;
	if ($_REQUEST['labelCategoryName'] && $node->isStratumNode) {
		$nodeNameExtended .= "\n{$node->categoryName}";
	}
	if ($_REQUEST['labelStratumTypeName'] && $node->isStratumNode) {
		$nodeNameExtended .= "\n{$node->typeName}";
	}

	if ($_REQUEST['labelArchObjectTypeName'] && $node->isArchObjectNode) {
		$nodeNameExtended .= "\n{$node->typeName}";
	}

	if ($_REQUEST['labelArchObjGroupTypeName'] && $node->isArchObjGroupNode) {
		$nodeNameExtended .= "\n{$node->typeName}";
	}

	if ($_REQUEST['labelCollectorMembers'] && $node->isCollectorNode) {
		$nodeNameExtended .= "\n[{$node->innerNodeNameList}]";
	}

	$nodeNameExtended = htmlspecialchars($nodeNameExtended, ENT_NOQUOTES | ENT_XML1, "UTF-8");


	// set attributes
	$shapeType = "rectangle";
	$fillColor = "#FFFFFF";
	$fontStyle = "plain";
	$borderWidth = "1.0";

	switch ($node->clusterLevel) {
	case 1:
		$fillColor = "#CCCCFF";
		break;
	case 2:
		$fontStyle = "bold";
		$borderWidth = "2.0";
		break;
	}

	// calc y-pos for yED
	$yPos = $node->rowNum * 150;

	// handle non-interface stratums at stratumlevel
	if ($node->clusterLevel == $stratumLevel && $node->categoryId != StratumCategory::ID_INTERFACE) {
		$shapeType = "ellipse";
	}

	// increment counter
	$outCount++;


	// begin of node and node-id
	$out .= "{$indent}<node id=\"$graphMlId\">\n";

	// output graphml data
	$isMarkerNode = (int)$node->isMarkerNode;
	if ($node->nodeName) {
		$out .= "{$indent}  <data key=\"d0\">{$node->nodeName}</data>\n";
	}
	if ($node->categoryId) {
		$out .= "{$indent}  <data key=\"d2\">{$node->categoryId}</data>\n";
	}
	if ($node->categoryName) {
		$out .= "{$indent}  <data key=\"d3\">{$node->categoryName}</data>\n";
	}
	if ($node->typeId) {
		$out .= "{$indent}  <data key=\"d4\">{$node->typeId}</data>\n";
	}
	if ($node->typeName) {
		$out .= "{$indent}  <data key=\"d5\">{$node->typeName}</data>\n";
	}
	if ($node->clusterLevel !== null) {
		$out .= "{$indent}  <data key=\"d6\">{$node->clusterLevel}</data>\n";
	}
	if ($isMarkerNode) {
		$out .= "{$indent}  <data key=\"d7\">{$isMarkerNode}</data>\n";
	}
	if ($node->interpretation) {
		$out .= "{$indent}  <data key=\"d8\">{$node->interpretation}</data>\n";
	}
	if ($node->datingSpec) {
		$out .= "{$indent}  <data key=\"d9\">{$node->datingSpec}</data>\n";
	}
	if ($node->datingPeriodId) {
		$out .= "{$indent}  <data key=\"d10\">{$node->datingPeriodId}</data>\n";
	}
	if ($node->datingPeriodName) {
		$out .= "{$indent}  <data key=\"d11\">{$node->datingPeriodName}</data>\n";
	}
	if ($nodeNameExtended) {
		$out .= "{$indent}  <data key=\"d12\">{$nodeNameExtended}</data>\n";
	}


	if ($_REQUEST['fileFormat'] == 'EXPORT_GRAPHML_YED') {

		// if inner nodes are present we show a yed cluster node and start a subgraph
		if ($node->innerClusterNodes) {
			$out .= "{$indent}  <data key=\"dy0\">\n" .
							"{$indent}    <y:ProxyAutoBoundsNode>\n" .
							"{$indent}      <y:Realizers active=\"0\">\n" .
							"{$indent}        <y:GroupNode>\n" .
						//"{$indent}          <y:Geometry height="192.9609375" width="108.857421875" x="223.5712890625" y="90.5390625"/>
							"{$indent}          <y:Fill color=\"$fillColor\" transparent=\"false\"/>\n" .
							"{$indent}          <y:BorderStyle color=\"#000000\" type=\"line\" width=\"$borderWidth\"/>\n" .
						//"{$indent}          <y:NodeLabel alignment="right" autoSizePolicy="node_width"[oegerinfo: is full node wight] backgroundColor="#EBEBEB" borderDistance="0.0" fontFamily="Dialog" fontSize="15" fontStyle="plain" hasLineColor="false" height="21.4609375" modelName="internal" modelPosition="t" textColor="#000000" visible="true" width="108.857421875" x="0.0" y="0.0">ogergroup1</y:NodeLabel>
							"{$indent}          <y:NodeLabel alignment=\"center\" fontStyle=\"$fontStyle\" autoSizePolicy=\"content\" backgroundColor=\"#FFFFFF\" modelName=\"internal\" modelPosition=\"t\" borderDistance=\"10.0\" topInset=\"5\" leftInset=\"5\" bottomInset=\"5\" rightInset=\"5\">{$nodeNameExtended}</y:NodeLabel>\n" .
							"{$indent}          <y:Shape type=\"$shapeType\"/>\n" .
						//"{$indent}          <y:State closed="false" closedHeight="50.0" closedWidth="50.0" innerGraphDisplayEnabled="false"/>
							"{$indent}          <y:State closed=\"false\"/>\n" .
						//"{$indent}          <y:Insets bottom="15" bottomF="15.0" left="15" leftF="15.0" right="15" rightF="15.0" top="15" topF="15.0"/>
							"{$indent}          <y:Insets bottom=\"15\" bottomF=\"15.0\" left=\"15\" leftF=\"15.0\" right=\"15\" rightF=\"15.0\" top=\"25\" topF=\"25.0\"/>\n" .
						//"{$indent}          <y:BorderInsets bottom="0" bottomF="0.0" left="0" leftF="0.0" right="0" rightF="0.0" top="0" topF="0.0"/>
							"{$indent}        </y:GroupNode>\n" .
							"{$indent}        <y:GroupNode>\n" .
						//"{$indent}          <y:Geometry height="50.0" width="50.0" x="223.5712890625" y="90.5390625"/>
						//"{$indent}          <y:Fill color="#F2F0D8" transparent="false"/>
						//"{$indent}          <y:BorderStyle color="#000000" type="line" width="1.0"/>
						//"{$indent}          <y:NodeLabel alignment="right" autoSizePolicy="node_width" backgroundColor="#B7B69E" borderDistance="0.0" fontFamily="Dialog" fontSize="15" fontStyle="plain" hasLineColor="false" height="21.4609375" modelName="internal" modelPosition="t" textColor="#000000" visible="true" width="65.201171875" x="-7.6005859375" y="0.0">Folder 1</y:NodeLabel>
							"{$indent}          <y:NodeLabel alignment=\"center\" autoSizePolicy=\"node_width\" backgroundColor=\"#B7B69E\" modelName=\"internal\" modelPosition=\"t\">{$nodeNameExtended}</y:NodeLabel>\n" .
						//"{$indent}          <y:Shape type="rectangle"/>
						//"{$indent}          <y:DropShadow color="#D2D2D2" offsetX="4" offsetY="4"/>
						//"{$indent}          <y:State closed="true" closedHeight="50.0" closedWidth="50.0" innerGraphDisplayEnabled="false"/>
							"{$indent}          <y:State closed=\"true\"/>\n" .
						//"{$indent}          <y:Insets bottom="5" bottomF="5.0" left="5" leftF="5.0" right="5" rightF="5.0" top="5" topF="5.0"/>
						//"{$indent}          <y:BorderInsets bottom="0" bottomF="0.0" left="0" leftF="0.0" right="0" rightF="0.0" top="0" topF="0.0"/>
							"{$indent}        </y:GroupNode>\n" .
							"{$indent}      </y:Realizers>\n" .
							"{$indent}    </y:ProxyAutoBoundsNode>\n" .
							"{$indent}  </data>\n";
			$out .= "{$indent}  <graph id=\"{$graphMlId}:\" edgedefault=\"directed\">\n";
			foreach($node->innerClusterNodes as $innerNode) {
				graphMlNodeOut($innerNode, $indentLevel + 2, $outCount, $out, $graphMlIds);
			}
			$out .= "{$indent}  </graph>\n";
		}

		else {   // yED base node
			$out .= "{$indent}  <data key=\"dy0\">\n" .
							"{$indent}    <y:ShapeNode>\n" .
						//"{$indent}      <y:Geometry height="30.0" width="78.857421875" x="-158.4287109375" y="122.0"/>
							"{$indent}      <y:Geometry y=\"{$yPos}\"" .
								($node->isCollectorNode ? " width=\"60\"" : "" ) .
								"/>\n" .
							"{$indent}      <y:Fill color=\"{$fillColor}\" transparent=\"false\"/>\n" .
						//"{$indent}      <y:BorderStyle color="#000000" type="line" width="1.0"/>
						//"{$indent}      <y:NodeLabel alignment="center" autoSizePolicy="content" fontFamily="Dialog" fontSize="12" fontStyle="plain" hasBackgroundColor="false" hasLineColor="false" height="17.96875" modelName="custom" textColor="#000000" visible="true" width="68.857421875" x="5.0" y="6.015625">ogernode1<y:LabelModel>
//              "{$indent}      <y:NodeLabel>{$node->nodeName}</y:NodeLabel>\n" .
							"{$indent}      <y:NodeLabel>{$nodeNameExtended}</y:NodeLabel>\n" .
						//"{$indent}        <y:LabelModel>\n" .
						//"{$indent}          <y:SmartNodeLabelModel distance="4.0"/>
						//"{$indent}        </y:LabelModel>
						//"{$indent}        <y:ModelParameter>
						//"{$indent}          <y:SmartNodeLabelModelParameter labelRatioX="0.0" labelRatioY="0.0" nodeRatioX="0.0" nodeRatioY="0.0" offsetX="0.0" offsetY="0.0" upX="0.0" upY="-1.0"/>
						//"{$indent}        </y:ModelParameter>
						//"{$indent}      </y:NodeLabel>\n" .
							"{$indent}      <y:Shape type=\"{$shapeType}\"/>\n" .
							"{$indent}    </y:ShapeNode>\n" .
							"{$indent}  </data>\n";
		}
	}  // eo yed attributes


	// close node
	$out .= "{$indent}</node>\n";

}  // eo graphml node out

/*
* Get internal graph ml node id
*/
function getGraphMlNodeId($node, &$graphMlIds) {

	$id = $graphMlIds[$node->nodeId];
	if (!$id) {
		echo "INTERNER FEHLER: Für den Knoten '{$node->nodeName}' konnte keine GraphMlId ermittelt werden.<br>\n";
	}
	return $id;
}  // eo get graph ml id



?>
