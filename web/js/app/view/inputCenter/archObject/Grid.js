/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/



/**
* Arch object grid
*/
Ext.define('App.view.inputCenter.archObject.Grid', {
	extend: 'Ext.grid.Panel',
	alias: 'widget.ic_archobjectgrid',

	stripeRows: true,
	autoScroll: true,

	sortableColumns: false,
	store: { type: 'archObject', remoteSort: true, remoteFilter: true },

	columns: [
		{ header: Oger._('Gr'), dataIndex: 'excavId', width: 30, hidden: true },
		{ header: Oger._('Grabung'), dataIndex: 'excavName', hidden: true },
		{ header: Oger._('Nummer'), dataIndex: 'archObjectId', width: 50, sortable: true },
		{ header: Oger._('Art/Bezeichnung'), dataIndex: 'typeName', width: 150, sortable: true },
		{ header: Oger._('Art-Zähler'), dataIndex: 'typeSerial', width: 50, hidden: true },
		{ header: Oger._('Stratumliste'), dataIndex: 'stratumIdList', width: 200 },
		{ header: Oger._('Objektgruppe'), dataIndex: 'archObjGroupIdList' },
		{ header: Oger._('Datierung'), dataIndex: 'datingSpec', sortable: true },
		{ header: Oger._('PeriodeId'), dataIndex: 'datingPeriodId', sortable: true, hidden: true },
		{ header: Oger._('Periode'), dataIndex: 'datingPeriodName', sortable: true },
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
		var win = Ext.ComponentQuery.query('ic_archobjectwindow')[0];
		if (!win) {
			win = Ext.create('App.view.inputCenter.archObject.Window');
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

		var editWin = Ext.ComponentQuery.query('ic_archobjectwindow')[0];
		if (editWin) {
			Ext.Msg.alert(Oger._('Fehler'), Oger._('Bitte zuerst das Objekt Eingabefenster schliessen.'));
			return;
		}
		var record = me.getSelectionModel().getSelection()[0];
		if (!record) {
			Ext.Msg.alert(Oger._('Fehler'), Oger._('Bitte zuerst ein Objekt aus der Liste auswählen.'));
			return;
		}

		// show delete window
		var win = Ext.create('App.view.inputCenter.archObject.DeleteWindow');
		win.assignedGrid = me;
		win.record = record;
		win.show();

	},  // eo delete record


});
