/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/



/**
* Stratum grid
*/
Ext.define('App.view.inputCenter.qmatrix.Grid', {
	extend: 'Ext.grid.Panel',
	alias: 'widget.ic_qmatrixgrid',

	stripeRows: true,
	columnLines: true,
	autoScroll: true,

	sortableColumns: true,
	store: Ext.create('App.store.QMatrix',
										{ remoteSort: true,
											remoteFilter: true,
											pageSize: 100,
                      //pageSize: 999999,
										}),

	viewConfig:{
		markDirty:false
	},

	columns: [
		{ header: Oger._('Gr'), dataIndex: 'excavId', width: 30, hidden: true, ogerHidden: true },
		{ header: Oger._('Grabung'), dataIndex: 'excavName', hidden: true, ogerHidden: true },
		{ header: Oger._('Nummer'), dataIndex: 'stratumId', width: 50,
      editor: { xtype: 'textfield', allowBlank: false, validator: xidValid },
    },
		{ header: Oger._('Kategorie'), dataIndex: 'categoryName',
      editor: {
        xtype: 'combo', forceSelection: true, /*allowBlank: false,*/
				queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
        store: { type: 'stratumCategories', autoLoad: true },
      },
    },

		// matrix
		{ header: Oger._('Älter als (unter)'), dataIndex: 'earlierThanIdList',
      editor: { xtype: 'textfield', validator: multiXidValid },
    },
		{ header: Oger._('Jünger als (über)'), dataIndex: 'reverseEarlierThanIdList',
      editor: { xtype: 'textfield', validator: multiXidValid },
    },
		{ header: Oger._('Ist ident mit'), dataIndex: 'equalToIdList',
      editor: { xtype: 'textfield', validator: multiXidValid },
    },
		{ header: Oger._('Zeitgleich mit'), dataIndex: 'contempWithIdList',
      editor: { xtype: 'textfield', validator: multiXidValid },
    },


		// detail - calced
		//{ header: Oger._('Interface'), dataIndex: 'containedInInterfaceIdList', width: 50, hidden: true, ogerHidden: true },
		{ header: Oger._('Objekt'), dataIndex: 'archObjectIdList',
      editor: { xtype: 'textfield', validator: multiXidValid },
		},
	],


	// filter panel at the top
	tbar: {
		xtype: 'form', //layout: 'hbox',
		height: 130, //width: 300,
		border: false,
		collapsible: true,
		collapsed: true,
		autoScroll: true,
		bodyStyle: 'background-color:#d3e1f1',
		title: Oger._('Filter'),
		layout: {
			type: 'vbox',
			align : 'stretch',
			pack  : 'start',
		},
		items: [
			{ xtype: 'panel', layout: 'anchor',
				//bodyPadding: '0 5 5 5',
				bodyPadding: 5,
				border: false,
				bodyStyle: 'background-color:#d3e1f1',
				items: [
					{ name: 'searchText', xtype: 'textfield', width: 350,
						fieldLabel: Oger._('Textsuche'), labelWidth: 80,
						checkChangeBuffer: CHKCHANGE_DEFER,
						listeners: {
							change: function(cmp, newValue, oldValue, opts) {
								cmp.up('form').doFilter();
							},
						},
					},
					{ name: 'filterCategoryId', xtype: 'combo', fieldLabel: Oger._('Kategorie'), width: 250,
						forceSelection: true, allowBlank: true,
						queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
		        store: { type: 'stratumCategories', autoLoad: true },
						listeners: {
							change: function(cmp, newValue, oldValue, options) {
								cmp.up('form').doFilter();
							},
							select: function(cmp, records, eOpts) {
								//cmp.up('form').doFilter();
							},
						},  // eo listerners
					},
				],
			},  // eo text

		],  // eo outer form items

		doFilter: function() {
			var form = this;
			var grid = form.up('grid');
			var store = grid.getStore();
			var excavId = grid.gluePanel.excavRecord.data.id
			store.clearFilter(true);
			var filterArr = [];
			filterArr.push({ property: 'excavId', value: grid.excavId });
			var vals = form.getForm().getValues();
			if (vals['searchText']) {
				vals['searchText'] = '%' + vals['searchText'] + '%';
			}
			for (var prop in vals) {
				filterArr.push({ property: prop, value: vals[prop] });
			}
			store.filter(filterArr);
		},  // eo do filter

	},  // eo form (tbar)


	dockedItems: [
		{ dock: 'right', xtype: 'form', itemId: 'theForm',
			bodyPadding: 15, border: false, width: 350,
			autoScroll: true,	trackResetOnLoad: true,
			layout: 'anchor',

			url: 'php/scripts/stratum.php',

			items: [
				{ xtype: 'hidden', name: 'dbAction' },
				{ xtype: 'hidden', name: 'id' },
				{ xtype: 'hidden', name: 'excavId' },
				//{ xtype: 'hidden', name: 'oldCategoryId' },
				{ name: 'stratumId', xtype: 'textfield', fieldLabel: Oger._('Stratum-Nr'),
					allowBlank: false, validator: xidValid, selectOnFocus: true, width: 300,
				},

				{ name: 'categoryId', xtype: 'combo', fieldLabel: Oger._('Kategorie'), width: 300,
					forceSelection: true, allowBlank: false,
					queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
					store: { type: 'stratumCategories', autoLoad: true },
				},

				{ xtype: 'component', html: '<HR>' },

				{ name: 'earlierThanIdList', xtype: 'textarea', fieldLabel: Oger._('Früher als (unter)'),
					width: 300, height: 35,	validator: multiXidValid,
				},
				{ name: 'reverseEarlierThanIdList', xtype: 'textarea', fieldLabel: Oger._('Später als (über)'),
					width: 300, height: 35, validator: multiXidValid,
				},
				{ name: 'equalToIdList', xtype: 'textarea', fieldLabel: Oger._('Ist ident mit'),
					width: 300, height: 35, validator: multiXidValid,
				},
				{ name: 'contempWithIdList', xtype: 'textarea', fieldLabel: Oger._('Zeitgleich mit'),
					width: 300, height: 35,	validator: multiXidValid,
				},

				{ xtype: 'component', html: '<HR>' },

				{ name: 'archObjectIdList', xtype: 'textfield', fieldLabel: Oger._('Objekt'),
					width: 300, validator: multiXidValid,
				},

				{ xtype: 'component', html: '<HR>', height: 20 },

				{ name: 'containedInInterfaceIdList', xtype: 'textfield', fieldLabel: Oger._('Interface'),
					readOnly: true, submitValue: false, width: 300,
				},
				{ name: 'containsStratumIdList', xtype: 'textfield', fieldLabel: Oger._('enthält Stratum'),
				 readOnly: true, submitValue: false, width: 300,
				},

				{ xtype: 'component', html: '<HR>', height: 20 },

				{ name: 'isTopEdge', boxLabel: Oger._('Grabungsoberkante (Baggerinterface)'),
					xtype: 'checkbox', inputValue: '1', uncheckedValue: '0' },
				{ name: 'isBottomEdge', boxLabel: Oger._('Grabungsunterkante (Geologie)'),
					xtype: 'checkbox', inputValue: '1', uncheckedValue: '0'
				},
				{ name: 'hasAutoInterface', boxLabel: Oger._('Unterkante als Interface behandeln'),
					xtype: 'checkbox', inputValue: '1', uncheckedValue: '0'
				},

			],

			listeners: {
				actioncomplete: function(form, action) {
					if (action.type == 'load') {
						// update grid
						var vals = form.getValues();
						vals.categoryName = form.findField('categoryId').getRawValue();
						var grid = this.up('grid');
						var store = grid.getStore();
						var rec = store.findRecord('id', vals.id);
						if (rec === null) {
							store.add(vals);
						}
						else {
							rec.set(vals);
						}
						Oger.extjs.resetDirty(form);
						if (grid.newFormFlag) {
							grid.newRecord();
							grid.newFormFlag = false;
						}
					}
				},
			},

			buttonAlign: 'center',
			minButtonWidth: 30,
			buttons: [
				{ text: Oger._('Speichern'),
					handler: function(button, event) {
						this.up('grid').saveRecord();
					}
				},
				{ text: Oger._('Speichern + Neu'),
					handler: function(button, event) {
						this.up('grid').saveAndNewRecord();
					}
				},
				{ text: Oger._('Neu'),
					handler: function(button, event) {
						this.up('grid').newRecord();
					}
				},
				{ text: Oger._('Zurücksetzen'),
					handler: function(button, event) {
						this.up('grid').resetRecord();
					}
				},
			],

		},  // eo form
	],




	// paging bar on the bottom
	bbar: {
		xtype: 'pagingtoolbar',
		displayInfo: true,
		/*
		items: [
			'-',
			{ text: 'Neu',
				handler: function() {
					this.up('panel').addRecord();
				}
			},
		],
		*/
	},


	listeners: {
		render: function(cmp, options) {
			cmp.down('pagingtoolbar').bindStore(this.getStore());
		},
		afterrender: function(cmp, options) {
			this.newRecord();
		},
    itemclick: function(view, record, item, index, event, options) {
      this.editRecord(record);
    },
	},

/*
	plugins: [
		Ext.create('Ext.grid.plugin.RowEditing', {
			pluginId: 'qMatrixRowEditingId',
      autoCancel: false,
			clicksToEdit: 2,
			errorSummary: false,

			listeners : {
				edit: function(editor, obj) {

					var url = obj.getGrid().getStore().getProxy().url;
					url = url.split('?')[0];

					var rec = Ext.clone(obj.record.data);
					rec._action = 'save';
					rec.dbAction = (rec.id ? 'UPDATE' : 'INSERT');

					Ext.Ajax.request({
						url: url,
						params: rec,
						success: function(response) {
							var responseObj = {};
							if (response.responseText) {
								responseObj = Ext.decode(response.responseText);
							}
							if (responseObj.success == true) {
								// do not alert - we see if the dirty indicator is removed on reload
								//var mb = Ext.Msg.alert(Oger._('Hinweis'), Oger._('Datensatz erfolgreich gespeichert.'));
								//Ext.Function.defer(function() { mb.hide(); me.focus(); }, 1000);
								obj.getGrid().getStore().load();
							}
						},
						failure: Oger.extjs.handleAjaxFailure,
					});

				},  // eo edit

				canceledit: function(editor, obj) {
					if (!obj.record.data.id) {
						//obj.getGrid().getStore().removeAt(obj.getStore().count() - 1);
					}
				},  // eo cancel edit

			},
		})  //,
	],
*/


	// ##############################################################


	// new record
	newRecord: function(opts) {
		var me = this;

		var pForm = me.down('#theForm');
		var bForm = pForm.getForm();

		if (Oger.extjs.formIsDirty(pForm)) {
			Ext.Msg.alert(Oger._('Hinweis'),
				Oger._('Ungespeicherte Änderungen vorhanden. Bitte zuerst Speichern oder Zurücksetzen.'));
			return;
		}

		var oldVals = bForm.getValues();

		Oger.extjs.emptyForm(bForm, true);
		bForm.findField('dbAction').setValue('INSERT');
		var excavId = me.gluePanel.excavRecord.data.id;
		bForm.findField('excavId').setValue(excavId);
		bForm.findField('stratumId').setReadOnly(false);
		bForm.findField('categoryId').setValue('DEPOSIT');

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

		Oger.extjs.resetDirty(bForm);
	},  // eo new record


	// edit current record or add new  if none selected
	editRecord: function(rec) {
		var me = this;

		var pForm = me.down('#theForm');
		var bForm = pForm.getForm();

		if (Oger.extjs.formIsDirty(pForm)) {
			Ext.Msg.alert(Oger._('Hinweis'),
				Oger._('Ungespeicherte Änderungen vorhanden. Bitte zuerst Speichern oder Zurücksetzen.'));
			return;
		}

		bForm.findField('dbAction').setValue('UPDATE');
		bForm.findField('stratumId').setReadOnly(true);
		pForm.load({
			params: { _action: 'loadQMatrixRecord', excavId: rec.data.excavId, stratumId: rec.data.stratumId },
		});
	},  // eo edit record


	// save record
	saveRecord: function(opts) {
		var me = this;
		opts = opts || {};

		var store = me.getStore();

		var pForm = me.down('#theForm');
		var bForm = pForm.getForm();
		var vals = bForm.getValues();

		pForm.submit(
			{ params: { _action: 'save' },
				clientValidation: true,
				success: function(form, action) {
					//if (!Oger.extjs.actionSuccess(action)) {
					//	return;
					//}
					Oger.extjs.resetDirty(form);
					bForm.findField('dbAction').setValue('UPDATE');
					bForm.findField('stratumId').setReadOnly(true);
					Oger.extjs.expireAlert(Oger._('Hinweis'), Oger._('Daten erfolgreich gespeichert.'));

					// reload saved record from db to update m:n relations
					pForm.load({
						params: { _action: 'loadQMatrixRecord', excavId: vals.excavId, stratumId: vals.stratumId },
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
		me.newFormFlag = true;
		me.saveRecord();
	},  // eo save record + new


	// reset form
	resetRecord: function() {
		var me = this;
		var pForm = me.down('#theForm');
		Oger.extjs.resetForm(pForm);
	},












	// #################################################################

	/* OBSOLETE - rowedit heavy buggy in ext 4.2.x !!!
	// add new record
	'addRecord': function() {
		var me = this;
	return;

    var rowEditing = me.getPlugin('qMatrixRowEditingId');
		var store = me.getStore();

		rowEditing.cancelEdit();

		// Create a model instance
		var rec = Ext.create('App.model.Stratum',
			{ stratumId: '1',
				date: new Date(),
			});
		store.add(rec);

		rowEditing.startEdit(store.count() - 1, 0);
	},  // eo add record
	*/


});
