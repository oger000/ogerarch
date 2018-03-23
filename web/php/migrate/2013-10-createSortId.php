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


	// arch find
	echo "Add column archFindIdSort to table archFind<br>\n";
	$tmpBeginTime = date("c");
	$errFlag = false;
	try {
		$cmd = "ALTER TABLE `archFind` ADD COLUMN `archFindIdSort` char(50) COLLATE utf8_unicode_ci NOT NULL";
		echo "{$cmd}<br>\n";
		Dbw::$conn->exec($cmd);
	}
	catch (Exception $ex) {
		echo "*** FEHLER: " . $ex->getMessage() . "<br>\n";
	}
	echo "<br>\n";


	echo "Begin: create arch find sort id on arch finds<br>";
	$errFlag = false;
	$updCount = 0;
	try {
		$cmdUpd = "UPDATE archFind SET archFindIdSort=:archFindIdSort " .
							"WHERE excavId=:excavId AND archFindId=:archFindId";
		echo "{$cmdUpd}<br>\n";
		$pstmtUpd = Dbw::$conn->prepare($cmdUpd);

		$cmd = "SELECT excavId,archFindId FROM archFind";
		$pstmt = Dbw::$conn->prepare($cmd);
		$pstmt->execute();
		while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
			//echo "excavId={$row['excavId']}, archFindId={$row['archFindId']}<br>\n";
			$row['archFindIdSort'] = Oger::getNatSortId($row['archFindId']);
			$pstmtUpd->execute($row);
			$updCount++;
		}
	}
	catch (Exception $ex) {
		$errFlag = true;
		echo "*** FEHLER: " . $ex->getMessage() . "<br>\n";
	}
	unset($pstmtUpd);
	$pstmt->closeCursor();
	unset($pstmt);

	if (!$errFlag) {
		echo "Affected row count: {$updCount}<br>\n";

		try {
			// write log
			echo "Write db struct log<br>\n";

			$values = array(
				"beginTime" => $tmpBeginTime,
				"log" => "Create archFindIdSort (natsort) on archFind table",
				"endTime" => date("c"),
			);
			$stmt = Dbw::getStoreStmt("INSERT", "dbStructLog", $values);
			$pstmt = Dbw::$conn->prepare($stmt);
			$pstmt->execute($values);
		}
		catch (Exception $ex) {
			echo "*** FEHLER: " . $ex->getMessage() . "<br>\n";
		}
		unset($pstmt);
	}  // no error

	echo "End: create arch find sort id on arch finds<br>\n";
	echo "<br>\n";




	// stratum
	echo "Add column stratumIdSort to table stratum<br>\n";
	$tmpBeginTime = date("c");
	$errFlag = false;
	try {
		$cmd = "ALTER TABLE `stratum` ADD COLUMN `stratumIdSort` char(50) COLLATE utf8_unicode_ci NOT NULL";
		echo "{$cmd}<br>\n";
		Dbw::$conn->exec($cmd);
	}
	catch (Exception $ex) {
		echo "*** FEHLER: " . $ex->getMessage() . "<br>\n";
	}
	echo "<br>\n";


	echo "Begin: create stratum sort id on stratum<br>";
	$errFlag = false;
	$updCount = 0;
	try {
		$cmdUpd = "UPDATE stratum SET stratumIdSort=:stratumIdSort " .
							"WHERE excavId=:excavId AND stratumId=:stratumId";
		echo "{$cmdUpd}<br>\n";
		$pstmtUpd = Dbw::$conn->prepare($cmdUpd);

		$cmd = "SELECT excavId,stratumId FROM stratum";
		$pstmt = Dbw::$conn->prepare($cmd);
		$pstmt->execute();
		while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
			//echo "excavId={$row['excavId']}, archFindId={$row['stratumId']}<br>\n";
			$row['stratumIdSort'] = Oger::getNatSortId($row['stratumId']);
			$pstmtUpd->execute($row);
			$updCount++;
		}
	}
	catch (Exception $ex) {
		$errFlag = true;
		echo "*** FEHLER: " . $ex->getMessage() . "<br>\n";
	}
	unset($pstmtUpd);
	$pstmt->closeCursor();
	unset($pstmt);

	if (!$errFlag) {
		echo "Affected row count: {$updCount}<br>\n";

		try {
			// write log
			echo "Write db struct log<br>\n";

			$values = array(
				"beginTime" => $tmpBeginTime,
				"log" => "Create stratumIdSort (natsort) on stratum table",
				"endTime" => date("c"),
			);
			$stmt = Dbw::getStoreStmt("INSERT", "dbStructLog", $values);
			$pstmt = Dbw::$conn->prepare($stmt);
			$pstmt->execute($values);
		}
		catch (Exception $ex) {
			echo "*** FEHLER: " . $ex->getMessage() . "<br>\n";
		}
		unset($pstmt);
	}  // no error

	echo "End: create stratum sort id on stratum<br>\n";
	echo "<br>\n";



?>
