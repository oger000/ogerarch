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
Ext.define('App.view.system.AboutWin', {
	extend: 'Ext.window.Window',

	title: Oger._('Über'),
	width: 500, height: 300,
	modal: true,
	autoScroll: true,
	layout: 'fit',
	items: [
		{ xtype: 'form',
			layout: 'fit',
			bodyStyle: 'padding:15px; background:transparent',
			border: false,
			url: 'php/system/about.php?_action=load',
			items: [
				{ xtype: 'textarea', name: 'about' },
			],
		},
	],
	buttonAlign: 'center',
	buttons: [
		{ text: Oger._('Schliessen'),
			handler: function(button, event) {
				this.up('window').close();
			},
		},
	],

	listeners: {
		afterrender: function(cmp) {
			cmp.down('form').load();
		},
	},  // eo listeners


	// ######################################




});

