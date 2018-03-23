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
Ext.define('App.view.system.userGroup.GridWinCtrl', {
	extend: 'Ext.app.ViewController',
	alias: 'controller.systemUserGroupGridWin',


	mainUrl: 'php/system/userGroup.php',


	// on render
	onAfterRender: function(cmp) {
		var me = this;

		me.defaultFilter();

		var map = new Ext.util.KeyMap({
			target: cmp.el,
			key: [ 10, Ext.event.Event.ENTER ],
			handler: function() {
				me.applyFilter();
			},
		});
	},  // eo on render


	// set default filter values
	defaultFilter: function() {
		var me = this;

		var filterForm = me.lookupReference('filterForm');
		Oger.extjs.emptyForm(filterForm);
	},  // eo default filter


	// reset filter values
	resetFilter: function() {
		var me = this;

		var filterForm = me.lookupReference('filterForm');
		filterForm.reset();
	},  // eo reset filter


	// on filter change
	onFilterDirtyChange: function(cmp, isDirty) {
		var me = this;

		if (cmp.inputEl) {
			if (isDirty) {
				cmp.inputEl.addCls('oger-filter-field-dirty');
			}
			else {
				cmp.inputEl.removeCls('oger-filter-field-dirty');
			}
		}
	},  // eo filter change


	// on item double click
	onItemDblClick: function() {
		this.doEditRecord('UPDATE');
	},  // eo item dbl click


	// apply filter
	applyFilter: function() {
		var me = this;

		var filterForm = me.lookupReference('filterForm');
		var vals = filterForm.getForm().getValues();
		Oger.extjs.resetDirty(filterForm);

		if (vals.filterText) {
			vals.filterText = '%' + vals.filterText + '%';
		}

		var store = me.lookupReference('theGrid').getStore();
		store.clearFilter(true);
		store.filter([
			{ property: 'filterText', value: vals.filterText, root: 'data'},
		]);

	},  // eo apply filter


	// add record
	newRecord: function() {
		this.doEditRecord('INSERT');
	},  // eo add record


	// edit record
	editRecord: function() {
		this.doEditRecord('UPDATE');
	},  // eo edit record


	// edit current record or add new
	doEditRecord: function(action) {
		var me = this;

		var grid = me.lookupReference('theGrid');
		var data;

		var rec;
		if (action == 'UPDATE') {
			rec = grid.getSelectionModel().getSelection()[0];
			if (!rec) {
				Ext.create('Oger.extjs.MessageBox').alert(
					Oger._('Hinweis'),
					Oger._('Bitte zuerst Datensatz auswählen.'));
				return;
			}
			data = rec.data;
		}

		var win = Oger.extjs.createOnce(App.view.system.userGroup.FormWin.xtype);
		win.show();
		win.getController().prepForm(action, data , grid);
	},  // eo edit record


	// delete current record
	deleteRecord: function() {
		var me = this;

		var grid = me.lookupReference('theGrid');

		var rec = grid.getSelectionModel().getSelection()[0];
		if (!rec) {
			Ext.create('Oger.extjs.MessageBox').alert(
				Oger._('Hinweis'),
				Oger._('Bitte zuerst Datensatz auswählen.'));
			return;
		}

		Ext.create('Oger.extjs.MessageBox').confirm(
			Oger._('Bestätigung erforderlich'),
			Ext.String.format(Oger._('Usergruppe {0} {1} löschen?'),
												 rec.data.userGroupId, rec.data.name),
			function(btn) {
				if (btn == 'yes') {
					Ext.Ajax.request({
						url: me.mainUrl,
						params: { _action: 'delete', userGroupId: rec.data.userGroupId },
						success: function(r) {
							var resp = Ext.decode(r.responseText, true) || {};
							if (resp.success) {
								grid.getStore().load();
							}
							// we expect the response to have a message (even if successful)
							Ext.create('Oger.extjs.MessageBox').alert(
								Oger._('Ergebnis'),
								resp.msg);
						},
						failure: Oger.extjs.showAjaxFailure,
					});
				}
			}
		);
	},  // eo delete record


	// close window
	closeWindow: function() {
		this.getView().close();
	},  // eo close window


});
