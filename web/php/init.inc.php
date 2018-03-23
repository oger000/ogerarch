<?php
/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/




#####################################
# Set default error level for initial startup.
# Can be changed in config
####################################

error_reporting((E_ALL | E_STRICT));
error_reporting(error_reporting() ^ E_NOTICE);


#####################################
# prepare input (trim)
####################################

// we only use $_REQUEST for now
// so we dont touch  $_GET, $_POST and $_COOKIE
/*
 * DISABLED, because global modification calls for trouble
if (!$skipTrimRequest) {
	foreach ($_REQUEST as &$value) {
		$value = trim($value);
	}
}
*/


#####################################
# Normalize cwd to that of the index.php
# by traversing up the directory tree
####################################
// This is very clumsy but seams to work for now

while (true) {
	// stop on index file directory
	if (file_exists("index.php")) {
		break;
	}
	$oldCwd = getcwd();
	chdir("..");
	// Avoid endless loops when reaching the root directory
	// It is very likely wrong if we reach the root dir
	// but we do not exit. The logfile will do the rest.
	if (getcwd() == $oldCwd) {
		break;
	}
}



#####################################
# autoload function for classes
# Do this first of all, because we need own classes
# very early (e.g. error-handling)
####################################

function ogerAutoload($className) {
	// not very clever, but works

	// application classes
	$file = "php/classes/" . $className . ".class.php";
	if (file_exists($file)) {
		require_once($file);
		return;
	}

	// system=bootstrap classes
	$file = "php/system/classes/" . $className . ".class.php";
	if (file_exists($file)) {
		require_once($file);
		return;
	}

	// ogerlib classes
	$file = "lib/ogerlibphp12/" . $className . ".class.php";
	if (file_exists($file)) {
		require_once($file);
		return;
	}

	// external ogerlib dependencies (including namespaced libs)
	$file = "lib/ogerlibphp12/external/" . $className . ".php";
	$file = str_replace('\\', '/', $file);
	if (file_exists($file)) {
		require_once($file);
		return;
	}

	// for namespaced libs at top lib level
	$file = "lib/${className}.php";
	$file = str_replace('\\', '/', $file);
	if (file_exists($file)) {
		require_once($file);
		return;
	}
	//echo "OGERAUTOLOADER FAILED to load {$file}.";
}
spl_autoload_register("ogerAutoload");

####################################



#####################################
# Start session
####################################

// Turn off caching, mainly for development.
// In producitive usage may be this should be disabled to speed up loading?
// Must be called before session_start()
session_cache_limiter("nocache");

// Start/reload session AFTER autoload is in place
// to avoid __PHP_Incomplete_Class errors for classes stored in the session
if (!$skipSessionStart) {
	session_start();
}


#####################################
# Init appliation
####################################

// Init configuration values
// and apply user setting
Config::init();




#####################################
# catch some errors and do json output
####################################
// INFO: return false to continue with php interal error handler

function ogerErrorHandler($errorCode, $errorText, $errorFile, $errorLine) {

	//$errMsg = "$errorCode: $errorText [in $errorFile on Line $errorLine].\n";
	$errMsg = "Level=$errorCode: $errorText in $errorFile on line $errorLine.\n";

	// collect a per logon error log - exclude notices
	$errFlags = error_reporting();
	if ($errorCode & $errFlags) {
		$_SESSION['errorLog'] .= "*** " . date("c") . " LogonID=" . Logon::$_id . ":\n$errMsg\n\n";
	}

	// send json to client for fatal errors
	if (Config::$alertErrors) {
		if ($errorCode == E_ERROR ||
				$errorCode == E_PARSE ||
				$errorCode == E_CORE_ERROR ||
				$errorCode == E_COMPILE_ERROR ||
				$errorCode == E_USER_ERROR) {
			echo OgerExtjs::errorMsg($errMsg);
		}
	}

	// return false to continue with php interal error handler
	return false;
}  // eo oger error handler

// set own error handler
set_error_handler("ogerErrorHandler");



#####################################
# catch exception and do json output
####################################

function ogerExceptionHandler($ex) {

	// collect a per logon error log
	$_SESSION['errorLog'] .= "*** " . date("c") . " LogonID=" . Logon::$_id . ":\n" . $ex->getMessage() . "\n\n";

	// send json to client
	if (Config::$alertErrors) {
		echo OgerExtjs::errorMsg($ex->getMessage());
	}

	// restore original exeption handler and rethrow exception
	set_exception_handler(null);
	throw $ex;
}  // eo oger exception handler

// set own exception handler
set_exception_handler("ogerExceptionHandler");



#####################################
# Init logon, user, db etc
####################################


// If the request contains an user session id, then use this for
// all following session lookups.
// This is the central point to distinguish between different apps and
// even between different logons within the same app.
if ($_REQUEST['_LOGONID']) {
	Logon::$_id = $_REQUEST['_LOGONID'];
}



// If there is a session logon info fitting to the logon id of the request
// write logon info back to Logon class
if ($_SESSION[Logon::$_id]['logon']) {
	Logon::$logon = $_SESSION[Logon::$_id]['logon'];
}

// If there is valid logon (restored from session above)
// Init database connection and check logon
if (Logon::$logon) {
	// PDO objects (and other resources) cannot be serialized so we have to open again
	Dbw::openDbAliasId(Logon::$logon->dbDefAliasId);
}


// Check logon
Logon::checkLogon();



// close write mode of session to avoid blocking
session_write_close();


// increase mysql variables to overcome known limits in this app if db-connection is established
if (Dbw::$conn) {
	Dbw::$conn->exec("SET SESSION group_concat_max_len = 64000;");
}




?>
