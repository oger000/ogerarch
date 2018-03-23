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

$debug = false;

// load list from database
if ($_REQUEST['_action'] == 'loadList') {

	// get total count for current where values including remote filter
	$sql = Excavation12::getSql("GRIDCOUNT", $seleVals);
	$total = Dbw::fetchValue1($sql, $seleVals);

	// inc remote sort, filter, ...
	$seleVals = array();
	$sql = Excavation12::getSql("GRID", $seleVals);

	$pstmt = Dbw::checkedExecute($sql, $seleVals);
	$data = array();
	while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
		$data[] = $row;
	}
	$pstmt->closeCursor();

	echo Extjs::encData($data, $total);
	exit;

}  // eo loading list



// load one record from db
if ($_REQUEST['_action'] == 'loadRecord' ||
		$_REQUEST['_action'] == 'jumpOffset' || $_REQUEST['_action'] == 'jumpOffsetFilter') {

	$sqlTarget = "FORM";

	if ($_REQUEST['_action'] == 'jumpOffset' || $_REQUEST['_action'] == 'jumpOffsetFilter') {

		if ($_REQUEST['__OFFSET__'] > 0) {
			$sqlTarget = "FORM-OFFSET-NEXT";
			//$orderDir = "ASC";  // hardcoded in sql tpl
		}
		else {
			$sqlTarget = "FORM-OFFSET-PREV";
			//$orderDir = "DESC";  // hardcoded in sql tpl
		}

		if ($_REQUEST['_action'] == 'jumpOffsetFilter') {
			$sqlTarget .= "-FILTER";
		}

		// overwrite extjs sort - always sort by default order
		//$_REQUEST['sort'] = array("name" => $orderDir, "id" => $orderDir);  // hardcoded in sql tpl

		$_REQUEST['start'] = abs($_REQUEST['__OFFSET__']) - 1;
		$_REQUEST['limit'] = 1;
	}  // eo jump


	// remote sort, filter, ...
	$sql = Excavation12::getSql($sqlTarget, $seleVals);
	$pstmt = Dbw::checkedExecute($sql, $seleVals);
	$row = $pstmt->fetch(PDO::FETCH_ASSOC);
	$pstmt->closeCursor();

	if ($row === false) {
		echo Extjs::errorMsg("Keine weiteren Datensätze in diese Richtung gefunden.");
		exit;
	}

	$row = $row;
	echo Extjs::encData($row);
	exit;
}  // eo loading one record



/*
* Save input
*/
if ($_REQUEST['_action'] == 'save') {

	try {
		$row = Excavation12::storeInput($_REQUEST, $_REQUEST['dbAction']);
	}
	catch (Exception $ex) {
		echo Extjs::errorMsg($ex->getMessage());
		exit;
	}

	echo Extjs::encData($row);
	exit;
}  // eo save posted data to database



/*
* Delete excavation
*/
if ($_REQUEST['_action'] == 'deleteExcavation') {

	try {
		deleteFullExcav();
	}
	catch (Exception $ex) {
		echo $ex->getMessage();  // plain html
		exit;
	}

	exit;
}  // eo dele excav




echo Extjs::errorMsg(sprintf("Invalid action '%s' in '%s'.", $_REQUEST['_action'], $_SERVER['PHP_SELF']));
exit;



// ###################################################################


/*
 * delete full excav or parts like all arch finds, ...
 */
