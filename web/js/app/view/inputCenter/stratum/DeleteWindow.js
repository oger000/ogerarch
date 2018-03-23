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
Ext.define('App.view.inputCenter.stratum.DeleteWindow', {
	extend: 'Ext.window.Window',
	alias: 'widget.ic_stratumdeletewindow',

	title: Oger._('Stratum löschen'),
	width: 400,
	height: 330,
	modal: true,
	//autoScroll: true,
	layout: 'fit',

	items: [
		{ xtype: 'form',
			bodyPadding: 15,
			border: false,
			autoScroll: true,
			layout: 'anchor',
			trackResetOnLoad: true,
			items: [
				{ name: 'id', xtype: 'hidden' },
				{ name: 'excavId', xtype: 'hidden' },
				{ name: 'hiddenConfirmCode', xtype: 'hidden' },
				{ name: 'stratumId', xtype: 'textfield', fieldLabel: Oger._('Stratum-Nr'), readOnly: true },
				{ xtype: 'fieldset', title: Oger._('Verweise löschen'),
					items: [
						{ xtype: 'displayfield', fieldLabel: Oger._('Verweise, die auf dieses Stratum zeigen ebenfalls löschen (nicht empfohlen)'), labelWidth: 300, value: '' },
						{ name: 'unlinkArchFind', xtype: 'checkbox', boxLabel: Oger._('von Fund'), uncheckedValue: '0' },
						{ name: 'unlinkMatrix', xtype: 'checkbox', boxLabel: Oger._('von Matrix (alle Relationen)'), uncheckedValue: '0' },
						{ name: 'unlinkComplex', xtype: 'checkbox', boxLabel: Oger._('von Komplex'), uncheckedValue: '0' },
						{ name: 'unlinkArchObject', xtype: 'checkbox', boxLabel: Oger._('von Objekt'), uncheckedValue: '0' },
					],
				},
				//{ name: 'unlinkAllCategories', xtype: 'checkbox', boxLabel: Oger._('Alle Kategorien'), uncheckedValue: '0' },
			],
			url: 'php/scripts/stratum.php',
		},
	],

	buttonAlign: 'center',
	minButtonWidth: 30,
	buttons: [
		{ text: Oger._('Löschen'),
			handler: function(button, event) {
				this.up('window').deleteRecord(button, event);
			},
		},
		{ text: Oger._('Abbrechen'),
			handler: function(button, event) {
				this.up('window').close();
			},
		},
	],  // eo buttons

	listeners: {
		beforerender: function(cmp, opts) {
			cmp.indexOfRecord = cmp.assignedGrid.getStore().indexOf(cmp.record);
			var pForm = cmp.down('form');
			pForm.getForm().load({ url: pForm.url,
														 params: { _action: 'loadRecord', excavId: cmp.record.data.excavId,
																			 stratumId: cmp.record.data.stratumId } });
		},
		afterlayout: function(cmp, opts) {
			cmp.alignTo(Ext.ComponentQuery.query('mainviewport')[0], 'c-c?');
		},
	},

	// ####################################


	// delete record
	deleteRecord: function() {
		var me = this;
		var pForm = me.down('form');
		var bForm = pForm.getForm();

		pForm.submit({
			url: pForm.url,
			params: { _action: 'delete' },
			clientValidation: true,
			success: function(form, action) {
				Ext.Msg.alert(Oger._('Hinweis'), Oger._('Datensatz erfolgreich gelöscht'));
				var store = me.assignedGrid.getStore();
				store.load({ params: { start: Math.max(0, me.indexOfRecord - 1), limit: store.pageSize } });
				me.close();
			},
			failure: function(form, action) {
				if (!Oger.extjs.handleFormSubmitFailure(form, action)) {
					//handle remaining failures
				}
			},
		});
	},

});
