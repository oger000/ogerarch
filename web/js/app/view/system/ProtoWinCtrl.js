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
Ext.define('App.view.system.ProtoWinCtrl', {
	extend: 'Ext.app.ViewController',
	alias: 'controller.systemProtoWin',


	// close window
	closeWindow: function() {
		this.getView().close();
	},  // eo close window



	// print proto via remote
	printProto: function() {
		var me = this;

		var pForm = me.lookupReference('protoForm');
		var bForm = pForm.getForm();
    bForm.standardSubmit = true;

		// additional values
		// alternative would be hidden fields
		var vals = bForm.getValues();
		var extraParams = Ext.Ajax.getExtraParams();
		if (extraParams) {
			vals._LOGONID = extraParams._LOGONID;
		}
		vals._action = 'exportPdf';
		vals.title = me.getView().getTitle();

		bForm.submit({
      target: '_blank',
			url: 'php/system/proto.php',
			params: vals,
		})

	},  // eo print proto



});
