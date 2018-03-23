/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/



/**
* Excavation form
*/
Ext.define('App.view.inputCenter.excavation.Form', {
	extend: 'Ext.form.Panel',
	alias: 'widget.ic_excavform',

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
						{ name: 'id', xtype: 'hidden',
							listeners: {
								change: function(cmp, newValue, oldValue, options) {
									cmp.up('form').getForm().findField('displayId').setValue(newValue);
								},
							},
						},
						{ name: 'displayId', xtype: 'textfield', fieldLabel: Oger._('Interne-ID'), disabled: true },
						{ name: 'name', xtype: 'textfield', fieldLabel: Oger._('Grabung'), allowBlank: false },
						{ name: 'officialId', xtype: 'textfield', fieldLabel: Oger._('Massnahme') },
						{ name: 'officialId2', xtype: 'textfield', fieldLabel: Oger._('Geschaeftszahl') },
						{ name: 'authorizedPerson', xtype: 'textfield', fieldLabel: Oger._('Verantwortlich') },
						{ name: 'originator', xtype: 'textfield', fieldLabel: Oger._('BearbeiterIn') },
						{ name: 'beginDate', xtype: 'datefield', fieldLabel: Oger._('Beginn'), submitFormat: 'Y-m-d', allowBlank: false },
						{ name: 'endDate', xtype: 'datefield', fieldLabel: Oger._('Ende'), submitFormat: 'Y-m-d' },
						{ xtype: 'radiogroup', fieldLabel: Oger._('Methode'), allowBlank: false, name: 'excavMethodId___',
							items: [
								{ boxLabel: 'Stratum', name: 'excavMethodId', inputValue: EXCAVMETHODID_STRATUM },
								{ boxLabel: 'Planum', name: 'excavMethodId', inputValue: EXCAVMETHODID_PLANUM },
							]
						},
						{ name: 'datingSpec', xtype: 'textfield', fieldLabel: Oger._('Datierung') },
						{ name: 'datingPeriodId', xtype: 'combo', fieldLabel: Oger._('Periode'), width: 300,
							queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
              store: { type: 'datingperiod', autoLoad: true },
						},
					],
				},  // eo basics tab

				{ xtype: 'panel',
					title: Oger._('Lage'),
					layout: 'anchor',
					bodyPadding: 15,
					border: false,
					hideMode: 'offsets',
					autoScroll: true,

					defaults: {
						width: 400,
					},
					items: [
						{ xtype: 'textfield', fieldLabel: Oger._('Land'), name: 'countryName' },
						{ xtype: 'textfield', fieldLabel: Oger._('Bundesland'), name: 'regionName' },
						{ xtype: 'textfield', fieldLabel: Oger._('Bezirk'), name: 'districtName' },
						{ xtype: 'textfield', fieldLabel: Oger._('Gemeinde'), name: 'communeName' },
						{ xtype: 'textfield', fieldLabel: Oger._('Katastralgem.'), name: 'cadastralCommunityName' },
						{ xtype: 'textfield', fieldLabel: Oger._('Flur'), name: 'fieldName' },
						{ xtype: 'textfield', fieldLabel: Oger._('Grundstücks-Nr'), name: 'plotName' },
						{ xtype: 'numberfield', fieldLabel: Oger._('Ost (WGS84)'), name: 'gpsX', decimalPrecision: 10 },
						{ xtype: 'numberfield', fieldLabel: Oger._('Nord (WGS84)'), name: 'gpsY', decimalPrecision: 10 },
						{ xtype: 'numberfield', fieldLabel: Oger._('Seehöhe'), name: 'gpsZ', decimalPrecision: 10 },
					],
				},  // eo location tab

				{ xtype: 'panel',
					title: Oger._('Beschreibung'),
					layout: 'fit',
					bodyPadding: 15,
					border: false,
					autoScroll: true,
					items: [
						//{ xtype: 'displayfield', fieldLabel: Oger._('Anmerkungen') },
						{ xtype: 'textarea', hideLabel: true, fieldLabel: Oger._('Anmerkungen'), name: 'comment', width: 450, height: 300 },
					],
				},  // eo description tab

				{ xtype: 'panel',
					title: Oger._('Meldungen'),
					layout: 'anchor',
					bodyPadding: 15,
					border: false,
					autoScroll: true,
					items: [
						{ xtype: 'textfield', fieldLabel: 'BDA E-Mail', name: 'emailBda', width: 400 },
						{ xtype: 'button', text: 'Beginnmeldung',
							handler: function() {
								var vals = this.up('form').getForm().getValues();
								var mailto = vals.emailBda;
								var subject = 'Beginnmeldung ' + vals.officialId2 ;
								var body =
									'Gemeinde: ' + vals.communeName + '\r\n' +
									'KG: ' + vals.cadastralCommunityName  + '\r\n' +
									'Flur: ' + vals.fieldName  + '\r\n' +
									'Grundstück: ' + vals.plotName  + '\r\n' +
									'GZ: ' + vals.officialId2  + '\r\n' +
									'Massnahme: ' + vals.officialId  + '\r\n' +
									'\r\nWir geben hiermit den Grabungsbeginn per '
										+ Ext.Date.format(new Date(vals.beginDate), 'd.m.Y')
										+ ' bekannt.\r\n' +
									'\r\nmfg\r\n\r\n\r\n\r\n\r\n\r\n';
								document.location.href =
									'mailto:' + mailto + '?' +
									Ext.Object.toQueryString({ subject: subject, body: body });
							},
						},
						{ xtype: 'component', html: '<br>' },
						//{ xtype: 'tbspacer', width: 50 },
						{ xtype: 'button', text: 'Endemeldung',
							handler: function() {
								var vals = this.up('form').getForm().getValues();
								var mailto = vals.emailBda;
								var subject = 'Endemeldung ' + vals.officialId2 ;
								var body =
									'Gemeinde: ' + vals.communeName + '\r\n' +
									'KG: ' + vals.cadastralCommunityName  + '\r\n' +
									'Flur: ' + vals.fieldName  + '\r\n' +
									'Grundstück: ' + vals.plotName  + '\r\n' +
									'GZ: ' + vals.officialId2  + '\r\n' +
									'Massnahme: ' + vals.officialId  + '\r\n' +
									'\r\nWir geben hiermit das Grabungsende per '
										+ Ext.Date.format(new Date(vals.endDate), 'd.m.Y')
										+ ' bekannt.\r\n' +
									'\r\nmfg\r\n\r\n\r\n\r\n\r\n\r\n';
								document.location.href =
									'mailto:' + mailto + '?' +
									Ext.Object.toQueryString({ subject: subject, body: body });
							},
						},
					],
				},  // eo message tab

				{ xtype: 'panel',
					title: Oger._('Extras'),
					layout: 'anchor',
					bodyPadding: 15,
					border: false,
					autoScroll: true,
					items: [
						{ name: 'inactive', xtype: 'checkbox', fieldLabel: Oger._('Inaktiv'), inputValue: '1', uncheckedValue: '0' },
						{ name: 'projectBaseDir', xtype: 'textfield', fieldLabel: Oger._('Datenverzeichnis'), width: 400 },
						{ xtype: 'panel', border: true, padding: '15 0 15 0', },
						{ xtype: 'fieldset', title: Oger._('Grabungsmethode wechseln'),
							items: [
								{ xtype: 'panel', border: false,
									html: 'Ein Wechsel der Grabungsmethode sollte niemals notwendig sein und hat weitreichende ' +
												'Auswirkungen auf die angezeigten Eingabefelder und auf die erstellten Listen. ' +
												'Falls trotzdem ein Wechsel der Grabungsmethode gewünscht ist, dann kann dies hier erzwungen werden.',
								},
								{ xtype: 'fieldcontainer', layout: 'hbox',
									items: [
										{ name: 'forceExcavMethodChange', xtype: 'checkbox', hideLabel: true },
										{ xtype: 'tbspacer', width: 10 },
										{ xtype: 'displayfield', hideLabel: true,
											value: Oger._('Wechsel der Grabungsmethode erzwingen - ich weiss was ich tue.'),
										},
									],
								},
							],
						},  // eo change method
					],
				},  // eo extras tab

			], // eo tabpanel items
		},  // eo tabpanel inside form
	],  // eo form items

	url: 'php/scripts/excavation.php',

	listeners: {
		actioncomplete: function(form, action) {  // for radioboxes and alike
			if (action.type == 'load') {
				Oger.extjs.resetDirty(form);
			}
		},
		actionfailed: function(form, action) {  // for end of next/prev jumps
			if (action.type == 'load') {
				if (action.result && action.result.msg) {
					Ext.Msg.alert(Oger._('Warnung'), action.result.msg);
					return;
				}
				Oger.extjs.actionSuccess(action); // show common errors
			}
		},
	},  // eo listeners


	// ########################################################



});
