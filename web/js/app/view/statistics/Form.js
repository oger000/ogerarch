/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Statistics startup main form
*/
Ext.define('App.view.statistics.Form', {
	extend: 'Ext.form.Panel',
	alias: 'widget.statisticsmainseleform',

	bodyPadding: 15,
	border: false,
	autoScroll: true,
	layout: 'anchor',
	trackResetOnLoad: true,

	items: [

		{ xtype: 'fieldcontainer', layout: 'hbox',
			items: [
				{ name: 'beginDate', xtype: 'datefield', fieldLabel: Oger._('Von Datum'), submitFormat: 'Y-m-d' },
				{ xtype: 'tbspacer', width: 20 },
				{ name: 'endDate', xtype: 'datefield', fieldLabel: Oger._('Bis Datum'), submitFormat: 'Y-m-d' },
			],
		},

		{ xtype: 'fieldset', title: Oger._('Fund/Probe'),
			items: [
				{ name: 'archFind', xtype: 'checkbox', hideLabel: true, boxLabel: Oger._('Auswerten'), checked: true,
					listeners: {
						change: function(cmp, newValue, oldValue, options) {
							var field2 = cmp.up('form').getForm().findField('specialArchFind');
							var field3 = cmp.up('form').getForm().findField('archFindOther');
							var field4 = cmp.up('form').getForm().findField('sampleOther');
							if (newValue) {
								field2.enable();
								field3.enable();
								field4.enable();
							}
							else {
								field2.disable();
								field3.disable();
								field4.disable();
							}
						},
					},
				},
				{ name: 'specialArchFind', xtype: 'checkbox', hideLabel: true, boxLabel: Oger._('Sonderfunde auflisten'), checked: true },
				{ name: 'archFindOther', xtype: 'checkbox', hideLabel: true, boxLabel: Oger._('Sonstige Funde auflisten'), checked: true },
				{ name: 'sampleOther', xtype: 'checkbox', hideLabel: true, boxLabel: Oger._('Sonstige Proben auflisten'), checked: true },
			],
		},

		{ xtype: 'fieldset', title: Oger._('Stratum'),
			items: [
				{ name: 'stratum', xtype: 'checkbox', hideLabel: true, boxLabel: Oger._('Auswerten'), checked: true,
					listeners: {
						change: function(cmp, newValue, oldValue, options) {
							var field2 = cmp.up('form').getForm().findField('stratumType');
							if (newValue) {
								field2.enable();
							}
							else {
								field2.disable();
							}
						},
					},
				},
				{ name: 'stratumType', xtype: 'checkbox', hideLabel: true, boxLabel: Oger._('Nach Art/Bezeichnung trennen'), checked: true },
			],
		},

		{ xtype: 'fieldset', title: Oger._('Objekt'),
			items: [
				{ name: 'archObject', xtype: 'checkbox', hideLabel: true, boxLabel: Oger._('Auswerten'), checked: true,
					listeners: {
						change: function(cmp, newValue, oldValue, options) {
							var field2 = cmp.up('form').getForm().findField('archObjectType');
							if (newValue) {
								field2.enable();
							}
							else {
								field2.disable();
							}
						},
					},
				},
				{ name: 'archObjectType', xtype: 'checkbox', hideLabel: true, boxLabel: Oger._('Nach Art/Bezeichnung trennen'), checked: true },
			],
		},

		{ xtype: 'fieldset', title: Oger._('Objektgruppe'),
			items: [
				{ name: 'archObjGroup', xtype: 'checkbox', hideLabel: true, boxLabel: Oger._('Auswerten'), checked: true,
					listeners: {
						change: function(cmp, newValue, oldValue, options) {
							var field2 = cmp.up('form').getForm().findField('archObjGroupType');
							if (newValue) {
								field2.enable();
							}
							else {
								field2.disable();
							}
						},
					},
				},
				{ name: 'archObjGroupType', xtype: 'checkbox', hideLabel: true, boxLabel: Oger._('Nach Art/Bezeichnung trennen'), checked: true },
			],
		},

	],  // eo form items

	url: 'php/scripts/statistics.php',

	// ########################################################


});
