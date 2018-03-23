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
Ext.define('App.view.system.user.FormWinCtrl', {
	extend: 'Ext.app.ViewController',
	alias: 'controller.systemUserFormWin',


	// prepare form
	prepForm: function(action, inVals, callingGrid, opts) {
		var me = this;

		inVals = inVals || {};
		opts = opts || {};

		var pForm = me.lookupReference('theForm');
		if (pForm.isDirty()) {
			Ext.create('Oger.extjs.MessageBox').alert(
				Oger._('Warnung'),
				Oger._('Das Formular enthält ungespeicherte Änderungen. Bitte diese zuerst abschliessen.'));
			return;
		}

		me.callingGrid = callingGrid;
		me.isAdmin = opts.isAdmin;


		var assignedUserGroupGrid = me.lookupReference('assignedUserGroupGrid');
		var availableUserGroupGrid = me.lookupReference('availableUserGroupGrid');

		pForm.down('tabpanel').setActiveTab(0);
		assignedUserGroupGrid.setDisabled(!me.isAdmin);
		availableUserGroupGrid.setDisabled(!me.isAdmin);

		var bForm = me.lookupReference('theForm').getForm();
		bForm.findField('logonName').setDisabled(!me.isAdmin);
		me.lookupReference('permPanel').setDisabled(!me.isAdmin);
		bForm.findField('skipSignTimeout').setHidden(!me.isAdmin);

		// load record on update
		if (action == 'UPDATE') {
			pForm.load({
				params: { _action: 'loadForm', userId: inVals.userId },
			});
			var bForm = pForm.getForm();
			bForm.findField('userId').setVisible(true);
			bForm.findField('oldPassword').setVisible(true);
		}


		// load user group grids

		var sto = assignedUserGroupGrid.getStore();
		sto.getProxy().setExtraParams({
			_action: 'loadAssignedUserGroupGrid',
			userId: inVals.userId,
		});
		sto.loadPage(1);
		sto.sort('name', 'ASC');

		var sto = availableUserGroupGrid.getStore();
		sto.getProxy().setExtraParams({
			_action: 'loadAvailableUserGroupGrid',
			userId: inVals.userId,
		});
		sto.loadPage(1);
		sto.sort('name', 'ASC');

		// set action
		me.lookupReference('actionField').setValue(action);
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


	// on import ssl change
	onImportSslClientCertChange: function(cmp, newValue) {
		var me = this;
		var bForm = me.lookupReference('theForm').getForm();
		bForm.findField('sslClientDN').setDisabled(newValue);
		bForm.findField('sslClientIssuerDN').setDisabled(newValue);
	},  // eo on import ssl change


	// fetch ssl client dert
	fetchSslClientCert: function() {
		var me = this;

		Ext.Ajax.request({
			url: 'php/system/logon.php',
			params: { _action: 'loadCurrentSslClientCertData' },
			success: function(resp) {
				var respObj = Ext.decode(resp.responseText);
				if (!respObj.success) {
					Ext.create('Oger.extjs.MessageBox').alert(Oger._('Fehler'), respObj.msg);
					return;
				}
				var bForm = me.lookupReference('theForm').getForm();
				bForm.findField('sslClientDN').setValue(respObj.data.sslClientDN);
				bForm.findField('sslClientIssuerDN').setValue(respObj.data.sslClientIssuerDN);
			},
			failure: Oger.extjs.showAjaxFailure,
		});
	},  // eo fetch ssl cert


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


	// drag user group from available to assigned grid
	onDropToAssigned: function() {
		this.setUserGroupIdListField();
	},


	// drag user group from assigned to available grid
	onDropToAvailable: function() {
		this.setUserGroupIdListField();
	},


	// get / create assigned user group id list
	getUserGroupIdList: function () {

		var userGrpArr = [];
		var store = this.lookupReference('assignedUserGroupGrid').getStore();
		store.each(function(rec) {
			userGrpArr.push(parseInt(rec.get('userGroupId')));
		});

		userGrpArr.sort();
		return userGrpArr.join(', ');
	},  // eo get user group id list


	// set user group id list field from assigned user group grid
	setUserGroupIdListField: function () {
		this.lookupReference('userGroupIdListField').setValue(this.getUserGroupIdList());
	},  // eo set user group id list field


	// refresh available user groups grid
	// advanced case study
	// ATTENTION: work happens in on-load listener !!!
	refreshAvailableUserGroupGrid: function() {
		var me = this;

		// create tmp store and load ALL user groups
		var tmpStore = Ext.create('App.store.UserToUserGroupUniqGroup');
		var pxy = tmpStore.getProxy();
		pxy.setExtraParams({
			_action: 'loadAvailableUserGroupGrid',
			userId: 0,
		});
		tmpStore.on('load', me.refreshAvailableUserGroupGridWorker, me);
		tmpStore.load();

	},  // eo refresh call


	// refresh available user groups grid
	// advanced case study
	// worker - called after load is ready
	refreshAvailableUserGroupGridWorker: function(allStore) {
		var me = this;

		var availStore = me.lookupReference('availableUserGroupGrid').getStore();
		var assigStore = me.lookupReference('assignedUserGroupGrid').getStore();

		// find records that can be updated in the assig store
		var tmpStore = assigStore;
		var updRecs = [];
		tmpStore.each(function(oldRec) {
			var newRec = allStore.findRecord('userGroupId', oldRec.get('userGroupId'));
			if (newRec) {
				updRecs.push(newRec);
			}
		});
		// repopulate the store with the updated records
		// and remove used records from all groups fake store
		tmpStore.loadData(updRecs);
		allStore.remove(updRecs);


		// find records that can be updated in the avail store
		var tmpStore = availStore;
		var updRecs = [];
		tmpStore.each(function(oldRec) {
			var newRec = allStore.findRecord('userGroupId', oldRec.get('userGroupId'));
			if (newRec) {
				updRecs.push(newRec);
			}
		});
		// repopulate the store with the updated records
		tmpStore.loadData(updRecs);
		allStore.remove(updRecs);

		tmpStore = null;

		// add user groups from the all groups fake store that are
		// neither in the assig store nor in the avail store
		// All used records are removed so we can simply add all remaining recs
		availStore.loadData(allStore.getData(), true);

	},  // eo on refresh




});
