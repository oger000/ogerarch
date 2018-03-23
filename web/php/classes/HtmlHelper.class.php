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
class HtmlHelper {



	/**
	 * Print html start
	 */
	public static function htmlStart($startBody = false) {

		header("Content-Type: text/html");
		echo <<< EOT
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
EOT;

		if ($startBody) {
			echo <<< EOT
</head>
<body>
EOT;

		}

	}  // eo html start



	/**
	 * Print html end
	 */
	public static function htmlEnd() {

		echo <<< EOT
</body>
<html>
EOT;

	}  // eo html end




}  // eo class

?>
