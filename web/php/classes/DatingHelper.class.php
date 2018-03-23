<?php
/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/***
* Dating helper class
* Maybe this could go to ExcavHelper?
*/
class DatingHelper {

	/*
	* Prepare input from frontend
	*/
	public static function prepareInput(&$datingFrom, &$datingTo) {

		// empty (space) input become null on database
		if (trim($datingFrom) === '') {
			$datingFrom = null;
		}
		if (trim($datingTo) === '') {
			$datingTo = null;
		}

		// if from AND to are given bring in order (force numeric value when compare)
		if ($datingFrom !== null && $datingTo !== null) {
			if ($datingFrom * 1 > $datingTo * 1) {
				$tmp = $datingFrom;
				$datingFrom = $datingTo;
				$datingTo = $tmp;
			}
		}

	} // eo prepare input



}  // end of class

?>
