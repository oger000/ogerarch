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
* Arch object type master.
*/
class ArchObjectType extends DbRecord {

	public static $tableName = 'archObjectType';

	#FIELDDEF BEGIN
	# Table: archObjectType
	# Fielddef created: 2012-02-02 08:42

	public static $fieldNames = array(
		'id',
		'name',
		'code',
		'beginDate',
		'endDate'
	);

	public static $keyFieldNames = array(
		'id'
	);

	public static $primaryKeyFieldNames = array(
		'id'
	);


	public static $textFieldNames = array(
		'name',
		'code'
	);

	public static $numberFieldNames = array(
		'id'
	);

	public static $boolFieldNames = array(

	);

	public static $dateFieldNames = array(
		'beginDate',
		'endDate'
	);

	public static $timeFieldNames = array(

	);

	#FIELDDEF END






}  // end of class



?>
