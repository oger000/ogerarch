/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
*/
Ext.define('App.store.StockLocationTypes', {
	extend: 'Ext.data.Store',

	model: 'App.model.StockLocationType',

	proxy: {
		type: 'ajax', url: 'php/scripts/stockLocationType.php', extraParams: { _action: 'loadGrid' },
		reader: { type: 'json', rootProperty: 'data' }
	},
});
