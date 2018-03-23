/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


Ext.define('App.store.###TABLE_NAME_UC1###', {
	extend: 'App.store.OgerStore',
	alias: 'store.###TABLE_NAME###',

	model: 'App.model.###TABLE_NAME_UC1###',

	proxy: {
		type: 'ajax', url: 'php/scripts/###TABLE_NAME###.php',
		extraParams: { _action: 'loadGrid' },
		reader: { type: 'json', rootProperty: 'data' },
	},

});
