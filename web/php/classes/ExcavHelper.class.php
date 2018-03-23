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
 * Excavation helper class.
 */
class ExcavHelper {


	// id list delimiter
	public static $xidDelimiter = ",";
	public static $xidDelimiterOut = ", ";
	public static $xidSubIdDelimiter = "/";


	//public static $xidPattern = '/^[a-zA-Z0-9_\/\-]+$/';
	//public static $xidPattern = '/^[a-zA-Z0-9_]+$/';
	//public static $xidPattern = "/^[1-9_]+[0-9a-zA-Z_]*\$/";
	public static $xidPattern = "/^[1-9a-zA-Z_][0-9a-zA-Z_\-]*\$/";




	/**
	* Validator for identifier (arch find id, stratum id, ...) input
	*/
	public static function xidValidErr($value) {

		/*
		if (preg_match("/\s+/", $value)) {
			return Oger::_("'{$value}'. Leerzeichen/Whitespace nicht erlaubt.");
		}
		*/

		// avoid leading zeros for all numbers (even inside strings)
		if (preg_match("/(^|[^\d])0\d/", $value)) {
			return Oger::_("'{$value}'. Führende Null bei Zahlen nicht erlaubt.");
		}
		// avoid starting zeros for ids
		if (preg_match("/^\s*0/", $value)) {
			return Oger::_("'{$value}'. ID darf nicht mit Null beginnen.");
		}

		$isMatch = preg_match(static::$xidPattern, trim($value));
		if (!$isMatch) {
			return Oger::_("'{$value}'. Nur Ziffern, Buchstaben A-Z oder '_-’ erlaubt.");
		}

		return null;
	}  // eo identifier validator



	/**
	 * Validator for multiple identifier (arch find id, stratum id, ...) input
	 * Multiple entries must be divided by ','.
	 */
	public static function multiXidValidErr($value, $opts = array()) {

		// default allowBlank to true if not specified
		if (!array_key_exists("allowBlank", $opts)) {
			$opts['allowBlank'] = true;
		}

		$parts = static::multiXidSplit($value);

		// check for empty
		if (!$parts) {
			if ($opts['allowBlank']) {
				return null;
			}
			return Oger::_("Dieses Feld darf nicht leer sein.");
		}

		// check every part if valid
		foreach ($parts as $id) {
			$errorMsg = static::xidValidErr($id);
			if ($errorMsg) {
				return $errorMsg;
			}
		}
		return null;
	}  // eo multi identifier validator


	/**
	* Split field with multiple excavation identifiers into parts
	* and preprocess (trim, unify, natsort).
	*/
	public static function multiXidSplit($value) {

		// remove all whitespace chars (inside and between ids)
		$value = str_replace(array(" ", "\n", "\r", "\t", "\f"), "", $value);

		// split, trim parts, remove empty parts and remove duplicates
		$tmpParts = explode(static::$xidDelimiter, $value);
		$parts = array();
		foreach ($tmpParts as $id) {
			$id = trim($id);
			if (!$id) {
				continue;
			}
			$parts[$id] = $id;
		}

		natsort($parts);

		return array_values($parts);
	}  // eo split excav identifier


	/**
	* Split combi id into main id and sub id
	* Multiple sub part delimiter are not supported for now.
	*/
	public static function xidSubIdSplit($value) {

		list($id, $subId) = explode(static::$xidSubIdDelimiter, $value, 2);

		return array(trim($id), trim($subId));
	}  // eo split combi id


	/**
	* Prepare multiple excavation identifiers field
	* (split, trim, unify, sort - most done by xid split)
	*/
	public static function multiXidPrepare($value, $opts = array()) {
		if (is_array($value)) {
			natsort($value);
		}
		else {
			$value = static::multiXidSplit($value);
		}

		// remove sub ids and remove duplicate ids
		if ($opts['hideSubId']) {
			$tmpArr = $value;
			$value = array();
			foreach ($tmpArr as $val) {
				list($id, $subId) = static::xidSubIdSplit($val);
				$value[$id] = $id;
			}
			$value = array_keys($value);
		}

		$value = implode(static::$xidDelimiterOut, $value);
		return $value;
	}  // eo prep multi ids


	/**
	* Prepare id with sub id combi
	*/
	public static function xidPrepareSubId($id, $subId) {
		return trim($id) . static::$xidSubIdDelimiter . trim($subId);
	}  // prep sub id





}  // end of class

?>
