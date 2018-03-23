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
Ext.define('App.view.inputCenter.stock.prepFind.WindowCtrl', {
	extend: 'Ext.app.ViewController',
	alias: 'controller.ic_stockPrepFindWindow',


	// prep form (edit/insert)
	prepForm: function(action, vals, callingGrid) {
		var me = this;

		me.getView().callingGrid = callingGrid;

		var pForm = me.getView().down('form');
		var bForm = pForm.getForm();

		Oger.extjs.emptyForm(bForm);
		bForm.findField('dbAction').setValue(action);

		if (action == 'UPDATE') {
			pForm.load({ params: { _action: 'loadRecord', excavId: vals.excavId,
														 archFindId: vals.archFindId, archFindSubId: vals.archFindSubId } });
		}

		if (action == 'INSERT') {
			bForm.setValues({
				excavId: vals.excavId,
			});
		}

		Oger.extjs.resetDirty(bForm);

	},  // eo prep form


	// save record
	saveRecord: function(opts) {
		var me = this;
		if (!opts) {
			opts = {};
		}

		var pForm = me.getView().down('form');
		var bForm = pForm.getForm();
		pForm.submit(
			{ params: { _action: 'save' },
				clientValidation: true,
				success: function(form, action) {
					Oger.extjs.expireAlert(Oger._('Info'), Oger._('Datensatz erfolgreich gespeichert.'));
					Oger.extjs.resetDirty(form);

					// set callback
					if (opts.callback) {
						me.afterLoadCallback = opts.callback;
					}
					me.getView().close();
				},
			}
		);
	},  // eo save record confirmed


	// show arch find window and entry
	jumpToOriArchFind: function() {
		var me = this;

		var pForm = me.getView().down('form');
		var bForm = pForm.getForm();
		var vals = bForm.getValues();

		if (!vals.oriArchFindId) {
			return;
		}

		// reuse existing window if present
		var win = Ext.ComponentQuery.query('ic_archfindwindow')[0];
		if (!win) {
			win = Ext.create('App.view.inputCenter.archFind.Window');
			//win.assignedGrid = me;
			win.gluePanel = Ext.ComponentQuery.query('inputcenterpanel')[0];
		}
		win.show();

		if (!Oger.extjs.formIsDirty(win.down('form').getForm())) {
			win.editRecord(vals.oriArchFindId);
		}
		else {
			// error message ???
		}

	},  // eo jump to ori find


	// on close
	onClose: function(cmp) {
		var me = this;
		var callingGrid = me.getView().callingGrid;
		if (callingGrid) {
			var store = callingGrid.getStore();
			store.loadPage(store.currentPage);
		}
	},  // eo close


	// reset form
	resetForm: function(cmp) {
		var me = this;
		Oger.extjs.resetForm(me.getView().down('form'));
	},  // eo reset form


});
