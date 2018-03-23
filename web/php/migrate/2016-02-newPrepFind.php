<?php
/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/*
 * ATTENTION:
 *
 * 1) make shure that the table prepFindTMPNEW exists
 * 2) make prepFindTMPNEW is empty !!!
 * 3) run this migration script
 * 4) check protokoll:
 *    "***ANZAHL*** PrepFindToStockLocations uebertragen" muss gleich sein mit
 *    "...OLD PrepFinds uebertragen auf ***ANZAHL*** NEUE prepFinds"
 * 5) rename prepFind to prepFindOBSOLETE to avoid further usage
 *
 */

require_once(__DIR__ . "/../init.inc.php");

	echo "<h1>Prep Find Migration</h1>\n<hr>\n";

	// copy OBSOLETE prepFindToStockLocation to NEW prep find
	echo "<h2>Copy OBSOLETE prep-find-to-stock-location info to NEW prep find table</h2>\n";

	$copyFields = array(
		"excavId" => "",
		"archFindId" => "",
		"archFindIdSort" => "",  // new field
		"archFindSubId" => "",  // new field
		"archFindSubIdSort" => "",  // new field
		"stockLocationId" => "",
	);

	$sql =
		"INSERT INTO prepFindTMPNEW (";
	$delim = "";
	foreach ($copyFields as $key => $val) {
		if (!$key) { continue; }
		$sql .= "{$delim}{$key}";
		$delim = ", ";
	}
	$sql .=	") VALUES (";
	$delim = "";
	foreach ($copyFields as $key => $val) {
		if (!$key) { continue; }
		$sql .= "{$delim}:{$key}";
		$delim = ", ";
	}
	$sql .=	")";

	echo "Insert-SQL: {$sql}<br>\n";
	$pstmtInsertPF = Dbw::$conn->prepare($sql);

	$copySourceCount = 0;
	$copyDestCountPSL = 0;
	try {

		$pstmt = Dbw::checkedExecute("SELECT * FROM prepFindToStockLocation ORDER BY excavId,archFindId,stockLocationId");
		while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {

			if ($row['excavId'] != $oldExcavId || $row['archFindId'] != $oldArchFindId) {
				$subId = 0;
				$oldExcavId = $row['excavId'];
				$oldArchFindId = $row['archFindId'];
			}
			$subId++;

			$vals = array_intersect_key($row, $copyFields);
			$vals['archFindIdSort'] = Oger::getNatSortId($vals['archFindId']);
			$vals['archFindSubId'] = $subId;
			$vals['archFindSubIdSort'] = Oger::getNatSortId($subId);
			$pstmtInsertPF->execute($vals);
			$copySourceCount++;
			$rowCount = $pstmtInsertPF->rowCount();
			$copyDestCountPSL += $rowCount;
			if (!$rowCount) {
				echo "*** WARNUNG: excavId={$vals['excavId']}, archFindId={$vals['archFindId']}" .
				     ", stockLocationId={$vals['archStockLocationId']} konnte nicht angelegt werden.<br>\n";
			}
		}
		$pstmt->closeCursor();

	}
	catch (Exception $ex) {
		$isError = true;
		echo "*** FEHLER: " . $ex->getMessage() . "<br>\n";
	}

	echo "<br>\n";
	echo "{$copySourceCount} PrepFindToStockLocations uebertragen auf {$copyDestCountPSL} Lagerort-Funde.<br>";
	echo "<hr>";

	if ($isError) {
		echo "<b>ABORT</b>\n";
		exit;
	}

	// --------------------------------------------------------------------------------------

	// copy OLD prep find to NEW prep find
	echo "<h2>Copy prep find info from OLD to NEW table</h2>\n";

	$copyFields = array(
		"excavId" => "",
		"archFindId" => "",
		//"archFindIdSort" => "",
		"oriArchFindId" => "",
		"datingSpec" => "",
		"washStatusId" => "",
		"labelStatusId" => "",
		"restoreStatusId" => "",
		"photographStatusId" => "",
		"drawStatusId" => "",
		"layoutStatusId" => "",
		"scientificStatusId" => "",
		"publishStatusId" => "",
		"comment" => "",
	);
	$sql =
		"UPDATE prepFindTMPNEW SET ";
	$delim = "";
	foreach ($copyFields as $key => $val) {
		if (!$key) { continue; }
		$sql .= "{$delim}{$key}=:{$key}";
		$delim = ", ";
	}
	$sql .=	" WHERE excavId=:excavId AND archFindId=:archFindId";

	echo "Update-SQL: {$sql}<br>\n";
	$pstmtUpdPTS = Dbw::$conn->prepare($sql);

	$copySourceCount = 0;
	$copyDestCountPF = 0;
	$notFoundCount = 0;
	try {
		$pstmt = Dbw::checkedExecute("SELECT * FROM prepFind");
		while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
			$vals = array_intersect_key($row, $copyFields);
			$pstmtUpdPTS->execute($vals);
			$copySourceCount++;
			$rowCount = $pstmtUpdPTS->rowCount();
			$copyDestCountPF += $rowCount;
			if (!$rowCount) {
				$notFoundCount++;
				echo "*** WARNUNG: excavId={$vals['excavId']}, archFindId={$vals['archFindId']} nicht gefunden.<br>\n";
			}
		}
		$pstmt->closeCursor();

	}
	catch (Exception $ex) {
		$isError = true;
		echo "*** FEHLER: " . $ex->getMessage() . "<br>\n";
	}

	echo "<br>\n";
	echo "{$copySourceCount} OLD PrepFinds uebertragen auf {$copyDestCountPF} NEUE prepFinds. {$notFoundCount} PrepFinds nicht gefunden.<br>";
	echo "<hr>\n";

	if ($isError) {
		echo "<b>ABORT</b>\n";
		exit;
	}

	// ----------------------------------------------------------------------------------------

	echo "<br>\n";
	if ($copyDestCountPSL == $copyDestCountPF) {
		echo "Beide alte Tabellen vollständig vereint.<br>";
	}
	else {
		echo "ACHTUNG: " . abs($copyDestCountPSL - $copyDestCountPF) .
		" unvollständige Datensätze beim vereinen der beiden alten Tabellen.<br>";
	}
	echo "<hr>\n";

	// ----------------------------------------------------------------------------------------


?>
