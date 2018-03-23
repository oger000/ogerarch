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
Ext.define('App.view.pictureOrganize.FormWinCtrl', {
	extend: 'Ext.app.ViewController',
	alias: 'controller.pictureOrganizeFormWinCtrl',


	// prep form
	prepForm: function(vals) {
		var me = this;
		me.getView().down('form').getForm().setValues(vals);
	},  // eo prep form


	// on change config file name
	/*
	onChangeConfigFileName: function(cmp, newValue) {
		var me = this;

		alert(newValue);
	},  // eo change config
	*/


	// start picture organize
	startPictureOrganize: function() {
		var me = this;

		var pForm = me.getView().down('form');
		var bForm = pForm.getForm();
		if (!bForm.isValid()) {
			Ext.Msg.alert(Oger._('Hinweis'), Oger._('Fehler im Auswahlformular.'));
			return;
		}

		var vals = bForm.getValues();
		Ext.Object.merge(vals, { _action: 'pictureOrganize' }, Ext.Ajax.getExtraParams());

		var urlStr = pForm.url + '?' + Ext.Object.toQueryString(vals);
		window.open(urlStr,
								'PICTUREORGANIZE',
								'left=' + Math.floor(window.innerWidth * 0.1) + ',top=' + Math.floor(window.innerHeight * 0.1) +
								',width=' + Math.floor(window.innerWidth * 0.8) + ',height=' + Math.floor(window.innerHeight * 0.8) +
								',menubar=yes,toolbar=yes,scrollbars=yes,resizeable=yes');
	},  // eo perform matrix


	// show help
	showHelp: function() {
		window.open('help/pictureOrganize.html',
								'HELP',
								'left=' + Math.floor(window.innerWidth * 0.1) + ',top=' + Math.floor(window.innerHeight * 0.1) +
								',width=' + Math.floor(window.innerWidth * 0.8) + ',height=' + Math.floor(window.innerHeight * 0.8) +
								',menubar=yes,toolbar=yes,scrollbars=yes,resizeable=yes');
	},


	// close window
	closeWindow: function(cmp) {
		var me = this;
		me.getView().close();
	},  // eo  close window



});
