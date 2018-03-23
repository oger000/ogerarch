/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Arch object type detail window
*/
Ext.define('App.view.master.archObjectType.DetailWindow', {
	extend: 'Ext.window.Window',

	title: Oger._('Objekt Art/Bezeichnung'),
	width: 500,
	height: 300,
	modal: true,
	//autoScroll: true,
	layout: 'fit',

	items: [ { xtype: 'archobjecttypemasterform' } ],

	buttonAlign: 'center',
	minButtonWidth: 30,
	buttons: [
		{ text: Oger._('Speichern'),
			handler: function(button, event) {
				this.up('window').saveRecord(button, event);
			},
		},
		{ text: Oger._('Zurücksetzen'),
			handler: function(button, event) {
				Oger.extjs.resetForm(this.up('window').down('form').getForm());
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
		},
		beforeclose: function (cmp, options) {
			return Oger.extjs.confirmDirtyClose(cmp, this.down('form').getForm(), true);
		},
		close: function(cmp, options) {
			var grid = cmp.assignedGrid;
			if (grid) {
				var store = grid.getStore();
				store.load({ params: { start: 0, limit: 0 } });
			}
		},
	},

	// #########################################


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
					me.close();
				},
				failure: function(form, action) {
					if (!Oger.extjs.handleFormSubmitFailure(form, action)) {
						//handle remaining failures
					}
				}
			}
		);
	},  // eo save record

	// new record
	newRecord: function() {
		var bForm = this.down('form').getForm();
		if (Oger.extjs.formIsDirty(bForm)) {
			this.dirtyMsg();
			return;
		}
		Oger.extjs.emptyForm(bForm, true);
		Oger.extjs.resetDirty(bForm);
	},

	// edit record
	editRecord: function(id) {
		if (!id) {
			this.newRecord();
			return;
		}
		var pForm = this.down('form');
		pForm.load({ url: pForm.url, params: { _action: 'loadRecord', id: id } });
	},


});
