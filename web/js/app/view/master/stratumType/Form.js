/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/



/**
* Stratum type master form
*/
Ext.define('App.view.master.stratumType.Form', {
	extend: 'Ext.form.Panel',
	alias: 'widget.stratumtypemasterform',

	bodyPadding: 15,
	border: false,
	autoScroll: true,
	layout: 'anchor',
	trackResetOnLoad: true,

	items: [
		{ name: 'id', xtype: 'hidden' },
		{ name: 'categoryId', xtype: 'combo', fieldLabel: Oger._('Kategorie'),
			width: 250, readOnly: true, forceSelection: true,
			mode: 'remote', store: Ext.create('App.store.StratumCategories'),
			valueField: 'id', displayField: 'name', triggerAction: 'all',
		},
		{ name: 'name', xtype: 'textfield', fieldLabel: Oger._('Art/Bezeichnung'), allowBlank: false, regex: TYPENAME_REGEX },
		{ name: 'code', xtype: 'textfield', fieldLabel: Oger._('Code') },
	],

	url: 'php/scripts/stratumType.php',

	listeners: {
		'actioncomplete': function(form, action) {
			if (action.type == 'load') {
				Oger.extjs.resetDirty(form);
			}
		}
	},  // eo listeners

});
