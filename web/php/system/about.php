<?php
/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/

$skipLogonCheck = true;
require_once(__DIR__ . "/../init.inc.php");




if ($_REQUEST['_action'] == "load") {

	$text =	Oger::_( <<< EOT
Author: Gerhard Öttl

mit Unterstützug von:
- David Russ und Marco Kultus
sowie
- Katharina Adametz
- Brigitte Muschal
- Christian Stöckl
- Ursula Zimmermann
EOT
);

	echo Extjs::encData(array('about' => $text));
	exit;
}  // eo load about text






echo Extjs::errorMsg("Invalid request action '{$_REQUEST['_action']}' in " . __FILE__);
exit;



?>
