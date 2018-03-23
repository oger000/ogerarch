<?php
/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/*
 * http://stackoverflow.com/questions/14557862/run-jquery-function-onclick
 * http://api.jquery.com/jquery.post/
 * http://hayageek.com/jquery-ajax-form-submit/
 */


/**
 * This class collects helper functions for the picture organize script.
*/
class PictureOrganize {

	public static $excavRec;
	public static $config = array();
	public static $configFileName;

	public static $baseDir;
	public static $cameraDir;
	public static $targetDir;

	public static $targetStratumDirMask = "";
	public static $targetStratumDirParams = array();
	public static $targetFileMask = "";
	public static $targetFileParams = array();
	public static $parentDirDefaults = array();
	public static $subDirDefaults = array();


	/*
	 * fetch config file name from excav table of db
	 */
	public static function fetchConfigFileName($excavId) {

		$me = __CLASS__;
		static::$excavRec = Dbw::fetchRow1(
			"SELECT * FROM excavation WHERE id=:excavId", array("excavId" => $excavId));
		if (!static::$excavRec) {
			throw new Exception(sprintf("Grabung mit ID '%s' nicht gefunden.", $excavId));
		}

		$configFileName = trim(static::$excavRec['projectBaseDir']);
		if (!$configFileName) {
			throw new Exception("Keine Konfigurationsdatei in den Grabungs-Stammdaten hinterlegt.");
		}
		static::$configFileName = $configFileName;

	}  // eo fetch config file name


	/*
	 * init class
	 */
	public static function init($excavId = null) {
		if ($excavId) {
			static::fetchConfigFileName($excavId);
		}
		static::readConfig();
	}  // eo init


	/*
	 * create default config
	 */
	public static function createDefaultConfig() {


		static::$config = array();

		static::$config['internal'] = array(
			"configFormatVersion" => 1,
		);

		static::$config['memo'] = array("" => "Platz für persönliche Anmerkungen.");

		static::$config['info'] = array("" => <<< EOT
*
* BITTE DIESE DATEI MIT HÖCHSTER VORSICHT BEARBEITEN !!!
*
* Und die Sektion [files] mit DOPPELTER Vorsicht anfassen.
*
------------

Alle Ordnernamen sind entweder relativ zum baseDir - Eintrag oder
als absolute Ordnernamen anzugeben.
Als Pfad-Trenner bitte immer '/' verwenden (/pfad/zu/meinem/ordner).

Erklärungen zu den Konfigurations-Parametern:

- baseDir: Das Basisordner für relative Ordnerangaben. Falls nichts angegeben wird,
    dann wird jener Ordner genommen, in dem die Konfigurationsdatei steht.

- cameraDir: Der Ordner (und Unterordner) mit den Fotos von der Kamera.

- targetDir: Basis-Zielordner für die Fotodateien (oberste Ebene).
    Innerhalb dieses Ordners werden die Stratum-Ordner erstellt.

- targetStratumDirMask: Maske für den Namen des Stratum-Zielordner. (1) und %Variablen für %Platzhalter.
    Gültige %Variablen sind: officialId, stratumId
    Jede %Variable darf nur einmal in der Maske verwendet werden. Siehe targetFileMask.
    Beispiel: SE %s ; stratumId

- targetFileMask: Maske für den Ziel-Namen der Fotodatei. (1) und %Variablen für %Platzhalter.
    Gültige %Variablen sind: officialId, stratumId, fileName, fileBaseName, fileNameExt, subSerial, collisionSerial
    Jede %Variable darf nur einmal in der Maske verwendet werden.
    Beispiel1: M%s_SE%s_%s%s.%s ; officialId, stratumId, fileBaseName, collisionSerial:-, fileNameExt
    Beispiel2: M%s_SE %s (%s).%s ; officialId, stratumId, subSerial, fileNameExt

- parentDirDefaults: Liste mit Vorschlägen für den Oberordner (oberhalb des Stratumordners).
    Beispiel: Arbeitsfotos, Fotogrammetrie, Presse

- subDirDefaults: Liste mit Vorschlägen für den Unterordner (unterhalb des Stratumordners).
    Beispiel: Funde


Erklärungen zu den %Variablen:
- officialId = Massnahmennummer
- stratumId = Stratum-Nummer
- fileName = Name der Datei im Kamera-Ordner
- fileBaseName = Basisname der Datei im Kamera-Ordner (Ohne Datei-Erweiterung)
- fileNameExt = Erweiterung der Datei im Kamera-Ordner (Der Teil nach dem letzten Punkt)
- subSerial = Eine laufende Nummer innerhalb eines einzelnen Stratum-Ziel-Ordner.
    Eindeutige Dateinamen sind garantiert. Eine zuverlässige fortlaufende Nummerierung
    ist aber nicht gewährleistet.
- collisonSerial = Eine laufende Nummer, falls es zu Namenskollisionen kommt.
    Getrennt mit Doppelpunkt können Präfix und Postfix angegeben werden.

(1) Anmerkung 1:
Gültig sind alle Formatanweisungen für die sprintf Anweisung in PHP.
Siehe <http://php.net/manual/de/function.sprintf.php>

Bitte beachten, dass es einige Zeichen gibt, die in Dateinamen möglicherweise Probleme machen:
Strichpunkt, Beistrich, Schrägstrich, Backslash, Einfache und Doppele Anführungszeichen, Doppelpunkt,
Stern, Fragezeichen, usw.


EOT
);

		static::$config['config'] = array(
			"baseDir" => "",
			"cameraDir" => "",
			"targetDir" => "",
			"targetStratumDirMask" => "",
			"targetFileMask" => "",
			"parentDirDefaults" => "",
			"subDirDefaults" => "",
		);


		static::$config['cameraFiles'] = array();

		static::$config['targetFiles'] = array();

	}  // eo default config


