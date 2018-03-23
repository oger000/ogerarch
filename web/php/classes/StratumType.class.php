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
* Stratum type master.
* Stratum types are inside stratum categories
*/
class StratumType extends DbRecord {

	public static $tableName = 'stratumType';

	#FIELDDEF BEGIN
	# Table: stratumType
	# Fielddef created: 2011-09-06 16:36

	public static $fieldNames = array(
		'id',
		'categoryId',
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
		'categoryId',
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




	/**
	* Get extended values.
	*/
	public function getExtendedValues($opts = array()) {

		$values = $this->values;
		$category = StratumCategory::newFromDb(array('id' => $values['categoryId']));
		$values['categoryName'] = $category->values['name'];
		return $values;
	}  // eo extended values


}  // end of class



?>
