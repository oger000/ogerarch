/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Arch find window
*/
Ext.define('App.view.inputCenter.archFind.Window', {
	extend: 'Ext.window.Window',
	alias: 'widget.ic_archfindwindow',

	title: Oger._('Fund'),
	width: 700,
	height: 500,
	// modal: true,
	//autoScroll: true,
	layout: 'fit',

	items: [ { xtype: 'ic_archfindform' } ],

	buttonAlign: 'center',
	minButtonWidth: 30,
	buttons: [
		{ text: Oger._('&lt;F'),
			handler: function() {
				this.up('window').jumpOffset(-1, true);
			}
		},
		{ text: Oger._('<'),
			handler: function() {
				this.up('window').jumpOffset(-1, false);
			}
		},
		{ text: Oger._('Speichern'),
			handler: function() {
				this.up('window').saveRecord();
			}
		},
		{ text: Oger._('Speichern + Neu'),
			handler: function() {
				this.up('window').saveAndNewRecord();
			}
		},
		{ text: Oger._('Neu'),
			handler: function() {
				this.up('window').newRecord();
			}
		},
		{ text: Oger._('Zurücksetzen'),
			handler: function() {
				this.up('window').resetRecord();
			}
		},
		{ text: Oger._('>'),
			handler: function() {
				this.up('window').jumpOffset(1, false);
			}
		},
		{ text: Oger._('F&gt;'),
			handler: function() {
				this.up('window').jumpOffset(1, true);
			}
		},
	],  // eo buttons

	listeners: {
		beforerender: function(cmp, options) {
			if (!cmp.gluePanel) {
				cmp.gluePanel = Ext.ComponentQuery.query('inputcenterpanel')[0];
			}
		},
		afterrender: function(cmp, options) {
			cmp.alignTo(Ext.ComponentQuery.query('mainviewport')[0], 'c-c?');
			/*
			var form = cmp.query('component[isPlanumPanel]')[0];
			if (cmp.gluePanel.excavRecord.data.excavMethodId == EXCAVMETHODID_PLANUM) {
				form.enable();
			}
			else {
				form.disable();
			}
			*/
		},
		beforeclose: function (cmp, options) {
			return Oger.extjs.confirmDirtyClose(cmp, cmp.down('form'));
		},
		close: function(cmp, options) {
			var grid = this.assignedGrid;
			if (grid) {
				var store = grid.getStore();
				store.loadPage(store.currentPage);
			}
		},
	},

	// ####################################

	autoSaveDirty: true,


	// new record
	newRecord: function() {
		var me = this;
		var pForm = me.down('form');
		var bForm = pForm.getForm();
		if (Oger.extjs.formIsDirty(pForm)) {
			if (me.autoSaveDirty) {
				me.saveRecord({ callback: me.newRecord });
			}
			else {
				me.confirmDirtyAction(pForm, function() { me.newRecord() });
			}
			return;
		}
		Oger.extjs.emptyForm(bForm, true);
		bForm.findField('dbAction').setValue('INSERT');
		bForm.findField('archFindId').setReadOnly(false);
		var excavId = me.gluePanel.excavRecord.data.id;
		bForm.findField('excavId').setValue(excavId);
		Oger.extjs.resetDirty(bForm);
		// get NEXT arch find id
		Ext.Ajax.request({
			url: pForm.url,
			params: { _action: 'getNewArchFindId', excavId: excavId },
			success: function(response) {
				var responseObj = {};
				if (response.responseText) {
					responseObj = Ext.decode(response.responseText);
				}
				if (responseObj.success == true && responseObj.data.newArchFindId) {
					bForm.findField('archFindId').setValue(responseObj.data.newArchFindId);
					Oger.extjs.resetDirty(pForm);
				}
			},
			failure: Oger.extjs.handleAjaxFailure,
		});
		// try from last saved record
		if (me.gluePanel.lastSavedArchFindForm
		    && excavId == me.gluePanel.lastSavedArchFindForm) {
			bForm.findField('date').setValue(me.gluePanel.lastSavedArchFindForm.date);
			bForm.findField('fieldName').setValue(this.gluePanel.lastSavedArchFindForm.fieldName);
			bForm.findField('plotName').setValue(this.gluePanel.lastSavedArchFindForm.plotName);
			//bForm.findField('planName').setValue(this.gluePanel.lastSavedArchFindForm.planName);
		}
		// if not found try other sources
		if (!bForm.findField('date').getValue()) {
			bForm.findField('date').setValue(new Date());
		}
		if (!bForm.findField('fieldName').getValue()) {
			bForm.findField('fieldName').setValue(this.gluePanel.excavRecord.data.fieldName);
		}
		if (!bForm.findField('plotName').getValue()) {
			bForm.findField('plotName').setValue(this.gluePanel.excavRecord.data.plotName);
		}
		Oger.extjs.resetDirty(pForm);
	},  // eo new record


	// edit record
	editRecord: function(archFindId) {
		var me = this;
		if (!archFindId) {
			me.newRecord();
			return;
		}
		var excavId = me.gluePanel.excavRecord.data.id;
		var pForm = me.down('form');
		var bForm = pForm.getForm();
		pForm.load({ params: { _action: 'loadRecord', excavId: excavId, archFindId: archFindId } });
	},


	// load/edit record with offset x to current
	jumpOffset: function(offset, useFilter) {
		var me = this;
		var pForm = me.down('form');
		var bForm = pForm.getForm();
		if (Oger.extjs.formIsDirty(pForm)) {
			if (me.autoSaveDirty) {
				me.saveRecord({ callback: function() { me.jumpOffset(offset, useFilter) } });
			}
			else {
				me.confirmDirtyAction(pForm, function() { me.jumpOffset(offset, useFilter) });
			}
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
		var archFindId = bForm.findField('archFindId').getValue();
		pForm.load({ params: { _action: action, excavId: me.gluePanel.excavRecord.data.id,
													 archFindId: archFindId, __OFFSET__: offset, filter: filter } });
	},  // eo jump offset


	// save record
	saveRecord: function(opts) {
		var me = this;
		if (!opts) {
			opts = {};
		}
		var pForm = me.down('form');
		var bForm = pForm.getForm();
		pForm.submit(
			{ params: { _action: 'save' },
				clientValidation: true,
				success: function(form, action) {
					Oger.extjs.resetDirty(form);
					var mb = Ext.create('Oger.extjs.MessageBox').alert(Oger._('Hinweis'), Oger._('Datensatz erfolgreich gespeichert.'));
					Ext.Function.defer(function() { mb.hide(); me.focus(); }, MSG_DEFER);
					me.gluePanel.lastSavedArchFindForm = form.getFieldValues();

					// remember saved arch finds for printing
					var pos = me.assignedGrid.unprintQueueAt(action.result.data.archFindId);
					if (pos == -1) {
						me.assignedGrid.unprintQueue.unshift(action.result.data.archFindId);
						while (me.assignedGrid.unprintQueue.length > 9) {
							me.assignedGrid.unprintQueue.pop();
						}
					}

					// set callback
					// this after load callback is an UGLY HACK, but dont know better
					// When setting the callback at form level, the this scope changes,
					// so we do it at window level
					if (typeof(opts.callback) == 'function') {
						me.afterLoadCallback = opts.callback;
					}

					// reload saved record from db to update m:n relations
					pForm.load({ params: { _action: 'loadRecord',
																 excavId: bForm.findField('excavId').getValue(),
																 archFindId: bForm.findField('archFindId').getValue() }
										});
				},
				failure: function(form, action) {
					if (!Oger.extjs.handleFormSubmitFailure(form, action)) {
						//handle remaining failures
					}
				}
			}
		);
	},  // eo save record confirmed


	// save record and new record
	saveAndNewRecord: function() {
		var me = this;
		me.saveRecord({ callback: me.newRecord });
	},  // eo save record + new


	// print arch find sheet
	printFindSheet: function() {
		var me = this;
		var pForm = me.down('form');
		var bForm = pForm.getForm();

		var vals = bForm.getValues();
		Ext.Object.merge(vals, { _action: 'printFindSheet' }, Ext.Ajax.getExtraParams());

		var urlStr = pForm.url + '?' + Ext.Object.toQueryString(vals);
		window.open(urlStr,
								'ARCHFINDSHEET',
								'left=' + Math.floor(window.innerWidth * 0.1) + ',top=' + Math.floor(window.innerHeight * 0.1) +
								',width=' + Math.floor(window.innerWidth * 0.8) + ',height=' + Math.floor(window.innerHeight * 0.8));
		// remove arch find id from unprinted queue
		me.assignedGrid.unprintQueueRemove(bForm.findField('archFindId').getValue());
	},  // eo print sheet


	// reset form
	resetRecord: function() {
		var me = this;
		var pForm = me.down('form');
		Oger.extjs.resetForm(pForm);
	},


	// save record and print arch find sheet
	saveAndPrint: function() {
		var me = this;
		var pForm = me.down('form');
		var bForm = pForm.getForm();
		if (!bForm.isValid()) {
			Ext.Msg.alert(Oger._('Hinweis'), Oger._('Fehler im Formular.'));
			return;
		}
		if (Oger.extjs.formIsDirty(bForm)) {
			me.saveRecord({ callback: me.printFindSheet });
			return;
		}
		else {
			me.printFindSheet();
		}
	},  // eo save record + print


	// print multiple arch find sheets
	multiPrint: function() {
		var me = this;
		var pForm = me.down('form');
		var bForm = pForm.getForm();
		if (Oger.extjs.formIsDirty(pForm)) {
			me.saveRecord({ callback: me.multiPrint });
			return;
		}
		if (!bForm.isValid()) {
			Ext.Msg.alert(Oger._('Hinweis'), Oger._('Fehler im Formular.'));
			return;
		}
		var win = Ext.create('App.view.inputCenter.archFind.MultiPrintWindow');
		win.assignedGrid = me.assignedGrid;
		win.down('form').getForm().findField('excavId').setValue(me.gluePanel.excavRecord.data.id);
		win.down('form').getForm().findField('archFindId0').setValue(me.down('form').getForm().findField('archFindId').getValue());
		win.show();
	},  // eo save record + print


	// jump to record
	jumpToRecord: function(archFindId) {
		var me = this;
		var pForm = me.down('form');
		var bForm = pForm.getForm();
		if (!archFindId) {
			archFindId = bForm.findField('jumpToArchFindId').getValue();
		}
		if (Oger.extjs.formIsDirty(bForm)) {
			if (me.autoSaveDirty) {
				bForm.preserveJumpToId = true;
				me.saveRecord({ callback: function() { me.jumpToRecord(archFindId) } });
			}
			else {
				me.confirmDirtyAction(pForm, function() { me.jumpToRecord(archFindId) });
			}
			return;
		}
		if (!archFindId) {  // default to reload
			archFindId = bForm.findField('archFindId').getValue();
		}
		if (!archFindId) {
			Ext.Msg.alert(Oger._('Warnung'), Oger._('Keine Fundnummer als Sprungziel angegeben.'));
			return;
		}
		var excavId = me.gluePanel.excavRecord.data.id;
		pForm.load({ params: { _action: 'loadRecord', excavId: excavId, archFindId: archFindId } });
	},  // eo jum to record


	// confirm dirty action
	confirmDirtyAction: function(form, nextFn) {
		var me = this;
		Oger.extjs.confirmDirtyAction({
			form: form,
			msg: Oger._('\nUngespeicherte Änderungen vorhanden.\n\nJetzt Speichern?'),
			yesFn: function() { me.saveRecord({ callback: nextFn }) },
			noText: Oger._('Verwerfen'),
			noFn: function() { Oger.extjs.resetForm(form); nextFn() },
		});
	},  // eo confirm dirty action


});
