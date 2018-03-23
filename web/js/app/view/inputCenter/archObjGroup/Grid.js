/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/



/**
* Arch object group grid
*/
Ext.define('App.view.inputCenter.archObjGroup.Grid', {
	extend: 'Ext.grid.Panel',
	alias: 'widget.ic_archobjgroupgrid',

	stripeRows: true,
	autoScroll: true,

	sortableColumns: false,
	store: Ext.create('App.store.ArchObjGroups'),
	columns: [
		{ header: Oger._('Gr'), dataIndex: 'excavId', width: 30, hidden: true },
		{ header: Oger._('Grabung'), dataIndex: 'excavName', hidden: true },
		{ header: Oger._('Nummer'), dataIndex: 'archObjGroupId', width: 50 },
		{ header: Oger._('Art/Bezeichnung'), dataIndex: 'typeName', width: 150 },
		{ header: Oger._('Art-Zähler'), dataIndex: 'typeSerial', width: 50, hidden: true },
		{ header: Oger._('Objektliste'), dataIndex: 'archObjectIdList', width: 200 },
		{ header: Oger._('Datierung'), dataIndex: 'datingSpec' },
	],

	// paging bar on the bottom
	bbar: {
		xtype: 'pagingtoolbar',
		displayInfo: true,
		items: [
			'-',
			{ text: 'Öffnen',
				handler: function() {
					this.up('panel').editRecord();
				}
			},
			'-',
			{ text: 'Umbenennen',
				disabled: true,
			},
			'-',
			{ text: 'Löschen',
				handler: function() {
					this.up('panel').deleteRecord();
				}
			},
		],
	},

	listeners: {
		render: function(cmp, options) {
			cmp.down('pagingtoolbar').bindStore(this.getStore());
		},
		itemdblclick: function(view, record, item, index, event, options) {
			this.editRecord(record.data.id);
		},
	},

	// edit current record or add new  if none selected
	'editRecord': function(id) {
		if (!id) {
			var record = this.getSelectionModel().getSelection()[0];
			if (record) {
				id = record.data.id;
			}
		}

		// show existing window if present
		var win = Ext.ComponentQuery.query('ic_archobjgroupwindow')[0];
		if (!win) {
			win = Ext.create('App.view.inputCenter.archObjGroup.Window');
			win.assignedGrid = this;
			win.gluePanel = this.gluePanel;
		}

		if (!Oger.extjs.formIsDirty(win.down('form').getForm())) {
			if (id) {
				win.editRecord(id);
			}
			else {
				win.newRecord();
			}
		}

		win.show();

	},  // eo edit record

	// delete current record
	'deleteRecord': function() {
		var me = this;

		var editWin = Ext.ComponentQuery.query('ic_archobjgroupwindow')[0];
		if (editWin) {
			Ext.Msg.alert(Oger._('Fehler'), Oger._('Bitte zuerst das Objektgruppen Eingabefenster schliessen.'));
			return;
		}
		var record = me.getSelectionModel().getSelection()[0];
		if (!record) {
			Ext.Msg.alert(Oger._('Fehler'), Oger._('Bitte zuerst eine Objektgruppe aus der Liste auswählen.'));
			return;
		}

		// show delete window
		var win = Ext.create('App.view.inputCenter.archObjGroup.DeleteWindow');
		win.assignedGrid = me;
		win.record = record;
		win.show();

	},  // eo delete record


});
