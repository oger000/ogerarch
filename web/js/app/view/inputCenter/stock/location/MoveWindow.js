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
Ext.define('App.view.inputCenter.stock.location.MoveWindow', {
	extend: 'Ext.window.Window',
	alias: 'widget.ic_movestockwindow',
	controller: 'ic_moveStockWindow',

	title: Oger._('Grabungsspezifischen Lagerort verschieben'),
	width: 550, height: 250,
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

			defaults: { labelWidth: 120 },

			items: [

				{ name: 'stockLocationId', xtype: 'hidden' },
				{ name: 'moveTo', xtype: 'hidden' },
				{ name: 'excavId', xtype: 'hidden' },
				//{ name: '_usecase', xtype: 'hidden' },
				//{ name: 'outerId', xtype: 'hidden' },

				/*
				{ name: 'outerName', xtype: 'textfield', fieldLabel: Oger._('Übergeordneter Lagerort'),
					width: 300, readOnly: true, readOnlyCls: 'x-item-disabled'
				},
				*/

				{ name: 'name', xtype: 'textfield', fieldLabel: Oger._('Verschoben wird'),
					width: 300, readOnly: true,
				},

				{ name: 'moveToName', xtype: 'textfield', fieldLabel: Oger._('Verschieben nach'),
					width: 300, readOnly: true,
				},

				{ name: 'moveArchFind', xtype: 'checkbox',
					inputValue: '1', uncheckedValue: '0',
					boxLabel: Oger._('Funde ohne Behälter/Verpackung ebenfalls hierher verschieben'),
				},

				/*
				{ name: 'moveEmptyLoc', xtype: 'checkbox',
					inputValue: '1', uncheckedValue: '0',
					boxLabel: Oger._('Leere Behälter ebenfalls hierher verschieben'),
				},
				*/

				{ name: 'moveInnerLoc', xtype: 'checkbox',
					inputValue: '1', uncheckedValue: '0',
					boxLabel: Oger._('Untergeordnete bewegliche Lagerorte und Funde ebenfalls hierher verschieben'),
				},

				{ xtype: 'radiogroup', fieldLabel: 'Verschiebemodus',
					items: [
						{ boxLabel: 'Verschieben durchführen', name: 'moveApplyMode', inputValue: 'apply', checked: true },
						{ boxLabel: 'Nur Protokoll', name: 'moveApplyMode', inputValue: 'checkOnly' },
					]
				},  // eo radio grp

				{ name: 'extendedProto', xtype: 'checkbox',
					inputValue: '1', uncheckedValue: '0',
					boxLabel: Oger._('Erweitertes Protokoll zur Fehlersuche'),
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
