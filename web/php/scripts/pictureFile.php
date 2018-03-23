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


// TODO handle upload on update and change from internal to external (and vice versa)
// TODO handle rename of external file names after modification of name relevant parts


// load data from database
if ($_REQUEST['_action'] == 'loadList' || $_REQUEST['_action'] == 'loadRecord'
		|| $_REQUEST['_action'] == 'loadContent' || $_REQUEST['_action'] == 'loadPreview') {

	$data = array();

	$sele['fields'] = '*';
	$sele['table'] = PictureFile::$tableName;
	$sele['orderBy'] = array('excavId' => 'ASC', 'date' => 'ASC');


	if ($_REQUEST['id']) {
		$sele['where']['id'] = $_REQUEST['id'];
	}
	if ($_REQUEST['excavId']) {
		$sele['where']['excavId'] = $_REQUEST['excavId'];
	}

	$sele = DbSeleHelper::prepareSeleOpts($sele);
	$stmt = Db::createSelectStmt($sele);

	$pstmt = Db::prepare($stmt);
	$pstmt->execute($sele['where']);
	while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
		$record = new PictureFile($row);
		if ($_REQUEST['_action'] == 'loadContent' || $_REQUEST['_action'] == 'loadPreview') {
			$record->loadExternalContent();
		}
		else {  // set content to empty if not explicitly requested to minimize transfer size
			$record->values['content'] = '';
		}
		$data[] = $record->values;
	}
	$pstmt->closeCursor();



	// if content is requested
	if ($_REQUEST['_action'] == 'loadContent') {
		$data = $data[0];
		if ($data['mimeType']) {
			header("Content-type: " . $data['mimeType']);
		}
		header('Content-disposition: attachment; filename="' . $data['fileName'] . '"');
		echo $data['content'];
		exit;
	}



	// if preview is requested
	if ($_REQUEST['_action'] == 'loadPreview') {

		$data = $data[0];

		if ($data['mimeType']) {
			header("Content-type: " . $data['mimeType']);
		}

		if (extension_loaded('gd') && function_exists('gd_info')) {
			//echo "It looks like GD is installed";

			// write data to tmp file
			if (!$data['externalStoreFileName']) {
				$isTmpFile = true;
				$imgFileName = tempnam(sys_get_temp_dir(), 'ogerarch_');
				file_put_contents ($imgFileName, $data['content']);
			}
			else {
				$imgFileName = Config::$externalDataDir . $data['externalStoreFileName'];
			}

			// try preview on the fly
			if (preg_match('/jpg$/i', $data['fileName']) ||
					preg_match('/jpeg$/i', $data['fileName']) ||
					$data['mimeType'] == 'image/jpeg') {
				$imgType = 'JPEG';
				$img = imagecreatefromjpeg($imgFileName);
			}
			elseif (preg_match('/png$/i', $data['fileName']) ||
							$data['mimeType'] == 'image/png') {
				$imgType = 'PNG';
				$img = imagecreatefrompng($imgFileName);
			}
			elseif (preg_match('/gif$/i', $data['fileName']) ||
							$data['mimeType'] == 'image/gif') {
				$imgType = 'GIF';
				$img = imagecreatefromgif($imgFileName);
			}

			// delete if tmpfile was created from this script AND ONLY IN THIS CASE
			if ($isTmpFile) {
				unlink($imgFileName);
			}

			// only if creating of img was successful
			if ($img) {

				$oriWidth = imagesx($img);
				$oriHeight = imagesy($img);

				// default target max width / max height if not given from frontend
				$targetMaxWidth = ($_REQUEST['width'] ?: 600);
				$targetMaxHeight = ($_REQUEST['height'] ?: 600);

				// calc unified ratio (max reduction is siginificant) and only shrink
				$ratio = max(1, $oriWidth / $targetMaxWidth, $oriHeight / $targetMaxHeight);

				$targetWidth = $oriWidth / $ratio;
				$targetHeight = $oriHeight / $ratio;


				$previewImg = imagecreatetruecolor($targetWidth, $targetHeight);
				imagecopyresampled($previewImg, $img, 0, 0, 0, 0, $targetWidth, $targetHeight, $oriWidth, $oriHeight);

				if ($imgType == 'JPEG') {
					imagejpeg($previewImg);
				}
				elseif ($imgType == 'PNG') {
					imagepng($previewImg);
				}
				elseif ($imgType == 'GIF') {
					imagegif($previewImg);
				}
				exit;
			}

		}  // eo gd present

		// if no preview was possible transfer full image
		echo $data['content'];
		exit;

	}  // eo preview


	// if load only one record into form do not send a list of records, but only the first one
	if ($_REQUEST['_action'] == 'loadRecord') {
		$data = $data[0];
	}
	else {  // loadList
		$pstmt = Db::prepare('SELECT COUNT(*) FROM ' . PictureFile::$tableName, $sele['where']);
		$pstmt->execute($sele['where']);
		$totalCount = $pstmt->fetchColumn();
		$pstmt->closeCursor();
	}

	echo Extjs::encData($data, $totalCount);

}  // eo loading data to json store



