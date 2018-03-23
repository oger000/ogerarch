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
Ext.define('App.view.inputCenter.stock.prepFind.MassEditProtoWin', {
	extend: 'Ext.window.Window',

	title: Oger._('Protokoll zu Fund/Lager Massenbearbeitung Status'),
	width: 550, height: 550,
	modal: true,
	autoScroll: true,
	layout: 'fit',

	items: [
		{ xtype: 'form',
			bodyPadding: 15,
			border: false,
			autoScroll: true,
			layout: 'anchor',
			trackResetOnLoad: true,
			items: [
				{ xtype: 'displayfield', fieldLabel: Oger._('Änderung erfolgreich bei Fundnummer'), value: '',
					labelWidth: 500,
				},
				{ name: 'okMsg', xtype: 'textarea', readOnly: true,
					hideLabel: true, width: 500, height: 80,
				},
				{ xtype: 'panel', html: '<br>', border: false },
				{ xtype: 'panel', html: '<br>', border: false },
				{ xtype: 'displayfield', fieldLabel: Oger._('Fehlerprotokoll'), value: '',
					displayWidth: 500,
				},
				{ name: 'errorMsg', xtype: 'textarea', readOnly: true,
					hideLabel: true, width: 500, height: 200,
				},
			],
		},
	],

	buttonAlign: 'center',
	buttons: [
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


	// ######################################################################

	// inject data
	injectData: function(data) {
		this.down('form').getForm().setValues(data);
	},



});
