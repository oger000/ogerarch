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
Ext.define('App.view.system.LogonWinCtrl', {
	extend: 'Ext.app.ViewController',
	alias: 'controller.logonWin',


	mainUrl: 'php/system/logon.php',


	// #############################################


	// on before render
	onBeforeRender: function(cmp) {
		var me = this;
	},  // eo on before render


	// on render
	onAfterRender: function(cmp) {
		var me = this;

		var dbDefCombo = me.lookupReference('dbDefCombo');
		var store = dbDefCombo.getStore();
		store.load({
			callback: function(records, operation, success) {
				if (records && records.length == 1) {
					var dbDefId = records[0].get('dbDefId');
					dbDefCombo.setValue(dbDefId);
				}
			},
		});

		var bForm = cmp.down('form').getForm();
		var sslCertField = bForm.findField('sslCertLogon');
		sslCertField.setDisabled(!OgerApp.allowSslClientCertLogon);

		var map = new Ext.util.KeyMap({
			target: cmp.el,
			key: [ 10, Ext.event.Event.ENTER ],
			handler: function() {
				me.handleLogon();
			},
		});
	},  // eo on render


	onDbDefChange: function(cmp, value, opts) {
		var record = cmp.getStore().findRecord('dbDefId', cmp.getValue());
		if (record) {
			var bForm = cmp.up('form').getForm();
			bForm.findField('autoLogon').setValue(record.data.autoLogonUser != '');
			bForm.findField('autoLogon').setDisabled(record.data.autoLogonUser == '');
			bForm.findField('logonName').setValue(record.data.autoLogonUser);
		}
	},  // eo db change


	onAutoLogonChange: function(cmp, newValue) {
		var me = this;
		me.enableDisableFields();
	},  // eo autologon change


	onSslCertLogonChange: function(cmp, newValue) {
		var me = this;
		me.enableDisableFields();
	},  // eo ssl cert logon



	enableDisableFields: function() {
		var me = this;

		var bForm = me.lookupReference('logonForm').getForm();

		var autoLogonField = bForm.findField('autoLogon');
		var sslCertLogonField = bForm.findField('sslCertLogon');

		var autoLogon = autoLogonField.getValue();
		var sslCertLogon = sslCertLogonField.getValue();

		sslCertLogonField.setDisabled(autoLogon || !OgerApp.allowSslClientCertLogon);
		bForm.findField('logonName').setDisabled(autoLogon);
		bForm.findField('password').setDisabled(autoLogon || sslCertLogon);

	},  // eo enable disable fields




	handleLogon: function() {
		var me = this;

		var bForm = me.lookupReference('logonForm');
		bForm.submit({
			url: me.mainUrl, params: { _action: 'logon' },
			clientValidation: true, submitEmptyText: false,
			success: function(form, action) {
				OgerApp.logon = Ext.decode(action.response.responseText).data;
				me.getView().close();
				App.app.launch();
			},
		})
	},  // eo handle logon


});
