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
Ext.define('App.store.StockDetailsTree', {
	extend: 'Ext.data.TreeStore',

	model: 'App.model.StockLocation',

	defaultRootId: '1',

	rootProperty: {
		expanded: true,
		text: "TheStoreRoot",
	},

	proxy: {
// ATTENTION: script not implemented !!!
		type: 'ajax', url: 'php/scripts/stockDetail.php', extraParams: { _action: 'loadTree' },
		reader: { type: 'json' }
	},
});
