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
* PDF template
*/
class PdfTemplate extends DbRecord {

	public static $tableName = 'pdfTemplate';

	#FIELDDEF BEGIN
	# Table: pdfTemplate
	# Fielddef created: 2011-09-29 18:18

	public static $fieldNames = array(
		'id',
		'sectionId',
		'name',
		'template',
		'description'
	);

	public static $keyFieldNames = array(
		'id'
	);

	public static $primaryKeyFieldNames = array(
		'id'
	);


	public static $textFieldNames = array(
		'sectionId',
		'name',
		'template',
		'description'
	);

	public static $numberFieldNames = array(
		'id'
	);

	public static $boolFieldNames = array(

	);

	public static $dateFieldNames = array(

	);

	public static $timeFieldNames = array(

	);

	#FIELDDEF END


/*
* Get form
* TODO get template from dateabase if present, fallback to default in file
*/
public static function getTemplate($name, $extraPath = null) {

	$fullPath = "pdftemplates/";  // template base dir
	if ($extraPath) {
		$fullPath .= $extraPath . '/';
	}
	$fullPath .= $name . ".tpl";

	if (file_exists($fullPath)) {
		$template = file_get_contents($fullPath);
	}
	else {
		// give error message and treat it as fatal error.
		echo "Template $name not found. (File $fullPath does not exist)";
		exit;
	}

	return $template;
}  // eo get template



}  // end of class



?>
