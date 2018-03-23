<?PHP
/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Picture file class
*/
class PictureFile extends DbRecord {

	public static $tableName = 'pictureFile';


	#FIELDDEF BEGIN
	# Table: pictureFile
	# Fielddef created: 2013-05-13 08:57

	public static $fieldNames = array(
		'id',
		'excavId',
		'fileName',
		'mimeType',
		'fileSize',
		'isExternal',
		'content',
		'externalStoreFileName',
		'date',
		'title',
		'isOverview',
		'relevance',
		'auxStratumIdList',
		'auxArchFindIdList',
		'auxSection',
		'auxSektor',
		'auxPlanum',
		'auxProfile',
		'auxObject',
		'auxGrave',
		'auxWall',
		'auxComplex',
		'comment',
		'datingPeriodId',
		'datingSpec'
	);

	public static $keyFieldNames = array(
		'excavId',
		'id'
	);

	public static $primaryKeyFieldNames = array(
		'id'
	);


	public static $textFieldNames = array(
		'fileName',
		'mimeType',
		'content',
		'externalStoreFileName',
		'title',
		'relevance',
		'auxStratumIdList',
		'auxArchFindIdList',
		'auxSection',
		'auxSektor',
		'auxPlanum',
		'auxProfile',
		'auxObject',
		'auxGrave',
		'auxWall',
		'auxComplex',
		'comment',
		'datingPeriodId',
		'datingSpec'
	);

	public static $numberFieldNames = array(
		'id',
		'excavId',
		'fileSize',
		'isExternal',
		'isOverview'
	);

	public static $boolFieldNames = array(

	);

	public static $dateFieldNames = array(
		'date'
	);

	public static $timeFieldNames = array(

	);

	#FIELDDEF END



	/*
	* Get proposed dirname for picture file
	* Make shure it ends with '/'
	*/
	public function getProposedExternalDirName() {
		return 'excavation/' . $this->values['excavId'] . '/fileUpload/picture/';
	}  // eo proposed external dir name


	/*
	* Get proposed full filename depending on field values (including directory parts)
	*/
	public function getProposedExternalFileName() {

		return $this->getProposedExternalDirName() .
					 'ex-' . $this->values['excavId'] .
					 '_id-' . $this->values['id'] .
					 '_da-' . $this->values['date'] .
					 '_st-' . preg_replace('/[^0-9A-Za-z\.\-_]/', '~', $this->values['auxStratumIdList']) .
					 '_se-' . preg_replace('/[^0-9A-Za-z\.\-_]/', '~', $this->values['auxSection']) .
					 '_kt-' . preg_replace('/[^0-9A-Za-z\.\-_]/', '~', $this->values['auxSektor']) .
					 '_pl-' . preg_replace('/[^0-9A-Za-z\.\-_]/', '~', $this->values['auxPlanum']) .
					 '_pr-' . preg_replace('/[^0-9A-Za-z\.\-_]/', '~', $this->values['auxProfile']) .
					 '_ob-' . preg_replace('/[^0-9A-Za-z\.\-_]/', '~', $this->values['auxObject']) .
					 '_gr-' . preg_replace('/[^0-9A-Za-z\.\-_]/', '~', $this->values['auxGrave']) .
					 '_wa-' . preg_replace('/[^0-9A-Za-z\.\-_]/', '~', $this->values['auxWall']) .
					 '_co-' . preg_replace('/[^0-9A-Za-z\.\-_]/', '~', $this->values['auxComplex']) .
					 '=' . preg_replace('/[^0-9A-Za-z\.\-_]/', '_', $this->values['fileName']);

	}  // eo create external file name



	/*
	* Load external content
	*/
	public function loadExternalContent() {

		if (!Config::$externalDataDir) {
			$this->values['content'] = "Missing configuration for external file storage.";
			return false;
		}

		if ($this->values['isExternal']) {
			$path = Config::$externalDataDir . $this->values['externalStoreFileName'];
			if (is_readable($path)) {
				$this->values['content'] = file_get_contents($path);
				return true;
			}
			else {
				$this->values['content'] = "External picture file not present or not readable.";
			}
		}

		return false;
	}  // eo load external content




	/*
	* Adjust external file name
	*/
	public function adjustExternalFileName() {

		// check if rename is neccessary and possible
		if (!$this->values['isExternal']) {
			return false;
		};

		if ($this->getProposedExternalFileName() == $this->values['externalStoreFileName']) {
			return false;
		};

		if (!is_readable(Config::$externalDataDir . $this->values['externalStoreFileName'])) {
			return false;
		}

		$oldExternalFullFileName = Config::$externalDataDir . $this->values['externalStoreFileName'];
		$content = file_get_contents($oldExternalFullFileName);
		$this->writeExternalContentFile($content);
		unlink($oldExternalFullFileName);

		return true;

	}  // eo adjust external file name




	/*
	* Write external content file
	*/
	public function writeExternalContentFile($content) {

		if (!is_writeable(Config::$externalDataDir)) {
			echo Extjs::errorMsg('Verzeichnis für Dateiablage nicht angelegt oder nicht schreibbar.');
			exit;
		}
		$path = $this->getProposedExternalDirName();
		if (!file_exists(Config::$externalDataDir . $path)) {
			mkdir(Config::$externalDataDir . $path, 0777, true);
		}
		if (!is_writeable(Config::$externalDataDir . $path)) {
			echo Extjs::errorMsg("Verzeichnis $path innerhalb der Dateiablage kann nicht angelegt werden oder ist nicht schreibbar.");
			exit;
		}
		$path = $this->getProposedExternalFileName();
		if (file_put_contents(Config::$externalDataDir . $path, $content) === false) {
			echo Extjs::errorMsg("Fehler beim Schreiben der Datei " . $path . '.');
			exit;
		}

		$this->values['isExternal'] = true;
		$this->values['externalStoreFileName'] = $this->getProposedExternalFileName();
		$this->values['content'] = '';

	}  // eo write external content




}  // end of class




?>
