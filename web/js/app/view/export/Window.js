/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Export window
*/
Ext.define('App.view.export.Window', {
	extend: 'Ext.window.Window',

	title: Oger._('Export'),
	width: 700,
	height: 500,
	modal: true,
	autoScroll: true,
	layout: 'fit',

	items: [ { xtype: 'exportmainpanel' } ],

	buttonAlign: 'center',
	buttons: [
		{ text: Oger._('Export starten'),
			handler: function(button, event) {
				this.up('window').startExport();
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

	// start export
	startExport: function() {
		var me = this;
		var pForm = me.down('exportform');
		var bForm = pForm.getForm();
		if (!bForm.isValid()) {
			Oger.extjs.showInvalidFields(bForm);
			return;
		}
		var excavId = '';
		if (this.down('exportmainpanel').excavRecord) {
			excavId = this.down('exportmainpanel').excavRecord.data.id;
		}
		if (!excavId) {
			Ext.Msg.confirm(Oger._('Bestätigung erforderlich'),
											Oger._('Es wurde keine Grabung ausgewählt. Sollen ALLE Grabungen exportiert werden?'),
				function(answerId) {
					if(answerId == 'yes') {
						me.doExport(excavId, pForm, bForm);
					}
				}
			);
		}
		else {  // excav is selected
			me.doExport(excavId, pForm, bForm);
		}
	},  // eo start export


	// process export
	doExport: function(excavId, pForm, bForm) {

		var vals = bForm.getValues();
		Ext.Object.merge(vals, { _action: 'export', excavId: excavId }, Ext.Ajax.getExtraParams());

		var urlStr = pForm.url + '?' + Ext.Object.toQueryString(vals);
		window.open(urlStr,
								'EXPORT',
								'left=' + Math.floor(window.innerWidth * 0.1) + ',top=' + Math.floor(window.innerHeight * 0.1) +
								',width=' + Math.floor(window.innerWidth * 0.8) + ',height=' + Math.floor(window.innerHeight * 0.8));
	},  // eo perform export


});
