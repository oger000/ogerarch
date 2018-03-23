/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Stratum type detail window
*/
Ext.define('App.view.master.stockLocation.DeleteWindow', {
	extend: 'Ext.window.Window',
	alias: 'widget.stocklocationmasterdeletewindow',
	controller: 'stockLocationMasterDeleteWindow',

	title: Oger._('Lagerort löschen'),
	width: 500, height: 250,
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

				{ name: 'stockLocationId', xtype: 'hidden' },
				{ name: 'excavId', xtype: 'hidden' },
				{ name: '_usecase', xtype: 'hidden' },
				{ name: 'outerId', xtype: 'hidden' },

				/*
				{ name: 'outerName', xtype: 'textfield', fieldLabel: Oger._('Übergeordneter Lagerort'),
					width: 300, readOnly: true, readOnlyCls: 'x-item-disabled'
				},
				*/

				{ name: 'name', xtype: 'textfield', fieldLabel: Oger._('Zu löschender Lagerort'),
					width: 300, readOnly: true,
				},

				{ name: 'deleteInnerLoc', xtype: 'checkbox',
					inputValue: '1', uncheckedValue: '0',
					boxLabel: Oger._('Untergeordnete Lagerorte ebenfalls löschen'),
					listeners: {
						change: 'onChangeDeleteInnerLoc',
					},
				},

				{ name: 'deleteExcavLoc', xtype: 'checkbox',
					inputValue: '1', uncheckedValue: '0', disabled: true,
					boxLabel: Oger._('Grabungsspezifische Lagerorte ebenfalls löschen'),
				},

				{ xtype: 'radiogroup', fieldLabel: 'Löschmodus',
					items: [
						{ boxLabel: 'Nur Protokoll', name: 'deleteApplyMode', inputValue: 'checkOnly', checked: true },
						{ boxLabel: 'Löschen durchführen', name: 'deleteApplyMode', inputValue: 'apply' },
					]
				},  // eo radio grp

			],
		},
	],

	buttonAlign: 'center',
	minButtonWidth: 30,
	buttons: [
		{ text: Oger._('Löschen'), handler: 'deleteRecord' },
		{ text: Oger._('Schliessen'), handler: 'closeWindow' },
	],


	listeners: {
		close: 'onClose',
	},



});
