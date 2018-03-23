/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Arch object group types for all categories
*/
Ext.define('App.store.ArchObjGroupTypes', {
	extend: 'Ext.data.Store',

	fields: [ 'id', 'name', 'code' ],
	proxy: {
		type: 'ajax', url: 'php/scripts/archObjGroupType.php?_action=loadList',
		reader: { type: 'json', rootProperty: 'data' }
	},
});
