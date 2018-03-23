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


	echo "Add column tombOtherMaterialStratumIdList to table stratumSkeleton<br>\n";
	$errFlag = false;
	try {
		$cmd = "ALTER TABLE `stratumSkeleton` ADD COLUMN `tombOtherMaterialStratumIdList` " .
					 "varchar(500) COLLATE utf8_unicode_ci NOT NULL";
		echo "{$cmd}<br>\n";
		Dbw::$conn->exec($cmd);
	}
	catch (Exception $ex) {
		echo "*** FEHLER: " . $ex->getMessage() . "<br>\n";
	}
	echo "<br>\n";


	echo "Transfer values from tombOtherMaterialStratumId to tombOtherMaterialStratumIdList<br>\n";
	$tmpBeginTime = date("c");
	$errFlag = false;
	try {
		$cmd = "UPDATE `stratumSkeleton` SET `tombOtherMaterialStratumIdList`=`tombOtherMaterialStratumId` ".
					 "WHERE `tombOtherMaterialStratumIdList`='' and `tombOtherMaterialStratumId`!=''";
		echo "{$cmd}<br>\n";
		$rowCount = Dbw::$conn->exec($cmd);
	}
	catch (Exception $ex) {
		$errFlag = true;
		echo "*** FEHLER: " . $ex->getMessage() . "<br>\n";
	}

	if (!$errFlag) {
		echo "Affected row count: " . ($rowCount + 0) . "<br>\n";

		try {
			// write log
			echo "Write db struct log<br>\n";

			$values = array(
				"beginTime" => $tmpBeginTime,
				"log" => "Transfer values from tombOtherMaterialStratumId to tombOtherMaterialStratumIdList",
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
	}
	echo "<br>\n";


	echo "Please drop column tombOtherMaterialStratumId from table stratumSkeleton after successful value transfer<br>\n";
	echo "<br>\n";



?>
