/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Arch object group type grid
*/
Ext.define('App.view.master.archObjGroupType.Grid', {
	extend: 'Ext.grid.Panel',
	alias: 'widget.archobjgrouptypemastergrid',

	stripeRows: true,
	autoScroll: true,

	sortableColumns: false,
	store: Ext.create('App.store.ArchObjGroupTypes'),
	columns: [
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
