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
* Import .lst file from STRATIFY
*/
function importStratifyLst($excav, $content, $applyFlag) {

	global $log;

	$log .= "*** Import Stratify lst File\n";
	$log .= "*** Dateigrösse: " . strlen($content) . "\n";
	$log .= "*** Apply=$applyFlag\n";


	$excavId = $excav->values['id'];

	$tmp = ExcavHelper::multiXidSplit($_REQUEST['ignoreStratumIdList']);
	$ignoreStratumIdArray = array();
	foreach ($tmp as $part) {
		$ignoreStratumIdArray[$part] = $part;
	}

	$stratumArray = array();
	$complexTree = array();
	$item = array();

	$lineCount = 0;
	foreach (preg_split("/((\r?\n)|(\r\n?))/", $content) as $line) {

		$lineCount++;

		// the first 3 lines are head info, data start at line 4
		if ($lineCount < 4) {
			continue;
		}

		// ignore empty lines
		if (!trim($line)) {
			continue;
		}

		// each stratum-stanza starts on first column - details follow at column 9
		if (substr($line, 0, 1) != ' ') {

			// apply collected stratum info
			if ($item) {
				if ($applyFlag) {
					// on interface prepare and apply length/width/height
					if ($item['categoryId'] == 'INTERFACE') {
						// length
						$value = $item['Visibility of boundaries'];
						$value = preg_replace('/[^0-9,-]/', '', $value);
						list($val1, $val2) = explode('-', $value, 2);  // split range input (from/to) separated by ' - '
						$value = max($val1, $val2);
						list ($val1, $val2) = explode(',', $value, 2);  // split integer and fractal separated by decimal ','
						$value = $val1 * 100 + $val2;
						$item['lengthValue'] = $value;
						// width
						$value = $item['Excavation method'];
						$value = preg_replace('/[^0-9,-]/', '', $value);
						list($val1, $val2) = explode('-', $value, 2);  // split range input (from/to) separated by ' - '
						$value = max($val1, $val2);
						list ($val1, $val2) = explode(',', $value, 2);  // split integer and fractal separated by decimal ','
						$value = $val1 * 100 + $val2;
						$item['width'] = $value;
						// height
						$value = $item['Conditions'];
						$value = preg_replace('/[^0-9,-]/', '', $value);
						list($val1, $val2) = explode('-', $value, 2);  // split range input (from/to) separated by ' - '
						$value = max($val1, $val2);
						list ($val1, $val2) = explode(',', $value, 2);  // split integer and fractal separated by decimal ','
						$value = $val1 * 100 + $val2;
						$item['height'] = $value;
					}
					$record = new Stratum($item);
					$record->values['id'] = Stratum::getMaxValue('id') + 1;
					$record->createStratumSub($item);
					$record->toDb(Db::ACTION_INSERT);
					// prepare and save arch find id list
					$archFindIdArray = ExcavHelper::multiXidSplit($item['archFindIdList']);
					StratumToArchFind::updDbArchFindIdArray($record->values['excavId'], $record->values['stratumId'], $archFindIdArray, Db::ACTION_INSERT);
					$log .= "Stratum " . $item['stratumId'] . " erfolgreich angelegt.\n";
				}
				else {
					$stratumArray[$item['stratumId']] = $item['stratumId'];
					// iterface check
					if (is_numeric(substr($item['Visibility of boundaries'], 0, 1)) &&
							(is_numeric(substr($item['Excavation method'], 0, 1)) || $item['Excavation method'] == '-') &&
							is_numeric(substr($item['Conditions'], 0, 1))) {
						if ($item['categoryId'] != 'INTERFACE') {
							$log .= "??? Identifier " . $item['stratumId'] . " von typ " . $item['typeId'] . " ist eventuell ein interface.\n";
						}
					}
					else {
						if ($item['categoryId'] == 'INTERFACE') {
							$log .= "??? Identifier " . $item['stratumId'] . " von typ " . $item['typeId'] .  " ist eventuell KEIN interface. (Abmessungen unvollständig)\n";
						}
					}
				}
			}

			// prepare line / remove leading zeros
			$line = trim($line);
			$line = ltrim($line, '0');

			// skip stratums from ignore list
			if ($ignoreStratumIdArray[$line]) {
				$item = array();
				continue;
			}

			// ignore invalid identifier as invalid lines
			if (!ExcavHelper::xidValidErr($line)) {
				$log .= "Zeile $lineCount: Ungültiger Identifier: $line\n";
				// abort on error
				if ($applyFlag) {
					return;
				}
			}

			// start new stratum
			$item = array('excavId' => $excavId, 'stratumId' => $line);
			continue;

		}  // eo stratum begin


		// if no identifier is in item, than skip data lines till the next identifier raises
		if (!$item) {
			continue;
		}

		// collect values
		$line = trim($line);
		list($key, $value) = explode(':', $line);
		$key = trim($key);
		$value = trim($value);


		switch ($key) {

		case 'above':
			$parts = ExcavHelper::multiXidSplit($value);
			$value = '';
			foreach ($parts as $part) {
				$part = ltrim($part, '0');
				if ($ignoreStratumIdArray[$part]) {
					continue;
				}
				$value .= ($value ? ',' : '') . $part;
			}
			if (!ExcavHelper::multiXidValidErr($value)) {
				$log .= "Zeile $lineCount: Ungültige 'above' Angabe: $line\n";
				if ($applyFlag) {
					return;
				}
			}
			$item['earlierThanIdList'] = $value;
			break;

		case 'equal to':
			$parts = ExcavHelper::multiXidSplit($value);
			$value = '';
			foreach ($parts as $part) {
				$part = ltrim($part, '0');
				if ($ignoreStratumIdArray[$part]) {
					continue;
				}
				$value .= ($value ? ',' : '') . $part;
			}
			if (!ExcavHelper::multiXidValidErr($value)) {
				$log .= "Zeile $lineCount: Ungültige 'equal to' Angabe: $line\n";
				if ($applyFlag) {
					return;
				}
			}
			$item['equalToIdList'] = $value;
			break;

		case 'part of':
			$parts = ExcavHelper::multiXidSplit($value);
			$value = '';
			foreach ($parts as $part) {
				$part = ltrim($part, '0');
				if ($ignoreStratumIdArray[$part]) {
					continue;
				}
				$value .= ($value ? ',' : '') . $part;
			}
			if (!ExcavHelper::multiXidValidErr($value)) {
				$log .= "Zeile $lineCount: Ungültige 'part of' Angabe: $line\n";
				if ($applyFlag) {
					return;
				}
			}
			$partOfList = ExcavHelper::multiXidSplit($value);
			foreach ($partOfList as $stratumId) {
				if ($ignoreStratumIdArray[$stratumId]) {
					continue;
				}
				if ($item['stratumId'] == $stratumId) {  // cannot be part of itself
					continue;
				}
				if (!$complexTree[$stratumId]) {
					$complexTree[$stratumId] = array();
				}
				$complexTree[$stratumId][$item['stratumId']] = $lineCount;
			}
			break;

		case 'Unit class':
			switch ($value) {
			case 'context':
				$value = 'DEPOSIT';
				break;
			case 'group':
				$value = 'COMPLEX';
				break;
			default:
				$log .= "Zeile $lineCount: Ungültige 'Unit class' Angabe: $line\n";
				if ($applyFlag) {
					return;
				}
			}
			// if set elsewhere than do not overwrite
			if (!$item['categoryId']) {
				$item['categoryId'] = $value;
			}
			break;

		case 'Unit type':
			$item['typeId'] = $value;
			// postcheck for interface types
			$value = substr($value, 0, 2);
			switch ($value) {
			case 'IF':
			case 'GN':
			case 'GR':
			case 'PL':
				$item['categoryId'] = 'INTERFACE';
			}
			break;

		case 'Colour':
			$item['color'] = $value;
			break;

		case 'Inclusions':
			$item['inclusion'] = $value;
			break;

		case 'Visibility of boundaries':
			$item['hardness'] = $value;
			$item[$key] = $value;  // preserve original key, because it is used for length value on interfaces
			break;

		case 'Formation process':
			$item['materialDenotation'] = $value;
			break;

		case 'Period':
		case 'Phase':
			$item['datingSpec'] .= ($item['datingSpec'] ? ', ' : '') . $value;
			break;

		case 'Excavation date':
			$item['date'] = $value;
			break;

		case 'Find Category':
			$item['archFindIdList'] = $value;
			break;

		case 'Interpretation':
			$item['interpretation'] = $value;
			break;

		case 'Description':
			$item['comment'] .= $value;
			break;

		// preserve original key for length/width/height. On interface "Visibility of boundaries" is the third dimension
		case 'Excavation method':
		case 'Conditions':
			$item[$key] = $value;
			break;

		// ignore some "known" key names
		case 'below':   // is calculated drom 'above'
		case 'Center year':
		case 'First year':
		case 'Last year':
			// ignore
			break;

		default:
			$log .= "Zeile $lineCount: Ungültiger Schlüssel: $line\n";
			if ($applyFlag) {
				return;
			}
		}

	}  // eo line loop


	// postprocess complex
	foreach ($complexTree as $stratumId => $complexParts) {
		foreach ($complexParts as $partId => $lineNumber) {
			if (($applyFlag && !Stratum::existsStatic(array('excavId' => $excavId, 'stratumId' => $stratumId))) ||
					(!$applyFlag && !$stratumArray[$stratumId])) {
				$log .= "Zeile $lineNumber: 'part of' bezieht sich auf nicht vorhandenen Identifier: $stratumId\n";
				if ($applyFlag) {
					return;
				}
			}
		}  // eo check loop

		if ($applyFlag) {
			$record = Stratum::newFromDb(array('excavId' => $excavId, 'stratumId' => $stratumId));
			$item = $record->values;
			$item['complexPartIdList'] = implode(ExcavHelper::$xidDelimiter, array_keys($complexParts));
			$record->createStratumSub($item);
			$record->toDb(Db::ACTION_UPDATE);
		}

	}  // eo complex


}  // eo stratify





?>
