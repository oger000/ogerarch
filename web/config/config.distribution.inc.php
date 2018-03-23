<?php

	// This is the distribution file for unattended windows-Xampp installations
	// If you want other setting copy this file to config.localonly.inc.php
	// and maintain your settings there.

	/**
	/ This file is included into the Config class.
	* Make shure, that the Config class can reach this file!
	* This file is included and executed, so you can use any php statement here.
	*/

	static::$appTitle = 'OgerArch - Archäologie Datenbank (Dist)';


	// database connection
  $tmpNam = "ogerarch";
	static::$dbDefs["default"] =
		array("visible" => true, "displayName" => "Archäologie Datenbank (Dist)",
          "dbName" => "{$tmpNam}", "dsnDriver" => "mysql",
          "dsnConnect" => "dbname={$tmpNam};host=localhost",
					"user" => "root", "pass" => "",
          "autoLogonUser" => "admin",
					'sqlDumpCmd' => '\xampp\mysql\bin\mysqldump.exe',
					//"sqlDumpCmd" => "/usr/bin/mysqldump",
					"sqlDumpCmdOpts" => " -u root --complete-insert {$tmpNam}",
					);



	// php-error handling
	error_reporting((E_ALL | E_STRICT));
	error_reporting(error_reporting() ^ E_NOTICE);
	// avoid errors in ajax stream
	ini_set('display_errors', '0');


	// other settings
	date_default_timezone_set('Europe/Vienna');


	// development settings
	//static::$printDebug = true;
	static::$appFlags['appMode'] = 'development';   // use this setting while app-all.js is not regulary maintained

?>
