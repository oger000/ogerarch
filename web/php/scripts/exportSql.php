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



/**
* Export sql dump
*/


// check database config and dump command

$dbDefAliasId = ($_REQUEST['__OGER_AUTOBACKUP_DBDEFALIASID__'] ?: Logon::$logon->dbDefAliasId);

$fileName = "ogerarch_" . date("Y-m-d_H-i-s") . ".sqldump";
$sqlDumpCmd = Config::$dbDefs[$dbDefAliasId]['sqlDumpCmd'];


// silently create dump to fixed directory
if ($_REQUEST['__OGER_AUTOBACKUP__']) {

	if (!$dbDefAliasId ||
			!$sqlDumpCmd  || !file_exists($sqlDumpCmd) || !is_executable($sqlDumpCmd)) {
		return;
	}  // eo prechecks

	$fileName .= "_" . $_REQUEST['__OGER_AUTOBACKUP__'];

	$dumpDir = "autobackup";
	if (!file_exists($dumpDir)) {
		mkdir($dumpDir, 777);
	}
	$fileName = "$dumpDir/$fileName";

	$cmd = "$sqlDumpCmd " . Config::$dbDefs[$dbDefAliasId]['sqlDumpCmdOpts'] . " > $fileName";
	exec($cmd);

	return;
}  // eo autobackup



if (!$dbDefAliasId) {
	echo "No database initialisized. May be logon timed out?";
	exit;
}

if (!$sqlDumpCmd) {
	echo "Sql dump command not set in config.";
	exit;
}  // eo sql dump

if (!file_exists($sqlDumpCmd)) {
	echo "Sql dump command - file not found.";
	exit;
}  // eo sql dump

if (!is_executable($sqlDumpCmd)) {
	echo "Sql dump command not executable.";
	exit;
}  // eo sql dump



//header('Content-type: text/plain; charset="utf-8"');
header("Content-type: text/plain");
header("Content-disposition: attachment; filename=\"{$fileName}\"");

// write ogerarch header into file
echo "--\n";
echo "-- OgerArch SQL-Dump from " . date('c') . "\n";
echo "--\n";
echo "\n";
echo "\n";

// do sql dump
passthru($sqlDumpCmd . " " . Config::$dbDefs[$dbDefAliasId]['sqlDumpCmdOpts']);

?>
