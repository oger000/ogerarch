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
class StratumWall extends DbRecord {

	public static $tableName = 'stratumWall';

	#FIELDDEF BEGIN
	# Table: stratumWall
	# Fielddef created: 2012-02-20 10:52

	public static $fieldNames = array(
		'id',
		'excavId',
		'stratumId',
		'datingStratigraphy',
		'datingWallStructure',
		'lengthApplyTo',
		'widthApplyTo',
		'heightRaising',
		'heightRaisingApplyTo',
		'heightFooting',
		'heightFootingApplyTo',
		'constructionType',
		'wallBaseType',
		'structureType',
		'relationDescription',
		'layerDescription',
		'shellDescription',
		'kernelDescription',
		'formworkDescription',
		'hasPutlogHole',
		'putlogHoleDescription',
		'hasBarHole',
		'barHoleDescription',
		'materialType',
		'stoneSize',
		'stoneMaterial',
		'stoneProcessing',
		'hasCommonBrick',
		'hasVaultBrick',
		'hasRoofTile',
		'hasFortificationBrick',
		'brickDescription',
		'hasProductionStampSign',
		'hasProductionFingerSign',
		'hasProductionOtherAttribute',
		'productionDescription',
		'mixedWallBrickPercent',
		'mixedWallDescription',
		'spoilDescription',
		'binderState',
		'binderType',
		'binderColor',
		'binderSandPercent',
		'binderLimeVisible',
		'binderGrainSize',
		'binderConsistency',
		'additivePebbleSize',
		'additiveLimepopSize',
		'additiveCrushedTilesSize',
		'additiveCharcoalSize',
		'additiveStrawSize',
		'additiveOtherSize',
		'additiveOtherDescription',
		'abreuvoirType',
		'abreuvoirDescription',
		'plasterSurface',
		'plasterThickness',
		'plasterExtend',
		'plasterColor',
		'plasterMixture',
		'plasterGrainSize',
		'plasterConsistency',
		'plasterAdditives',
		'plasterLayer'
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
		'heightRaising',
		'heightRaisingApplyTo',
		'heightFooting',
		'heightFootingApplyTo',
		'constructionType',
		'wallBaseType',
		'structureType',
		'relationDescription',
		'layerDescription',
		'shellDescription',
		'kernelDescription',
		'formworkDescription',
		'putlogHoleDescription',
		'barHoleDescription',
		'materialType',
		'stoneSize',
		'stoneMaterial',
		'stoneProcessing',
		'brickDescription',
		'productionDescription',
		'mixedWallBrickPercent',
		'mixedWallDescription',
		'spoilDescription',
		'binderState',
		'binderType',
		'binderColor',
		'binderSandPercent',
		'binderGrainSize',
		'binderConsistency',
		'additivePebbleSize',
		'additiveLimepopSize',
		'additiveCrushedTilesSize',
		'additiveCharcoalSize',
		'additiveStrawSize',
		'additiveOtherSize',
		'additiveOtherDescription',
		'abreuvoirType',
		'abreuvoirDescription',
		'plasterSurface',
		'plasterThickness',
		'plasterExtend',
		'plasterColor',
		'plasterMixture',
		'plasterGrainSize',
		'plasterConsistency',
		'plasterAdditives',
		'plasterLayer'
	);

