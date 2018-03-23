<?php
/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/

require_once(__DIR__ . 'init.inc.php');


$excavId = 7;

$offset = 0;
$limit = 200;




// ########################################################################
// arch finds

$whereVals = array('excavId' => $excavId);


$okCount = 0;
$failCount = 0;




// fake sele vals for template internal checks
$seleVals = array("excavId" => $detailValues['excavId'], "archFindId" => $detailValues['archFindId']);
$sql = ArchFind12::getSql("FORM", $seleVals);
$pstmt12 = Dbw::$conn->prepare($sql);



$detailObj = new ArchFind();

$pstmtDetail = Db::prepare('SELECT * FROM ' . ArchFind::$tableName, $whereVals, "ORDER BY 0+archFindId LIMIT {$offset},{$limit}");
$whereVals = Db::getCleanWhereVals($whereVals);
$pstmtDetail->execute($whereVals);
while ($detailRow = $pstmtDetail->fetch(PDO::FETCH_ASSOC)) {

	$detailObj->clearValues();
	$detailObj->setValues($detailRow);
	$detailValues = $detailObj->getExtendedValues(array('export' => true, 'skipExtendedExport' => true));

	$seleVals = array("excavId" => $detailValues['excavId'], "archFindId" => $detailValues['archFindId']);
	$pstmt12->execute($seleVals);
	$values12 = $pstmt12->fetch(PDO::FETCH_ASSOC);
	// remove known extrafields
	unset($values12['excavName']);

	// calc diff
	echo "id={$detailValues['id']}, excavId={$detailValues['excavId']}, archFindId={$detailValues['archFindId']}";
	$interVals = array_intersect_assoc($detailValues, $values12);
	$detailValues = array_diff_assoc($detailValues, $interVals);
	$values12 = array_diff_assoc($values12, $interVals);

	if ($detailValues || $values12) {
		$failCount++;
		echo " FAILED<br>\n";
		echo "<b>pre12=</b>";
		var_export($detailValues);
		echo "<br>\n<b>cur12=</b>";
		var_export($values12);
		//echo "<br>\ncommon=";
		//var_export($interVals);
		echo "<br>\n";
	}
	else {
		$okCount++;
		echo " OK<br>\n";
		var_export($detailValues);
		var_export($values12);
		echo "<br>\n";
	}
	echo "<br>\n";

}
$pstmtDetail->closeCursor();
$pstmt12->closeCursor();


echo "Count ArchFind: OK={$okCount}, Failed={$failCount}<br><br>\n";


// eo arch finds




// ########################################################################
// stratum

$whereVals = array('excavId' => $excavId);


$okCount = 0;
$failCount = 0;




// fake sele vals for template internal checks
$seleVals = array("excavId" => $detailValues['excavId'], "stratumId" => $detailValues['stratumId']);
$sql = Stratum12::getSql("FORM", $seleVals);
$pstmt12 = Dbw::$conn->prepare($sql);



$detailObj = new Stratum();

$pstmtDetail = Db::prepare('SELECT * FROM ' . Stratum::$tableName, $whereVals, "ORDER BY 0+stratumId LIMIT {$offset},{$limit}");
$whereVals = Db::getCleanWhereVals($whereVals);
$pstmtDetail->execute($whereVals);
while ($detailRow = $pstmtDetail->fetch(PDO::FETCH_ASSOC)) {

	$detailObj->clearValues();
	$detailObj->setValues($detailRow);
	//$detailObj->allFromDb();
	$detailObj->stratumSubFromDb();
	$detailValues = $detailObj->getAllExtendedValues(array('export' => true));
	// remove known unused fields
	unset($detailValues['reverseEqualToIdList']);
	unset($detailValues['reverseContempWithIdList']);
	unset($detailValues['complexPartIdList']);
	unset($detailValues['partOfComplexIdList']);


	$seleVals = array("excavId" => $detailValues['excavId'], "stratumId" => $detailValues['stratumId']);
	$pstmt12->execute($seleVals);
	$values12 = $pstmt12->fetch(PDO::FETCH_ASSOC);
	$values12 = Stratum12::prep4Export($values12);

	// calc diff
	echo "id={$detailValues['id']}, excavId={$detailValues['excavId']}, stratumId={$detailValues['stratumId']}, category={$detailValues['categoryId']} : ";

	// preprocess migration
	if ($detailValues['categoryId'] == "DEPOSIT" && $detailValues['orientation'] == $values12['DEPOSIT___orientation']) {
		unset($detailValues['orientation']);
		unset($values12['DEPOSIT___orientation']);
	}
	if ($detailValues['categoryId'] == "SKELETON" && $detailValues['orientation'] == $values12['SKELETON___orientation']) {
		unset($detailValues['orientation']);
		unset($values12['SKELETON___orientation']);
	}
	if ($detailValues['categoryId'] == "TIMBER" && $detailValues['orientation'] == $values12['TIMBER___orientation']) {
		unset($detailValues['orientation']);
		unset($values12['TIMBER___orientation']);
	}

	if ($detailValues['categoryId'] == "TIMBER" && $detailValues['relationDescription'] == $values12['TIMBER___relationDescription']) {
		unset($detailValues['relationDescription']);
		unset($values12['TIMBER___relationDescription']);
	}

	if ($detailValues['categoryId'] == "WALL" && $detailValues['relationDescription'] == $values12['WALL___relationDescription']) {
		unset($detailValues['relationDescription']);
		unset($values12['WALL___relationDescription']);
	}




	$interVals = array_intersect_assoc($detailValues, $values12);
	$detailValues = array_diff_assoc($detailValues, $interVals);
	$values12 = array_diff_assoc($values12, $interVals);
	// remove null values - hoping that are all results of outer join
	foreach($values12 as $key => $value) {
		if ($value === null) {
			unset($values12[$key]);
		}
	} // eo unset-loop
	// unset known extrafields
	unset($values12['excavName']);



	// report
	if ($detailValues || $values12) {
		$failCount++;
		echo " FAILED<br>\n";
		echo "<b>pre12=</b>";
		var_export($detailValues);
		echo "<br>\n<b>cur12=</b>";
		var_export($values12);
		echo "<br>\n";
	}
	else {
		$okCount++;
		echo " OK<br>\n";
		var_export($detailValues);
		var_export($values12);
		echo "<br>\n";
	}
	echo "<br>\n";

}
$pstmtDetail->closeCursor();
$pstmt12->closeCursor();


echo "Count Stratum: OK={$okCount}, Failed={$failCount}<br><br>\n";


// eo stratums


?>