/*
* Save input
*/
if ($_REQUEST['_action'] == 'save') {

	// precheck external storage - we do NOT allow internal blobs for now !
	if (!Config::$externalDataDir) {
		echo Extjs::errorMsg('Kein Verzeichnis für Dateiablage konfiguriert.');
		exit;
	}
	if (!is_writeable(Config::$externalDataDir)) {
		echo Extjs::errorMsg('Verzeichnis für Dateiablage nicht angelegt oder nicht schreibbar.');
		exit;
	}

	// create from request
	DatingHelper::prepareInput($_REQUEST['datingFrom'], $_REQUEST['datingTo']);
	$record = new PictureFile($_REQUEST);

	if ($_REQUEST['dbAction'] == Db::ACTION_INSERT) {
		// new entry needs file name and a size
		if (!$_FILES['uploadFileName']['name']) {
			echo Extjs::errorMsg('Name der hochgeladenen Datei konnte nicht ermittelt werden.');
			exit;
		}
		if (!$_FILES['uploadFileName']['size']) {
			echo Extjs::errorMsg('Die hochgeladenen Datei ist leer.');
			exit;
		}

		$record->values['id'] = (string)(PictureFile::getMaxValue('id') + 1);
		$oldRecord = new PictureFile();
	}

	if ($_REQUEST['dbAction'] == Db::ACTION_UPDATE) {
		$oldRecord = PictureFile::newFromDb(array('id' => $_REQUEST['id']));
	}


	// handle uploaded file only if a file is uploaded
	if (($_FILES['uploadFileName'] && $_FILES['uploadFileName']['name'] && $_FILES['uploadFileName']['size'])) {

		if ($_FILES['uploadFileName']['error'] != UPLOAD_ERR_OK) {
			echo Extjs::errorMsg('Fehler ' . $_FILES['uploadFileName']['error'] . ' beim Hochladen der Datei ' . $_REQUEST['uploadFileName']);
			exit;
		}
		if (!$_FILES['uploadFileName']['size']) {
			echo Extjs::errorMsg('Hochgeladene Datei ist leer oder zu gross.');
			exit;
		}

		$record->values['fileName'] = $_FILES['uploadFileName']['name'];
		$record->values['mimeType'] = $_FILES['uploadFileName']['type'];
		$record->values['fileSize'] = $_FILES['uploadFileName']['size'];

		$content = file_get_contents($_FILES['uploadFileName']['tmp_name']);
		unlink($_FILES['uploadFileName']['tmp_name']);

		// try to redetect mime type from content
		$fi = new Finfo(FILEINFO_MIME);
		if ($fi) {
			$tmp = $fi->buffer($content);
			if ($tmp) {
				list($record->values['mimeType'], $tmp) = explode(';', $tmp, 2);
			}
			//$fi->__destruct();    // Call to undefined method finfo::__destruct() ???
		} // eo redetect mime type

		if ($record->values['mimeType'] != 'image/jpeg' &&
				$record->values['mimeType'] != 'image/png' &&
				$record->values['mimeType'] != 'image/gif') {
			echo Extjs::errorMsg('Ungültiger Dateityp ' . $record->values['mimeType'] . '.');
			exit;
		}

		// new content stored in external file (not in db)
		if (Config::$externalDataDir) {
			$record->writeExternalContentFile($content);
		}
		else {  // content is stored in database
			$record->values['isExternal'] = false;
			//$record->values['externalStoreFileName'] = '';
			$record->values['content'] = $content;
			// if external file exists we cannot remove it because we have no Config::$externalDataDir
		}

	}  // eo upload
	else {  // no upload, but db record is updated
		// exclude file specific fields if no upload happened
		$excludeFields = array('fileName', 'mimeType', 'content', 'isExternal');
		$record->values['isExternal'] = $oldRecord->values['isExternal'];
		$record->values['externalStoreFileName'] = $oldRecord->values['externalStoreFileName'];
		if (!$record->adjustExternalFileName()) {
			$excludeFields[] = 'externalStoreFileName';
		}
	}  // eo non-upload


	$record->toDb($_REQUEST['dbAction'], null, array('excludeFields' => $excludeFields));
	$record->values['content'] = '';  // remove content before return to frontend
	echo Extjs::encData($record->values);

}  // eo save posted data to database




/*
* Delete record and file
*/
if ($_REQUEST['_action'] == 'delete') {

	if (!$_REQUEST['id']) {
		echo Extjs::errorMsg("Id für Datensatz fehlt.");
		exit;
	}

	// create from request
	$record = new PictureFile($_REQUEST['id']);
	$record->fromDb();

	if ($record->values['externalStoreFileName']) {
		$path = Config::$externalDataDir . $record->values['externalStoreFileName'];
		if (file_exists($path)) {
			unlink($path);
			if (file_exists($path)) {
				echo Extjs::errorMsg("Externe Datei '" . $record->values['externalStoreFileName'] . "' kann nicht gelöscht werden.");
				exit;
			}
		}
	}

	$whereVals = array('id' => $_REQUEST['id']);
	$pstmt = Db::prepare('DELETE FROM ' . PictureFile::$tableName, $whereVals);
	$pstmt->execute($whereVals);

	echo Extjs::encData();

}  // eo delete

?>
