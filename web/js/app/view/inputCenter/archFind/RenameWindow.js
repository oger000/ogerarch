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
Ext.define('App.view.inputCenter.archFind.RenameWindow', {
	extend: 'Ext.window.Window',
	alias: 'widget.ic_archfindrenamewindow',

	title: Oger._('Fundnummer ändern'),
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
				{ name: 'oldArchFindId', xtype: 'textfield', fieldLabel: Oger._('Alte Fund-Nr'), readOnly: true },
				{ name: 'archFindId', xtype: 'textfield', fieldLabel: Oger._('Neue Fund-Nr'), validator: xidValid },
				{ xtype: 'fieldset', title: Oger._('Verweise ändern'),
					items: [
						{ xtype: 'displayfield', fieldLabel: Oger._('Verweise, die auf diesen Fund zeigen ebenfalls ändern'), labelWidth: 300, value: '' },
						{ name: 'renameStratum', xtype: 'checkbox', boxLabel: Oger._('von Stratum'), uncheckedValue: '0', checked: true },
					],
				},
			],
			url: 'php/scripts/archFind.php',
		},
	],

	buttonAlign: 'center',
	minButtonWidth: 30,
	buttons: [
		{ text: Oger._('Fundnummer ändern'),
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
																						 archFindId: cmp.record.data.archFindId } });
			bForm.findField('oldArchFindId').setValue(cmp.record.data.archFindId);
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
