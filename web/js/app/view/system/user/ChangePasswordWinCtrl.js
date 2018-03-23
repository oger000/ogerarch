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
Ext.define('App.view.system.user.ChangePasswordWinCtrl', {
	extend: 'Ext.app.ViewController',
	alias: 'controller.systemUserChangePasswordWin',


	// save recordedit record
	saveRecord: function() {
		var me = this;

		var pForm = me.lookupReference('theForm');
		pForm.submit({
			clientValidation: true, submitEmptyText: false,
			success: function(form, action) {
				if (action.result.success) {
					Ext.create('Oger.extjs.MessageBox').alert(
						Oger._('Ergebnis'), Oger._('Passwortänderung wurde durchgeführt.'));
					me.closeWindow();
				}
			},
		});
	},  // eo save record


	// close window
	closeWindow: function() {
		this.getView().close();
	},


});
