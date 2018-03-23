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
Ext.define('App.view.inputCenter.stratum.RenameWindow', {
	extend: 'Ext.window.Window',
	alias: 'widget.ic_stratumrenamewindow',

	title: Oger._('Stratum-Nummer ändern'),
	width: 400,
	height: 250,
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
				{ name: 'excavId', xtype: 'hidden' },
				{ name: 'oldStratumId', xtype: 'textfield', fieldLabel: Oger._('Alte Stratum-Nr'), readOnly: true },
				{ name: 'stratumId', xtype: 'textfield', fieldLabel: Oger._('Neue Stratum-Nr'), validator: xidValid },
				{ xtype: 'fieldset', title: Oger._('Verweise ändern'),
					items: [
						{ xtype: 'displayfield', fieldLabel: Oger._('Verweise, die auf dieses Stratum zeigen ebenfalls ändern'), labelWidth: 300, value: '' },
						{ name: 'renameArchFind', xtype: 'checkbox', boxLabel: Oger._('von Fund'),
							uncheckedValue: '0', checked: true,
						},
						{ name: 'renameArchObject', xtype: 'checkbox', boxLabel: Oger._('von Objekt'),
							uncheckedValue: '0', checked: true,
						},
					],
				},
			],
			url: 'php/scripts/stratum.php',
		},
	],

	buttonAlign: 'center',
	minButtonWidth: 30,
	buttons: [
		{ text: Oger._('Stratum-Nummer ändern'),
			handler: function(button, event) {
				this.up('window').renameRecord(button, event);
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
			var bForm = pForm.getForm();
			bForm.load({ url: pForm.url, params: { _action: 'loadRecord', excavId: cmp.record.data.excavId,
																						 stratumId: cmp.record.data.stratumId } });
			bForm.findField('oldStratumId').setValue(cmp.record.data.stratumId);
		},
		afterlayout: function(cmp, opts) {
			cmp.alignTo(Ext.ComponentQuery.query('mainviewport')[0], 'c-c?');
		},
	},

	// ####################################


	// rename record
	renameRecord: function() {
		var me = this;
		var pForm = me.down('form');
		var bForm = pForm.getForm();

		pForm.submit({
			url: pForm.url,
			params: { _action: 'rename' },
			clientValidation: true,
			success: function(form, action) {
				Ext.Msg.alert(Oger._('Hinweis'), Oger._('Datensatz erfolgreich geändert'));
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
