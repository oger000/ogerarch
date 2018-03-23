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
Ext.define('App.view.system.userGroup.FormWinCtrl', {
	extend: 'Ext.app.ViewController',
	alias: 'controller.systemUserGroupFormWin',


	// prepare form
	prepForm: function(action, inVals, callingGrid) {

		var pForm = this.lookupReference('theForm');
		if (pForm.isDirty()) {
			Ext.create('Oger.extjs.MessageBox').alert(
				Oger._('Warnung'),
				Oger._('Das Formular enthält ungespeicherte Änderungen. Bitte diese zuerst abschliessen.'));
			return;
		}

		inVals = inVals || {};
		this.callingGrid = callingGrid

		if (action == 'UPDATE') {
			pForm.load({
				params: { _action: 'loadForm', userGroupId: inVals.userGroupId },
			});
			var bForm = pForm.getForm();
			bForm.findField('userGroupId').setVisible(true);
		}

		this.lookupReference('actionField').setValue(action);
		Oger.extjs.resetDirty(pForm);
	},  // eo prep form


	// on render
	onAfterRender: function(cmp) {
		var me = this;

		var map = new Ext.util.KeyMap({
			target: cmp.el,
			key: [ 10, Ext.event.Event.ENTER ],
			handler: function() {
				me.saveRecord();
			},
		});
	},  // eo on render


	// save record
	saveRecord: function() {
		var me = this;

		var pForm = me.lookupReference('theForm');
		pForm.submit({
			clientValidation: true, submitEmptyText: false,
			success: function(form, action) {
				Oger.extjs.resetDirty(form);
				Oger.extjs.expireAlert(Oger._('Hinweis'), Oger._('Datensatz erfolgreich gespeichert.'), null, null, MSG_DEFER);
				me.closeWindow();
			},
		});
	},  // eo save record


	// close window
	closeWindow: function() {
		this.getView().close();
	},


	// before close
	onBeforeClose: function (cmp, opts) {
		return Oger.extjs.confirmDirtyClose(cmp, this.lookupReference('theForm'));
	},


	// on close
	onClose: function(cmp, options) {
		var me = this;

		if (me.callingGrid && !me.callingGrid.isDestroyed) {
			var store = me.callingGrid.getStore();
			store.loadPage(store.currentPage);
		}
	},  // eo on close



});
