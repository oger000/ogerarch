/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Arch object - arch object groups store
*/
Ext.define('App.store.ArchObjectArchObjGroups', {
	extend: 'Ext.data.Store',

	fields: [ 'id', 'excavId', 'archObjGroupId', 'typeName', 'archObjectIdList' ],
	proxy: {
		type: 'ajax', url: 'php/scripts/archObject.php?_action=loadArchObjGroupRecords',
		reader: { type: 'json', rootProperty: 'data' }
	},
});
