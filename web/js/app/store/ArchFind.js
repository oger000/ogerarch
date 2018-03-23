/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


Ext.define('App.store.ArchFind', {
	extend: 'App.store.OgerStore',
	alias: 'store.archFind',

	model: 'App.model.ArchFind',

	proxy: {
		type: 'ajax', url: 'php/scripts/archFind.php',
		extraParams: { _action: 'loadList' },
		reader: { type: 'json', rootProperty: 'data' },
	},

});
