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
Ext.define('App.view.inputCenter.stock.location.ContentWindow', {
	extend: 'Ext.window.Window',
	alias: 'widget.ic_stocklocationcontentwindow',
	controller: 'ic_stockLocationContentWindow',

	title: Oger._('Lagerort - Inhalt'),
	width: 600, height: 450,
	modal: true,
	//autoScroll: true,
	layout: 'fit',

	items: [
		{ xtype: 'form',

			url: 'php/scripts/stockLocation.php',
			trackResetOnLoad: true,

			bodyPadding: 15, border: false,
			autoScroll: true,
			layout: 'anchor',

			items: [
				{ name: 'excavId', xtype: 'hidden' },
				{ name: 'stockLocationId', xtype: 'hidden' },
				{ name: 'dbAction', xtype: 'hidden' },

				{ name: 'name', xtype: 'textfield', fieldLabel: Oger._('Bezeichnung'),
					width: 500, readOnly: true,
				},

				{ xtype: 'displayfield', fieldLabel: Oger._('Fundnummern') },
				{ name: 'archFindIdList', xtype: 'textarea',
					width: 500, height: 150, validator: multiXidSubIdValid,
				},

				{ xtype: 'displayfield', fieldLabel: Oger._('Anmerkungen zum Inhalt'), width: 300, labelWidth: 300 },
				{ name: 'contentComment', xtype: 'textarea',
					width: 500, height: 120,
				},

			],
		},
	],

	buttonAlign: 'center',
	minButtonWidth: 30,
	buttons: [
		{ text: Oger._('Speichern'), handler: 'saveLocContent' },
		{ text: Oger._('Zurücksetzen'), handler: 'resetForm' },
		{ text: Oger._('Schliessen'), handler: 'closeWindow' },
		{ xtype: 'tbspacer', width: 20 },
		{ text: Oger._('Stammdaten'), handler: 'editContentMaster' },
	],


	listeners: {
		beforeclose: Oger.extjs.defaultOnBeforeWinClose,
		close: 'onClose',
	},

});
