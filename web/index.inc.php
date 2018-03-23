<?PHP
/*
#LICENSE BEGIN
#LICENSE END
*/


$extjsDir = "extjs5";
$extjsDirPack = "{$extjsDir}/packages";


$title = Config::$appTitle;


/*
 * create java script tag with time stamp param
 */
function createJsTag($fileName) {
	$fileTime = filemtime($fileName);
	echo "	<script type=\"text/javascript\" src=\"{$fileName}?_dc={$fileTime}\"></script>\n";
}  // eo create java script tag


echo <<< EOTEXT
<html>
 <head>
	<!-- turn off caching (see also session_cache_limiter in the init script) -->
	<meta http-equiv="expires" content="0">
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="pragma" content="no-cache">

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

	<title>{$title}</title>

	<!-- Ext relies on its default css so include it here. -->
	<!-- This must be done BEFORE javascript includes! -->
	<link rel="stylesheet" type="text/css" href="lib/{$extjsDirPack}/ext-theme-classic/build/resources/ext-theme-classic-all.css">

	<!-- Include here your own css files if you have someone. -->
	<style type="text/css">
		/*
		.oger-filter-field-dirty { background-color: yellow !important;
															 background-image:none !important;
															 color: red !important;}
		*/
		.oger-filter-field-dirty { border: 1px solid #00FF00 !important;
															 background-color: yellow !important;
															 /* color: red !important; */}
	</style>

EOTEXT;


//$extJs = "lib/{$extjsDir}/build/bootstrap.js";  // loads ext-all-dev.js - so no benefit
$extJs = "lib/{$extjsDir}/build/ext-all.js";
$extJsLocale = "lib/{$extjsDirPack}/ext-locale/build/ext-locale-de.js";

if(Config::$appFlags['appMode'] == 'development') {
	$extJs = "lib/{$extjsDir}/build/ext-all-debug.js";  // full debug version
	//$extJs = "lib/{$extjsDir}/build/ext.js";  // minimal
}
if(array_key_exists('extJs', Config::$appFlags)) {
	$extJs = Config::$appFlags['extJs'];
}

if(array_key_exists('extJsLocale', Config::$appFlags)) {
	$extJsLocale = Config::$appFlags['extJsLocale'];
}


$appTitle = Config::$appTitle;

echo "  <!-- Load basic Extjs, config dynamic loader and setup App globals. -->\n";
createJsTag($extJs);

echo <<< EOTEXT
	<script type="text/javascript">

		// set oger app globals
		OgerApp = {};
		OgerApp.appTitle = '{$appTitle}';
		OgerApp.logon = {$logonData};  // if logon is empty the logon dialog is prompted
		OgerApp.allowSslClientCertLogon = {$allowSslClientCertLogon};

		// config dynamic loader
		Ext.Loader.setConfig({
			enabled: true, // enable always to have a fallback
			disableCaching: false,
			paths: {
				'Ext' : 'lib/{$extjsDir}/src',
				'App' : 'js/app',
				'Extensible' : 'lib/extensible',
			},
		});
	</script>
EOTEXT;


if ($extJsLocale) {
	createJsTag($extJsLocale);
}


echo "  <!-- Include here your extended classes and overrides - if you have some. -->\n";
createJsTag("lib/{$extjsDir}/ux/ComboBoxMultiSelect.js");
createJsTag("lib/{$extjsDir}/ux/NumberFormatField.js");

createJsTag("lib/{$extjsDir}/ux/ComboBoxAllowEmpty-override.js");
createJsTag("lib/{$extjsDir}/ux/ComboBoxClearFilter-override.js");
createJsTag("lib/{$extjsDir}/ux/oger-workarounds.js");

echo "  <!-- Include here your library javascript file if you have it. -->\n";
createJsTag("lib/ogerlibjs12/ogerlib.js");
echo "  <!-- ogerlibjs/ for ext4 backward compatibility -->\n";
createJsTag("lib/ogerlibjs/ogerlib-extjs4.js");
createJsTag("lib/ogerlibjs12/ogerlib-extjs.js");

createJsTag("js/constants.js");
createJsTag("js/common.js");



// load js files (at least the main entry point)
$appJsMain = "js/app/app.js";
$appJsAll = "js/build/app-all.js";
if(Config::$appFlags['appMode'] == 'development') {

	// HACK: dont load app-files on minimal ext.js
	if (file_exists($appJsFilesFrom) && substr($extJs, -7) != "/ext.js") {
		$fileList = file($appJsFilesFrom);
		foreach ($fileList as $fileName) {
			$fileName = trim($fileName);
			// skip app main - is loaded always (see below)
			if ($fileName == $appJsMain) {
				continue;
			}
			// skip comments
			if (substr($fileName, 0, 2) == "//") {
				continue;
			}
			if ($fileName) {
				createJsTag($fileName);
			}
		}
	}

	// load app main always (is sufficient for dynamic loading) and always at last
	createJsTag($appJsMain);
}
else {
	createJsTag($appJsAll);
}


echo <<< EOTEXT
 </head>
 <body></body>
</html>
EOTEXT;
