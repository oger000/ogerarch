<?PHP
/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
*/
class PrepFind12 extends DbRec {

	public static $tableName = "prepFindTMPNEW";

	const SUBID_DELIM = "/";

	const STATUS_UNPREP = 0;
	const STATUS_PLANED = 1;
	const STATUS_PARTIAL = 2;
	const STATUS_READY = 3;


	/**
	* Store input
	*/
	public static function storeInput($values, $dbAction, $opts = array()) {

		// check for required fields
		if (!$values['excavId']) {
			throw new Exception(Oger::_("Interner Fehler: Nummer der Grabung fehlt."));
		}
		if (!$values['archFindId']) {
			throw new Exception(Oger::_("Fundnummer fehlt."));
		}

		if (!$values['archFindSubId'] && $dbAction != "INSERT") {
			throw new Exception(Oger::_("Fund-Subnummer fehlt."));
		}

		// extrachecks for rename
		if ($dbAction == "rename") {
			if (!$_REQUEST['oldArchFindId']) {
				throw new Exception(Oger::_("Alte Fund-Nummer erforderlich."));
			}
			if (!$_REQUEST['oldArchFindSubId']) {
				throw new Exception(Oger::_("Alte Fund-Sub-Nummer erforderlich."));
			}

			// check for rename to already existing keys
			$oldCount = Dbw::fetchValue1(
				"SELECT COUNT(*) FROM prepFindTMPNEW " .
				" WHERE excavId=:excavId AND archFindId=:archFindId AND archFindSubId=:archFindSubId",
				array("excavId" => $_REQUEST['excavId'],
							"archFindId" => $_REQUEST['archFindId'], "archFindSubId" => $_REQUEST['archFindSubId']));
			if ($oldCount) {
				throw new Exception(Oger::_("Umbenennen fehlgeschlagen, weil neue Fundnummer/Subnummer bereits vorhanden."));
			}
		}  // eo rename checks


		// on check-only return here
		if ($opts['checkOnly']) {
			return;
		}

		// original arch find id defaults to prep find id - if not given
		if (!$values['oriArchFindId']) {
			$values['oriArchFindId'] = $values['archFindId'];
		}
		if (!$values['archFindSubId'] && $dbAction == "INSERT") {
			$values['archFindSubId'] =
				Dbw::fetchValue1(
					"SELECT MAX(CAST(archFindSubId AS SIGNED)) FROM prepFindTMPNEW" .
					" WHERE excavId=:excavId AND archFindId=:archFindId" .
					"   AND archFindSubId REGEXP '^[0-9]+$'",
					array("excavId" => $values['excavId'], "archFindId" => $values['archFindId']));
			$values['archFindSubId'] += 1;
		}
		$values['archFindIdSort'] = Oger::getNatSortId($values['archFindId']);
		$values['archFindSubIdSort'] = Oger::getNatSortId($values['archFindSubId']);


		$whereVals = array("excavId" => $values['excavId'],
											 "archFindId" => $values['archFindId'], "archFindSubId" => $values['archFindSubId']);


		if ($dbAction == "rename") {
			$dbAction = "UPDATE";
			$whereVals['archFindId'] = array("oldArchFindId" => $values['oldArchFindId']);
			$whereVals['archFindSubId'] = array("oldArchFindSubId" => $values['oldArchFindSubId']);
		}


		static::store($dbAction, $values, $whereVals);
	}  // eo store input




}  // end of class



?>
