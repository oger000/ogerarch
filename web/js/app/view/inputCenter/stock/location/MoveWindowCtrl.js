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
Ext.define('App.view.inputCenter.stock.location.MoveWindowCtrl', {
	extend: 'Ext.app.ViewController',
	alias: 'controller.ic_moveStockWindow',

	// show move form
	// action param is unused
	// opts contain cargo:
	//   node, data, overModel, dropPosition, dropHandlers, eOpts
	prepForm: function(action, vals, callingGrid, opts) {
		var me = this;

		var win = me.getView();
		win.callingGrid = callingGrid;
		win.inOpts = opts || {};

		var pForm = win.down('form');
		var bForm = pForm.getForm();

		bForm.setValues(vals);

		Oger.extjs.resetDirty(bForm);
	},  // eo show form



	// more record
	moveRecord: function() {
		var me = this;

		var win = me.getView();
		var pForm = win.down('form');
		var bForm = pForm.getForm();
		pForm.submit(
			{ params: { _action: 'moveLoc' },
				clientValidation: true,
				success: function(form, action) {
					var resp = action.result;

					var protoWin = Ext.create('App.view.inputCenter.stock.location.MoveProtoWindow');
					protoWin.down('textarea').setValue(resp.proto);
					protoWin.show();

					if (resp.moveApplyMode != 'apply') {
						return;
					}

					me.moveOk = true;
					Oger.extjs.resetDirty(form);
					win.close();
				},
			});
	},  // eo more record


	beforeDropRemote: function(node, data, overModel, dropPosition, dropHandlers, eOpts) {
		var me = this;

		var win = me.getView();
		var pForm = win.down('form');

		Ext.Ajax.request({
			url: pForm.url,
			params: { _action: 'moveNode' , node: data.records[0].data.id, to: overModel.data.id },
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


	// cleanup on close
	onClose: function(cmp, opts) {
		var me = this;
		var win = me.getView();

		if (me.moveOk) {
			win.inOpts.dropHandlers.processDrop();
			if (win.callingGrid) {
				var store = win.callingGrid.getStore();
				store.load({ params: { stockLocationId: App.clazz.StockLocation.ROOT_ID }});
			}
		}
		else {
			win.inOpts.dropHandlers.cancelDrop();
		}
	},  // eo on close


	// close window
	closeWindow: function(cmp) {
		var me = this;
		me.getView().close();
	},  // eo  close window


});
