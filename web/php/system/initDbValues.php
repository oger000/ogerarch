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



	// check for initial tree root entries
	StockLocation12::createInitialRecords();



	echo Extjs::msg(Oger::_("Initiale Einträge in der Datenbank erstellt."));
	exit;


?>
