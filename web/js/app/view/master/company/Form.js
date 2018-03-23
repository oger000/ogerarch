/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/



/**
* Company form
*/
Ext.define('App.view.master.company.Form', {
	extend: 'Ext.form.Panel',
	alias: 'widget.companymasterform',

	layout: 'anchor',
	trackResetOnLoad: true,

	items: [
		{ xtype: 'tabpanel',
			//height: 600,
			activeTab: 0,
			deferredRender: false,

			items: [
				{ xtype: 'panel',
					title: Oger._('Allgemein'),
					layout: 'anchor',
					bodyPadding: 15,
					border: false,
					hideMode: 'offsets',
					autoScroll: true,

					defaults: {
						width: 400,
					},
					items: [
						{ name: 'id', xtype: 'hidden' },
						{ name: 'shortName', xtype: 'textfield', fieldLabel: Oger._('Kurzbezeichn'), allowBlank: false },
						{ name: 'name1', xtype: 'textfield', fieldLabel: Oger._('Name1'), allowBlank: false },
						{ name: 'name2', xtype: 'textfield', fieldLabel: Oger._('Name2') },
						{ name: 'street', xtype: 'textfield', fieldLabel: Oger._('Strasse') },
						{ name: 'postalCode', xtype: 'textfield', fieldLabel: Oger._('Postleitzahl') },
						{ name: 'city', xtype: 'textfield', fieldLabel: Oger._('Ort') },
						{ name: 'countryName', xtype: 'textfield', fieldLabel: Oger._('Land') },
					],
				},  // eo basics tab

			], // eo tabpanel items
		},  // eo tabpanel inside form
	],  // eo form items

	url: 'php/scripts/company.php',

	listeners: {
		'actioncomplete': function(form, action) {  // for radioboxes and alike
			if (action.type == 'load') {
				Oger.extjs.resetDirty(form);
			}
		}
	},  // eo listeners


	// ########################################################



});