	public static $numberFieldNames = array(
		'id',
		'excavId',
		'datingStratigraphy',
		'datingWallStructure',
		'hasPutlogHole',
		'hasBarHole',
		'hasCommonBrick',
		'hasVaultBrick',
		'hasRoofTile',
		'hasFortificationBrick',
		'hasProductionStampSign',
		'hasProductionFingerSign',
		'hasProductionOtherAttribute',
		'binderLimeVisible'
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

			$master = WallConstructionType::newFromDb(array('id' => $this->values['constructionType']));
			$values['constructionTypeName'] = ($master->values['name'] ?: $values['constructionType']);
			$values['constructionTypeCode'] = $master->values['code'];

			$master = WallBaseType::newFromDb(array('id' => $this->values['wallBaseType']));
			$values['wallBaseTypeName'] = ($master->values['name'] ?: $values['wallBaseType']);
			$values['wallBaseTypeCode'] = $master->values['code'];

			$master = WallStructureType::newFromDb(array('id' => $this->values['structureType']));
			$values['structureTypeName'] = ($master->values['name'] ?: $values['structureType']);
			$values['structureTypeCode'] = $master->values['code'];

			$master = WallMaterialType::newFromDb(array('id' => $this->values['materialType']));
			$values['materialTypeName'] = ($master->values['name'] ?: $values['materialType']);
			$values['materialTypeCode'] = $master->values['code'];

			$master = WallBinderType::newFromDb(array('id' => $this->values['binderType']));
			$values['binderTypeName'] = ($master->values['name'] ?: $values['binderType']);
			$values['binderTypeCode'] = $master->values['code'];

			$master = WallBinderState::newFromDb(array('id' => $this->values['binderState']));
			$values['binderStateName'] = ($master->values['name'] ?: $values['binderState']);
			$values['binderStateCode'] = $master->values['code'];

			$master = WallBinderGrainSize::newFromDb(array('id' => $this->values['binderGrainSize']));
			$values['binderGrainSizeName'] = ($master->values['name'] ?: $values['binderGrainSize']);
			$values['binderGrainSizeCode'] = $master->values['code'];

			$master = WallBinderConsistency::newFromDb(array('id' => $this->values['binderConsistency']));
			$values['binderConsistencyName'] = ($master->values['name'] ?: $values['binderConsistency']);
			$values['binderConsistencyCode'] = $master->values['code'];

			$master = WallAbreuvoirType::newFromDb(array('id' => $this->values['abreuvoirType']));
			$values['abreuvoirTypeName'] = ($master->values['name'] ?: $values['abreuvoirType']);
			$values['abreuvoirTypeCode'] = $master->values['code'];

			$master = WallPlasterSurface::newFromDb(array('id' => $this->values['plasterSurface']));
			$values['plasterSurfaceName'] = ($master->values['name'] ?: $values['plasterSurface']);
			$values['plasterSurfaceCode'] = $master->values['code'];

			// ---

			$master = WallSizeApplyToType::newFromDb(array('id' => $this->values['lengthApplyTo']));
			$values['lengthApplyToName'] = ($master->values['name'] ?: $values['lengthApplyTo']);

			$master = WallSizeApplyToType::newFromDb(array('id' => $this->values['widthApplyTo']));
			$values['widthApplyToName'] = ($master->values['name'] ?: $values['widthApplyTo']);

			$master = WallSizeApplyToType::newFromDb(array('id' => $this->values['heightRaisingApplyTo']));
			$values['heightRaisingApplyToName'] = ($master->values['name'] ?: $values['heightRaisingApplyTo']);

			$master = WallSizeApplyToType::newFromDb(array('id' => $this->values['heightFootingApplyTo']));
			$values['heightFootingApplyToName'] = ($master->values['name'] ?: $values['heightFootingApplyTo']);
		}  // eo export mode

		return $values;
	}  // eo extended values




	/**
	* Get item (field) labels
	*/
	public static function getItemLabels() {

		$values = array(
			'datingStratigraphy' => Oger::_('Stratigrafie'),
			'datingWallStructure' => Oger::_('Struktur'),
			'hasCommonBrick' => Oger::_('Mauerziegel'),
			'hasVaultBrick' => Oger::_('Gewölbeziegel'),
			'hasRoofTile' => Oger::_('Dachziegel'),
			'hasFortificationBrick' => Oger::_('Fortifikationsziegel'),
			'hasProductingStampSign' => Oger::_('Stempel'),
			'hasProductingFingerSign' => Oger::_('Fingerstrich'),
			'hasProductingOtherAttribute' => Oger::_('Sonst. Zeichen'),
		);

		return $values;
	}  // eo get labels



}  // end of class



?>
