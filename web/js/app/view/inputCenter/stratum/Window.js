/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Stratum window
*/
Ext.define('App.view.inputCenter.stratum.Window', {
	extend: 'Ext.window.Window',
	alias: 'widget.ic_stratumwindow',

	title: Oger._('Stratum'),
	width: 700,
	height: 500,
	//modal: true,
	//autoScroll: true,
	layout: 'fit',

	items: [ { xtype: 'ic_stratumform' } ],

	buttonAlign: 'center',
	minButtonWidth: 30,
	buttons: [
		{ text: Oger._('&lt;F'),
			handler: function(button, event) {
				this.up('window').jumpOffset(-1, true);
			}
		},
		{ text: Oger._('<'),
			handler: function(button, event) {
				this.up('window').jumpOffset(-1, false);
			}
		},
		{ text: Oger._('Speichern'),
			handler: function(button, event) {
				this.up('window').saveRecord();
			}
		},
		{ text: Oger._('Speichern + Neu'),
			handler: function(button, event) {
				this.up('window').saveAndNewRecord();
			}
		},
		{ text: Oger._('Neu'),
			handler: function(button, event) {
				this.up('window').newRecord();
			}
		},
		{ text: Oger._('Zurücksetzen'),
			handler: function(button, event) {
				this.up('window').resetRecord();
			}
		},
		{ text: Oger._('>'),
			handler: function(button, event) {
				this.up('window').jumpOffset(1, false);
			}
		},
		{ text: Oger._('F&gt;'),
			handler: function(button, event) {
				this.up('window').jumpOffset(1, true);
			}
		},
	],  // eo buttons

	listeners: {
		afterrender: function(cmp, options) {
			cmp.alignTo(Ext.ComponentQuery.query('mainviewport')[0], 'c-c?');
			cmp.initKeyMap(cmp);
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

	autoSaveDirty: true,


	// new record
	newRecord: function(opts) {
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

		var oldVals = bForm.getValues();

		Oger.extjs.emptyForm(bForm, true);
		pForm.adjustDetailPanel();
		bForm.findField('dbAction').setValue("INSERT");
		var excavId = this.gluePanel.excavRecord.data.id;
		bForm.findField('excavId').setValue(excavId);
		bForm.findField('stratumId').setReadOnly(false);
		// get NEXT stratum id
		Ext.Ajax.request({
			url: pForm.url,
			params: { _action: 'getNewStratumId', excavId: excavId, oldStratumId: oldVals.stratumId },
			success: function(response) {
				var responseObj = {};
				if (response.responseText) {
					responseObj = Ext.decode(response.responseText);
				}
				if (responseObj.success == true && responseObj.data.newStratumId) {
					bForm.findField('stratumId').setValue(responseObj.data.newStratumId);
					Oger.extjs.resetDirty(bForm);
				}
			},
			failure: Oger.extjs.handleAjaxFailure,
		});
		// try from last saved record
		if (this.gluePanel.lastSavedStratumForm &&
				this.gluePanel.lastSavedStratumForm.common &&
				excavId == this.gluePanel.lastSavedStratumForm.common.excavId) {
			bForm.findField('date').setValue(this.gluePanel.lastSavedStratumForm.common.date);
			bForm.findField('originator').setValue(this.gluePanel.lastSavedStratumForm.common.originator);
			bForm.findField('fieldName').setValue(this.gluePanel.lastSavedStratumForm.common.fieldName);
			bForm.findField('plotName').setValue(this.gluePanel.lastSavedStratumForm.common.plotName);
			bForm.findField('section').setValue(this.gluePanel.lastSavedStratumForm.common.section);
			bForm.findField('area').setValue(this.gluePanel.lastSavedStratumForm.common.area);
			bForm.findField('profile').setValue(this.gluePanel.lastSavedStratumForm.common.profile);
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
		if (!bForm.findField('originator').getValue()) {
			bForm.findField('originator').setValue(this.gluePanel.excavRecord.data.originator);
		}
		Oger.extjs.resetDirty(bForm);
		// set first tab active - deactivated, because some enter only matrix ...
		//me.down('tabpanel').setActiveTab(0);
	},  // eo new record


	// edit record
	editRecord: function(stratumId) {
		var me = this;
		if (!stratumId) {
			me.newRecord();
			return;
		}
		var excavId = me.gluePanel.excavRecord.data.id;
		var pForm = me.down('form');
		pForm.load({ params: { _action: 'loadRecord', excavId: excavId, stratumId: stratumId } });
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
		var stratumId = bForm.findField('stratumId').getValue();
		pForm.load({ params: { _action: action, excavId: me.gluePanel.excavRecord.data.id,
													 stratumId: stratumId, __OFFSET__: offset, filter: filter } });
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
					if (!Oger.extjs.actionSuccess(action)) {
						return;
					}
					Oger.extjs.resetDirty(form);
					var mb = Ext.create('Oger.extjs.MessageBox').alert(Oger._('Hinweis'), Oger._('Datensatz erfolgreich gespeichert.'));
					Ext.Function.defer(function() { mb.hide(); me.focus(); }, MSG_DEFER);

					// save form values of new entris as defaults for followup input
					if (!me.gluePanel.lastSavedStratumForm) {
						me.gluePanel.lastSavedStratumForm = {};
					}
					var formFieldValues = form.getFieldValues();
					me.gluePanel.lastSavedStratumForm.common = formFieldValues;
					me.updateFieldHistoryAll(formFieldValues);

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
																 stratumId: bForm.findField('stratumId').getValue() },
											});
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
	saveAndNewRecord: function() {
		var me = this;
		me.saveRecord({ callback: me.newRecord });
	},  // eo save record + new


	// reset form
	resetRecord: function() {
		var me = this;
		var pForm = me.down('form');
		Oger.extjs.resetForm(pForm);
	},


	// jump to record
	jumpToRecord: function(stratumId) {
		var me = this;
		var pForm = me.down('form');
		var bForm = pForm.getForm();
		if (!stratumId) {
			stratumId = bForm.findField('jumpToStratumId').getValue();
		}
		if (Oger.extjs.formIsDirty(bForm)) {
			if (me.autoSaveDirty) {
				bForm.preserveJumpToId = true;
				me.saveRecord({ callback: function() { me.jumpToRecord(stratumId) } });
			}
			else {
				me.confirmDirtyAction(pForm, function() { me.jumpToRecord(stratumId); me.focus(false) });
			}
			return;
		}
		if (!stratumId) {  // default to reload
			stratumId = bForm.findField('stratumId').getValue();
		}
		if (!stratumId) {
			Ext.create('Oger.extjs.MessageBox').alert(Oger._('Warnung'), Oger._('Kein Stratum als Sprungziel angegeben.'));
			return;
		}
		var excavId = this.gluePanel.excavRecord.data.id;
		pForm.load({ params: { _action: 'loadRecord', excavId: excavId, stratumId: stratumId } });
	},  // eo jump to record


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


	// update all field history stores
	updateFieldHistoryAll: function(values) {

		var me = this;

		for (var field in values) {
			var store = me.gluePanel.getFieldHistoryStore('stratum', values.categoryId, field);
			if (!store) {
				continue;
			}
			var value = values[field];
			if (!store.getById(value)) {
				store.add({ id: value, text: value });
			}
		}
	},  // eo update field history for all fields


	// init key map
	/*
	 * see: <http://extperience.wordpress.com/tag/keymap/>
	 * this is only a template for later use in initKeyMap function
	 *
	function switchTabs(e) {

		// note the items.items - no idea why
		var items = tabs.items.items;

		// grab the active tab
		var active_tab = tabs.getActiveTab();

		// grab the total number of tabs
		var total_tabs = items.length;

		// loop the tabs
		for(i = 0 ; i < items.length; i++) {
			// find the active tab based on the id property.
			if (active_tab.id == items[i].id) {
				// do we want to move left?
				if (e == Ext.EventObject.LEFT) {
					// move left
					var next = (i - 1);
					if (next < 0) {
						// we're at -1, set to last tab
						next = (total_tabs - 1);
					}
				}
				else {
					// move right
					var next = (i + 1);
					if (next >= total_tabs) {
						// we've gone 1 too many set to start position.
						next = 0;
					}
				}
				// set the tab and return there's no need to carry on
				tabs.setActiveTab(items[next].id);
				return;
			}
		}
	}
	*/
	initKeyMap: function(cmp) {

		var me = this;

		cmp.keyMap = Ext.create('Ext.util.KeyMap', {
			target: cmp.el,
			binding: [
				{
					key: [ 10, Ext.EventObject.ENTER, Ext.EventObject.RETURN ],
					ctrl: true,
					shift: false,
					alt: false,
					handler: function() {
						me.saveRecord();
					},
					//scope: this,
					defaultEventAction: 'stopEvent',
				},

				{
					key: [ 10, Ext.EventObject.ENTER, Ext.EventObject.RETURN ],
					ctrl: true,
					shift: true,
					alt: false,
					handler: function() {
						me.saveAndNewRecord();
					},
					defaultEventAction: 'stopEvent',
				},

				{
					key: [ Ext.EventObject.PAGE_DOWN ],
					ctrl: true,
					shift: false,
					alt: false,
					handler: function() {
						me.nextRecord();
					},
					defaultEventAction: 'stopEvent',
				},

				{
					key: [ Ext.EventObject.PAGE_UP ],
					ctrl: true,
					shift: false,
					alt: false,
					handler: function() {
						me.previousRecord();
					},
					defaultEventAction: 'stopEvent',
				},

				{
					key: [ Ext.EventObject.LEFT, Ext.EventObject.RIGHT ],
					ctrl: true,
					shift: false,
					alt: false,
					handler: function(ev) {
						var tabPanel = me.down('tabpanel');

						// collect data
						var tabItems = tabPanel.items.items;
						var tabCount = tabItems.length;
						var activeTab = tabPanel.getActiveTab();

						// find index of active tab
						var index = 0;
						var i;
						for(i = 0 ; i < tabCount; i++) {
							if (activeTab.id == tabItems[i].id) {
								index = i;
							}
						}

						// previous tab (cyling to last on overflow)
						if (ev == Ext.EventObject.LEFT) {
							index = index - 1;
							if (index < 0) {
								index = tabCount - 1;
							}
						}
						// next tab (cyling to first on overflow)
						if (ev == Ext.EventObject.RIGHT) {
							index = index + 1;
							if (index >= tabCount) {
								index = 0;
							}
						}

						// set active tab
						tabPanel.setActiveTab(index);
					},
					defaultEventAction: 'stopEvent',
				},

				{
					key: [ Ext.EventObject.ONE ],
					ctrl: false,
					shift: false,
					alt: true,
					handler: function(ev) {
						me.down('tabpanel').setActiveTab(0);
					},
					defaultEventAction: 'stopEvent',
				},
				{
					key: [ Ext.EventObject.S ],
					ctrl: false,
					//shift: false,
					alt: true,
					handler: function(ev) {
						me.down('form').getForm().findField('jumpToStratumId').focus(false);
					},
					defaultEventAction: 'stopEvent',
				},
				{
					key: [ Ext.EventObject.P ],
					ctrl: false,
					//shift: false,
					alt: true,
					handler: function(ev) {
						me.jumpToRecord();
					},
					defaultEventAction: 'stopEvent',
				},

			],
		});

	},  // eo init key map



});
