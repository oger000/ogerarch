/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Main status info
*/
Ext.define('App.view.MainStatus', {
	extend: 'Ext.toolbar.Toolbar',
	alias: 'widget.mainstatus',

	items: [
		Oger._('User: '),
		{ xtype: 'textfield', itemId: 'logonUserField',
			readOnly: true,
		},
		' ',
		Oger._('Anmeldedatum: '),
		{ xtype: 'datefield', itemId: 'logonDate',
			readOnly: true,
		},
		' ',
		Oger._('Datenbank: '),
		{ xtype: 'textfield', itemId: 'logonDbName',
			readOnly: true, width: 250,
		},
		' ',
	],

	listeners: {
		afterrender: function(cmp) {
			cmp.down('#logonUserField').setValue(
				'' + OgerApp.logon.userId + ' ' + OgerApp.logon.userName +
				' (' + OgerApp.logon.userName + ')' );
			cmp.down('#logonDate').setValue(OgerApp.logon.time);
			cmp.down('#logonDbName').setValue(OgerApp.logon.dbName);
		},
	},




});
