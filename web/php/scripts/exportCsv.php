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




//$fileName = sys_get_temp_dir() . '/ogerarch_' . time() . '.txt';
$fileName = 'php://output';
$fh = fopen ($fileName, 'w+');
if ($fh === false) {
	echo "Cannot open file $fileName.";
	exit;
}




header("Content-type: text/csv");
header('Content-disposition: attachment; filename="Export.csv"');



$data = collectExportData($outDate);

// loop over excavations
foreach ($data['EXCAVATIONLIST'] as $excav) {
	csvExportExcav($excav);
}



// MASTERDATA
if ($_REQUEST['companyMaster']) {
	echo "Company master requested, but not available in CSV format.\n\n";  // TODO
}
if ($_REQUEST['stratumCategoryMaster']) {
	echo "Stratum category master requested, but not available in CSV format.\n\n";
}
if ($_REQUEST['stratumTypeMaster']) {
	echo "Stratum type master requested, but not available in CSV format.\n\n";
}
if ($_REQUEST['archObjectTypeMaster']) {
	echo "Object type master requested, but not available in CSV format.\n\n";
}
if ($_REQUEST['archObjGroupTypeMaster']) {
	echo "Object type master requested, but not available in CSV format.\n\n";
}

// DBSTRUCT
if ($_REQUEST['dbStruct']) {
	echo "Database structure requested, but not available in CSV format.\n\n";
}




// EXPORT A SINGLE EXCAVATION
function csvExportExcav($excav) {

	global $fh;

	// export excavation even if not requested

	fwrite($fh, "\n");
	fwrite($fh, OgerCsv::prepRowOut("****** EXCAVATION [BEGIN] ******"));

	fwrite($fh, "\n");
	fwrite($fh, OgerCsv::prepRowOut("*** EXCAVATION MASTER [BEGIN]"));

	$values = $excav['TRANSFERHEADER']['MASTERDATACOPY'];

	if (!$_REQUEST['excavation']) {
		$values = array_intersect_key($values, array_flip(array('id', 'name', 'excavMethodId', 'beginDate', 'endDate')));
	}

	fwrite($fh, OgerCsv::prepRowOut(array_keys($values)));
	fwrite($fh, OgerCsv::prepRowOut($values));

	fwrite($fh, OgerCsv::prepRowOut("*** EXCAVATION MASTER [END]"));

	// -----------------------------------------------

	fwrite($fh, "\n");
	fwrite($fh, OgerCsv::prepRowOut("*** EXCAVATION / ARCHFINDLIST [BEGIN]"));
	$headDone = false;

	foreach($excav['ARCHFINDLIST'] as $values) {

		if (!$headDone) {
			fwrite($fh, OgerCsv::prepRowOut(array_keys($values)));
			$headDone = true;
		}
		fwrite($fh, OgerCsv::prepRowOut($values));
	}  // eo arch find

	fwrite($fh, OgerCsv::prepRowOut("*** EXCAVATION / ARCHFINDLIST [END]"));

	// -----------------------------------------------

	fwrite($fh, "\n");
	fwrite($fh, OgerCsv::prepRowOut("*** EXCAVATION / STRATUMLIST [BEGIN]"));
	$headDone = false;

	// collect extended fieldnames - including substratum but UNORDERED (not normalized)
	$stratumFields = Stratum::getAllExtendedFieldNames(array('export' => true));
	$stratumFields = array_fill_keys($stratumFields, '');

	foreach($excav['STRATUMLIST'] as $values) {

		// normalize fields across categories
		$values = array_merge($stratumFields, $values);

		if (!$headDone) {
			fwrite($fh, OgerCsv::prepRowOut(array_keys($values)));
			$headDone = true;
		}
		fwrite($fh, OgerCsv::prepRowOut($values));
	}

	fwrite($fh, OgerCsv::prepFieldOut("*** EXCAVATION / STRATUMLIST [END]"));

	// -----------------------------------------------

	fwrite($fh, "\n");
	fwrite($fh, OgerCsv::prepRowOut("*** EXCAVATION / ARCHOBJECTLIST [BEGIN]"));
	$headDone = false;

	foreach($excav['ARCHOBJECTLIST'] as $values) {

		if (!$headDone) {
			fwrite($fh, OgerCsv::prepRowOut(array_keys($values)));
			$headDone = true;
		}
		fwrite($fh, OgerCsv::prepRowOut($values));
	}  // eo arch find

	fwrite($fh, "\n");
	fwrite($fh, OgerCsv::prepRowOut("*** EXCAVATION / ARCHOBJECTLIST [END]"));

	// -----------------------------------------------

	fwrite($fh, "\n");
	fwrite($fh, OgerCsv::prepRowOut("*** EXCAVATION / ARCHOBJECTGROUPLIST [BEGIN]"));
	$headDone = false;

	foreach($excav['ARCHOBJECTGROUPLIST'] as $values) {

		if (!$headDone) {
			fwrite($fh, OgerCsv::prepRowOut(array_keys($values)));
			$headDone = true;
		}
		fwrite($fh, OgerCsv::prepRowOut($values));
	}  // eo arch find

	fwrite($fh, "\n");
	fwrite($fh, OgerCsv::prepRowOut("*** EXCAVATION / ARCHOBJECTGROUPLIST [END]"));

	// -----------------------------------------------
	// space between excavations

	fwrite($fh, "\n");
	fwrite($fh, OgerCsv::prepFieldOut("****** EXCAVATION [END] ******"));
	fwrite($fh, "\n\n\n");

	//fclose($fh);

}  // eo detail export






?>