	/*
	 * read config
	 */
	public static function readConfig() {
		$me = __CLASS__;

		static::createDefaultConfig();

		$content = file_get_contents(static::$configFileName);
		if ($content === false) {
			throw new Exception(Oger::_("Fehler beim Lesen der Konfigurationsdatei ({$me::$configFileName})."));
		}

		$sects = preg_split("/^\[/ms", $content);

		foreach ($sects as $sect) {
			$sect = trim($sect);
			if (!$sect) {
				continue;
			}

			list($sectKey, $sectVal) = preg_split("/\]\$/ms", $sect, 2);
			$sectKey = trim($sectKey);
			$sectVal = trim($sectVal);

			switch ($sectKey) {

			case "internal":
				$tmp = static::readConfigParams($sectVal);
				$tmp = array_merge(static::$config['internal'], $tmp);
				static::$config[$sectKey] = array_intersect_key($tmp, static::$config['internal']);
				break;

			case "memo":
				if ($sectVal) {
					static::$config[$sectKey][''] = $sectVal;
				}
				break;

			case "info":
				// we dont import existing info, but always write own version
				break;

			case "config":
				$tmp = static::readConfigParams($sectVal);
				$tmp = array_merge(static::$config['config'], $tmp);
				static::$config[$sectKey] = array_intersect_key($tmp, static::$config['config']);
				break;

			case "cameraFiles":
				$lines = explode("\n", $sectVal);
				foreach ($lines as $line) {

					$line = trim($line);
					if (!$line) {
						continue;
					}

					list($cameraFileName, $hash, $stratumIdList) = explode(";", $line);
					$cameraFileName = trim($cameraFileName);
					$hash = trim($hash);
					$stratumIdList = trim($stratumIdList);

					if (!$cameraFileName) {
						continue;
					}

					$stratumIds = array();
					$tmp = explode(",", $stratumIdList);
					foreach ($tmp as $val) {
						$stratumIds[] = trim($val);
					}
					$stratumIds = array_filter($stratumIds);

					static::$config[$sectKey][$cameraFileName] = array(
						"stratumIds" => $stratumIds,
						"cameraFileName" => $cameraFileName,
						"hash" => $hash,
					);
				}
				break;

			case "targetFiles":
				$lines = explode("\n", $sectVal);
				foreach ($lines as $line) {

					$line = trim($line);
					if (!$line) {
						continue;
					}

					list($targetFileName, $hash) = explode(";", $line);
					$targetFileName = trim($targetFileName);
					$hash = trim($hash);

					if (!$targetFileName) {
						continue;
					}

					static::$config[$sectKey][$targetFileName] = array(
						"targetFileName" => $targetFileName,
						"hash" => $hash,
					);
				}
				break;

			default:
				//throw new Exception(Oger::_("Unbekannte Sektion [{$sectKey}] in der Konfigurationsdatei gefunden."));
			}

		}  // eo section loop

	}  // eo read config


