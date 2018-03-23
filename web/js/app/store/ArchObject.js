/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


Ext.define('App.store.ArchObject', {
	extend: 'App.store.OgerStore',
	alias: 'store.archObject',

	model: 'App.model.ArchObject',

	proxy: {
		type: 'ajax', url: 'php/scripts/archObject.php',
		extraParams: { _action: 'loadList' },
		reader: { type: 'json', rootProperty: 'data' },
	},

});
