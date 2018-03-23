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
Ext.define('App.view.inputCenter.stock.prepFind.DeleteWindow', {
	extend: 'Ext.window.Window',
	alias: 'widget.ic_prepfinddeletewindow',
	controller: 'ic_prepFindDeleteWindow',


	title: Oger._('Fundnummer löschen'),
	width: 400,	height: 250,
	modal: true,
	//autoScroll: true,
	layout: 'fit',

	items: [
		{ xtype: 'form',
			url: 'php/scripts/prepFind.php',
			trackResetOnLoad: true,
			bodyPadding: 15, border: false,	autoScroll: true,
			layout: 'anchor',
			items: [
				{ name: 'excavId', xtype: 'hidden' },
				{ name: 'archFindId', xtype: 'textfield', fieldLabel: Oger._('Fundnummer'), readOnly: true },
				{ name: 'archFindSubId', xtype: 'textfield', fieldLabel: Oger._('Fund-Subnummer'), readOnly: true },
				{ name: 'stockLocationName', xtype: 'textfield',
					fieldLabel: Oger._('Behälter'), readOnly: true, submitValue: false,
				},
			],
		},
	],

	buttonAlign: 'center',
	minButtonWidth: 30,
	buttons: [
		{ text: Oger._('Fund löschen'), handler: 'deleteRecord' },
		{ text: Oger._('Abbrechen'), handler: 'closeWindow' },
	],


	listeners: {
		close: 'onClose',
	},



});