	/*
	 * analyze config
	 * - check paths params
	 * - prepare dir and file mask
	 */
	public static function analyzeConfig() {
		$me = __CLASS__;

		static::$baseDir = static::$config['config']['baseDir'];
		if (!static::$baseDir) {
			static::$baseDir = dirname(static::$configFileName);
		}
		static::$baseDir = static::realPath(static::$baseDir, "Basisordner");

		static::$cameraDir = static::$config['config']['cameraDir'];
		if (!static::isAbsolutePath(static::$cameraDir)) {
			static::$cameraDir = "{$me::$baseDir}/{$me::$cameraDir}";
		}
		static::$cameraDir = static::realPath(static::$cameraDir, "Kameraordner");

		static::$targetDir = static::$config['config']['targetDir'];
		if (!static::isAbsolutePath(static::$targetDir)) {
			static::$targetDir = "{$me::$baseDir}/{$me::$targetDir}";
		}
		static::$targetDir = static::realPath(static::$targetDir, "Stratum-Zielordner");

		if (substr(static::$targetDir, 0, strlen(static::$cameraDir)) == static::$cameraDir) {
			throw new Exception(Oger::_("Das Stratum-Zielordner darf nicht im Kameraordner liegen."));
		}

		// parse dir mask
		list(static::$targetStratumDirMask, static::$targetStratumDirParams) =
			static::parseFileMask(static::$config['config']['targetStratumDirMask'],
			"targetStratumDirMask", array("officialId", "stratumId"));

		// parse file mask
		list(static::$targetFileMask, static::$targetFileParams) =
			static::parseFileMask(static::$config['config']['targetFileMask'],
			"targetFileMask", array("officialId", "stratumId", "fileName", "fileBaseName", "fileNameExt",
				"subSerial", "collisionSerial"));

		// prepare parent dir defaults
		static::$parentDirDefaults = explode(",", static::$config['config']['parentDirDefaults']);
		array_walk(static::$parentDirDefaults, function(&$arr, $idx) {
			$arr[$idx] = trim($arr[$idx]);
		});
		static::$parentDirDefaults = array_filter(static::$parentDirDefaults);

		// prepare sub dir defaults
		static::$subDirDefaults = explode(",", static::$config['config']['subDirDefaults']);
		array_walk(static::$subDirDefaults, function(&$arr, $idx) {
			$arr[$idx] = trim($arr[$idx]);
		});
		static::$subDirDefaults = array_filter(static::$subDirDefaults);

	}  // eo check config



	/*
	 * parse dir and file mask
	 */
	public static function parseFileMask($rawMask, $title, $validVarNames) {

		// check dir mask
		list($mask, $varNameList) = explode(";", $rawMask);
		$mask = trim($mask);
		if (!$mask) {
			throw new Exception(Oger::_("Der {$title} Parameter fehlt in der Konfigurationsdatei."));
		}

		$varNames = array();
		$varNamesIn = explode(",", $varNameList);
		foreach ($varNamesIn as $varName) {
			list($varName, $extra) = explode(":", $varName, 2);
			$varName = trim($varName);
			$extra = trim($extra);
			if (!$varName) {
				continue;
			}
			if (!in_array($varName, $validVarNames)) {
				throw new Exception(Oger::_("Ungültige %Variable ({$varName}) in targetStratumDirMask."));
			}
			$varNames[$varName] = array("varName" => $varName, "extra" => $extra);
		}

		$tmp = str_replace("%%", "%", $mask);
		$tplCount = substr_count($tmp, "%");
		$varCount = count($varNames);
		if ($tplCount <> $varCount) {
			throw new Exception(Oger::_("{$title} hat {$tplCount} %Platzhalter, aber {$varCount} %Variable."));
		}

		return array($mask, $varNames);
	}  // eo parse mask


	/*
	 * read config params
	 */
	private static function readConfigParams($text) {

		$parms = array();

		$lines = preg_split("/[\n\r]/ms", $text);
		foreach ($lines as $line) {
			$line = trim($line);
			if (!$line) {
				continue;
			}

			list($pKey, $pVal) = explode("=", $line, 2);
			$pKey = trim($pKey);
			$pVal = trim($pVal);
			if (!($pKey && $pVal)) {
				continue;
			}
			$parms[$pKey] = $pVal;
		}

		return $parms;
	}  // eo get config params


