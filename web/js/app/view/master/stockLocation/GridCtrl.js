/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


// INCOMPLETE


/**
*/
Ext.define('App.view.master.stockLocation.GridCtrl', {
	extend: 'Ext.app.ViewController',
	alias: 'controller.stockLocationMasterGrid',


	editRecord: function(cmp, gridView, rowIndex, colIndex, actionItem, event, record, ro) {
		var me = this;
		var opts = { _usecase: 'MASTER' };

		var win = Oger.extjs.createOnce('stocklocationmasterwindow', 'App.view.master.stockLocation.DetailWindow');
		win.getController().prepForm('UPDATE', Ext.clone(record.data), me.getView(), opts);
		win.show();
	},  // eo edit record


	addSubRecord: function(cmp, gridView, rowIndex, colIndex, actionItem, event, record, row) {
		var me = this;
		var opts = { _usecase: 'MASTER' };

		var win = Oger.extjs.createOnce('stocklocationmasterwindow', 'App.view.master.stockLocation.DetailWindow');
		win.getController().prepForm('INSERT', Ext.clone(record.data), me.getView(), opts);
		win.show();
	},  // eo add sub record


	onBeforeDrop: function(node, data, overModel, dropPosition, dropHandlers, eOpts) {
		var me = this;

		// only assigning to another node is handled
		if (dropPosition != 'append') {
			dropHandlers.cancelDrop();
			return;
		}

		dropHandlers.wait = true;
		var msg = Ext.String.format(Oger._('Knoten \'{0}\' verschieben nach \'{1}\'?'),
			data.records[0].data.name, overModel.data.name);

		Ext.create('Oger.extjs.MessageBox').confirm(
			Oger._('Verschieben'),
			Oger._(msg),
			function(btn){
				if (btn === 'yes') {
					me.beforeDropRemote(node, data, overModel, dropPosition, dropHandlers, eOpts);
				} else {
					dropHandlers.cancelDrop();
				}
			}
		);
	},  // eo before drop


	beforeDropRemote: function(node, data, overModel, dropPosition, dropHandlers, eOpts) {
		var me = this;

		Ext.Ajax.request({
			url: 'php/scripts/stockLocation.php',
			params: { _action: 'moveNode' , stockLocationId: data.records[0].data.stockLocationId, moveTo: overModel.data.stockLocationId },
			success: function(response) {
				var resp = Ext.decode(response.responseText);
				if (resp.success == true) {
					dropHandlers.processDrop();
				}
				else {
					Ext.create('Oger.extjs.MessageBox').alert(Oger._('Antwort'), resp.msg);
					dropHandlers.cancelDrop();
				}
			},
			failure: function(response, opts) {
				Oger.extjs.handleAjaxFailure(response, opts),
				dropHandlers.cancelDrop();
			},
		});

	},  // eo before drop remote



	// reload location grid
	reloadLocationGrid: function() {
		var me = this;
		var store = me.getView().getStore()
		store.load({ params: { stockLocationId: App.clazz.StockLocation.ROOT_ID }});
		//store.load();  // load without params loads root node (according to sencha docs)
	},  // eo reload loc grid


	// show delete location window
	deleteLocation: function() {
		var me = this;
		var grid = me.getView();

		var rec = grid.getSelectionModel().getSelection()[0];
		if (!rec) {
			Ext.create('Oger.extjs.MessageBox').alert(Oger._('Fehler'), Oger._('Bitte zuerst einen Lagerort auswählen.'));
			return;
		}

		var data = Ext.clone(rec.data);
		var opts = { _usecase: 'MASTER' };

		var win = Oger.extjs.createOnce(null, 'App.view.master.stockLocation.DeleteWindow');
		win.getController().prepForm('DELETE', data, grid, opts);
		win.show();
	},  // eo show del loc win



});
