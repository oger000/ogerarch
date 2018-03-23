/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Stratum type detail window
*/
Ext.define('App.view.master.stratumType.GridWindow', {
	extend: 'Ext.window.Window',

	title: Oger._('Stratum Art/Bezeichnung'),
	width: 750,
	height: 500,
	modal: true,
	//autoScroll: true,
	layout: 'fit',

	items: [ { xtype: 'stratumtypemastergrid' } ],

	buttonAlign: 'center',
	minButtonWidth: 30,
	buttons: [
		{ text: Oger._('Bearbeiten'),
			handler: function(button, event) {
				this.up('window').editRecord();
			}
		},
		{ text: Oger._('Neuanlage'),
			handler: function(button, event) {
				this.up('window').newRecord();
			}
		},
		{ text: Oger._('Schliessen'),
			handler: function(button, event) {
				this.up('window').close();
			}
		},
	],  // eo buttons

	listeners: {
		afterrender: function(cmp, options) {
			cmp.alignTo(Ext.ComponentQuery.query('mainviewport')[0], 'c-c?');
			cmp.down('grid').getStore().load({ params: { start: 0, limit: 0 } });
		},
		close: function(cmp, options) {
			// if inputcenter panel is present than reload the stratum type store
			var inputCenterPanel = Ext.ComponentQuery.query('inputcenterpanel')[0];
			if (inputCenterPanel) {
				inputCenterPanel.stratumTypeStore.clearFilter();
				inputCenterPanel.stratumTypeStore.load({ params: { start: 0, limit: 0 } });
			}
		},
	},

	// #########################################


	// edit current record
	'editRecord': function() {
		var record = this.down('grid').getSelectionModel().getSelection()[0];
		if (!record) {
			Ext.Msg.alert(Oger._('Hinweis'), Oger._('Bitte zuerst eine Art/Bezeichnung auswählen.'));
			return;
		}
		this.showDetailWindow(record.data.id);
	},

	// add new  if none selected
	'newRecord': function() {
		this.down('grid').getSelectionModel().deselectAll();
		this.showDetailWindow();
	},

	// show detail window
	'showDetailWindow': function(id) {

		var win = Ext.create('App.view.master.stratumType.DetailWindow');
		win.assignedGrid = this.down('grid');
		win.show();
		if (id) {
			win.editRecord(id);
		}
		else {
			win.newRecord();
		}
	},




});
