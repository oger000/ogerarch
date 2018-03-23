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
Ext.define('App.view.system.LogoffWin', {
	extend: 'Ext.window.Window',

	title: Oger._('Auf Wiedersehen'),
	width: 300,
	height: 250,
	modal: true,
	autoScroll: true,
	layout: 'fit',

	html: Oger._('<CENTER><BR><BR>Auf Wiedersehen.<BR><BR></CENTER>'),
	buttonAlign: 'center',
	buttons: [
		{ text: Oger._('Anwendung Beenden'),
			handler: function(button, event) {
				this.up('window').logoff('php/system/goodBye.php');
			},
		},
		{ text: Oger._('Neu Anmelden'),
			handler: function(button, event) {
				this.up('window').logoff('index.php');
			},
		},
		{ text: Oger._('Abbrechen'),
			handler: function(button, event) {
				this.up('window').close();
			},
		},
	],  // eo buttons


	// #########################################


	logoff: function(url) {
		var me = this;
		Ext.create('Oger.extjs.MessageBox').confirm(
			Oger._('Bestätigung erforderlich'),
			Oger._('Anwendung wirklich beenden?'),
			function(btn) {
				if (btn == 'yes') {
					Ext.Ajax.request({
						url: 'php/system/logon.php?_action=logoff',
						success: function(response) {
							var resp = Ext.decode(response.responseText);
							if (resp.success) {
								window.location.href = url;
							}
							else {
								msg = resp.msg || Oger._('Fehler (nomsg)');
								Ext.create('Oger.extjs.MessageBox').alert(Oger._('Fehler'), msg);
							}
						},
						failure: Oger.extjs.showAjaxFailure,
					});
				}
				me.close();
			}
		);
	},



});