	/*
	 * write config
	 */
	public static function writeConfig() {

		$txt = "";
		foreach (static::$config as $sectKey => $sectVal) {

			$txt .= "\n[{$sectKey}]\n";

			switch ($sectKey) {

			case "internal":
			case "config":
				foreach ((array)$sectVal as $pKey => $pVal) {
					switch ($pKey) {
					case "configFormatVersion":
						$pVal = intval($pVal);
						break;
					default:
						// nothing to do
					}
					$txt .= "  {$pKey} = {$pVal}\n";
				}
				break;

			case "memo":
			case "info":
				$txt .= "{$sectVal['']}\n";
				break;

			case "cameraFiles":
				foreach ((array)$sectVal as $pKey => $pVal) {

					if (!trim($pVal['cameraFileName'])) {
						continue;
					}

					$stratumIdList = implode(", ", $pVal['stratumIds']);
					$txt .= "{$pVal['cameraFileName']} ; {$pVal['hash']} ; {$stratumIdList} \n";
				}
				break;

			case "targetFiles":
				foreach ((array)$sectVal as $pKey => $pVal) {

					if (!trim($pVal['targetFileName'])) {
						continue;
					}

					$txt .= "{$pVal['targetFileName']} ; {$pVal['hash']} \n";
				}
				break;

			default:
				//throw new Exception(Oger::_("Unbekannte Sektion [{$sectKey}] im Konfigurationsarray gefunden."));
			}

			$txt .= "\n";

		}  // eo section loop

		static::writeX(static::$configFileName, $txt);

	}  // eo write config


	/*
	 * write with extended handling
	 * - report errors and abort
	 * - chmod 0777
	 */
	public static function writeX($fileName, $content) {

		$result = file_put_contents($fileName, $content);
		if ($result === false) {
			throw new Exception(Oger::_("Fehler beim Schreiben der Datei ({$fileName})."));
		}

		chmod($fileName, 0777);
	}  // eo write ex


	/*
	 * get real dir path with extrachecks
	 */
	public static function realPath($pathName, $info = "") {

		$info = ($info ?: Oger::_("Ordner oder Datei"));
		$pathName = static::normalizePath($pathName);

		if (!file_exists($pathName)) {
			throw new Exception(Oger::_("{$info} existiert nicht ({$pathName})."));
		}

		$realPath = realpath($pathName);
		if ($realPath === false) {
			throw new Exception(Oger::_("Kein RealPath für {$info} ({$pathName})."));
		}

		return $realPath;
	}  // eo real dir path


	/*
	 * check if this is an absolute path
	 */
	public static function isAbsolutePath($pathName) {

		$pathName = static::normalizePath($pathName);

		if (substr($pathName, 0, 1) == "/" ||
				substr($pathName, 1, 1) == ":") {
			return true;
		}

		return false;
	}  // eo is absolute path



	/*
	 * normalize path delimiter
	 */
	public static function normalizePath($pathName) {
		return str_replace("\\", "/", $pathName);
	}  // eo normalize path



	/*
	 * get filenames and sub dirs for dir name
	 */
	public static function getDirTreeFileList($dirName) {

		$pathNames = array();

		$dirName = static::realPath($dirName);
		if (!$dirName) {
			return $pathNames;
		}

		$tmpPathNames = glob("{$dirName}/*");
		foreach($tmpPathNames as $pathName) {

			$pathName = static::realPath($pathName);
			if (is_dir($pathName)) {
				$subDirs[] = $pathName;
			}
			else {
				$pathNames[] = $pathName;
			}
		}

		foreach ((array)$subDirs as $subDirName) {
			$pathNames = array_merge($pathNames, static::getDirTreeFileList($subDirName));
		}

		return $pathNames;
	}  // eo file list recursive


	// ###########################################################



