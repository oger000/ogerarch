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



//$allowRemote = true;  // TODO remove after testing

$rootDir = "../..";

// do not allow on remote servers because of security reasons
// e.g. full local paths are exposed
// file deletion is performed and so on ...
// maybe bypass with extra passcode
if (!($_SERVER['HTTP_HOST'] == "localhost" || $allowRemote)) {
	HtmlHelper::htmlStart(true);
	echo "Diese Funktion steht nur für Dateien am eigenen Rechner zur Verfügung.";
	exit;
}  // eo localhost-check



if ($_REQUEST['_action'] == 'pictureOrganize') {

	$poc = "PictureOrganize";

	HtmlHelper::htmlStart();
	echo <<< EOT
  <!-- <script type="text/javascript" src="{$rootDir}/lib/jquery/jquery-2.2.1.min.js"></script> -->
	<link rel="stylesheet" href="{$rootDir}/lib/jquery-ui/jquery-ui.min.css">
	<script src="{$rootDir}/lib/jquery-ui/external/jquery/jquery.js"></script>
	<script src="{$rootDir}/lib/jquery-ui/jquery-ui.min.js"></script>


	<script type="text/javascript">

		$(document).ready( function() {

			// button click
			$(':button').click(function(e) {

				var button = $(this);
				var boxMasterId = button.attr('boxMasterId');

				var form = $('#form_' + boxMasterId);
				var vals = form.serializeArray();
				vals.push({ name: 'fileAction', value: button.attr('action')});

				var oVals = {};
				for (var i=0; i < vals.length; i++) {
					oVals[vals[i].name] = vals[i].value;
				}

				if (oVals.fileAction == 'delete' && oVals.confirmDelete != '1') {
					alert('Löschen wird nicht durchgeführt, weil "Wirklich löschen" nicht angekreuzt ist.');
					return;
				}

				if (oVals.fileAction == 'delete' && oVals.moreAction == '1') {
					alert('Löschen wird nicht durchgeführt, weil "Weitere Aktion" angekreuzt ist.');
					return;
				}
				if (oVals.fileAction == 'move' && oVals.moreAction == '1') {
					alert('Verschieben wird nicht durchgeführt, weil "Weitere Aktion" angekreuzt ist.');
					return;
				}

				$.ajax({
					url : form.attr('action'),
					type: form.attr('method'),
					data : vals,
					success:function(data, textStatus, jqXHR)
					{
						//var resp = $.parseJSON(data);
						var resp = data;
						if (resp.success == false) {
							alert('Ergebnis: ' + resp.msg);
							return;
						}

						if (oVals.fileAction == 'showTargetName') {
							$('#fileNamePreview_'  + boxMasterId).html(resp.msg);
							return;
						}

						if (oVals.moreAction) {
							return;
						}

						$('#div_' + boxMasterId).html(resp.msg);
					},
					error: function(jqXHR, statusText, errorThrown)
					{
						alert('ERR=' + statusText);
					},
				});
				//e.preventDefault(); //STOP default action
				//e.unbind(); //unbind. to stop multiple form submit.
			});  // eo button click

			// add slinder
			$('.slider').each(function() {
				$(this).slider({
					value: 75,
					//orientation: 'vertical',
					min: 0,
					max: 500,
					step: 5,
					boxMasterId: $(this).attr('boxMasterId'),
					slide: function( event, ui ) {
						var boxMasterId = $(this).context.attributes.boxmasterid.value;
						var img = $('#img_' + boxMasterId);
						var oldWidth = img.width();
						var newWidth = '' + ui.value + '%';
						img.width(newWidth);
					},
				});
			});  // eo slider

		});
	</script>
 </head>
<body>
EOT;



	echo "<h1>Fotodateien organisieren</h1>\n";

	try {

		if ($_REQUEST['configFileName'] && $_REQUEST['excavId']
		    && is_file($_REQUEST['configFileName'])) {
			Dbw::checkedExecute(
				"UPDATE excavation SET projectBaseDir=:configFileName WHERE id=:excavId",
				array("configFileName" => $_REQUEST['configFileName'], "excavId" => $_REQUEST['excavId']));
		}

		PictureOrganize::fetchConfigFileName($_REQUEST['excavId']);
		echo "<h1>Grabung {$poc::$excavRec['name']} / {$poc::$excavRec['officialId']}</h1>";
		echo "Konfigurationdatei: {$poc::$configFileName}<br>\n";

		// setup config file
		if (!file_exists(PictureOrganize::$configFileName)) {
			echo "Die Konfigurationsdatei existiert nicht. Eine Beispieldatei wird erstellt.<br>\n";
			PictureOrganize::createDefaultConfig();
			PictureOrganize::writeConfig();
			echo "<br><hr><br>Die Konfigurationsdatei wurde erstellt. Bitte bearbeiten und neu starten.<br><br><hr>\n";
			exit;
		}

		PictureOrganize::init();
		PictureOrganize::analyzeConfig();

		echo "Basisordner: {$poc::$baseDir}<br>\n";
		echo "Kameraordner: {$poc::$cameraDir}<br>\n";
		echo "Stratum-Zielordner: {$poc::$targetDir}<br>\n";
		echo "<br><hr>\n";
		flush();

		// read camera dir and show new camera files to process
		$cameraFileNames = $poc::getDirTreeFileList($poc::$cameraDir);
		echo "<br>";
		echo count($poc::$config['cameraFiles']) . " Kamera-Dateien sind in der Konfigurationdatei registriert.<br>\n";
		echo count($cameraFileNames) . " Dateien sind im Kameraordner vorhanden.<br>\n";

		$newFiles = array();
		foreach ($cameraFileNames as $cameraFileName) {

			$fullCameraFilePath = $cameraFileName;
			$cameraFileName = substr($cameraFileName, strlen($poc::$cameraDir) + 1);

			$cameraFileVals = $poc::$config['cameraFiles'][$cameraFileName];
			if (!$poc::$config['cameraFiles'][$cameraFileName]) {
				$newFiles[$cameraFileName]  = $fullCameraFilePath;
			}

		}  // eo read camera dir
		echo count($newFiles) . " Kamera-Dateien sind noch nicht registriert und zugeordnet.<br>\n";


		// predefine selection lists
		echo "<datalist id=\"parentDirDefaults\">\n";
		foreach (PictureOrganize::$parentDirDefaults as $tmp) {
			echo "<option value=\"{$tmp}\">\n";
		}
		echo "</datalist>";

		echo "<datalist id=\"subDirDefaults\">\n";
		foreach (PictureOrganize::$subDirDefaults as $tmp) {
			echo "<option value=\"{$tmp}\">\n";
		}
		echo "</datalist>";

		// show new/unassigned files
		$picCount = 0;
		foreach ($newFiles as $cameraFileName => $fullCameraFilePath) {
			$picCount++;
			if ($picCount == 1) {
				echo "<br><hr><br>Bitte die unten angezeigten Fotos behandeln.<br>\n";
				if ($_REQUEST['maxCameraFiles']) {
					echo "Es werden maximal {$_REQUEST['maxCameraFiles']} Fotos gleichzeitig angezeigt.<br><br>\n";
				}
			}

			$logonId = Logon::$_id;
			$picUrl = urlencode("{$poc::$cameraDir}/{$cameraFileName}");
			echo <<< EOT
			<hr><br>Foto {$picCount}: {$cameraFileName}<br>
			<div id="div_{$picCount}"><center>

			<form action="pictureOrganize.php" method="POST", id="form_{$picCount}">

				<input type="hidden" name="_LOGONID" value="{$logonId}">
				<input type="hidden" name="_action" value="performPictureAction">
				<input type="hidden" name="excavId" value="{$poc::$excavRec['id']}">
				<input type="hidden" name="cameraFileName" value="{$cameraFileName}">

				ObjektGruppe: <input type="text" name="archObjGroupId">
				Objekt: <input type="text" name="archObjectId">
				<br>

				Oberordner: <input type="text" name="parentDir" value="" list="parentDirDefaults">
				Unterordner: <input type="text" name="subDir" value="" list="subDirDefaults">
				<br>
				<br>

				<b>Stratum:</b> <input type="text" name="stratumId">
				<input type="checkbox" name="noStratumDir" value="1">Kein Stratum-Ordner
				| <input type="checkbox" name="moreAction" value="1">Weitere Zuordnung
				| <input type="checkbox" name="carryForward" value="1">Eingaben vortragen
				<br>

				<button type="button" action="showTargetName" boxMasterId="{$picCount}">Zielnamen anzeigen</button>
				<button type="button" action="copy" boxMasterId="{$picCount}">Kopieren</button>
				<button type="button" action="move" boxMasterId="{$picCount}">Verschieben</button>
				<button type="button" action="delete" boxMasterId="{$picCount}">Löschen</button>
				[ <input type="checkbox" name="confirmDelete" value="1">Wirklich löschen ]
				<button type="reset">Zurücksetzen</button>
				<br>

				<span id="fileNamePreview_{$picCount}"></span>
			</form>

			<div class="slider" id="slider_{$picCount}" boxMasterId="{$picCount}"></div>
			<br>

			<img src="pictureOrganize.php?_LOGONID={$logonId}&_action=streamPicture&image={$picUrl}"
			 width="75%" height="auto"
			 id="img_{$picCount}">
			<br>
			<br>
			<br>
			<hr>

			</center></div>
EOT;

			flush();
			if ($_REQUEST['maxCameraFiles'] && $picCount >= $_REQUEST['maxCameraFiles']) {
				$moreOpen = count($newFiles) - $picCount;
				echo "<br><hr><br>*** Es sind weitere {$moreOpen} nicht registrierte Dateien im Kamera-Ordner vorhanden.<br>\n";
				echo "Bitte die Stratum-Zuordnungen für die oben angezeigten Fotos treffen und dann neu starten.<br><br><hr>\n";
				return;
			}
		}

	}
	catch (Exception $ex) {
		echo "<br><br><hr><br>*** ABBRUCH: {$ex->getMessage()}<br><br><hr>";
	}

	HtmlHelper::htmlEnd();
	exit;
}  // eo organizee