function deleteFullExcav() {

  HtmlHelper::htmlStart(true);
  echo "<h1>Grabung Löschen</h1>\n";
  echo "<b>Grabung: {$_REQUEST['excavName']}</b><br><br>\n";


	// check deleting code  - but NOT for localhost.
	// for localhost the code is fixed and not calced from the dele id
	if (!($_SERVER['HTTP_HOST'] == "localhost" && $_REQUEST['deleCode'] == "local")) {

		$deleId = str_replace("-", "", $_REQUEST['deleId']);

		$pass = substr($deleId, -5);
		$passAdd = substr($pass, -2, 1) + substr($pass, -1, 1);
		$pass =
			"9" .
			substr(substr($pass, 2, 1) + $passAdd + 0, -1) .
			substr(substr($pass, 4, 1) + $passAdd + 0, -1) .
			substr(substr($pass, 0, 1) + $passAdd + 1, -1) .
			"";

		if (($deleId < time() - (60 * 10)) ||
				($deleId > time() + (60 * 10))) {
			//echo "ID = '{$deleId}' / " . time() . "<br>\n";
			echo "Ungültige Lösch-ID.<br>\n";
			exit;
		}

		if (!$_REQUEST['deleCode'] || strlen($_REQUEST['deleCode']) != 4 ||
				substr($_REQUEST['deleCode'], -3) != substr($pass, -3)) {
			//echo "code = {$pass}<br>\n";
			echo "Ungültiger Lösch-Code<br>\n";
			exit;
		}

	}  // eo check dele pass


	$seleVals = array("excavId" => $_REQUEST['excavId']);


	// arch find
  echo "<hr>\n";
  echo "<b>Fund</b><br>\n";
	if ($_REQUEST['deleArchFind']) {
    echo 0 + $_REQUEST['archFindCount'] . " Funde erwartet.<br>\n";
		$pstmt = Dbw::$conn->prepare("DELETE FROM archFind WHERE excavId=:excavId");
		$pstmt->execute($seleVals);
    echo $pstmt->rowCount() . " Funde gelöscht.<br>\n";
	}
	else {
    echo "- Löschen nicht vorgesehen.<br>\n";
	}

	// stratum
  echo "<hr>\n";
  echo "<b>Stratum</b><br>\n";
	if ($_REQUEST['deleStratum']) {

    echo 0 + $_REQUEST['stratumCount'] . " Stratum-Haupteinträge erwartet.<br>\n";

		$pstmt = Dbw::$conn->prepare("DELETE FROM stratumInterface WHERE excavId=:excavId");
		$pstmt->execute($seleVals);
    echo $pstmt->rowCount() . " Interfaces gelöscht.<br>\n";

		$pstmt = Dbw::$conn->prepare("DELETE FROM stratumDeposit WHERE excavId=:excavId");
		$pstmt->execute($seleVals);
    echo $pstmt->rowCount() . " Schichten gelöscht.<br>\n";

		$pstmt = Dbw::$conn->prepare("DELETE FROM stratumWall WHERE excavId=:excavId");
		$pstmt->execute($seleVals);
    echo $pstmt->rowCount() . " Mauern gelöscht.<br>\n";

		$pstmt = Dbw::$conn->prepare("DELETE FROM stratumTimber WHERE excavId=:excavId");
		$pstmt->execute($seleVals);
    echo $pstmt->rowCount() . " Holz gelöscht.<br>\n";

		$pstmt = Dbw::$conn->prepare("DELETE FROM stratumSkeleton WHERE excavId=:excavId");
		$pstmt->execute($seleVals);
    echo $pstmt->rowCount() . " Skelette gelöscht.<br>\n";

		$pstmt = Dbw::$conn->prepare("DELETE FROM stratumComplex WHERE excavId=:excavId");
		$pstmt->execute($seleVals);
    echo $pstmt->rowCount() . " Komplexe gelöscht.<br>\n";

		$pstmt = Dbw::$conn->prepare("DELETE FROM stratumMatrix WHERE excavId=:excavId");
		$pstmt->execute($seleVals);
    echo $pstmt->rowCount() . " Matrix-Verweise gelöscht.<br>\n";

		$pstmt = Dbw::$conn->prepare("DELETE FROM stratum WHERE excavId=:excavId");
		$pstmt->execute($seleVals);
    echo $pstmt->rowCount() . " Stratum-Haupteinträge gelöscht.<br>\n";
	}
	else {
    echo "- Löschen nicht vorgesehen.<br>\n";
	}

  // arch obj
  echo "<hr>\n";
  echo "<b>Objekt</b><br>\n";
	if ($_REQUEST['deleArchObject']) {
    echo 0 + $_REQUEST['archObjectCount'] . " Objekte erwartet.<br>\n";
		$pstmt = Dbw::$conn->prepare("DELETE FROM archObject WHERE excavId=:excavId");
		$pstmt->execute($seleVals);
    echo $pstmt->rowCount() . " Objekte gelöscht.<br>\n";
	}
	else {
    echo "- Löschen nicht vorgesehen.<br>\n";
	}

  // obj grp
  echo "<hr>\n";
  echo "<b>Objektgruppe</b><br>\n";
	if ($_REQUEST['deleArchObjGroup']) {
    echo 0 + $_REQUEST['archObjGroupCount'] . " Objektgruppen erwartet.<br>\n";
		$pstmt = Dbw::$conn->prepare("DELETE FROM archObjGroup WHERE excavId=:excavId");
		$pstmt->execute($seleVals);
    echo $pstmt->rowCount() . " Objektgruppen gelöscht.<br>\n";
	}
	else {
    echo "- Löschen nicht vorgesehen.<br>\n";
	}

  // prep find + stock location
  echo "<hr>\n";
  echo "<b>Fund (Lager)</b><br>\n";
	if ($_REQUEST['delePrepFind']) {
    echo 0 + $_REQUEST['prepFindCount'] . " Funde (Lager) erwartet.<br>\n";
		$pstmt = Dbw::$conn->prepare("DELETE FROM prepFindTMPNEW WHERE excavId=:excavId");
		$pstmt->execute($seleVals);
    echo $pstmt->rowCount() . " Funde (Lager) gelöscht.<br>\n";
	}
	else {
    echo "- Löschen nicht vorgesehen.<br>\n";
	}


	// ATTENTION:
	// we NOT delete
	// - archFindCatalog
	// - pictureFile
	// because that should be empty
	// so finaly deleting of excavation failes if something exists here


  // -----------------
  // orphaned m:n joining entries

  // stratum to arch find
  echo "<hr>\n";
  echo "<b>Stratum-zu-Fund Verbindung</b><br>\n";
  $pstmt = Dbw::$conn->prepare(
    "DELETE STAF" .
    " FROM stratumToArchFind AS STAF" .
    "  LEFT OUTER JOIN archFind" .
    "    ON archFind.excavId = STAF.excavId AND archFind.archFindId = STAF.archFindId" .
    "  LEFT OUTER JOIN stratum" .
    "    ON stratum.excavId = STAF.excavId AND stratum.stratumId = STAF.stratumId" .
    " WHERE STAF.excavId=:excavId AND archFind.archFindId IS NULL AND stratum.stratumId IS NULL" .
    ""
  );
  $pstmt->execute($seleVals);
  echo $pstmt->rowCount() . " Stratum-zu-Fund Verbindungen gelöscht.<br>\n";

  // arch object to stratum
  echo "<hr>\n";
  echo "<b>Objekt-zu-Stratum Verbindung</b><br>\n";
  $pstmt = Dbw::$conn->prepare(
    "DELETE OTS" .
    " FROM archObjectToStratum AS OTS" .
    "  LEFT OUTER JOIN archObject" .
    "    ON archObject.excavId = OTS.excavId AND archObject.archObjectId = OTS.archObjectId" .
    "  LEFT OUTER JOIN stratum" .
    "    ON stratum.excavId = OTS.excavId AND stratum.stratumId = OTS.stratumId" .
    " WHERE OTS.excavId=:excavId AND archObject.archObjectId IS NULL AND stratum.stratumId IS NULL" .
    ""
  );
  $pstmt->execute($seleVals);
  echo $pstmt->rowCount() . " Objekt-zu-Stratum Verbindungen gelöscht.<br>\n";

  // arch object group to object
  echo "<hr>\n";
  echo "<b>Objektgruppe-zu-Objekt Verbindung</b><br>\n";
  $pstmt = Dbw::$conn->prepare(
    "DELETE GTO" .
    " FROM archObjGroupToArchObject AS GTO" .
    "  LEFT OUTER JOIN archObject" .
    "    ON archObject.excavId = GTO.excavId AND archObject.archObjectId = GTO.archObjectId" .
    "  LEFT OUTER JOIN archObjGroup" .
    "    ON archObjGroup.excavId = GTO.excavId AND archObjGroup.archObjGroupId = GTO.archObjGroupId" .
    " WHERE GTO.excavId=:excavId AND archObject.archObjectId IS NULL AND archObjGroup.archObjGroupId IS NULL" .
    ""
  );
  $pstmt->execute($seleVals);
  echo $pstmt->rowCount() . " Objektgruppe-zu-Objekt Verbindungen gelöscht.<br>\n";

	// stock location if empty
  echo "<hr>\n";
  echo "<b>Lager-Behälter</b><br>\n";
	if ($_REQUEST['deleStockLocation']) {

		$pstmt = Dbw::$conn->prepare(
			"DELETE STL" .
			" FROM stockLocation AS STL" .
			" WHERE STL.excavId=:excavId" .
			"   AND (SELECT COUNT(*) FROM prepFindTMPNEW AS PF" .
			"        WHERE PF.excavId=:excavId AND PF.stockLocationId = STL.stockLocationId) = 0" .
			""
		);
		$pstmt->execute($seleVals);
		echo $pstmt->rowCount() . " Lager-Behälter gelöscht.<br>\n";
	}
	else {
    echo "- Löschen nicht vorgesehen.<br>\n";
	}


  // finaly dele excav
  echo "<hr>\n";
  echo "<b>Grabung-Kerndaten</b><br>\n";
	if ($_REQUEST['deleFullExcav']) {
		$pstmt = Dbw::$conn->prepare("DELETE FROM excavation WHERE id=:excavId");
		$pstmt->execute($seleVals);
    echo $pstmt->rowCount() . " Grabung-Kerndaten gelöscht.<br>\n";
	}
	else {
    echo "- Löschen nicht vorgesehen.<br>\n";
	}


  HtmlHelper::htmlEnd();

}  // eo dele full excav


?>