	/*
	 * create target file name
	 */
	public static function createTargetFileName($vals = array()) {
		$me = __CLASS__;


		$targets = array();
		foreach ($vals['stratumIds'] as $stratumId) {

			$dirName = "";

			$paramVal = "";
			$paramVals = array();
			foreach (static::$targetStratumDirParams as $paramInfo) {
				$param = $paramInfo['varName'];
				switch ($param) {
				case "officialId":
					$paramVal = static::$excavRec['officialId'];
					break;
				case "stratumId":
					$paramVal = $stratumId;
					break;
				default:
					throw new Exception("Kann %Variable '{$param}' in targetStratumDirMask nicht verarbeiten.");
				}
				$paramVals[$param] = $paramVal;
			}
			$dirName .= vsprintf(static::$targetStratumDirMask, $paramVals);

			// try to detect reusable file in target dir via hash
			// before creating a new name
			$hashFound = false;
			foreach (static::$config['targetFiles'] as $fileInfo) {

				$filePath = $fileInfo['targetFileName'];
				$tmpDir = dirname($filePath);
				$fileName = basename($filePath);

				$hash = $fileInfo['hash'];
				if ($tmpDir == $dirName && $hash == $vals['hash']) {

					$fullPath = "{$me::$targetDir}/{$filePath}";

					if (!file_exists($fullPath)) {
						unset(static::$config['targetFiles'][$filePath]);
						static::writeConfig();
						continue;
					}

					// rehash from disk file content
					$hash = sha1_file($fullPath);
					if ($hash != $fileInfo['hash']) {
						static::$config['targetFiles'][$filePath]['hash'] = $hash;
						static::writeConfig();
					}

					if ($hash == $vals['hash']) {
						$targets[] = array("fileName" => "{$dirName}/{$fileName}", "reused" => true);
						$hashFound = true;
						break;
					}
				}
			}
			if ($hashFound) {
				continue;
			}

			// create file name
			$paramVal = "";
			$paramVals = array();
			foreach (static::$targetFileParams as $paramInfo) {
				$param = $paramInfo['varName'];
				switch ($param) {
				case "officialId":
					$paramVal = static::$excavRec['officialId'];
					break;
				case "stratumId":
					$paramVal = $stratumId;
					break;
				case "fileName":
					$paramVal = basename($vals['cameraFileName']);
					break;
				case "fileBaseName":
					$parts = explode(".", basename($vals['cameraFileName']));
					if (count($parts) > 1) {
						array_pop($parts);
					}
					$paramVal = implode(".", $parts);
					break;
				case "fileNameExt":
					$parts = explode(".", basename($vals['cameraFileName']));
					$paramVal = "";
					if (count($parts) > 1) {
						$paramVal = array_pop($parts);
					}
					break;
				case "subSerial":
					break;
				case "collisionSerial":
					list($collisionSerialPrefix, $collisionSerialPostfix) = explode(":", $paramInfo['extra']);
					$collisionSerialPrefix = trim($collisionSerialPrefix);
					$collisionSerialPostfix = trim($collisionSerialPostfix);
					break;
				default:
					throw new Exception("Kann %Variable '{$param}' in targetFileMask nicht verarbeiten.");
				}
				$paramVals[$param] = $paramVal;
			}
			$fileName = vsprintf(static::$targetFileMask, $paramVals);

			// handle subSerial after collecting all variables
			if (array_key_exists("subSerial", $paramVals)) {
				$serial = count(glob("{$me::$targetDir}/{$dirName}/*"));
				do {
					$serial++;
					$paramVals['subSerial'] = $serial;
					$fileName = vsprintf(static::$targetFileMask, $paramVals);
					$fullFilePath = "{$me::$targetDir}/{$dirName}/{$fileName}";
				} while (file_exists($fullFilePath));
			}

			// handle collisionSerial
			// visible serial starts with 2
			if (array_key_exists("collisionSerial", $paramVals)) {
				$serial = 0;
				do {
					$serial++;
					$paramVals['collisionSerial'] = ($serial <= 1 ? "" : "{$collisionSerialPrefix}{$serial}{$collisionSerialPostfix}");
					$fileName = vsprintf(static::$targetFileMask, $paramVals);
					$fullFilePath = "{$me::$targetDir}/{$dirName}/{$fileName}";
				} while (file_exists($fullFilePath));
			}

			$targets[] = array("fileName" => "{$dirName}/{$fileName}", "reused" => false);

		}  // eo stratum list loop

		return $targets;
	}  // eo create target file name

















}  // eo class

?>
