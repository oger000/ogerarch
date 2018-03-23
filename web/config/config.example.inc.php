<?php

  /**
  / This file is included into the Config class.
  * Make shure, that the Config class can reach this file!
  * This file is included and executed, so you can use any php statement here.
  */


  static::$appTitle = "OgerArch - Archäologie Datenbank";


	// database connection
  $tmpNam = "ogerarch";
	static::$dbDefs["default"] =
		array("visible" => true, "displayName" => "Archäologie Datenbank (Example)",
          "dbName" => "{$tmpNam}", "dsnDriver" => "mysql",
          "dsnConnect" => "dbname={$tmpNam};host=localhost",
					"user" => "*****", "pass" => "*****",
          "autoLogonUser" => "admin",
					'sqlDumpCmd' => '\xampp\mysql\bin\mysqldump.exe',
					//"sqlDumpCmd" => "/usr/bin/mysqldump",
					"sqlDumpCmdOpts" => " -u ***** -p***** --complete-insert {$tmpNam}",
					);


  // php-error handling
  error_reporting((E_ALL | E_STRICT));
  error_reporting(error_reporting() ^ E_NOTICE);
  // avoid errors in ajax stream
  ini_set("display_errors", "0");


  // other settings
  date_default_timezone_set("Europe/Vienna");


	//static::$externalDataDir = '/srv/uploads/myApp/';


  // development settings
  //static::$appFlags["appMode"] = "development";

?>
