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
Ext.define('App.view.master.stockLocation.Form', {
	extend: 'Ext.form.Panel',
	alias: 'widget.stocklocationmasterform',

	url: 'php/scripts/stockLocation.php',
	trackResetOnLoad: true,
	bodyPadding: 15, border: false,
	autoScroll: true,
	layout: 'anchor',

	items: [
		{ name: 'stockLocationId', xtype: 'hidden' },
		{ name: 'excavId', xtype: 'hidden' },
		{ name: 'dbAction', xtype: 'hidden' },
		{ name: '_usecase', xtype: 'hidden' },
		{ name: 'outerId', xtype: 'hidden' },

		{ name: 'outerName', xtype: 'textfield', fieldLabel: Oger._('Übergeordneter Lagerort'),
			width: 300, readOnly: true, readOnlyCls: 'x-item-disabled'
		},

		{ name: 'name', xtype: 'textfield', fieldLabel: Oger._('Bezeichnung'),
			width: 300,  //allowBlank: false,
		},

		{ name: 'typeId', xtype: 'combo', width: 300,
			fieldLabel: Oger._('Art/Grössenklasse'),
			forceSelection: true, allowBlank: false,
			queryMode: 'local', valueField: 'id', displayField: 'sizeAndName',
			store: {
				type: 'stockLocationType', autoLoad: true,
				proxyExtraParams: { _action: 'loadSizeCombo' },
			},
		},

		{ xtype: 'fieldset',  title: Oger._('Kann andere Behälter aufnehmen bis zur Grössenklasse'),
			collapsible: true, itemId: 'maxInnerTypeFieldSet',
			items: [
				{ name: 'maxInnerTypeId', xtype: 'combo', width: 300,
					fieldLabel: Oger._('Maximale Grössenklasse'),
					forceSelection: true,
					queryMode: 'local', valueField: 'id', displayField: 'sizeAndName',
					store: {
						type: 'stockLocationType', autoLoad: true,
						proxyExtraParams: { _action: 'loadSizeCombo' },
					},
				},
				{ name: '', xtype: 'displayfield',  fieldLabel: Oger._('leer=kann keine Behälter aufnehmen'),
					labelWidth: 300, value: '', labelSeparator: '',
				},
			],
		},

		{ xtype: 'fieldset',  title: Oger._('Eigenschaften'),
			items: [

				{ name: 'movable', xtype: 'checkbox',
					inputValue: '1', uncheckedValue: '0',
					boxLabel: Oger._('Fundort/Behälter ist beweglich'),
				},

				{ name: 'reusable', xtype: 'checkbox',
					inputValue: '1', uncheckedValue: '0',
					boxLabel: Oger._('Fundort/Behälter ist wiederverwendbar (Inventar)'),
					hidden: true,  // if master all reuseable, if inputcenter none reusable
				},

				{ name: 'canItem', xtype: 'checkbox',
					inputValue: '1', uncheckedValue: '0',
					boxLabel: Oger._('Kann Funde direkt aufnehmen (ohne Zwischen-Behälter)'),
				},

				{ name: 'canReusableMovable', xtype: 'checkbox',
					inputValue: '1', uncheckedValue: '0',
					boxLabel: Oger._('Kann bewegliche wiederverwendbare Behälter direkt aufnehmen'),
				},

				{ name: 'canExcavMovable', xtype: 'checkbox',
					inputValue: '1', uncheckedValue: '0',
					boxLabel: Oger._('Kann bewegliche grabungsspezifische Behälter direkt aufnehmen'),
				},

			],
		},

		{ xtype: 'fieldset',  title: Oger._('Massenanlage'),
			itemId: 'massAddFieldSet',
			checkboxToggle: true, collapsed: true,

			items: [

				{ name: 'massAddMode', xtype: 'checkbox',
					inputValue: '1', uncheckedValue: '0', hidden: true,
				},

				{ name: 'prefixName', xtype: 'textfield', fieldLabel: Oger._('Vorangestellter Text'),
					width: 450, labelWidth: 150,
				},

				{ name: 'prefixSpace', xtype: 'checkbox',
					inputValue: '1', uncheckedValue: '0',
					boxLabel: Oger._('Leerzeichen zwischen vorangestelltem Text und Bezeichnung'),
				},

				{ name: '', xtype: 'displayfield', fieldLabel: Oger._('Bezeichnungen (getrennt durch Beistriche)'),
					width: 450, labelWidth: 450,
				},
				{ name: 'massNames', xtype: 'textarea', hideLabel: true, width: 450, height: 100 },

				{ name: 'postfixSpace', xtype: 'checkbox',
					inputValue: '1', uncheckedValue: '0',
					boxLabel: Oger._('Leerzeichen zwischen Bezeichnung und nachgestelltem Text'),
				},

				{ name: 'postfixName', xtype: 'textfield', fieldLabel: Oger._('Nachgestellter Text'),
					width: 450, labelWidth: 150,
				},

				{ xtype: 'radiogroup', fieldLabel: 'Anlagemodus',
					items: [
						{ boxLabel: 'Nur Anzeigen', name: 'massApplyMode', inputValue: 'protoOnly', checked: true },
						{ boxLabel: 'Anlage durchführen', name: 'massApplyMode', inputValue: 'apply' },
					]
				},  // eo radio grp

				/*
				{ name: '', xtype: 'displayfield', fieldLabel: Oger._('Beispiel'),
					width: 500,
				},
				*/

			],

			listeners: {
				collapse: 'onCollapseMassAddFieldSet',
				expand: 'onExpandMassAddFieldSet',
			},

		},  // eo mass add field set

	],


	listeners: {
		actioncomplete: 'onFormLoad',
	},


});
