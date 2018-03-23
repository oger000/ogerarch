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
* Stratum. Common part.
*/
class StratumInterface extends DbRecord {

	public static $tableName = 'stratumInterface';

	#FIELDDEF BEGIN
	# Table: stratumInterface
	# Fielddef created: 2012-05-18 07:16

	public static $fieldNames = array(
		'id',
		'excavId',
		'stratumId',
		'shape',
		'contour',
		'intersection',
		'vertex',
		'sidewall',
		'basis'
	);

	public static $keyFieldNames = array(
		'excavId',
		'stratumId',
		'id'
	);

	public static $primaryKeyFieldNames = array(
		'id'
	);


	public static $textFieldNames = array(
		'stratumId',
		'shape',
		'contour',
		'intersection',
		'vertex',
		'sidewall',
		'basis'
	);

	public static $numberFieldNames = array(
		'id',
		'excavId'
	);

	public static $boolFieldNames = array(

	);

	public static $dateFieldNames = array(

	);

	public static $timeFieldNames = array(

	);

	#FIELDDEF END




}  // end of class



?>
