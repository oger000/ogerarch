/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
*/
Ext.define('App.view.inputCenter.stock.prepFind.MassEditWin', {
	extend: 'Ext.window.Window',

	title: Oger._('Fund/Lager Massenbearbeitung Status'),
	width: 700, height: 500,
	modal: true,
	//autoScroll: true,
	layout: 'fit',

	items: [
		{ xtype: 'form',
			url: 'php/scripts/prepFind.php',
			bodyPadding: 15, border: false,
			autoScroll: true,
			trackResetOnLoad: true,
			layout: 'anchor',
			items: [
				{ xtype: 'hidden', name: 'excavId' },
				{ xtype: 'displayfield', fieldLabel: Oger._('Fundnummern'), value: '' },
				{ name: 'archFindIdList', xtype: 'textarea',
					hideLabel: true, width: 500, height: 70,
					validator: multiXidSubIdValid, allowBlank: false, readOnly: true,
				},

				{ xtype: 'tabpanel',
					activeTab: 0,
					//height: 800,  // corresponds with autscroll ???
					plain: true,
					autoScroll: true,
					deferredRender: false,
					items: [

						{ xtype: 'ic_stockprepfindstateinputpanel',
							title: Oger._('Status'),
							hideMode: 'offsets',
							bodyPadding: '15 0 0 0',
						},  // eo find detail tab

						{ xtype: 'ic_stockprepfindmaterialinputpanel',
							title: Oger._('Material'),
							hideMode: 'offsets',
						},  // eo material tab
					],

				},
			],
		},
	],

	buttonAlign: 'center',
	minButtonWidth: 30,
	buttons: [
		{ text: Oger._('Speichern'), itemId: 'saveButton',
			listeners: {
				click: function(cmp) {
					cmp.up('window').saveInput();
				},
			},
		},
		{ text: Oger._('Zurücksetzen'), itemId: 'resetButton',
			listeners: {
				click: function(cmp) {
					cmp.up('window').down('form').getForm().reset();
				},
			},
		},
		{ text: Oger._('Schliessen'), itemId: 'closeButton',
			listeners: {
				click: function(cmp) {
					cmp.up('window').close();
				},
			},
		},
	],

	listeners: {
		afterrender: function(cmp) {
			cmp.prepForm(cmp);
		},
		beforeclose: function (cmp) {
			return Oger.extjs.confirmDirtyClose(cmp, cmp.down('form').getForm(), true);
		},
		close: function(cmp) {
			if (cmp.callingGrid) {
				var store = this.callingGrid.getStore();
				store.loadPage(store.currentPage);
			}
		},
	},


	// ########################################################################


	// show hidden extra selection ("untouched")
	// if used as beforerender event the function is called TWICE - dont know why
	prepForm: function(cmp) {
		var bForm = cmp.down('form').getForm();
		bForm.getFields().each(function(field) {
			if (field.ogerExtraHide) {
				if (field.isXType('radiogroup')) {
					field.items.each(function(item) {
						if (item.ogerHidden) {
							item.show();
							item.setRawValue(-1);
						}
					});
				}
			}
		});

		Oger.extjs.resetDirty(bForm);
	},  // eo prep form


	// inject data into form
	injectData: function(vals, callingGrid) {
		var me = this;
		me.callingGrid = callingGrid;

		vals.archFindIdList = '';
		var sele = me.callingGrid.getSelectionModel().getSelection();

		// collect visible (and invisible) ids
		for(var i=0, len=sele.length; i < len; ++i){
			var rec = sele[i];
			vals.archFindIdList += (vals.archFindIdList ? ', ' : '') +
				rec.data.archFindId + App.clazz.PrepFind.SUBID_DELIM + rec.data.archFindSubId;
		}

		var bForm = me.down('form').getForm();
		bForm.setValues(vals);

		Oger.extjs.resetDirty(bForm);
	},  // eo inject data


	// save data
	saveInput: function(opts) {
		var me = this;
		if (!opts) {
			opts = {};
		}

		var pForm = me.down('form');
		var bForm = pForm.getForm();
		pForm.submit(
			{ params: { _action: 'massSaveState' },
				clientValidation: true,
				success: function(form, action) {
					//Oger.extjs.expireAlert(Oger._('Hinweis'), Oger._('Daten erfolgreich gespeichert.'));
					var resData = action.result.data;
					var protoWin = Ext.create('App.view.inputCenter.stock.prepFind.MassEditProtoWin');
					protoWin.injectData(resData);
					protoWin.show();
					if (!resData.errorMsg) {
						Oger.extjs.resetDirty(form);
						me.close();
					}
				},
			}
		);
	},  // eo save data


});
