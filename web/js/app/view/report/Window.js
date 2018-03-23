/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Report selection window
*/
Ext.define('App.view.report.Window', {
	extend: 'Ext.window.Window',

	title: Oger._('Protokolle und Listen'),
	width: 700,
	height: 500,
	modal: true,
	//autoScroll: true,
	layout: 'fit',

	items: [ { xtype: 'reportmainselepanel' } ],

	buttonAlign: 'center',
	buttons: [
		{ text: Oger._('Druck erstellen'),
			handler: function(button, event) {
				this.up('window').startReport();
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

	// start report
	startReport: function() {
		var me = this;
		var pForm = me.down('reportmainseleform');
		var bForm = pForm.getForm();
		if (!bForm.isValid()) {
			Ext.Msg.alert(Oger._('Hinweis'), Oger._('Fehler im Auswahlformular.'));
			return;
		}
		var excavId = '';
		if (this.down('reportmainselepanel').excavRecord) {
			excavId = this.down('reportmainselepanel').excavRecord.data.id;
		}
		if (!excavId) {
			Ext.Msg.prompt(Oger._('Bestätigung erforderlich'),
				Oger._('Es wurde keine Grabung ausgewählt. Wenn ALLE Grabungen exportiert werden sollen, dann bitte "***" eingeben.'),
				function(answerId, text) {
					if(answerId == 'ok' && text == '***') {
						me.doReport(excavId, pForm, bForm);
					}
				}
			);
		}
		else {  // excav is selected
			me.doReport(excavId, pForm, bForm);
		}
	},  // eo start report


	// process report
	doReport: function(excavId, pForm, bForm) {

		var vals = bForm.getValues();
		Ext.Object.merge(vals, { _action: 'report', excavId: excavId }, Ext.Ajax.getExtraParams());

		var urlStr = pForm.url + '?' + Ext.Object.toQueryString(vals);
		window.open(urlStr,
								'REPORT',
								'left=' + Math.floor(window.innerWidth * 0.1) + ',top=' + Math.floor(window.innerHeight * 0.1) +
								',width=' + Math.floor(window.innerWidth * 0.8) + ',height=' + Math.floor(window.innerHeight * 0.8));
	},  // eo perform report


});
