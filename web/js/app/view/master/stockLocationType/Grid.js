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
Ext.define('App.view.master.stockLocationType.Grid', {
	extend: 'Ext.grid.Panel',
	alias: 'widget.stocklocationtypemastergrid',

	stripeRows: true,
	autoScroll: true,

	sortableColumns: false,
	store: Ext.create('App.store.StockLocationTypes'),
	columns: [
		{ header: Oger._('Id'), dataIndex: 'id', hidden: true },
		{ header: Oger._('Art/Bezeichnung'), dataIndex: 'name', width: 200 },
		{ header: Oger._('Grössenklasse'), dataIndex: 'sizeClass' },
		{ header: Oger._('Für Grabung'), dataIndex: 'excavVisible' },
	],

	listeners: {
		itemdblclick: function(view, record, item, index, event, options) {
			this.up('window').editRecord();
		},
		afterrender: function(cmp, opts) {
			cmp.getStore().load();
		},
	},

});
