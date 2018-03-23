/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Check data consitency window
*/
Ext.define('App.view.checkConsistency.Window', {
	extend: 'Ext.window.Window',

	title: Oger._('Konsistenzprüfung'),
	width: 700,
	height: 500,
	modal: true,
	//autoScroll: true,
	layout: 'fit',

	items: [ { xtype: 'checkconsistencymainpanel' } ],

	buttonAlign: 'center',
	buttons: [
		{ text: Oger._('Prüfung starten'),
			handler: function(button, event) {
				this.up('window').startCheckConsistency();
			}
		},
		{ text: Oger._('Schliessen'),
			handler: function(button, event) {
				this.up('window').close();
			}
		},
	],  // eo buttons

	listeners: {
		afterrender: function(cmp, options) {
			cmp.alignTo(Ext.ComponentQuery.query('mainviewport')[0], 'c-c?');
		},
	},

	// ####################################

	// start consistency check
	startCheckConsistency: function() {
		var me = this;
		var pForm = me.down('checkconsistencyform');
		var bForm = pForm.getForm();
		if (!bForm.isValid()) {
			Oger.extjs.showInvalidFields(bForm);
			return;
		}
		var excavId = '';
		if (this.down('checkconsistencymainpanel').excavRecord) {
			excavId = this.down('checkconsistencymainpanel').excavRecord.data.id;
		}
		if (!excavId) {
			Ext.Msg.confirm(Oger._('Bestätigung erforderlich'),
											Oger._('Es wurde keine Grabung ausgewählt. Sollen ALLE Grabungen geprüft werden?'),
				function(answerId) {
					if(answerId == 'yes') {
						me.doCheckConsistency(excavId, pForm, bForm);
					}
				}
			);
		}
		else {  // excav is selected
			me.doCheckConsistency(excavId, pForm, bForm);
		}
	},  // eo start consistency check


	// process consistency check
	doCheckConsistency: function(excavId, pForm, bForm) {

		var vals = bForm.getValues();
		Ext.Object.merge(vals, { _action: 'checkConsistency', excavId: excavId }, Ext.Ajax.getExtraParams());

		var urlStr = pForm.url + '?' + Ext.Object.toQueryString(vals);
		window.open(urlStr,
								'CHECK',
								'left=' + Math.floor(window.innerWidth * 0.1) + ',top=' + Math.floor(window.innerHeight * 0.1) +
								',width=' + Math.floor(window.innerWidth * 0.8) + ',height=' + Math.floor(window.innerHeight * 0.8) +
								',menubar=yes,resizable=yes,scrollbars=yes,toolbar=yes');
	},  // eo perform consistency check

	// show info for conistency check levels
	showCheckLevelInfoWindow: function () {
		var win = Ext.create('App.view.checkConsistency.CheckLevelInfoWindow');
		win.show();
	},  // eo level info




});
