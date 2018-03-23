/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


Ext.define('App.store.StratumToArchFind', {
	extend: 'App.store.OgerStore',
	alias: 'store.stratumToArchFind',

	model: 'App.model.StratumToArchFind',

	proxy: {
		type: 'ajax', url: 'php/scripts/stratumToArchFind.php',
		extraParams: { _action: 'loadGrid' },
		reader: { type: 'json', rootProperty: 'data' },
	},

});
