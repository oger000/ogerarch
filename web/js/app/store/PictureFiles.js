/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Picture files store
*/
Ext.define('App.store.PictureFiles', {
	extend: 'Ext.data.Store',

	fields: [ 'id', 'excavId', 'fileName', 'fileSize', 'date', 'title', 'isOverview', 'relevance',
						'auxStratumIdList', 'auxArchFindIdList',
						'auxSection', 'auxSektor', 'auxPlanum', 'auxProfile', 'auxObject', 'auxGrave', 'auxWall', 'auxComplex' ],
	proxy: {
		type: 'ajax', url: 'php/scripts/pictureFile.php?_action=loadList',
		reader: { type: 'json', rootProperty: 'data' }
	},
});
