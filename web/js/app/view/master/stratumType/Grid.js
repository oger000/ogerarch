/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Excavation grid
*/
Ext.define('App.view.master.stratumType.Grid', {
	extend: 'Ext.grid.Panel',
	alias: 'widget.stratumtypemastergrid',

	stripeRows: true,
	autoScroll: true,

	sortableColumns: false,
	store: Ext.create('App.store.StratumTypes'),
	columns: [
		{ header: Oger._('Kategorie'), dataIndex: 'categoryName' },
		{ header: Oger._('Art/Bezeichnung'), dataIndex: 'name' },
		{ header: Oger._('Code'), dataIndex: 'code' },
	],

	listeners: {
		/*
		beforerender: function(cmp, opts) {
			cmp.getStore().load();
		},
		*/
		itemdblclick: function(view, record, item, index, event, options) {
			this.up('window').editRecord();
		},
	},

});
