/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Stratum (quick matrix only)
*/
Ext.define('App.store.QMatrix', {
	extend: 'App.store.Stratums',
	alias: 'qmatrix',

	model: 'App.model.Stratum',

	proxy: {
		type: 'ajax', url: 'php/scripts/stratum.php',
		extraParams: { _action: 'loadQMatrixList' },
		reader: { type: 'json', rootProperty: 'data' }
	},
});
