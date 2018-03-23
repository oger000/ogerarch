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
Ext.define('App.view.inputCenter.stock.prepFind.MoveWindow', {
	extend: 'Ext.window.Window',
	alias: 'widget.ic_moveprepfindwindow',
	controller: 'ic_movePrepFindWindow',

	title: Oger._('Funde verschieben'),
	width: 550, height: 250,
	modal: true,
	//autoScroll: true,
	layout: 'fit',

	items: [
		{ xtype: 'form',
			url: 'php/scripts/prepFind.php',
			trackResetOnLoad: true,
			bodyPadding: 15, border: false,
			autoScroll: true,
			layout: 'anchor',

			defaults: { labelWidth: 120 },

			items: [

				{ name: 'moveTo', xtype: 'hidden' },
				{ name: 'excavId', xtype: 'hidden' },

				{ name: 'moveToName', xtype: 'textfield', fieldLabel: Oger._('Verschieben nach'),
					width: 300, readOnly: true, submitValue: false,
				},

				/*
				{ name: 'moveCount', xtype: 'textfield', fieldLabel: Oger._('Anzahl Datensätze'),
					width: 300, readOnly: true,
				},
				*/

				{ name: 'archFindIdList', xtype: 'textarea', fieldLabel: Oger._('Fundnummern'),
					width: 500, readOnly: true,
				},
			],
		},
	],

	buttonAlign: 'center',
	minButtonWidth: 30,
	buttons: [
		{ text: Oger._('Verschieben'), handler: 'moveRecord' },
		{ text: Oger._('Schliessen'), handler: 'closeWindow' },
	],


	listeners: {
		close: 'onClose',
	},


});
