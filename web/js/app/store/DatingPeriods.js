/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Dating periods store
*/
Ext.define('App.store.DatingPeriods', {
	extend: 'Ext.data.Store',
  alias: 'store.datingperiod',

	fields: [ 'id', 'name' ],

	proxy: {
		type: 'ajax', url: 'php/scripts/datingPeriod.php',
		extraParams: { _action: 'loadList' },
		reader: { type: 'json', rootProperty: 'data' }
	},
});
