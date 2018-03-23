/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Report startup main form
*/
Ext.define('App.view.report.Form', {
	extend: 'Ext.form.Panel',
	alias: 'widget.reportmainseleform',

	bodyPadding: 15,
	border: false,
	autoScroll: true,
	layout: 'anchor',
	trackResetOnLoad: true,

	items: [

		{ xtype: 'fieldcontainer', layout: 'hbox',
			items: [
				{ name: 'reportType', xtype: 'combo', fieldLabel: Oger._('Bereich (Was)'),
					allowBlank: false, forceSelection: true,
					store: Ext.create('Ext.data.Store', {
						fields: [ 'id', 'name' ],
						data: [
							{ id: 'TYPE_ARCHFIND', name: Oger._('Fund') },
							{ id: 'TYPE_STRATUM', name: Oger._('Stratum') },
							{ id: 'TYPE_ARCHOBJECT', name: Oger._('Objekt') },
							{ id: 'TYPE_ARCHOBJGROUP', name: Oger._('Objektgruppe') },
						]
					}),
					queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
					listeners: {
						change: function(cmp, newValue, oldValue, options) {

							var combo2 = cmp.up('form').getForm().findField('reportMode');
							var store2 = combo2.getStore();
							combo2.disable();
							combo2.setValue('');
							store2.removeAll();

							if (newValue == 'TYPE_ARCHFIND') {
								combo2.enable();
								store2.add([
									{ id: 'MODE_REPORT-SHORT', name: Oger._('Protokoll - Mini') },
									{ id: 'MODE_REPORT-MEDIUM', name: Oger._('Protokoll - Mittel') },
									{ id: 'MODE_REPORT-FULL', name: Oger._('Protokoll - Maxi') },
									{ id: 'MODE_FINDSHEET', name: Oger._('Fundzettel') },
								]);
							}
							if (newValue == 'TYPE_STRATUM') {
								combo2.enable();
								store2.add([
									{ id: 'MODE_LIST-BDA', name: Oger._('BDA-Zusammenfassung') },
									{ id: 'MODE_REPORT-SHORT', name: Oger._('Protokoll - Mini') },
									{ id: 'MODE_REPORT-FULL', name: Oger._('Protokoll - Maxi') },
								]);
							}
							if (newValue == 'TYPE_ARCHOBJECT') {
								combo2.enable();
								store2.add([
									{ id: 'MODE_LIST-BDA', name: Oger._('BDA-Zusammenfassung') },
									{ id: 'MODE_REPORT-FULL', name: Oger._('Protokoll') },
								]);
							}
							if (newValue == 'TYPE_ARCHOBJGROUP') {
								combo2.enable();
								store2.add([
									{ id: 'MODE_LIST-BDA', name: Oger._('BDA-Zusammenfassung') },
									{ id: 'MODE_REPORT-FULL', name: Oger._('Protokoll') },
								]);
							}

						},  // eo change listener
					},  // eo listeners
				},
				{ xtype: 'tbspacer', width: 20 },
				{ name: 'reportMode', xtype: 'combo', fieldLabel: Oger._('Modus (Wie)'), width: 250, disabled: true,
					allowBlank: false, forceSelection: true,
					store: Ext.create('Ext.data.Store', {
						fields: [ 'id', 'name' ],
					}),
					queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
					listeners: {
						change: function(cmp, newValue, oldValue, options) {
							var form = cmp.up('form');
							var specificDetailPanel = Ext.ComponentQuery.query('component[isReportSpecificDetailPanel]', form)[0];
							var newDetailCard = null;
							if (newValue == 'MODE_FINDSHEET') {
								newDetailCard = Ext.ComponentQuery.query('component[isReportFindSheetDetailPanel]', form)[0];
							}
							if (newValue == 'MODE_LIST-BDA') {
								newDetailCard = Ext.ComponentQuery.query('component[isReportStratumBdaListDetailPanel]', form)[0];
							}
							var oldDetailCard = specificDetailPanel.getLayout().getActiveItem();
							if (newDetailCard != oldDetailCard) {
								oldDetailCard.disable();
							}
							if (newDetailCard) {
								specificDetailPanel.getLayout().setActiveItem(newDetailCard);
								newDetailCard.enable();
								specificDetailPanel.show();
							}
							else {
								specificDetailPanel.hide();
							}
						},
					},
				},
			],
		},


		{ xtype: 'fieldcontainer', layout: 'hbox',
			items: [
				{ name: 'beginDate', xtype: 'datefield', fieldLabel: Oger._('Von Datum'), submitFormat: 'Y-m-d' },
				{ xtype: 'tbspacer', width: 20 },
				{ name: 'endDate', xtype: 'datefield', fieldLabel: Oger._('Bis Datum'), submitFormat: 'Y-m-d' },
			],
		},

		{ xtype: 'fieldcontainer', layout: 'hbox',
			items: [
				{ name: 'beginId', xtype: 'textfield', fieldLabel: Oger._('Von Nummer'), validator: xidValid },
				{ xtype: 'tbspacer', width: 20 },
				{ name: 'endId', xtype: 'textfield', fieldLabel: Oger._('Bis Nummer'), validator: xidValid },
			],
		},

		{ xtype: 'checkboxgroup', fieldLabel: Oger._('Seitenwechsel'),
			items: [
				{ name: 'newPagePerItem', boxLabel: Oger._('Neue Seite pro Eintrag'), uncheckedValue: '0' },
			],
		},

		{ xtype: 'panel',
			hidden: true,
			border: false,
			isReportSpecificDetailPanel: true,
			layout: 'card',
			items: [

				/*
				{ xtype: 'panel',  // --- empty panel
					border: false, disabled: true, deferredRender: true,
					isReportFindSheetDetailPanel: true,
					layout: 'anchor',
				},
				*/

				{ xtype: 'panel',  // --- findsheet
					border: false, disabled: true, deferredRender: true,
					isReportFindSheetDetailPanel: true,
					layout: 'anchor',

					items: [
						{ xtype: 'fieldset', title: Oger._('Fundzettel'),
							items: [
								{ name: 'sheetPerFindCategory', xtype: 'checkbox', boxLabel: Oger._('Druck je Fundkategorie') },
								{ name: 'sheetPerSampleCategory', xtype: 'checkbox', boxLabel: Oger._('Druck je Probenkategorie') },
								{ name: 'numCopies', xtype: 'numberfield', fieldLabel: Oger._('Anzahl'), value: 1, minValue: 1 },
							],
						},
					],
				},

				{ xtype: 'panel',  // ---
					border: false, disabled: true, deferredRender: true,
					isReportStratumBdaListDetailPanel: true,
					layout: 'anchor',

					items: [
						{ xtype: 'fieldset', title: Oger._('BDA Stratum Liste'),
							items: [
								{ xtype: 'radiogroup', fieldLabel: Oger._('Stratum Typ ausgeben'), labelWidth: 150, // columns: 1,
									items: [
										{ name: 'bdaListStratumType', boxLabel: Oger._('als Bezeichnung'),
											inputValue: 'BDALIST_STRATUMTYPE_NOTATION', checked: true
										},
										{ name: 'bdaListStratumType', boxLabel: Oger._('als Anmerkung'),
											inputValue: 'BDALIST_STRATUMTYPE_COMMENT'
										},
										{ name: 'bdaListStratumType', boxLabel: Oger._('nicht ausgeben'),
											inputValue: 'BDALIST_STRATUMTYPE_NONE'
										},
									],
								},
							],
						},
					],
				},

			],
		},

	],  // eo form items

	url: 'php/scripts/report.php',

	// ########################################################


});
