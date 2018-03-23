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
Ext.define('App.view.inputCenter.stock.prepFind.MoveWindowCtrl', {
	extend: 'Ext.app.ViewController',
	alias: 'controller.ic_movePrepFindWindow',


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

		vals.moveCount = vals.records.length;
		vals.archFindIdList = '';
		var archFindIdArr = []
		for (i = 0; i < vals.records.length; i++) {
			var rec = vals.records[i];
			vals.archFindIdList += (vals.archFindIdList ? ', ' : '') +
				rec.data.archFindId + App.clazz.PrepFind.SUBID_DELIM + rec.data.archFindSubId;
		}

		bForm.setValues(vals);
		Oger.extjs.resetDirty(bForm);
	},  // eo show form



	// move record
	moveRecord: function() {
		var me = this;

		var win = me.getView();
		var pForm = win.down('form');
		var bForm = pForm.getForm();
		pForm.submit(
			{ params: { _action: 'movePrepFindLoc' },
				clientValidation: true,
				success: function(form, action) {
					var respData = action.result.data;
					// show updateCount ???
					me.moveOk = true;
					Oger.extjs.resetDirty(form);
					win.close();
				},
			}
		);
	},  // eo save record


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
			// ALWAYS cancel drop, because we do not want to show
			// the moved arch finds inside the location grid !!!
			// So we have to suppress the visual representation.
			//me.inOpts.dropHandlers.processDrop();
			win.inOpts.dropHandlers.cancelDrop();
			if (win.callingGrid) {
				var store = win.callingGrid.getStore();
				store.loadPage(store.currentPage);
			}
		}
		else {
			win.inOpts.dropHandlers.cancelDrop();
		}
	},  // eo on close


	// close window
	closeWindow: function() {
		var me = this;
		me.getView().close();
	},  // eo close win



});
