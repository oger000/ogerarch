/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


Ext.define('App.model.Stratum', {
	extend: 'Ext.data.Model',

	fields: [
	// autogen-begin>
		'id',
		'excavId',
		'stratumId',
		'stratumIdSort',
		'categoryId',
		{ name: 'date', type: 'date' },
		'originator',
		'fieldName',
		'plotName',
		'section',
		'area',
		'profile',
		'typeId',
		'interpretation',
		'datingSpec',
		'datingPeriodId',
		'pictureReference',
		'planDigital',
		'planAnalog',
		'photogrammetry',
		'photoDigital',
		'photoSlide',
		'photoPrint',
		'lengthValue',
		'width',
		'height',
		'diaMeter',
		'hasArchFind',
		'hasSample',
		'hasArchObject',
		'hasArchObjGroup',
		'comment',
		'listComment',
		'isTopEdge',
		'isBottomEdge',
		'hasAutoInterface',
	// <autogen-end
		'excavName',
		'categoryName', 'typeName',
		'earlierThanIdList', 'reverseEarlierThanIdList', 'equalToIdList', 'contempWithIdList',
		'archFindIdList','archObjectIdList',
		'containedInInterfaceIdList', 'containsStratumIdList',
	],

});
