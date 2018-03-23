/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Matrix selection window
*/
Ext.define('App.view.matrix.Window', {
	extend: 'Ext.window.Window',

	title: Oger._('Harris Matrix'),
	width: 700,
	height: 500,
	modal: true,
	//autoScroll: true,
	layout: 'fit',

	items: [ { xtype: 'matrixmainselepanel' } ],

	buttonAlign: 'center',
	buttons: [
		{ text: Oger._('Ausgabe starten'),
			handler: function(button, event) {
				this.up('window').startMatrix();
			}
		},
		{ text: Oger._('Schliessen'),
			handler: function(button, event) {
				this.up('window').close();
			}
		},
		{ text: Oger._('Hilfe'),
			handler: function(button, event) {
				window.open('help/matrix.html',
										'HELP',
										'left=' + Math.floor(window.innerWidth * 0.1) + ',top=' + Math.floor(window.innerHeight * 0.1) +
										',width=' + Math.floor(window.innerWidth * 0.8) + ',height=' + Math.floor(window.innerHeight * 0.8) +
										',menubar=yes,toolbar=yes,scrollbars=yes,resizeable=yes');
			}
		},
	],  // eo buttons

	listeners: {
		afterrender: function(cmp, options) {
			cmp.alignTo(Ext.ComponentQuery.query('mainviewport')[0], 'c-c?');
		},
	},

	// ####################################

	// start matrix
	startMatrix: function() {
		var me = this;
		var pForm = me.down('matrixmainseleform');
		var bForm = pForm.getForm();
		if (!bForm.isValid()) {
			Ext.Msg.alert(Oger._('Hinweis'), Oger._('Fehler im Auswahlformular.'));
			return;
		}
		var excavId = '';
		if (this.down('matrixmainselepanel').excavRecord) {
			excavId = this.down('matrixmainselepanel').excavRecord.data.id;
		}
		if (!excavId) {
			Ext.Msg.alert(Oger._('Hinweis'),
				Oger._('Es wurde keine Grabung ausgewählt. Die Matrix ist pro Grabung getrennt zu erstellen.'));
			return;
		}
		me.doMatrix(excavId, pForm, bForm);
	},  // eo start matrix


	// process matrix
	doMatrix: function(excavId, pForm, bForm) {

		var vals = bForm.getValues();
		Ext.Object.merge(vals, { _action: 'matrix', excavId: excavId }, Ext.Ajax.getExtraParams());

		var urlStr = pForm.url + '?' + Ext.Object.toQueryString(vals);
		window.open(urlStr,
								'MATRIX',
								'left=' + Math.floor(window.innerWidth * 0.1) + ',top=' + Math.floor(window.innerHeight * 0.1) +
								',width=' + Math.floor(window.innerWidth * 0.8) + ',height=' + Math.floor(window.innerHeight * 0.8) +
								',menubar=yes,toolbar=yes,scrollbars=yes,resizeable=yes');
	},  // eo perform matrix


});
