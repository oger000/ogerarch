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
Ext.define('App.view.master.stockLocation.Grid', {
	extend: 'Ext.tree.Panel',
	alias: 'widget.stocklocationmastergrid',
	controller: 'stockLocationMasterGrid',

	rootVisible: false,
	useArrows: true,
	//stripeRows: true,
	autoScroll: true,

	viewConfig: {
		plugins: {
			ptype: 'treeviewdragdrop',
		},
		listeners: {
			beforedrop: 'onBeforeDrop',
		},
	},

	store: {
		type: 'stockLocationTree',
		// the proxy get lost by declarative store definition, so readd here
		proxy: {
			type: 'ajax', url: 'php/scripts/stockLocation.php',
			reader: { type: 'json' },
		},
		// the root entry get lost by declarative store definition, so readd here
		root: {
			expanded: true,
			id: '1',
			text: "DefaultRootOfMasterGridDefine",
			root: true,
			children: [],  // we need this to avoid loading at app start
		},
	},

	sortableColumns: false,
	columns: [
		{ header: Oger._('Name'), xtype: 'treecolumn', dataIndex: 'name', width: 300 },
		{ header: Oger._('ID'), dataIndex: 'id', hidden: true },
		//{ header: Oger._('Fund'), dataIndex: 'archFindCount', hidden: true },
		{ header: Oger._('Bearbeiten'), xtype: 'actioncolumn', width: 50,
			align: 'center', icon: 'img/famfamfam_silk/icons/application_edit.png',
			handler: function(gridView, rowIndex, colIndex, actionItem, event, record, row) {
				var cmp = this.up('treepanel');
				cmp.fireEvent('ogeractionedit', cmp, gridView, rowIndex, colIndex, actionItem, event, record, row);
			},
		},
		{ header: Oger._('Unterteilen'), xtype: 'actioncolumn', width: 50,
			align: 'center', icon: 'img/famfamfam_silk/icons/add.png',
			handler: function(gridView, rowIndex, colIndex, actionItem, event, record, row) {
				var cmp = this.up('treepanel');
				cmp.fireEvent('ogeractionadd', cmp, gridView, rowIndex, colIndex, actionItem, event, record, row);
			},
		},
	],


	bbar: [
		{ text: Oger._('Aktualisieren'), handler: 'reloadLocationGrid',
			//iconCls: Ext.baseCSSPrefix + 'tbar-loading',
		},
		{ xtype: 'tbseparator' },
		{ text: Oger._('Löschen'), handler: 'deleteLocation'},
	],


	listeners: {
		ogeractionedit: 'editRecord',
		ogeractionadd: 'addSubRecord',
	},



});