if ($_REQUEST['_action'] == 'performPictureAction') {

	$poc = "PictureOrganize";

	try {
		PictureOrganize::init($_REQUEST['excavId']);
		PictureOrganize::readConfig();
		PictureOrganize::analyzeConfig();

		$cameraFileName = $_REQUEST['cameraFileName'];
		$fullCameraFilePath = "{$poc::$cameraDir}/{$cameraFileName}";

		// delete camera file
		if ($_REQUEST['fileAction'] == "delete") {

			$success = unlink($fullCameraFilePath);
			if (!$success) {
				echo Extjs::errorMsg("Fehler beim Löschen der Kamera-Datei {$cameraFileName}.");
				exit;
			}

			echo Extjs::enc(array("msg" => "Die Kamera-Datei {$cameraFileName} wurde gelöscht."));
			exit;
		}

		// prepare stratum ids
		$errMsg = ExcavHelper::multiXidValidErr($_REQUEST['stratumId'], array("allowBlank" => false));
		if ($errMsg) {
			echo Extjs::errorMsg("Stratum-Zuordnung: {$errMsg}");
			exit;
		}

		$stratumIds = ExcavHelper::multiXidSplit($_REQUEST['stratumId']);
		if (!$stratumIds) {
			echo Extjs::errorMsg("Stratumangabe ist leer oder falsch.");
			exit;
		}

		$_REQUEST['stratumIds'] = $stratumIds;
		$_REQUEST['hash'] = sha1_file($fullCameraFilePath);
		$newFileNamesInfo = PictureOrganize::createTargetFileName($_REQUEST);

		// show target names
		if ($_REQUEST['fileAction'] == "showTargetName") {
			$msg = "Die Kamera-Datei {$cameraFileName}<br>würde kopiert/verschoben nach<br>";
			foreach ($newFileNamesInfo as $newFileInfo) {
				$msg .= $newFileInfo['fileName'];
				if ($newFileInfo['reused']) {
					$msg .= " (wiederverwendet)";
				}
				$msg .= "<br>";
			}
			echo Extjs::enc(array("msg" => $msg));
			exit;
		}

		// copy or move
		if ($_REQUEST['fileAction'] == "copy" || $_REQUEST['fileAction'] == "move") {

			$success = $content = file_get_contents($fullCameraFilePath);
			if (!$success) {
				echo Extjs::errorMsg("Fehler beim Lesen der Kamera-Datei {$cameraFileName}.");
				exit;
			}

			$fileMsg = "";
			foreach ($newFileNamesInfo as $newFileInfo) {

				$targetFileName = $newFileInfo['fileName'];
				$fullTargetPath = PictureOrganize::normalizePath("{$poc::$targetDir}/{$targetFileName}");

				$tmpDir = dirname($fullTargetPath);
				if (!file_exists($tmpDir)) {
					$success = mkdir($tmpDir, 0777, true);
					if (!$success) {
						echo Extjs::errorMsg("Fehler beim Anlegen des Ordners {$tmpDir}.");
						exit;
					}
					// chmod for recursive dirs
					$tmpDirParts = explode("/", dirname($targetFileName));
					$tmpDir2 = PictureOrganize::$targetDir;
					foreach ($tmpDirParts as $tmpPart) {
						$tmpDir2 = "{$tmpDir2}/{$tmpPart}";
						chmod($tmpDir2, 0777);
					}
				}
				elseif (!is_dir($tmpDir)) {
					echo Extjs::errorMsg("{$tmpDir} ist kein Ordner.");
					exit;
				}
				chmod($tmpDir, 0777);

				if (!$newFileInfo['reused']) {

					if (file_exists($fullTargetPath)) {
						// maybe recheck if content is equal and mark as "reused" ?
						echo Extjs::errorMsg("Die Ziel-Datei {$targetFileName} ist bereits vorhanden, wurde aber nicht als 'wiederverwendet' markiert.");
						exit;
					}

					$success = file_put_contents($fullTargetPath, $content);
					if (!$success) {
						echo Extjs::errorMsg("Fehler beim Schreiben der Ziel-Datei {$targetFileName}.");
						exit;
					}
				}

				// book-keeping
				PictureOrganize::$config['cameraFiles'][$cameraFileName] = array(
					"cameraFileName" => $cameraFileName,
					"hash" => $_REQUEST['hash'],
					"stratumIds" => $stratumIds,
				);
				PictureOrganize::$config['targetFiles'][$targetFileName] = array(
					"targetFileName" => $targetFileName,
					"hash" => $_REQUEST['hash'],
				);
				PictureOrganize::writeConfig();

				// create response msg
				$fileMsg .= $newFileInfo['fileName'];
				if ($newFileInfo['reused']) {
					$fileMsg .= " (wiederverwendet)";
				}
				$fileMsg .= "<br>";

			}  // eo target files loop

			if ($_REQUEST['fileAction'] == "move") {
				$success = unlink($fullCameraFilePath);
				if (!$success) {
					echo Extjs::errorMsg("Fehler beim Löschen der Kamera-Datei {$cameraFileName} nach Verschieben. ($fullCameraFilePath)");
					exit;
				}
			}

			$msg = "Die Kameradatei {$cameraFileName}<br>" .
				"wurde " . ($_REQUEST['fileAction'] == "copy" ? "kopiert" : "verschoben") . " nach<br>" .
				$fileMsg;

			echo Extjs::enc(array("msg" => $msg));
			exit;
		}  // eo copy/move

		echo Extjs::errorMsg("Ungültige 'fileAction' '{$_REQUEST['fileAction']}'.");
		exit;
	}
	catch (Exception $ex) {
		echo Extjs::errorMsg($ex->getMessage());
		exit;
	}

	echo Extjs::enc();
	exit;
}  // eo set stratum id in config



if ($_REQUEST['_action'] == 'streamPicture') {
	$me = __CLASS__;

	$fileName = $_REQUEST['image'];

	header('Content-Type: image/jpeg');
	header("Content-Length: " . filesize($fileName));
	readfile($fileName);

	exit;
}  // eo stream picture



echo Extjs::errorMsg(sprintf("Invalid action '%s' in '%s'.", $_REQUEST['_action'], $_SERVER['PHP_SELF']));
exit;




?>
