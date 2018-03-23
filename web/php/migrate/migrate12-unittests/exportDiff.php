#!/usr/bin/php
<?PHP

error_reporting((E_ALL | E_STRICT));
error_reporting(error_reporting() ^ E_NOTICE);


$variant = "b";

$json0 = file_get_contents("export0{$variant}F.json.localonly");
$json12 = file_get_contents("export12{$variant}-rex.json.localonly");

$arr0 = json_decode($json0, true);
$arr12 = json_decode($json12, true);




// ############ arch find

$find0 = &$arr0['EXCAVATIONLIST'][0]['ARCHFINDLIST'];
$find12 = &$arr12['EXCAVATIONLIST'][0]['ARCHFINDLIST'];


$errCount = 0;
$recCount = 0;

foreach((array)$find0 as $rec0) {

	$recCount++;
	$id0 = $rec0['archFindId'];

	$rec12 = $find12[$id0];
	unset($rec0['id']);    // internal only
	unset($find12[$id0]);  // remove from list

	if (!$rec12) {
		echo "archFindId={$id0}: no rec12\n";
		continue;
	}

	unset($rec0['excavId']);     // excav ids differ from db to db
	unset($rec12['excavId']);    // excav ids differ from db to db
	unset($rec12['excavName']);          // only present in 12
	unset($rec0['interfaceTypeName']);   // unused
	unset($rec0['interfaceTypeCode']);   // unused

	foreach($rec0 as $key0 => $value0) {

		if ($rec12[$key0] === $value0) {
			unset($rec0[$key0]);
			unset($rec12[$key0]);
		}
		else {
			echo "archFindId={$id0}: {$key0}: 0=" . var_export($value0, true) . ", 12=" . var_export($rec12[$key0], true) . "\n";
		}
	}

	foreach((array)$rec0 as $k => $v) {
		echo "archFindId={$id0}:  0: $k=" . var_export($v, true) . "\n";
		$errCount++;
	}
	foreach((array)$rec12 as $k => $v) {
		echo "archFindId={$id0}: 12: $k=" . var_export($v, true) . "\n";
		$errCount++;
	}
}

foreach((array)$find12 as $rec12) {
	echo "archFindId={$rec12['archFindId']}: no rec0\n";
}



echo "\n##### arch find: {$recCount} records, {$errCount} errors\n";



// ############ stratum


$stratum0 = &$arr0['EXCAVATIONLIST'][0]['STRATUMLIST'];
$stratum12 = &$arr12['EXCAVATIONLIST'][0]['STRATUMLIST'];

$errCount = 0;
$recCount = 0;

foreach((array)$stratum0 as $rec0) {

	$recCount++;
	$id0 = $rec0['stratumId'];

	$rec12 = $stratum12[$id0];
	unset($rec0['id']);    // internal only
	unset($stratum12[$id0]);  // remove from list

	if (!$rec12) {
		echo "stratumId={$id0}: no rec12\n";
		continue;
	}

	unset($rec0['excavId']);     // excav ids differ from db to db
	unset($rec12['excavId']);    // excav ids differ from db to db

	unset($rec12['excavName']);   // ..12 only

	unset($rec0['typeCode']);     // unused
	unset($rec12['typeCode']);    // unused

	unset($rec0['reverseEqualToIdList']);       // unused
	unset($rec0['reverseContempWithIdList']);   // unused

	unset($rec0['complexPartIdList']);       // unused
	unset($rec0['partOfComplexIdList']);     // unused


	foreach($rec0 as $key0 => $value0) {

		if ($rec12[$key0] === $value0) {
			unset($rec0[$key0]);
			unset($rec12[$key0]);
		}
		else {
			if (is_numeric($value0) && is_string($rec12[$key0])) {
				// no type-maindata on import, so is-number results in string
				unset($rec0[$key0]);
				unset($rec12[$key0]);
			}
			else {
				echo "stratumId={$id0}: {$key0}: 0=" . var_export($value0, true) . ", 12=" . var_export($rec12[$key0], true) . "\n";
			}
		}
	}

	foreach((array)$rec0 as $k => $v) {
		echo "stratumId={$id0}:  0: $k=" . var_export($v, true) . "\n";
		$errCount++;
	}
	foreach((array)$rec12 as $k => $v) {
		echo "stratumId={$id0}: 12: $k=" . var_export($v, true) . "\n";
		$errCount++;
	}
}


foreach((array)$stratum12 as $rec12) {
	echo "stratumId={$rec12['stratumId']}: no rec0\n";
}


echo "\n##### stratum: {$recCount} records, {$errCount} errors\n";


?>
