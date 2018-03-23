/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Excavation window
*/
Ext.define('App.view.inputCenter.excavation.Window', {
	extend: 'Ext.window.Window',

	title: Oger._('Grabung'),
	width: 500,
	height: 500,
	modal: true,
	//autoScroll: true,
	layout: 'fit',

	//items: [ Ext.create('App.view.excavation.Form')  ],  // works frist time, then throws exception
	//items: [ Cache.get('excavForm') ],  // works first time, then shows empty form
	items: [ { xtype: 'ic_excavform' } ],  // works for now

	buttonAlign: 'center',
	minButtonWidth: 30,
	buttons: [
		{ text: Oger._('&lt;F'),
			handler: function(button, event) {
				this.up('window').jumpOffset(-1, true, button, event);
			}
		},
		{ text: Oger._('<'),
			handler: function(button, event) {
				this.up('window').jumpOffset(-1, false, button, event);
			}
		},
		{ text: Oger._('Speichern'),
			handler: function(button, event) {
				this.up('window').saveRecord(button, event);
			}
		},
		{ text: Oger._('Speichern + Neu'),
			handler: function(button, event) {
				this.up('window').saveAndNewRecord(button, event);
			}
		},
		{ text: Oger._('Neu'),
			handler: function(button, event) {
				this.up('window').newRecord(button,event);
			}
		},
		{ text: Oger._('Zurücksetzen'),
			handler: function(button, event) {
				this.up('window').resetRecord(button, event);
			}
		},
		{ text: Oger._('>'),
			handler: function(button, event) {
				this.up('window').jumpOffset(1, false, button, event);
			}
		},
		{ text: Oger._('F&gt;'),
			handler: function(button, event) {
				this.up('window').jumpOffset(1, true, button, event);
			}
		},
	],  // eo buttons

	listeners: {
		afterrender: function(cmp, options) {
			cmp.alignTo(Ext.ComponentQuery.query('mainviewport')[0], 'c-c?');
		},
		beforeclose: function (cmp, options) {
			return Oger.extjs.confirmDirtyClose(cmp, this.getBasicForm());
		},
		close: function(cmp, options) {
			var grid = cmp.assignedGrid;
			if (grid) {
				var store = grid.getStore();
				store.loadPage(store.currentPage);
			}
		},
	},

	// ####################################

	// get corresponding form panel
	getFormPanel: function() {
		return this.down('form');
	},
	// get corresponding base form
	getBasicForm: function() {
		return this.getFormPanel().getForm();
	},

	// new record
	newRecord: function() {
		var formPanel = this.getFormPanel();
		if (Oger.extjs.formIsDirty(formPanel)) {
			this.dirtyMsg();
			return;
		}
		Oger.extjs.emptyForm(this.getBasicForm(), true);
	},

	// edit record
	editRecord: function(id) {
		if (!id) {
			this.newRecord();
			return;
		}
		var formPanel = this.getFormPanel();
		formPanel.load({ url: formPanel.url, params: { _action: 'loadRecord', id: id } });
	},

	// load/edit record with offset x to current
	jumpOffset: function(offset, useFilter) {
		var me = this;
		var pForm = me.down('form');
		var bForm = pForm.getForm();
		if (Oger.extjs.formIsDirty(pForm)) {
			me.confirmDirtyAction(pForm, function() { me.jumpOffset(offset, useFilter) });
			return;
		}
		var action = 'jumpOffset';
		var filter = "";
		if (useFilter) {
			action = 'jumpOffsetFilter';
			var store = me.assignedGrid.getStore();
			var filters = store.getFilters().getRange();  // store.filters.items
			var filtersOut = [];
			for (var i=0; i<filters.length; i++) {
				var f = filters[i];
				filtersOut.push({ property: f.getProperty(), value: f.getValue() });
			}
			filter = Ext.JSON.encode(filtersOut);
		}
		var id = bForm.findField('id').getValue();
		//bForm.findField('dbAction').setValue('UPDATE');
		pForm.load({ url: pForm.url, params: { _action: action, id: id, __OFFSET__: offset, filter: filter } });
	},  // eo jump offset

	// save record
	saveRecord: function(button, event, callback) {
		var me = this;
		var formPanel = me.getFormPanel();
		var id = me.getBasicForm().findField('id').getValue();
		formPanel.submit(
			{ params: { _action: 'save', dbAction: (id ?  'UPDATE' : 'INSERT') },
				clientValidation: true,
				success: function(form, action) {
					if (!Oger.extjs.actionSuccess(action)) {
						return;
					}
					Oger.extjs.resetDirty(form);
					var mb = Ext.Msg.alert(Oger._('Hinweis'), Oger._('Datensatz erfolgreich gespeichert.'));
					Ext.Function.defer(Ext.Msg.hide, 1000, Ext.Msg);
					if (!id) {
						me.getBasicForm().findField('id').setValue(action.result.data.id);
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

	// save record and new record
	saveAndNewRecord: function(button, event) {
		var me = this;
		var fn = function() {
			Ext.Function.defer(me.newRecord, 100, me);
		};
		this.saveRecord(button, event, fn);
	},  // eo save record + new

	// reset form
	resetRecord: function() {
		var formPanel = this.getFormPanel();
		Oger.extjs.resetForm(formPanel);
	},

	// show dirty form message
	dirtyMsg: function(msg) {
		if (!msg) {
			msg = Oger._('Bitte zuerst Änderungen speichern oder zurücksetzen.');
		}
		Ext.Msg.alert(Oger._('Warnung'), msg);
	}

});
