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
Ext.define('App.view.system.userGroup.FormWin', {
	extend: 'Ext.window.Window',
	alias: 'widget.systemUserGroupFormWin',

	controller: 'systemUserGroupFormWin',

	title: Oger._('Usergruppe'),
	width: 700, height: 500,
	//autoScroll: true,
	layout: 'fit',

	items: [
		{ xtype: 'form', reference: 'theForm',

			url: 'php/system/userGroup.php',

			bodyPadding: 15,
			border: false,
			autoScroll: true,
			layout: 'anchor',
			trackResetOnLoad: true,

			items: [

				{ name: '_action', xtype: 'hidden', value: 'INSERT', reference: 'actionField' },
				{ name: 'userGroupId', fieldLabel: Oger._('Id'), xtype: 'textfield', readOnly: true, hidden: true },
				{ name: 'name', fieldLabel: Oger._('Bezeichnung'), xtype: 'textfield', allowBlank: false },

				{ xtype: 'fieldset', title: Oger._('Rechte'),
					items: [
						{ name: 'updateMasterDataPerm', xtype: 'checkbox', fieldLabel: Oger._('Stammdaten'), inputValue: '1', uncheckedValue: '0' },
						{ name: 'insertBookingPerm', xtype: 'checkbox', fieldLabel: Oger._('Buchungen erfassen'), inputValue: '1', uncheckedValue: '0' },
						{ name: 'updateBookingPerm', xtype: 'checkbox', fieldLabel: Oger._('Buchungen verändern'), inputValue: '1', uncheckedValue: '0' },
					],
				},

				{ xtype: 'panel', height: 5, border: false },
				{ name: 'oldPassword', xtype: 'textfield', inputType: 'password',
					fieldLabel: Oger._('Ihr Passwort'),
				},
			],

		},  // eo form
	],

	buttonAlign: 'center',
	minButtonWidth: 30,
	buttons: [
		{ text: Oger._('Speichern'), handler: 'saveRecord' },
		{ text: Oger._('Abbrechen'), handler: 'closeWindow' },
	],


	listeners: {
		afterrender: 'onAfterRender',
		beforeclose: 'onBeforeClose',
		close: 'onClose',
	},

});
