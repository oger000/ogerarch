/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/



Ext.require('App.store.Dummy');


/*
 * Startpoint for application.
 */
Ext.application({
	name: 'App',
	appFolder: 'js/app',  // without this setting the dynamic loading does not work - even if set in Ext.Loader

	controllers: [],
	stores: [],
	models: [],
	views: [],



	// init global listeners for extjs 4
	/*
	init: function() {
		this.control('window', {
			afterrender: this.onWindowRenderGlobal,
			show: this.onWindowRenderGlobal,
		});
	},  // eo init
	*/


	// start app
	launch: function() {

		// if there are no logon data, then show the logon form and return
		if (!OgerApp.logon) {
			Ext.create('App.view.system.LogonWin').show();
			return;
		}


		// set universal committed logon id
		Ext.Ajax.setExtraParams(
			Ext.Object.merge(
				{ '_LOGONID': OgerApp.logon.logonId },
				Ext.Ajax.getExtraParams()));

		// show viewport
		Ext.create('App.view.MainViewport').show();

		// load excavs grid automatically
		var mainMenu = Ext.ComponentQuery.query('mainmenu')[0];
		mainMenu.showCenterView(Ext.create('App.view.inputCenter.Panel'));

		// start keep alive manager and logon checker
		Ext.TaskManager.start({
			run: function() {
				Ext.Ajax.request({
					url: 'php/system/logon.php',
					params: { _action: 'checkLogon' },
					success: function(response) {
						var responseObj = Ext.decode(response.responseText);
						if (!responseObj.isLogon) {
							Ext.create('Oger.extjs.MessageBox').alert(
								Oger._('Fehler'),
								Oger._('Anmeldung abgelaufen.'),
								function(buttonId) {
									Ext.create('App.view.system.LogoffWin').show();
								}
							);
						}
					},
					failure: Oger.extjs.showAjaxFailure,
				});
			},
			// TODO move to config file / logon-data
			interval: 5 * 60 * 1000 //1000=1 second
		});

	},  // eo launch


	// global listeners
	config: {
		control: {
			'form': {
				actionfailed: 'onFormActionFailedGlobal',
			},
		},
	},


	// on form action failed show common errors
	onFormActionFailedGlobal: function(form, action) {
		if (action.type == 'load') {
			//Oger.extjs.resetDirty(form);
			Oger.extjs.showFormActionFailure(form, action);
		}
		if (action.type == 'submit') {
			if (!Oger.extjs.showFormActionFailure(form, action)) {
				//handle remaining failures
			}
		}
	},  // eo form action failed


	// on action complete
	/* MEMO necessary for extjs 4.x maybe obsolete in 5.x
	onActionComplete: function(form, action) {
		if (action.type == 'load') {  // for radioboxes and alike
			Oger.extjs.resetDirty(form);
		}
	},  // eo action complete
	*/


});
