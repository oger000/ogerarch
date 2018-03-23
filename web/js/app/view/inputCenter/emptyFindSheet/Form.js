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
Ext.define('App.view.inputCenter.emptyFindSheet.Form', {
	extend: 'Ext.form.Panel',
	alias: 'widget.emptyfindsheetform',

	bodyPadding: 15,
	border: false,
	autoScroll: true,
	layout: 'anchor',
	trackResetOnLoad: true,

	items: [

		{ xtype: 'fieldcontainer', layout: 'hbox',
			items: [
				{ name: 'companyOut', xtype: 'checkbox', boxLabel: Oger._('Firma'), hideLabel: true, checked: true },
			],
		},

		{ xtype: 'fieldcontainer', layout: 'hbox',
			items: [
				{ name: 'excavationOut', xtype: 'checkbox', boxLabel: Oger._('Grabung-Stammdaten (wenn Grabung ausgewählt)'),
					hideLabel: true, checked: true, width: 500,
				},
			],
		},

		{ xtype: 'fieldcontainer', layout: 'hbox',
			items: [
				{ name: 'dateOut', xtype: 'checkbox', boxLabel: Oger._('Datum'), hideLabel: true,
					listeners: {
						change: function(cmp, newValue, oldValue, opts) {
							var dateField = cmp.up('form').getForm().findField('date');
							if (newValue) {
								dateField.enable();
							}
							else {
								dateField.disable();
							}
						}
					},
				},
				{ xtype: 'tbspacer', width: 20 },
				{ name: 'date', xtype: 'datefield', hideLabel: true, value: new Date(), submitFormat: 'Y-m-d', disabled: true },
			],
		},

		//{ xtype: 'displayfield', value: '' },
		{ xtype: 'component', html: '<HR>' },

		{ name: 'numCopies', xtype: 'numberfield', fieldLabel: Oger._('Anzahl'), value: 1 },

	],  // eo form items

	url: 'php/scripts/archFind.php',

	// ########################################################


});
