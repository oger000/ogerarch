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
* Stratum. Deposit part.
*/
class StratumDeposit extends DbRecord {

	public static $tableName = 'stratumDeposit';

	#FIELDDEF BEGIN
	# Table: stratumStratum
	# Fielddef created: 2012-01-10 13:28

	public static $fieldNames = array(
		'id',
		'excavId',
		'stratumId',
		'color',
		'hardness',
		'consistency',
		'inclusion',
		'orientation',
		'incline',
		'materialDenotation'
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
		'color',
		'hardness',
		'consistency',
		'inclusion',
		'orientation',
		'incline',
		'materialDenotation'
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
