<?php
/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/***
* Startup configuration base class.
*/
class Config {


	public static $isInit;


	// *** local config file name ***
	// Filename for the local maintained config file.
	// If you want another config file, please include your config file
	// into the local config file and do not change this value.
	// Filename has to be relative to the top web dir.
	public static $localConfigFile = "config/config.localonly.inc.php";

	// *** distribution config file name ***
	// Filename for included config file delivered with the distribution.
	// This is used as fallback if no local config is found and used
	// primary for "unattended" installations.
	// Make shure you deliver such a file with your distribution!
	// Filename has to be relative to the top web dir.
	public static $distConfigFile = "config/config.distribution.inc.php";


	// *** application title ***
	// This is used for the browser window title
	public static $appTitle = "Application Title";


	// *** inital user ***
	// If no user is present this user will be created and will
	// grant super permissions. So use this for the inial admin.
	public static $initialUser = array('logonName' => "admin",
																		 'realName' => "Admin",
																		 'password' => "admin");


	// *** dbDefs ***
	// Associative array defining values for PDO.
	// $dbDefs["xxx"] = array(dbDefs-stanza)
	// where "xxx" is the alias ID for the dbDef-stanza.
	// Following keys are used in the dbDefs-stanza:
	// - dsnDriver : Required. DSN driver name.
	// - dsnConnect : Required. Driver specific connection syntax.
	// - dbName : Required. Database name. Normally this is part of the dsnConnect string,
	//            but there is no fixed syntax, so we cannot rely on parsing dsnDriver.
	// - driverOpts : Associative array. Details see in description of used DSN driver.
	// - user : User for this database access (depends on database type)
	// - pass : Password for database access (depends on database type)
	// - extraOpts : Associative array. Driver specific extra options that are not handled by PDO::__construct().
	// - autoLogonUser : Username for automatic logon.
	public static $dbDefs = array();


	// *** alert errors ***
	// alert (fatal) errors and exceptions to client
	public static $alertErrors = false;

	public static $externalDataDir = '';

	// *** application flags ***
	// An versatile array to store application flags
	public static $appFlags = array();


	###########################################################################


	/**
	* Init configuation class and application-
	* This is an example stanza and can be overwritten in your
	* application specific Config class - If you know what you do!
	*/
	public static function init() {

		// call guard
		if (static::$isInit) {
			return;
		}


		// include local confiǵ
		if (file_exists(static::$localConfigFile)) {
			require_once(static::$localConfigFile);
		}
		else {  // fallback
			require_once(static::$distConfigFile);
		}

		static::$isInit = true;
	}  // eo init



}  // end of class

?>
