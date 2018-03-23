#!/usr/bin/php
<?PHP

error_reporting((E_ALL | E_STRICT));
error_reporting(error_reporting() ^ E_NOTICE);


include(__DIR__ . "../../lib/ogerlibphp/OgerFunc.class.php");

$file = $argv[1];

if (!$file) {
	echo "input file required.\n";
	exit;
}


if (!file_exists($file)) {
	echo "inputfile $file does not exist\n";
	exit;
}

$jsCode = file_get_contents($file);
echo OgerFunc::beautifyJson($jsCode);

?>
