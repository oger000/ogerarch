/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Arch object group store
*/
Ext.define('App.store.ArchObjGroups', {
	extend: 'Ext.data.Store',

	fields: [ 'id', 'excavId', 'archObjGroupId', 'typeName', 'typeSerial', 'archObjectIdList', 'datingSpec' ],
	proxy: {
		type: 'ajax', url: 'php/scripts/archObjGroup.php?_action=loadList',
		reader: { type: 'json', rootProperty: 'data' }
	},
});
