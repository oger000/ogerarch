/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Stratum category store
*/
Ext.define('App.store.StratumCategories', {
	extend: 'Ext.data.Store',
  alias: 'store.stratumCategories',

	fields: [ 'id', 'name' ],
	proxy: {
		type: 'ajax', url: 'php/scripts/stratumCategory.php',
		extraParams: { _action: 'loadList' },
		reader: { type: 'json', rootProperty: 'data' }
	},
});
