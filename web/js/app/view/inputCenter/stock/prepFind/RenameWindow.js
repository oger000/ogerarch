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
Ext.define('App.view.inputCenter.stock.prepFind.RenameWindow', {
	extend: 'Ext.window.Window',
	alias: 'widget.ic_prepfindrenamewindow',
	controller: 'ic_prepFindRenameWindow',

	title: Oger._('Fundnummer ändern'),
	width: 400, height: 250, modal: true,
	//autoScroll: true,
	layout: 'fit',

	items: [
		{ xtype: 'form',
			url: 'php/scripts/prepFind.php',
			trackResetOnLoad: true,
			bodyPadding: 15, border: false,
			autoScroll: true,
			layout: 'anchor',
			items: [
				{ name: 'excavId', xtype: 'hidden' },
				{ name: 'oldArchFindId', xtype: 'textfield', fieldLabel: Oger._('Alte Fund-Nr'), readOnly: true },
				{ name: 'oldArchFindSubId', xtype: 'textfield', fieldLabel: Oger._('Alte Sub-Nr'), readOnly: true },
				{ name: 'archFindId', xtype: 'textfield', fieldLabel: Oger._('Neue Fund-Nr'), validator: xidValid },
				{ name: 'archFindSubId', xtype: 'textfield', fieldLabel: Oger._('Neue Sub-Nr'), validator: xidValid },
				{ name: 'stockLocationName', xtype: 'textfield',
					fieldLabel: Oger._('Behälter'), readOnly: true, submitValue: false,
				},
			],
		},
	],

	buttonAlign: 'center',
	minButtonWidth: 30,
	buttons: [
		{ text: Oger._('Fundnummer ändern'), handler: 'renameRecord' },
		{ text: Oger._('Abbrechen'), handler: 'closeWindow' },
	],


	listeners: {
		close: 'onClose',
	},


});
