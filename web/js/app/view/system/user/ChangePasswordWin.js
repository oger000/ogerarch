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
Ext.define('App.view.system.user.ChangePasswordWin', {
	extend: 'Ext.window.Window',
	alias: 'widget.systemUserChangePasswordWin',

	controller: 'systemUserChangePasswordWin',

	title: Oger._('Passwort ändern'),
	width: 350, height: 200,
	modal: true,
	autoScroll: true,
	layout: 'fit',
	items: [
		{ xtype: 'form', reference: 'theForm',
			url: 'php/system/user.php?_action=changePassword',
			bodyStyle: 'padding:15px; background:transparent',
			border: false,
			trackResetOnLoad: true,
			items: [
				{ name: 'oldPassword', xtype: 'textfield', inputType: 'password',
					fieldLabel: Oger._('Altes Passwort'), allowBlank: false,
				},
				{ name: 'newPassword', xtype: 'textfield', inputType: 'password',
					fieldLabel: Oger._('Neues Passwort'), allowBlank: false,
				},
				{ name: 'newPasswordRepeated', xtype: 'textfield', inputType: 'password',
					fieldLabel: Oger._('Passwort wiederholen'), allowBlank: false,
				},
			],
		},
	],
	buttonAlign: 'center',
	buttons: [
		{ text: Oger._('Ok'), handler: 'saveRecord' },
		{ text: Oger._('Abbrechen'), handler: 'closeWindow' },
	],


});

