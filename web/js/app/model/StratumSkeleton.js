/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


Ext.define('App.model.StratumSkeleton', {
	extend: 'Ext.data.Model',

	fields: [
	// autogen-begin>
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
		'tombConstructArchFindIdList',
	// <autogen-end
	],
});
