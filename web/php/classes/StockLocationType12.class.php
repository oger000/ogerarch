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
class StockLocationType12 extends DbRec {

	public static $tableName = "stockLocationType";


	/**
	* Get SELECT template.
	*/
	public static function getSqlTpl($target, &$opts = array()) {

		$listDelim = ExcavHelper::$xidDelimiterOut;


		$seleExtraCols =
			"";


		$extjsOrder =
			"=name; " .
			"";


		// ######


		if ($target == "DEFAULT") {
			return "SELECT * FROM stockLocationType ";
		}

		if ($target == "GRIDCOUNT") {
			return
				"SELECT COUNT(*) AS recordCount " .
				"FROM stockLocationType ";
		}


		if ($target == "GRID") {
			return
				"SELECT * " .
				"FROM stockLocationType " .
				"{ORDER BY $extjsOrder} " .
				"__EXTJS_LIMIT__";
		}

		if ($target == "FORM") {
			return
				"SELECT * " .
				"FROM stockLocationType " .
				"{WHERE id=:!id}";
		}

		if ($target == "SIZECOMBO") {
			return
				"SELECT *, CONCAT(name,' (',sizeClass,')') AS sizeAndName " .
				"FROM stockLocationType " .
				"ORDER BY sizeClass " .
				"";
		}


		throw new Exception("Invalid id $target for sql template.");
	}  // eo get select template




	/**
	* Store input
	*/
	public static function storeInput($values, $dbAction, $opts = array()) {

		// check for required fields
		if (!$values['name']) {
			throw new Exception(Oger::_("Name der Grabung fehlt."));
		}
		if ($values['sizeClass'] <= 0) {
			throw new Exception(Oger::_("Grössenklasse muss grösser als 0 sein."));
		}


		// construct new id for insert
		if ($dbAction == "INSERT") {
			$values['id'] = (string)(Dbw::fetchValue1("SELECT MAX(id) FROM stockLocationType") + 1);
		}

		// check for unchanged excavMethodId (if there was already an method on old record)
		if ($dbAction == "UPDATE") {
			if (!$values['id']) {
				throw new Exception(Oger::_("Interne ID des Behältertypes fehlt."));
			}
		}

		// on check-only return here
		if ($opts['checkOnly']) {
			return;
		}


		static::store($dbAction, $values, array('id' => $values['id']));
		return array("id" => $values['id']);
	}  // eo store input



}  // end of class



?>
