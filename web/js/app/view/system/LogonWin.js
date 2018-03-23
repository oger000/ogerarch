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
Ext.define('App.view.system.LogonWin', {
	extend: 'Ext.window.Window',
	alias: 'widget.logonWin',

	controller: 'logonWin',

	title: Oger._('Anmeldung ' + OgerApp.appTitle),
	closable : false,
	modal: true,
	width: 500, height: 350,
	layout: 'fit',

	items: [
		{ xtype: 'form', reference: 'logonForm',
			border: false, bodyPadding: 15,
			autoScroll: true,
			items: [

				{ name: 'dbDefAliasId', xtype: 'combo', fieldLabel: Oger._('Datenbank'),
					width: 400, reference: 'dbDefCombo',
					allowBlank : false, forceSelection: true,
					queryMode: 'local', valueField: 'dbDefId', displayField: 'name', triggerAction: 'all',
					store: { type: 'dbDefList', pageSize: 0 },
					listeners: {
						change: 'onDbDefChange',
					},
				},

				{ xtype: 'component', border: false, html: '<BR><BR>' },
				{ name: 'autoLogon', xtype: 'checkbox', boxLabel: Oger._('Automatische Anmeldung'), disabled: true,
					inputValue: '1', uncheckedValue: '0',
					listeners: {
						change: 'onAutoLogonChange',
					},
				},
				{ name: 'sslCertLogon', xtype: 'checkbox', boxLabel: Oger._('SSL Client Zertifikat verwenden'), disabled: true,
					inputValue: '1', uncheckedValue: '0',
					listeners: {
						change: 'onSslCertLogonChange',
					},
				},

				{ xtype: 'component', border: false, html: '<BR><BR>' },
				{ name: 'logonName', xtype: 'textfield', fieldLabel: Oger._('Logon User'), width: 400, allowBlank : false },
				{ name: 'password', xtype: 'textfield', inputType: 'password', fieldLabel: Oger._('User Passwort'), width: 400 },

			],

			buttonAlign: 'center',
			buttons: [
				{ text: Oger._('Anmelden'), handler: 'handleLogon' },
			],

		},  // eo form
	],


	listeners: {
		beforerender: 'onBeforeRender',
		afterrender: 'onAfterRender',
	},


});
