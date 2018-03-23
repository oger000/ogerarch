/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/



/**
* Arch object type master form
*/
Ext.define('App.view.master.archObjectType.Form', {
	extend: 'Ext.form.Panel',
	alias: 'widget.archobjecttypemasterform',

	bodyPadding: 15,
	border: false,
	autoScroll: true,
	layout: 'anchor',
	trackResetOnLoad: true,

	items: [
		{ name: 'id', xtype: 'hidden' },
		{ name: 'name', xtype: 'textfield', fieldLabel: Oger._('Art/Bezeichnung'), allowBlank: false, regex: TYPENAME_REGEX },
		{ name: 'code', xtype: 'textfield', fieldLabel: Oger._('Code') },
	],

	url: 'php/scripts/archObjectType.php',

	listeners: {
		'actioncomplete': function(form, action) {
			if (action.type == 'load') {
				Oger.extjs.resetDirty(form);
			}
		}
	},  // eo listeners

});
