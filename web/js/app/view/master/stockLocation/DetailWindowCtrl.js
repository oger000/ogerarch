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
Ext.define('App.view.master.stockLocation.DetailWindowCtrl', {
	extend: 'Ext.app.ViewController',
	alias: 'controller.stockLocationMasterDetailWindow',


	// show form (edit/insert)
	prepForm: function(action, vals, callingGrid, opts) {
		var me = this;

		var win = me.getView();
		win.callingGrid = callingGrid;
		win.inOpts = opts;

		var pForm = win.down('form');
		var bForm = pForm.getForm();

		//Oger.extjs.emptyForm(bForm);
		bForm.setValues({
			dbAction: action,
			_usecase: win.inOpts._usecase,
		});

		if (action == 'UPDATE') {
			pForm.load({ params: { _action: 'loadRecord', stockLocationId: vals.stockLocationId } });
			pForm.down('#massAddFieldSet').hide();
		}


		// add inner location
		if (action == 'INSERT') {

			if (vals.maxInnerTypeId == 0) {  // force convert "0" to int
				Ext.create('Oger.extjs.MessageBox').alert(
					Oger._('Hinweis'),
					Oger._('Dieser Lagerort kann keine Behälter aufnehmen.'),
					function() {
						win.disable();
						win.close();
					});
				return;
			}

			bForm.setValues({
				outerId: vals.stockLocationId,
				outerName: vals.name,
			});

			if (win.inOpts._usecase == 'MASTER') {
				bForm.setValues({
					reusable: '1',
				});
			}
			else {  // INPUTCENTER
				bForm.setValues({
					excavId: vals.excavId,  // has to be provided by calling func
					canItem: '1',
					movable: '1',
				});
			}

		}  // eo insert

		// adjust form and stock location type store
		var locTypeStore = bForm.findField('typeId').getStore();
		locTypeStore.clearFilter(true);

		var innerLocTypeStore = bForm.findField('maxInnerTypeId').getStore();
		innerLocTypeStore.clearFilter(true);

		if (win.inOpts._usecase == 'INPUTCENTER') {

			win.setTitle(Oger._('Transportbehälter'));

			bForm.findField('movable').hide();
			bForm.findField('canReusableMovable').hide();
			pForm.down('#maxInnerTypeFieldSet').collapse();

			locTypeStore.filter('excavVisible', '1');
			innerLocTypeStore.filter('excavVisible', '1');

		}  // adjust form to inputcenter


		Oger.extjs.resetDirty(bForm);

	},  // eo show form




	// #########################################


	// on form load for update
	onFormLoad: function(form, action) {
		var me = this;
		var win = me.getView();

		if (action.type == 'load') {

			var vals = action.result.data;

			if (win.inOpts._usecase != 'MASTER') {

				if (vals.reusable != 0 || vals.movable == 0) {

					Ext.create('Oger.extjs.MessageBox').alert(
						Oger._('Hinweis'),
						Oger._('Unbewegliche und wiederverwendbare Lagerorte können hier nicht bearbeitet werden.'),
						function() {
							win.disable();
							win.close();
						});
					return;
				}

			}  // eo not master (inputcenter)

			if (win.inOpts._usecase == 'MASTER') {
				if (!vals.excavId) {
					form.findField('excavId').setValue(App.clazz.StockLocation.REUSABLES_EXCAV_MARKER);
				}
			}  // eo master usage

			form.findField('dbAction').setValue('UPDATE');
			Oger.extjs.resetDirty(form);
		}

	},  // eo on form load




	// save record
	saveRecord: function() {
		var me = this;

		var win = me.getView();
		var pForm = win.down('form');
		var bForm = pForm.getForm();
		pForm.submit(
			{ params: { _action: 'save' },
				clientValidation: true,
				success: function(form, action) {

					// show demo names
					var resp = action.result;
					if (resp.isDemo) {
						var demoWin = Ext.create('App.view.master.stockLocation.MassDemoWindow');
						demoWin.down('textarea').setValue(resp.demoNames);
						demoWin.show();
						return;
					}

					// default form handling
					Oger.extjs.resetDirty(form);
					win.close();
				},
			}
		);
	},  // eo save record


	// on collapse mass add field set
	onCollapseMassAddFieldSet: function() {
		var me = this;

		var bForm = me.getView().down('form').getForm();
		bForm.findField('name').setVisible(true);
		bForm.setValues({
			massAddMode: '0',
		});
	},  // eo collapse mass add field set


	// on expand mass add field set
	onExpandMassAddFieldSet: function() {
		var me = this;

		var bForm = me.getView().down('form').getForm();
		bForm.findField('name').setVisible(false);
		bForm.setValues({
			massAddMode: '1',
			prefixSpace: '1',
			postfixSpace: '1',
		});
	},  // eo expand mass add field set


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
