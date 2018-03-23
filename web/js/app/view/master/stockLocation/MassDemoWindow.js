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
Ext.define('App.view.master.stockLocation.MassDemoWindow', {
	extend: 'Ext.window.Window',

	title: Oger._('Liste der gewünschten Lagerort Namen'),
	width: 550, height: 350,
	modal: true,
	autoScroll: true,
	layout: 'fit',

	items: [
		{ xtype: 'textarea', readOnly: true },
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



});
