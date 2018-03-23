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
Ext.define('App.view.system.user.GridWin', {
	extend: 'Ext.window.Window',
	alias: 'widget.systemUserGridWin',

	controller: 'systemUserGridWin',

	title: Oger._('Userliste'),
	width: 700, height: 500,
	autoScroll: true,
	layout: 'fit',

	items: [
		{ xtype: 'grid', reference: 'theGrid',

			stripeRows: true,
			columnLines: true,
			autoScroll: true,

			store: {
				type: 'user', pageSize: 0, autoLoad: true,
				remoteSort: true, remoteFilter: true,
			},

			columns: [
				{ header: Oger._('Id'), dataIndex: 'userId', width: 50 },
				{ header: Oger._('Logon User'), dataIndex: 'logonName', width: 150 },
				{ header: Oger._('Person Name'), dataIndex: 'realName', width: 250 },
				{ header: Oger._('Logon'), dataIndex: 'logonPerm', width: 50 },
				{ header: Oger._('Super'), dataIndex: 'superPerm', width: 50 },
				//{ header: Oger._('TestDatum'), dataIndex: 'testDate' },
			],

			listeners: {
				itemdblclick: 'onItemDblClick',
			},


			// filter at top
			tbar: [
				{ xtype: 'form', reference: 'filterForm',
					height: 20, width: 300,
					layout: 'hbox',
					border: false,
					bodyStyle: 'background-color:#d3e1f1',

					items: [

						{ xtype: 'fieldcontainer', layout: 'hbox',
							items: [

								{ text: Oger._('Filter'),	xtype: 'button',
									menu: {
										xtype: 'menu', width: 100, plain: true,
										items: [
											{ text: Oger._('Vorschlag'), handler: 'defaultFilter' },
											{ text: Oger._('Zurücksetzen'), handler: 'resetFilter' },
											{ text: Oger._('Anwenden'), handler: 'applyFilter' },
										],
									},
								},

								{ xtype: 'tbspacer', width: 20 },
								{ name: 'filterText', fieldLabel: Oger._('Text'), xtype: 'textfield',
									labelWidth: 30, width: 200,
									listeners: {
										dirtychange: 'onFilterDirtyChange',
									},
								},
							],
						},
					],
				},
			],  // eo tbar


			// paging bar on the bottom
			bbar: {
				layout: { pack: 'center' },
				items: [
					'->',
					'-', { text: 'Neu', handler: 'newRecord' },
					'-', { text: 'Bearbeiten', handler: 'editRecord' },
					'-', { text: 'Löschen', handler: 'deleteRecord' },
					'-',
					'->',
					'-', { xtype: 'ux_gridinfotoolbar' },
				],
			},

		},  // eo grid
	],

	buttonAlign: 'center',
	minButtonWidth: 30,
	buttons: [
		{ text: Oger._('Filter Anwenden'), handler: 'applyFilter' },
		{ text: Oger._('Schliessen'), handler: 'closeWindow' },
	],


	listeners: {
		afterrender: 'onAfterRender',
	},


});
