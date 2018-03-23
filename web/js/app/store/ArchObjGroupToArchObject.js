/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


Ext.define('App.store.ArchObjGroupToArchObject', {
	extend: 'App.store.OgerStore',
	alias: 'store.archObjGroupToArchObject',

	model: 'App.model.ArchObjGroupToArchObject',

	proxy: {
		type: 'ajax', url: 'php/scripts/archObjGroupToArchObject.php',
		extraParams: { _action: 'loadGrid' },
		reader: { type: 'json', rootProperty: 'data' },
	},

});
