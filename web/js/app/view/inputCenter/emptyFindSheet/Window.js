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
Ext.define('App.view.inputCenter.emptyFindSheet.Window', {
	extend: 'Ext.window.Window',

	title: Oger._('Blanko Fundzettel'),
	width: 700,
	height: 500,
	modal: true,
	//autoScroll: true,
	layout: 'fit',

	items: [ { xtype: 'emptyfindsheetpanel' } ],

	buttonAlign: 'center',
	buttons: [
		{ text: Oger._('Druck starten'),
			handler: function(button, event) {
				this.up('window').startOutput();
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


	// start output
	startOutput: function() {
		var me = this;
		var pForm = me.down('emptyfindsheetform');
		var bForm = pForm.getForm();
		if (!bForm.isValid()) {
			Oger.extjs.showInvalidFields(bForm);
			return;
		}
		var excavId = '';
		if (this.down('emptyfindsheetpanel').excavRecord) {
			excavId = this.down('emptyfindsheetpanel').excavRecord.data.id;
		}
		/*
		if (!excavId) {
			Ext.Msg.confirm(Oger._('Bestätigung erforderlich'),
											Oger._('Es wurde keine Grabung ausgewählt. Soll der Fundzettel ohne Grabung erstellt werden?'),
				function(answerId) {
					if(answerId == 'yes') {
						me.doExport(excavId, pForm, bForm);
					}
				}
			);
		}
		else {  // excav is selected
			me.doOutput(excavId, pForm, bForm);
		}
		*/
		// print without asking
		me.doOutput(excavId, pForm, bForm);
	},  // eo start export


	// process arch find sheet
	doOutput: function(excavId, pForm, bForm) {

		var vals = bForm.getValues();
		Ext.Object.merge(vals, { _action: 'printEmptyFindSheet', excavId: excavId, }, Ext.Ajax.getExtraParams());

		var urlStr = pForm.url + '?' + Ext.Object.toQueryString(vals);
		window.open(urlStr,
								'ARCHFINDSHEET',
								'left=' + Math.floor(window.innerWidth * 0.1) + ',top=' + Math.floor(window.innerHeight * 0.1) +
								',width=' + Math.floor(window.innerWidth * 0.8) + ',height=' + Math.floor(window.innerHeight * 0.8));
	},  // eo perform  arch find sheet


});
