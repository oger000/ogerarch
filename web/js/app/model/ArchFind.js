/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


Ext.define('App.model.ArchFind', {
	extend: 'Ext.data.Model',

	fields: [
	// autogen-begin>
		'id',
		'excavId',
		'archFindId',
		'archFindIdSort',
		{ name: 'date', type: 'date' },
		'fieldName',
		'plotName',
		'section',
		'area',
		'profile',
		'atStepLowering',
		'atStepCleaningRaw',
		'atStepCleaningFine',
		'atStepOther',
		'isStrayFind',
		'interpretation',
		'datingSpec',
		'datingPeriodId',
		'planName',
		'interfaceIdList',
		'archObjectIdList',
		'archObjGroupIdList',
		'specialArchFind',
		'ceramicsCountId',
		'animalBoneCountId',
		'humanBoneCountId',
		'ferrousCountId',
		'nonFerrousMetalCountId',
		'glassCountId',
		'architecturalCeramicsCountId',
		'daubCountId',
		'stoneCountId',
		'silexCountId',
		'mortarCountId',
		'timberCountId',
		'organic',
		'archFindOther',
		'sedimentSampleCountId',
		'slurrySampleCountId',
		'charcoalSampleCountId',
		'mortarSampleCountId',
		'slagSampleCountId',
		'sampleOther',
		'comment',
	// <autogen-end
		'stratumIdList',  'excavName',
	],

});
