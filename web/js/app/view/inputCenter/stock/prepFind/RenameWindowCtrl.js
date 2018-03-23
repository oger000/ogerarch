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
Ext.define('App.view.inputCenter.stock.prepFind.RenameWindowCtrl', {
	extend: 'Ext.app.ViewController',
	alias: 'controller.ic_prepFindRenameWindow',


	// prep rename form
	// action param not used for now
	prepForm: function(action, vals, callingGrid) {
		var me = this;

		var win = me.getView();
		win.callingGrid = callingGrid;

		var pForm = win.down('form');
		var bForm = pForm.getForm();

		vals.oldArchFindId = vals.archFindId;
		vals.oldArchFindSubId = vals.archFindSubId;
		bForm.setValues(vals);
	},  // eo show form


	// rename record
	renameRecord: function() {
		var me = this;

		var win = me.getView();
		var pForm = win.down('form');
		var bForm = pForm.getForm();

		pForm.submit({
			params: { _action: 'rename' },
			clientValidation: true,
			success: function(form, action) {
				Ext.Msg.alert(Oger._('Hinweis'), Oger._('Datensatz erfolgreich geändert'));
				win.close();
			},
		});
	},  // rename


	// on close
	onClose: function(cmp) {
		var me = this;
		var callingGrid = me.getView().callingGrid;
		if (callingGrid) {
			var store = callingGrid.getStore();
			store.loadPage(store.currentPage);
		}
	},  // eo close


	// close window
	closeWindow: function() {
		var me = this;
		me.getView().close();
	},  // eo close win



});
