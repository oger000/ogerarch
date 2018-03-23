/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


Ext.define('App.model.PictureFile', {
	extend: 'Ext.data.Model',

	fields: [
	// autogen-begin>
		'id',
		'excavId',
		'fileName',
		'mimeType',
		'fileSize',
		'isExternal',
		'content',
		'externalStoreFileName',
		{ name: 'date', type: 'date' },
		'title',
		'isOverview',
		'relevance',
		'auxStratumIdList',
		'auxArchFindIdList',
		'auxSection',
		'auxSektor',
		'auxPlanum',
		'auxProfile',
		'auxObject',
		'auxGrave',
		'auxWall',
		'auxComplex',
		'comment',
		'datingPeriodId',
		'datingSpec',
	// <autogen-end
	],
});
