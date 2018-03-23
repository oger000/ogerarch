<?PHP
/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/



/*
* Dev class.
* Temporary class for quick and dirty development needs.
*/
class Dev {

	/*
	* This function marks debug text that can be removed later on.
	* To turn off debugging simply comment out the trigger_error call.
	*/
	static function debug($msg, $level = E_USER_NOTICE) {
		$_SESSION[Logon::$_id]['log'] .= self::toHtml("$msg\n");
		if (!Config::$printDebug) {
			return;
		}
		global $ogerDebugSkipTrace;
		$ogerDebugSkipTrace = true;
		trigger_error($msg, $level);
	}  // eo oger debug



	/*
	* Debug a variable.
	* @formatHtml: If true than use nl2br and &nbsp for output on screen.
	*/
	static function debugVar($var, $echo = false) {

		$var = var_export($var, true);
		self::debug($var);

		// if echo is requestet than format for screen
		if ($echo) {
			echo self::toHtml($var);
		}

	}  // eo debug a variable



	/*
	* Clear session log text.
	*/
	static function clearSessionLog() {
		$_SESSION[Logon::$_id]['log'] = "";
	}



	/*
	* Write debug messages to session.
	*/
	static function debugSess($msg) {
		$_SESSION[Logon::$_id]['log'] .= self::toHtml("$msg\n");
	}  // eo oger debug



	/*
	* Debug a variable to session.
	*/
	static function debugVarSess($var) {
		self::debugSess(var_export($var, true));
	}  // eo debug a variable to session



	/*
	* Convert for html output.
	*/
	static function toHtml($msg) {

		$msg = nl2br($msg);
		//$msg = preg_replace('/^ /m', '&nbsp;', $msg);
		$nlMode = true;
		for ($i = 0; $i < strlen($msg); $i++) {
			$char = substr($msg, $i, 1);
			if ($nlMode && $char == ' ') {
				$out .= '&nbsp;';
				continue;
			}
			if ($char == "\n") {
				$nlMode = true;
			}
			else {
				$nlMode = false;
			}
			$out .= $char;
		}

		return $out;
	}  // eo prepare html



}  // end of class

?>
