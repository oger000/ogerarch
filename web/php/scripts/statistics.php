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
* Create statistics
*/
if ($_REQUEST['_action'] == 'statistics') {

	// if  no excavId is given than export all excavations
	if (!$_REQUEST['excavId']) {
		$pstmt = Db::prepare("SELECT id FROM " . Excavation::$tableName . "ORDER BY name");
		$pstmt->execute();
		$excavList = $pstmt->fetchAll();
		$pstmt->closeCursor();
	}
	else {
		$excavList = array(array('id' => $_REQUEST['excavId']));
	}


	// loop over excavations
	foreach ($excavList as $excavSele) {

		$excav = Excavation::newFromDb(array('id' => $excavSele['id']));
		if (!$excav->values) {
			echo Extjs::errorMsg('Keine Grabung mit ID ' . $excavSele['id'] . ' gefunden.<br>');
			exit;
		}

		echo "<H1>Grabung " . $excav->values['name'] . "</H1>";
		doStatistics($excav->values['id']);
		echo "<HR>";
	}

}  // eo start statistics



/*
* Process all statistics
*/
function doStatistics($excavId) {

	if ($_REQUEST['archFind']) {
		doArchFindStatistics($excavId);
	}

	if ($_REQUEST['stratum']) {
		doStratumStatistics($excavId);
	}

	if ($_REQUEST['archObject']) {
		doArchObjectStatistics($excavId);
	}

	if ($_REQUEST['archObjGroup']) {
		doArchObjGroupStatistics($excavId);
	}

}  // eo process all statistics



/*
* Process arch find statistics
*/
function doArchFindStatistics($excavId) {

	echo "<HR>";
	echo "<H2>Fund/Probe</H2>";

	$whereVals = array();
	$whereVals['excavId'] = $excavId;

	if ($_REQUEST['beginDate']) {
		$whereVals['date,>='] = $_REQUEST['beginDate'];
	}
	if ($_REQUEST['endDate']) {
		$whereVals['date,<='] = $_REQUEST['endDate'];
	}


	$labels = ArchFind::getItemLabels();
	// unset "atStep xxx" labels
	foreach ($labels as $key => $value) {
		if (substr($key, 0, 6) == "atStep") {
			unset($labels[$key]);
		}
	}

	$count = array();
	$countThis = 0;
	$specialArchFinds = array();
	$otherArchFinds = array();
	$otherSamples = array();

	$pstmt = Db::prepare("SELECT * FROM " . ArchFind::$tableName, $whereVals, "ORDER BY 0+archFindId");
	$whereVals = Db::getCleanWhereVals($whereVals);
	$pstmt->execute($whereVals);
	while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {

		$countThis++;

		// materialtypes
		foreach ($row as $key => $value) {
			if (array_key_exists($key, $labels) && $value) {
				$count[$key]++;
			}
		}

		if ($_REQUEST['specialArchFind'] && $row['specialArchFind']) {
			$specialArchFinds[] = "{$row['specialArchFind']} (Fundnummer {$row['archFindId']})";
		}
		if ($_REQUEST['archFindOther'] && $row['archFindOther']) {
			$otherArchFinds[] = $row['archFindOther'] . " (Fundnummer " . $row['archFindId'] . ")";
		}
		if ($_REQUEST['sampleOther'] && $row['sampleOther']) {
			$otherSamples[] = $row['sampleOther'] . " (Fundnummer " . $row['archFindId'] . ")";
		}

	}  // eo loop
	$pstmt->closeCursor();

	echo "$countThis Fund/Probe<br><br>";

	foreach ($labels as $key => $label) {
		$count[$key] *= 1;
		echo "{$count[$key]} $label <BR>";
	}


	if ($specialArchFinds) {
		echo "<H3>Sonderfund</H3>";
		foreach ($specialArchFinds as $text) {
			echo $text . "<BR>";
		}
	}

	if ($otherArchFinds) {
		echo "<H3>Sonstiger Fund</H3>";
		foreach ($otherArchFinds as $text) {
			echo $text . "<BR>";
		}
	}

	if ($otherSamples) {
		echo "<H3>Sonstige Probe</H3>";
		foreach ($otherSamples as $text) {
			echo $text . "<BR>";
		}
	}

}  // eo arch find


