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
Ext.define('App.view.inputCenter.stock.prepFind.Grid', {
	extend: 'Ext.grid.Panel',
	alias: 'widget.ic_stockprepfindgrid',

	title: Oger._('Fundnummern Details'),
	rootVisible: false,
	useArrows: true,
	//stripeRows: true,
	autoScroll: true,

	viewConfig: {
		plugins: {
			ptype: 'gridviewdragdrop',
			dragGroup: 'prepFindToStockLocation',
		},
		listeners: {
			//beforedrop: 'onBeforeDrop',
		},
	},

	selModel: Ext.create('Ext.selection.CheckboxModel'),

	store: { type: 'prepFind', remoteSort: true, remoteFilter: true },

	columns: [
		{ header: Oger._('ID'), dataIndex: 'id', width: 60, hidden: true },
		{ header: Oger._('FundNr'), dataIndex: 'archFindId', width: 60 },
		{ header: Oger._('Sub'), dataIndex: 'archFindSubId', width: 40 },
		{ header: Oger._('Material'), dataIndex: 'materialNames', width: 120 },
		{ header: Oger._('Original F-Nr'), dataIndex: 'oriArchFindId', width: 60, hidden: true },
		{ header: Oger._('Lagerort'), dataIndex: 'stockLocationName', width: 100 },
		{ header: Oger._('Wasch'), dataIndex: 'washStatusId', width: 40 },
		{ header: Oger._('Beschr'), dataIndex: 'labelStatusId', width: 40 },
		{ header: Oger._('Restau'), dataIndex: 'restoreStatusId', width: 40 },
		{ header: Oger._('Foto'), dataIndex: 'photographStatusId', width: 40 },
		{ header: Oger._('Zeichn'), dataIndex: 'drawStatusId', width: 40 },
		{ header: Oger._('Gesetzt'), dataIndex: 'layoutStatusId', width: 40 },
		{ header: Oger._('Wiss.Be'), dataIndex: 'scientificStatusId', width: 40 },
		{ header: Oger._('Publi'), dataIndex: 'publishStatusId', width: 40 },
	],


	// filter panel at the top
	tbar: {
		xtype: 'form', reference: 'prepFindFilterForm',
		height: 90,
		border: false,
		collapsible: true, collapsed: true,
		autoScroll: true,
		bodyStyle: 'background-color:#d3e1f1',
		title: Oger._('Filter'),
		layout: {
			type: 'vbox',
			align : 'stretch',  pack  : 'start',
		},
		items: [
			{ xtype: 'panel', layout: 'anchor',
				//bodyPadding: '0 5 5 5',
				bodyPadding: 5,
				border: false,
				bodyStyle: 'background-color:#d3e1f1',
				items: [
					{ xtype: 'fieldcontainer', layout: 'hbox',
						items: [
							{ name: 'archFindId', xtype: 'textfield',
								fieldLabel: Oger._('Fundnummer'), labelWidth: 80,
								checkChangeBuffer: CHKCHANGE_DEFER,
								listeners: {
									change: 'onPrepFindFilterChange',
								},
							},
							{ xtype: 'tbspacer', width: 20 },
							{ name: 'archFindIdLikeFlag', xtype: 'checkbox', boxLabel: Oger._('Teilsuche'),
								inputValue: 1, uncheckedValue: 0,
								checkChangeBuffer: CHKCHANGE_DEFER,
								listeners: {
									change: 'onPrepFindFilterChange',
								},
							},
							{ xtype: 'tbspacer', width: 20 },
						],
					},
					{ name: 'searchText', xtype: 'textfield', width: 350, disabled: true,
						fieldLabel: Oger._('Textsuche'), labelWidth: 80,
						checkChangeBuffer: CHKCHANGE_DEFER,
						listeners: {
							change: 'onPrepFindFilterChange',
						},
					},
				],
			},  // eo text

		],  // eo outer form items

	},  // eo form (tbar)


	// paging bar on the bottom
	bbar: {
		//xtype: 'pagingtoolbar',
		//displayInfo: true,
		items: [
			{ xtype: 'tbseparator' },
			{ text: 'Bearbeiten', handler: 'editPrepFind' },
			{ xtype: 'tbseparator' },
			{ text: 'Massenbearbeitung', handler: 'massEditPrepFind' },
			{ xtype: 'tbseparator' },
			{ text: 'Umbenennen', handler: 'renamePrepFind' },
			{ xtype: 'tbseparator' },
			{ text: 'Löschen', handler: 'deletePrepFind' },
			{ xtype: 'tbseparator' },
			{ xtype: 'button', text: 'Alle anzeigen', handler: 'clearPrepFindFilter' },
		],
	},




});
