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
class StratumSkeleton extends DbRecord {

	public static $tableName = 'stratumSkeleton';

	#FIELDDEF BEGIN
	# Table: stratumSkeleton
	# Fielddef created: 2013-10-16 18:19

	public static $fieldNames = array(
		'id',
		'excavId',
		'stratumId',
		'bodyPosition',
		'orientation',
		'boneQuality',
		'dislocationNone',
		'dislocationBase',
		'dislocationShaft',
		'dislocationPrivation',
		'dislocationDen',
		'recoverySingleBones',
		'recoveryBlock',
		'recoveryHardened',
		'specialBurial',
		'viewDirection',
		'legPosition',
		'armPosition',
		'positionDescription',
		'upperArmRightLength',
		'upperArmLeftLength',
		'foreArmRightLength',
		'foreArmLeftLength',
		'thighRightLength',
		'thighLeftLength',
		'shinRightLength',
		'shinLeftLength',
		'bodyLength',
		'sex',
		'gender',
		'age',
		'burialCremationId',
		'cremationDemageStratumIdList',
		'cremationDemageDescription',
		'coffinStratumIdList',
		'tombTimberStratumIdList',
		'tombStoneStratumIdList',
		'tombBrickStratumIdList',
		'tombOtherMaterialStratumIdList',
		'tombFormCircleStratumIdList',
		'tombFormOvalStratumIdList',
		'tombFormRectangleStratumIdList',
		'tombFormSquareStratumIdList',
		'tombFormOtherStratumIdList',
		'tombDemageStratumIdList',
		'tombDemageFormId',
		'tombDescription',
		'burialObjectArchFindIdList',
		'costumeArchFindIdList',
		'depositArchFindIdList',
		'tombConstructArchFindIdList'
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
		'bodyPosition',
		'orientation',
		'boneQuality',
		'viewDirection',
		'legPosition',
		'armPosition',
		'positionDescription',
		'upperArmRightLength',
		'upperArmLeftLength',
		'foreArmRightLength',
		'foreArmLeftLength',
		'thighRightLength',
		'thighLeftLength',
		'shinRightLength',
		'shinLeftLength',
		'bodyLength',
		'sex',
		'gender',
		'age',
		'burialCremationId',
		'cremationDemageStratumIdList',
		'cremationDemageDescription',
		'coffinStratumIdList',
		'tombTimberStratumIdList',
		'tombStoneStratumIdList',
		'tombBrickStratumIdList',
		'tombOtherMaterialStratumIdList',
		'tombFormCircleStratumIdList',
		'tombFormOvalStratumIdList',
		'tombFormRectangleStratumIdList',
		'tombFormSquareStratumIdList',
		'tombFormOtherStratumIdList',
		'tombDemageStratumIdList',
		'tombDemageFormId',
		'tombDescription',
		'burialObjectArchFindIdList',
		'costumeArchFindIdList',
		'depositArchFindIdList',
		'tombConstructArchFindIdList'
	);

	public static $numberFieldNames = array(
		'id',
		'excavId',
		'dislocationNone',
		'dislocationBase',
		'dislocationShaft',
		'dislocationPrivation',
		'dislocationDen',
		'recoverySingleBones',
		'recoveryBlock',
		'recoveryHardened',
		'specialBurial'
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

			// --- skeleton

			$master = SkeletonBodyPositionType::newFromDb(array('id' => $this->values['bodyPosition']));
			$values['bodyPositionName'] = ($master->values['name'] ?: $values['bodyPosition']);
			$values['bodyPositionCode'] = $master->values['code'];

			$master = SkeletonArmPositionType::newFromDb(array('id' => $this->values['armPosition']));
			$values['armPositionName'] = ($master->values['name'] ?: $values['armPosition']);
			$values['armPositionCode'] = $master->values['code'];

			$master = SkeletonLegPositionType::newFromDb(array('id' => $this->values['legPosition']));
			$values['legPositionName'] = ($master->values['name'] ?: $values['legPosition']);
			$values['legPositionCode'] = $master->values['code'];

			$master = SkeletonBoneQualityType::newFromDb(array('id' => $this->values['boneQuality']));
			$values['boneQualityName'] = ($master->values['name'] ?: $values['boneQuality']);
			$values['boneQualityCode'] = $master->values['code'];

			// --- anthro

			$master = SkeletonSexType::newFromDb(array('id' => $this->values['sex']));
			$values['sexName'] = ($master->values['name'] ?: $values['sex']);
			$values['sexCode'] = $master->values['code'];

			$master = SkeletonSexType::newFromDb(array('id' => $this->values['gender']));
			$values['genderName'] = ($master->values['name'] ?: $values['gender']);
			$values['genderCode'] = $master->values['code'];

			$values['ageName'] = '';
			$values['ageCode'] = '';
			foreach (explode(',', $this->values['age']) as $ageId) {
				$master = SkeletonAgeType::newFromDb(array('id' => $ageId));
				$values['ageName'] .= ($values['ageName'] ? ', ' : '') . ($master->values['name'] ?: $ageId);
				$values['ageCode'] .= ($values['ageCode'] ? ',' : '') . $master->values['code'];
			}

			// --- burial

			$master = SkeletonBurialCremationType::newFromDb(array('id' => $this->values['burialCremationId']));
			$values['burialCremationName'] = ($master->values['name'] ?: $values['burialCremationId']);
			$values['burialCremationIdCode'] = $master->values['code'];

			// --- demage

			$master = SkeletonTombDemageFormType::newFromDb(array('id' => $this->values['tombDemageFormId']));
			$values['tombDemageFormName'] = ($master->values['name'] ?: $values['tombDemageFormId']);
			$values['tombDemageFormCode'] = $master->values['code'];

	}  // eo export mode

		return $values;
	}  // eo extended values



	/**
	* Get item (field) labels
	*/
	public static function getItemLabels() {

		$values = array(
			'dislocationNone' => Oger::_('Keine Dislozierung'),
			'dislocationBase' => Oger::_('An Grabsohle'),
			'dislocationShaft' => Oger::_('Im Schacht'),
			'dislocationPrivation' => Oger::_('Beraubung'),
			'dislocationDen' => Oger::_('Tierbau'),
			'recoverySingleBones' => Oger::_('Einzelknochen'),
			'recoveryBlock' => Oger::_('Blockbergung'),
			'recoveryHardened' => Oger::_('Härtung'),
			);

		return $values;
	}  // eo get labels



}  // end of class



?>
