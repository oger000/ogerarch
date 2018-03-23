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
class StratumTimber extends DbRecord {

	public static $tableName = 'stratumTimber';

	#FIELDDEF BEGIN
	# Table: stratumTimber
	# Fielddef created: 2012-01-20 15:18

	public static $fieldNames = array(
		'id',
		'excavId',
		'stratumId',
		'dendrochronology',
		'lengthApplyTo',
		'widthApplyTo',
		'heightApplyTo',
		'orientation',
		'functionDescription',
		'constructDescription',
		'relationDescription',
		'timberType',
		'infill',
		'otherConstructMaterial',
		'surface',
		'preservationStatus',
		'physioZoneDullEdge',
		'physioZoneSeapWood',
		'physioZoneHeartWood',
		'secundaryUsage',
		'processSign',
		'processDetail',
		'connection'
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
		'lengthApplyTo',
		'widthApplyTo',
		'heightApplyTo',
		'orientation',
		'functionDescription',
		'constructDescription',
		'relationDescription',
		'timberType',
		'infill',
		'otherConstructMaterial',
		'surface',
		'preservationStatus',
		'processSign',
		'processDetail',
		'connection'
	);

	public static $numberFieldNames = array(
		'id',
		'excavId',
		'dendrochronology',
		'physioZoneDullEdge',
		'physioZoneSeapWood',
		'physioZoneHeartWood',
		'secundaryUsage'
	);

	public static $boolFieldNames = array(

	);

	public static $dateFieldNames = array(

	);

	public static $timeFieldNames = array(

	);

	#FIELDDEF END




	/**
	* Get extended values.
	*/
	public function getExtendedValues($opts = array()) {

		$values = $this->values;

		if ($opts['export']) {

			$master = WallSizeApplyToType::newFromDb(array('id' => $this->values['lengthApplyTo']));
			$values['lengthApplyToName'] = ($master->values['name'] ?: $values['lengthApplyTo']);

			$master = WallSizeApplyToType::newFromDb(array('id' => $this->values['widthApplyTo']));
			$values['widthApplyToName'] = ($master->values['name'] ?: $values['widthApplyTo']);

			$master = WallSizeApplyToType::newFromDb(array('id' => $this->values['heightApplyTo']));
			$values['heightApplyToName'] = ($master->values['name'] ?: $values['heightApplyTo']);

		}  // eo export mode

		return $values;
	}  // eo extended values



	/**
	* Get item (field) labels
	*/
	public static function getItemLabels() {

		$values = array(
			'physioZoneDullEdge' => Oger::_('Waldkante'),
			'physioZoneSeapWood' => Oger::_('Splintholz'),
			'physioZoneHeartWood' => Oger::_('Kernholz'),
			);

		return $values;
	}  // eo get labels





}  // end of class



?>
