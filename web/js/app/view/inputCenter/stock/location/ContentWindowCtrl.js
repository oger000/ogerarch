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
Ext.define('App.view.inputCenter.stock.location.ContentWindowCtrl', {
	extend: 'Ext.app.ViewController',
	alias: 'controller.ic_stockLocationContentWindow',

/*
			'ic_stocklocationcontentwindow ic_stocklocationcontentform': {
				actioncomplete: function(form, action) {
					if (action.type == 'load') {
						form.findField('dbAction').setValue('UPDATE');
						Oger.extjs.resetDirty(form);
					}
				},
			},  // eo form

			'ic_stocklocationcontentwindow ic_stocklocationcontentform field[name=typeId]': {
				beforerender: function(cmp, opts) {
					cmp.getStore().getProxy().setExtraParam('_action', 'loadSizeCombo');
					cmp.getStore().load();
				},
			},
			'ic_stocklocationcontentwindow ic_stocklocationcontentform field[name=maxInnerTypeId]': {
				beforerender: function(cmp, opts) {
					cmp.getStore().getProxy().setExtraParam('_action', 'loadSizeCombo');
					cmp.getStore().load();
				},
			},
*/


	// ########################################################


	// show form (edit/insert)
	prepForm: function(action, vals, callingGrid, opts) {
		var me = this;
		opts = opts || {};

		var win = me.getView();
		win.callingGrid = callingGrid;
		win.opts = opts;

		var pForm = win.down('form');
		var bForm = pForm.getForm();

		Oger.extjs.emptyForm(bForm);
		bForm.findField('dbAction').setValue(action);

		if (action == 'UPDATE') {
			pForm.load({ params: { _action: 'loadLocContent',
														 excavId: vals.excavId, stockLocationId: vals.stockLocationId } });
		}

		if (action == 'INSERT') {
			bForm.setValues({
				excavId: vals.excavId,
				outerId: vals.id,
				outerName: vals.name,
			});
			//bForm.findField('typeId').setReadOnly(false);
		}

		if (vals.canItem == 0) {
			Ext.create('Oger.extjs.MessageBox').alert(
				Oger._('Hinweis'),
				Oger._('Dieser Lagerort kann keine Funde aufnehmen.'));
		}

		Oger.extjs.resetDirty(bForm);

	},  // eo show form




	// #########################################


	// save location content
	saveLocContent: function() {
		var me = this;

		var win = me.getView();
		var pForm = win.down('form');
		var bForm = pForm.getForm();
		var vals = bForm.getValues();

		pForm.submit(
			{ params: { _action: 'saveLocContent' },
				clientValidation: true,
				success: function(form, action) {
					Oger.extjs.expireAlert(Oger._('Info'), Oger._('Datensatz erfolgreich gespeichert.'));
					Oger.extjs.resetDirty(form);
					if (win.opts.prepFindGrid) {
						win.opts.prepFindGrid.getStore().filter('stockLocationId', vals.stockLocationId);
					}
					win.close();
				},
			}
		);
	},  // eo save record



	// edit master for this container
	editContentMaster: function() {
		var me = this;

		var win = me.getView();
		var data = win.down('form').getForm().getValues();
		var opts = {};
		opts._usecase = 'INPUTCENTER';

		var masterWin = Ext.create('App.view.master.stockLocation.DetailWindow');
		masterWin.getController().prepForm('UPDATE', data, win.callingGrid, opts);
		masterWin.show();
	},  // eo edit content master


	// on close
	onClose: function(cmp) {
		var me = this;

		var callingGrid = me.getView().callingGrid;
		if (callingGrid) {
			var store = callingGrid.getStore();
			store.load({ params: { stockLocationId: App.clazz.StockLocation.ROOT_ID }});
		}

		var prepFindGrid = Ext.ComponentQuery.query('ic_stockprepfindgrid')[0];
		if (prepFindGrid) {
			var store = prepFindGrid.getStore();
			store.loadPage(store.currentPage);
		}
	},  // eo  on close


	// close window
	closeWindow: function(cmp) {
		var me = this;
		me.getView().close();
	},  // eo  close window



});
