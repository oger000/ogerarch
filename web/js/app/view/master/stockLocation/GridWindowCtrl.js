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
Ext.define('App.view.master.stockLocation.GridWindowCtrl', {
	extend: 'Ext.app.ViewController',
	alias: 'controller.stockLocationMasterGridWin',


	// on render
	onRender: function(cmp) {
		var me = this;

		//var grid = cmp.down('grid');
		var grid = me.lookupReference('stockLocationGrid');
		var store = grid.getStore();
		store.getProxy().setExtraParam('_action', 'loadTree');
		store.load();
	},  // eo on render


	// close window
	closeWindow: function(cmp) {
		var me = this;
		me.getView().close();
	},  // eo  close window



});