/*
* Process stratum statistics
*/
function doStratumStatistics($excavId) {

	echo "<HR>";
	echo "<H2>Stratum</H2>";

	$whereVals = array();
	$whereVals['excavId'] = $excavId;

	if ($_REQUEST['beginDate']) {
		$whereVals['date,>='] = $_REQUEST['beginDate'];
	}
	if ($_REQUEST['endDate']) {
		$whereVals['date,<='] = $_REQUEST['endDate'];
	}


	$categoryLabels = StratumCategory::getRecordsWithKeys();
	$typeLabels = array();
	$pstmt = Db::prepare("SELECT * FROM " . StratumType::$tableName);
	$pstmt->execute();
	while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
		$typeLabels[$row['id']] = $row['name'];
	}  // eo loop
	$pstmt->closeCursor();

	$count = array();
	$countThis = 0;
	$categoryCount = array();
	$typeCount = array();

	$pstmt = Db::prepare("SELECT * FROM " . Stratum::$tableName, $whereVals, "ORDER BY 0+stratumId");
	$whereVals = Db::getCleanWhereVals($whereVals);
	$pstmt->execute($whereVals);
	while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {

		$countThis++;

		// categories
		if (array_key_exists($row['categoryId'], $categoryLabels)) {
			$categoryName = $categoryLabels[$row['categoryId']]['name'];
		}
		else {
			$categoryName = "? " . $row['categoryId'];
		}
		$categoryCount[$categoryName]++;

		// types
		if ($_REQUEST['stratumType']) {
			if (array_key_exists($row['typeId'], $typeLabels)) {
				$typeName = $typeLabels[$row['typeId']];
			}
			else {
				if (!$row['typeId']) {
					$typeName = "[ohne Art/Bezeichnung]";
				}
				else {
					$typeName = "{$row['typeId']} [man]";
				}
			}
			$typeCount[$categoryName][$typeName]++;
		}

	}  // eo loop
	$pstmt->closeCursor();

	echo "$countThis Stratum<br><br>";

	ksort($categoryCount);

	foreach ($categoryCount as $catName => $catCount) {
		echo "$catCount $catName <BR>";
		if ($typeCount[$catName]) {
			ksort($typeCount[$catName]);
			foreach ($typeCount[$catName] as $typeName_ => $typeCount_) {
				echo "&nbsp;&nbsp;&nbsp;" . $typeCount_ . " " . $typeName_ . "<BR>";
			}
		}
		if ($_REQUEST['stratumType']) {
			echo "<BR>";
		}
	} // eo output

}  // eo stratum




/*
* Process arch object statistics
*/
function doArchObjectStatistics($excavId) {

	echo "<HR>";
	echo "<H2>Objekt</H2>";

	$whereVals = array();
	$whereVals['excavId'] = $excavId;

	if ($_REQUEST['beginDate']) {
		$whereVals['date,>='] = $_REQUEST['beginDate'];
	}
	if ($_REQUEST['endDate']) {
		$whereVals['date,<='] = $_REQUEST['endDate'];
	}


	$typeLabels = array();
	$pstmt = Db::prepare("SELECT * FROM " . ArchObjectType::$tableName);
	$pstmt->execute();
	while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
		$typeLabels[$row['id']] = $row['name'];
	}  // eo loop
	$pstmt->closeCursor();

	$count = array();
	$countThis = 0;
	$typeCount = array();

	$pstmt = Db::prepare("SELECT * FROM " . ArchObject::$tableName, $whereVals, "ORDER BY 0+archObjectId");
	$whereVals = Db::getCleanWhereVals($whereVals);
	$pstmt->execute($whereVals);
	while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {

		$countThis++;

		// types
		if ($_REQUEST['archObjectType']) {
			if (array_key_exists($row['typeId'], $typeLabels)) {
				$typeName = $typeLabels[$row['typeId']];
			}
			else {
				if (!$row['typeId']) {
					$typeName = "[ohne Art/Bezeichnung]";
				}
				else {
					$typeName = "{$row['typeId']} [man]";
				}
			}
			$typeCount[$typeName]++;
		}

	}  // eo loop
	$pstmt->closeCursor();

	echo "$countThis Objekt<br><br>";

	ksort($typeCount);
	foreach ($typeCount as $typeName_ => $typeCount_) {
		echo "&nbsp;&nbsp;&nbsp;" . $typeCount_ . " " . $typeName_ . "<BR>";
	}

}  // eo arch object



/*
* Process arch object group statistics
*/
function doArchObjGroupStatistics($excavId) {

	echo "<HR>";
	echo "<H2>Objektgruppe</H2>";

	$whereVals = array();
	$whereVals['excavId'] = $excavId;

	if ($_REQUEST['beginDate']) {
		$whereVals['date,>='] = $_REQUEST['beginDate'];
	}
	if ($_REQUEST['endDate']) {
		$whereVals['date,<='] = $_REQUEST['endDate'];
	}


	$typeLabels = array();
	$pstmt = Db::prepare("SELECT * FROM " . ArchObjGroupType::$tableName);
	$pstmt->execute();
	while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
		$typeLabels[$row['id']] = $row['name'];
	}  // eo loop
	$pstmt->closeCursor();

	$count = array();
	$countThis = 0;
	$typeCount = array();

	$pstmt = Db::prepare("SELECT * FROM " . ArchObjGroup::$tableName, $whereVals, "ORDER BY 0+archObjGroupId");
	$whereVals = Db::getCleanWhereVals($whereVals);
	$pstmt->execute($whereVals);
	while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {

		$countThis++;

		// types
		if ($_REQUEST['archObjGroupType']) {
			if (array_key_exists($row['typeId'], $typeLabels)) {
				$typeName = $typeLabels[$row['typeId']];
			}
			else {
				if (!$row['typeId']) {
					$typeName = "[ohne Art/Bezeichnung]";
				}
				else {
					$typeName = "{$row['typeId']} [man]";
				}
			}
			$typeCount[$typeName]++;
		}

	}  // eo loop
	$pstmt->closeCursor();

	echo "$countThis Objekt<br><br>";

	ksort($typeCount);
	foreach ($typeCount as $typeName_ => $typeCount_) {
		echo "&nbsp;&nbsp;&nbsp;" . $typeCount_ . " " . $typeName_ . "<BR>";
	}

}  // eo arch object group





?>
