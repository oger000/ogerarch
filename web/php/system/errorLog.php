<?php
/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


require_once(__DIR__ . "/../init.inc.php");


// ATTENTION: the errorlog is per session and not per logon
// so maybe multiple apps are mixed

// only admin can do this
// TODO maybe everybody can see the own session without security problems???
if(!Logon::$logon->user->hasPerm("SUPER")) {
	echo Extjs::errorMsg(Oger::_("Sie benötigen Administrationsrechte für diesen Vorgang."));
	exit;
}



if ($_REQUEST['_action'] == "load") {
	echo Extjs::encData(array('errorLog' => $_SESSION['errorLog']));
	exit;
}



if ($_REQUEST['_action'] == "clear") {
	Oger::sessionRestart();
	$_SESSION['errorLog'] = null;
	exit;
}





echo Extjs::errorMsg("Invalid request action '{$_REQUEST['_action']}' in " . __FILE__);
exit;



?>
