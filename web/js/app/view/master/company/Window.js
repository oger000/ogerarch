/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Company window
*/
Ext.define('App.view.master.company.Window', {
	extend: 'Ext.window.Window',

	title: Oger._('Firma'),
	width: 500,
	height: 500,
	modal: true,
	//autoScroll: true,
	layout: 'fit',

	items: [ { xtype: 'companymasterform' } ],

	buttonAlign: 'center',
	minButtonWidth: 30,
	buttons: [
		{ text: Oger._('Speichern'),
			handler: function(button, event) {
				this.up('window').saveRecord(button, event);
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
			this.loadRecord();
		},
		beforeclose: function (cmp, options) {
			return Oger.extjs.confirmDirtyClose(cmp, this.down('form').getForm());
		},
		close: function(cmp, options) {
			var grid = cmp.assignedGrid;
			if (grid) {
				var store = grid.getStore();
				store.load({ params: { start: 0, limit: store.pageSize } });
			}
		},
	},

	// ####################################


	// save record
	saveRecord: function(button, event, callback) {
		var me = this;
		var pForm = me.down('form');
		var bForm = pForm.getForm();
		var id = bForm.findField('id').getValue();
		pForm.submit(
			{ url: pForm.url,
				params: { _action: 'save', dbAction: (id ?  'UPDATE' : 'INSERT') },
				clientValidation: true,
				success: function(form, action) {
					Oger.extjs.resetDirty(form);
					var mb = Ext.Msg.alert(Oger._('Hinweis'), Oger._('Datensatz erfolgreich gespeichert.'));
					Ext.Function.defer(Ext.Msg.hide, 1000, Ext.Msg);
					if (!id) {
						bForm.findField('id').setValue(action.result.data.id);
						Oger.extjs.resetDirty(form);
					}
					if (typeof(callback) == 'function') {
						callback();
					}
				},
				failure: function(form, action) {
					if (!Oger.extjs.handleFormSubmitFailure(form, action)) {
						//handle remaining failures
					}
				}
			}
		);
	},  // eo save record

	// load record
	// there is only ONE record so we do not need more parameters
	loadRecord: function() {
		var pForm = this.down('form');
		pForm.load({ url: pForm.url, params: { _action: 'loadRecord' } });
	},  // eo load record

});
