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
Ext.define('App.view.master.stockLocation.DeleteWindowCtrl', {
	extend: 'Ext.app.ViewController',
	alias: 'controller.stockLocationMasterDeleteWindow',


	// show delete form
	// action param is unused
	prepForm: function(action, vals, callingGrid, opts) {
		var me = this;

		var win = me.getView();
		win.callingGrid = callingGrid;
		win.inOpts = opts;

		var pForm = win.down('form');
		var bForm = pForm.getForm();

		bForm.setValues(vals);
		bForm.setValues({
			_usecase: win.inOpts._usecase,
		});


		if (win.inOpts._usecase != 'MASTER') {

			win.setTitle(Oger._('Grabungspezifische Lagerorte löschen'));

			// inner locations can be deleted - so we cannot abort here
			/*
			if (parseInt(vals.reusable) || !parseInt(vals.movable)) {
				Ext.create('Oger.extjs.MessageBox').alert(
					Oger._('Hinweis'),
					Oger._('Unbewegliche und wiederverwendbare Lagerorte können hier nicht gelöscht werden.'),
					function() {
						var win = me.getWinRef();
						win.disable();
						win.close();
					});
				return;
			}
			*/

			var fld = bForm.findField('deleteExcavLoc');
			fld.enable();
			//fld.setReadOnly(true);
			fld.hide();
			bForm.setValues({
				deleteExcavLoc: '1',
			});

		}  // eo inputcenter

		Oger.extjs.resetDirty(bForm);

	},  // eo prep form


	// on change deleteInnerLoc
	onChangeDeleteInnerLoc: function(cmp, newValue, oldValue) {
		var me = this;
		var win = me.getView();

		// in excav use case deleteExcavLoc is hidden, so return
		if (win.inOpts._usecase != 'MASTER') {
			return;
		}
		var form = cmp.up('form').getForm();
		form.findField('deleteExcavLoc').setDisabled(!newValue);
	},  // eo change deleteInnerLoc


	// delete record
	deleteRecord: function() {
		var me = this;

		var win = me.getView();
		var pForm = win.down('form');
		var bForm = pForm.getForm();
		pForm.submit(
			{ params: { _action: 'delete' },
				clientValidation: true,
				success: function(form, action) {
					var resp = action.result;

					var win = Ext.create('App.view.master.stockLocation.DeleProtoWindow');
					win.down('textarea').setValue(resp.proto);
					win.show();

					if (resp.deleteApplyMode != 'apply') {
						return;
					}

					Oger.extjs.resetDirty(form);
					win.close();
				},
			}
		);
	},  // eo delete record


	// on close
	onClose: function(cmp) {
		var me = this;

		var callingGrid = me.getView().callingGrid;
		if (callingGrid) {
			var store = callingGrid.getStore();
			store.load({ params: { stockLocationId: App.clazz.StockLocation.ROOT_ID }});
		}
	},  // eo  on close


	// close window
	closeWindow: function(cmp) {
		var me = this;
		me.getView().close();
	},  // eo  close window



});
