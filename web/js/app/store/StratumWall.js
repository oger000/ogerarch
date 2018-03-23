/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


Ext.define('App.store.StratumWall', {
	extend: 'App.store.OgerStore',
	alias: 'store.stratumWall',

	model: 'App.model.StratumWall',

	proxy: {
		type: 'ajax', url: 'php/scripts/stratumWall.php',
		extraParams: { _action: 'loadGrid' },
		reader: { type: 'json', rootProperty: 'data' },
	},

});
