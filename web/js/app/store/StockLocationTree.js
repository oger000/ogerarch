/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/*
 * ATTENTION
 * see OgerTreeStore for BUG info when using { type: ... } for tree stores
 */


/**
*/
Ext.define('App.store.StockLocationTree', {
	//extend: 'Ext.data.TreeStore',
	extend: 'App.store.OgerTreeStore',
	alias: 'store.stockLocationTree',

	model: 'App.model.StockLocation',

	nodeParam: 'stockLocationId',  // name of id for server requests

	defaultRootId: '1',

	// fake children for root node to avoid tree loading if the root node is
	// hidden in a tree panel. Explicit loading (eg. in beforerender listener
	// will overwrite the empty children.

	root: {
		expanded: true,
		id: '1',
		text: "DefaultRootOfStoreDefine",
		root: true,
		children: [],  // we need this to avoid loading at app start
	},

	proxy: {
		type: 'ajax', url: 'php/scripts/stockLocation.php',
		reader: { type: 'json' },
	},


});
