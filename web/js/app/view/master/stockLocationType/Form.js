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
Ext.define('App.view.master.stockLocationType.Form', {
	extend: 'Ext.form.Panel',
	alias: 'widget.stocklocationtypemasterform',

	bodyPadding: 15,
	border: false,
	autoScroll: true,
	layout: 'anchor',
	trackResetOnLoad: true,

	items: [
		{ name: 'id', xtype: 'textfield', fieldLabel: Oger._('ID'), readOnly: true, readOnlyCls: 'x-item-disabled' },
		{ name: 'name', xtype: 'textfield', fieldLabel: Oger._('Art/Bezeichnung'), allowBlank: false, regex: TYPENAME_REGEX },
		{ name: 'sizeClass', xtype: 'numberfield', fieldLabel: Oger._('Grössenklasse'),
			value: 1, minValue: 1 , allowDecimals: false, hideTrigger: true,
		},
		{ name: 'excavVisible', xtype: 'checkbox',
			inputValue: '1', uncheckedValue: '0',
			boxLabel: Oger._('Im grabungsspezifischen Bereich sichtbar'),
		},
	],

	url: 'php/scripts/stockLocationType.php',

	listeners: {
		'actioncomplete': function(form, action) {
			if (action.type == 'load') {
				Oger.extjs.resetDirty(form);
			}
		}
	},  // eo listeners

});
