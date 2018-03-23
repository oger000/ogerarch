/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Arch object window
*/
Ext.define('App.view.inputCenter.archObject.Window', {
	extend: 'Ext.window.Window',
	alias: 'widget.ic_archobjectwindow',

	title: Oger._('Objekt'),
	width: 700,
	height: 500,
	//modal: true,
	//autoScroll: true,
	layout: 'fit',

	items: [ { xtype: 'ic_archobjectform' } ],

	buttonAlign: 'center',
	minButtonWidth: 30,
	buttons: [
		{ text: Oger._('|<'),
			tooltip: Oger._('Erster Eintrag'),
			handler: function(button, event) {
				this.up('window').firstRecord(button, event);
			}
		},
		{ text: Oger._('<'),
			handler: function(button, event) {
				this.up('window').previousRecord(button, event);
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
				this.up('window').nextRecord(button, event);
			}
		},
		{ text: Oger._('>|'),
			handler: function(button, event) {
				this.up('window').lastRecord(button, event);
			}
		},
	],  // eo buttons

	listeners: {
		afterrender: function(cmp, options) {
			cmp.alignTo(Ext.ComponentQuery.query('mainviewport')[0], 'c-c?');
		},
		beforeclose: function (cmp, options) {
			return Oger.extjs.confirmDirtyClose(cmp, cmp.down('form'));
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


	// new record
	newRecord: function() {
		var me = this;
		var pForm = me.down('form');
		var bForm = pForm.getForm();
		if (Oger.extjs.formIsDirty(pForm)) {
			me.confirmDirtyAction(pForm, function() { me.newRecord() });
			return;
		}
		Oger.extjs.emptyForm(bForm, true);
		var excavId = this.gluePanel.excavRecord.data.id;
		bForm.findField('excavId').setValue(excavId);
		bForm.fireEvent('actioncomplete', bForm, { type: 'load' });
		// get NEXT arch object id
		Ext.Ajax.request({
			url: pForm.url,
			params: { _action: 'getNewArchObjectId', excavId: excavId },
			success: function(response) {
				var responseObj = {};
				if (response.responseText) {
					responseObj = Ext.decode(response.responseText);
				}
				if (responseObj.success == true && responseObj.data.newArchObjectId) {
					bForm.findField('archObjectId').setValue(responseObj.data.newArchObjectId);
					Oger.extjs.resetDirty(pForm);
				}
			},
			failure: Oger.extjs.handleAjaxFailure,
		});
		Oger.extjs.resetDirty(bForm);
	},  // eo new record

	// edit record
	editRecord: function(id) {
		var me = this;
		if (!id) {
			me.newRecord();
			return;
		}
		var pForm = me.down('form');
		pForm.load({ url: pForm.url, params: { _action: 'loadRecord', id: id } });
	},


	// edit first record
	firstRecord: function() {
		var me = this;
		var pForm = me.down('form');
		if (Oger.extjs.formIsDirty(pForm)) {
			me.confirmDirtyAction(pForm, function() { me.firstRecord() });
			return;
		}
		var id = pForm.getForm().findField('id').getValue();
		pForm.load({ url: pForm.url, params: { _action: 'loadRecord', excavId: me.gluePanel.excavRecord.data.id, jumpTo: 'first' } });
	},

	// edit last record
	lastRecord: function() {
		var me = this;
		var pForm = me.down('form');
		if (Oger.extjs.formIsDirty(pForm)) {
			me.confirmDirtyAction(pForm, function() { me.lastRecord() });
			return;
		}
		var id = pForm.getForm().findField('id').getValue();
		pForm.load({ url: pForm.url, params: { _action: 'loadRecord', excavId: me.gluePanel.excavRecord.data.id, jumpTo: 'last' } });
	},

	// edit previous record
	previousRecord: function() {
		var me = this;
		var pForm = me.down('form');
		if (Oger.extjs.formIsDirty(pForm)) {
			me.confirmDirtyAction(pForm, function() { me.previousRecord() });
			return;
		}
		var id = pForm.getForm().findField('id').getValue();
		pForm.load({ url: pForm.url, params: { _action: 'loadRecord', excavId: me.gluePanel.excavRecord.data.id,
																									 jumpTo: 'offset-1~id=' + id} });
	},  // eo prev record


	// edit next record
	nextRecord: function() {
		var me = this;
		var pForm = me.down('form');
		if (Oger.extjs.formIsDirty(pForm)) {
			me.confirmDirtyAction(pForm, function() { me.nextRecord() });
			return;
		}
		var id = pForm.getForm().findField('id').getValue();
		pForm.load({ url: pForm.url, params: { _action: 'loadRecord', excavId: me.gluePanel.excavRecord.data.id,
																									 jumpTo: 'offset+1~id=' + id} });
	},  // eo next record


	// save record
	saveRecord: function(button, event, callback) {
		var me = this;
		var pForm = me.down('form');
		var bForm = pForm.getForm();
		if (bForm.findField('id').getValue() && bForm.findField('archObjectId').originalValue &&
				bForm.findField('archObjectId').getValue() != bForm.findField('archObjectId').originalValue) {
			Ext.Msg.confirm(Oger._('Warnung'),
											Oger._('Die Objektnummer wurde geändert von ' + bForm.findField('archObjectId').originalValue +
														 ' auf ' + bForm.findField('archObjectId').getValue() + '. Ist das beabsichtigt?'),
											function(answerId) {
				if(answerId == 'yes') {
					me.saveRecordConfirmed(button, event, callback);
				}
				else {
					Ext.Msg.alert(Oger._('Warnung'), Oger._('Datensatz wurde NICHT gespeichert.'));
				}
			});
			return;  // because we do not know the answer
		};
		this.saveRecordConfirmed(button, event, callback);
	},  // eo save record pretest

	// save record confirmed
	saveRecordConfirmed: function(button, event, callback) {
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
						form.findField('id').setValue(action.result.data.id);
						Oger.extjs.resetDirty(form);
					}

					// callback or reload record from db to update m:n relations
					if (typeof(callback) == 'function') {
						callback();
					}
					else {
						me.loadRecordManually();
					}
				},
				failure: function(form, action) {
					if (!Oger.extjs.handleFormSubmitFailure(form, action)) {
						//handle remaining failures
					}
				}
			}
		);
	},  // eo confirmed save record

	// save record and new record
	saveAndNewRecord: function(button, event) {
		var me = this;
		var fn = function() {
			Ext.Function.defer(me.newRecord, 100, me);
		};
		me.saveRecord(button, event, fn);
	},  // eo save record + new

	// reset form
	resetRecord: function() {
		var me = this;
		var pForm = me.down('form');
		Oger.extjs.resetForm(pForm);
	},

	// load record manually
	loadRecordManually: function() {
		var me = this;
		var pForm = me.down('form');
		var bForm = pForm.getForm();
		if (Oger.extjs.formIsDirty(bForm)) {
			me.confirmDirtyAction(pForm, function() { me.loadRecordManually() });
			return;
		}
		var archObjectId = bForm.findField('jumpToArchObjectId').getValue();
		if (!archObjectId) {  // default to reload
			archObjectId = bForm.findField('archObjectId').getValue();
		}
		if (!archObjectId) {
			Ext.Msg.alert(Oger._('Warnung'), Oger._('Keine Objektnummer als Sprungziel angegeben.'));
			return;
		}
		var excavId = this.gluePanel.excavRecord.data.id;
		Ext.Ajax.request({
			url: pForm.url,
			params: { _action: 'loadRecord', excavId: excavId, archObjectId: archObjectId },
			success: function(response) {
				var responseObj = {};
				if (response.responseText) {
					responseObj = Ext.decode(response.responseText);
				}
				if (responseObj.success == true && responseObj.data.archObjectId == archObjectId) {
					bForm.setValues(responseObj.data);
					bForm.findField('jumpToArchObjectId').setValue('');
					Oger.extjs.resetDirty(bForm);
					bForm.fireEvent('actioncomplete', bForm, { type: 'load' });
				}
				else {
					//Ext.Msg.alert(Oger._('Antwort'), responseObj.msg);
					Ext.Msg.alert(Oger._('Antwort'), Oger._('Objektnummer ' + archObjectId + ' nicht gefunden.'));
				}
			},
			failure: Oger.extjs.handleAjaxFailure,
		});
	},  // eo load record manually


	// confirm dirty action
	confirmDirtyAction: function(form, nextFn) {
		var me = this;
		Oger.extjs.confirmDirtyAction({
			form: form,
			saveFn: function() { me.saveRecord(null, null, nextFn) },
			resetText: Oger._('Verwerfen'),
			resetFn: function() { Oger.extjs.resetForm(form); nextFn() },
		});
	},  // eo confirm dirty action


});
