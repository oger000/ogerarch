/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Import form
*/
Ext.define('App.view.import.Form', {
	extend: 'Ext.form.Panel',
	alias: 'widget.importform',

	//bodyPadding: 15,
	border: false,
	autoScroll: true,
	layout: 'anchor',
	trackResetOnLoad: true,

	items: [

		{ xtype: 'tabpanel',
			activeTab: 0,
			plain: true,
			//autoScroll: true,
			deferredRender: false,

			items: [

				{ xtype: 'panel',
					title: Oger._('Allgemein'),
					layout: 'anchor',
					bodyPadding: 15,
					border: false,
					hideMode: 'offsets',
					autoScroll: true,
					items: [

						{ name: 'fileFormat', xtype: 'combo', fieldLabel: Oger._('Format'), width: 400, value: 'OGERARCH_JSON',
							allowBlank: false, forceSelection: true,
							store: Ext.create('Ext.data.Store', {
								fields: [ 'id', 'name' ],
								data: [
									{ id: 'OGERARCH_JSON', name: Oger._('OgerArch JSON (.json)') },
									{ id: 'ARCHDOCUCOMPAT_JSON', name: Oger._('ArchDocu Compat (.json)') },
									//{ id: 'STRATIFY_LST', name: Oger._('Stratify (.lst)') },
								]
							}),
							queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
						},
						{ name: 'uploadFileName', xtype: 'filefield', fieldLabel: Oger._('Dateiname'), width: 400, allowBlank: false },

						{ xtype: 'radiogroup', fieldLabel: Oger._('Aktion'), columns: 1,
							items: [
								//{ name: 'actionMode', boxLabel: Oger._('Liste der Grabungen in der Importdatei (ID-Liste)'), inputValue: 'ACTIONMODE_EXCAVATIONLIST', checked: true },
								{ name: 'actionMode', boxLabel: Oger._('Kurzübersicht über den Inhalt der Importdatei'), inputValue: 'ACTIONMODE_VOLUMECONTENT', checked: true },
								{ name: 'actionMode', boxLabel: Oger._('Nur Protokoll - Import simulieren aber nicht durchführen'), inputValue: 'ACTIONMODE_TEST' },
								{ name: 'actionMode', boxLabel: Oger._('Übernehmen - Import durchführen und Daten übernehmen'), inputValue: 'ACTIONMODE_APPLY' },
							],
						},

						{ name: 'logExtended', xtype: 'checkbox', fieldLabel: Oger._('Erweitertes Protokoll'), uncheckedValue: '0' },

						{ name: 'sourceExcavId', xtype: 'textfield', fieldLabel: Oger._('ID der Importgrabung aus der Importdatei'), labelWidth: 280 },
						{ name: '', xtype: 'displayfield', labelWidth: 500, value: '', labelSeparator: '',
							fieldLabel: Oger._('ID der Importgrabung kann entfallen, wenn die Importdatei nur eine Grabung enthält'),
						},

					],
				},  // eo common

				{ xtype: 'panel',
					title: Oger._('Grabungsdaten'),
					layout: 'anchor',
					bodyPadding: 15,
					border: false,
					hideMode: 'offsets',
					autoScroll: true,
					items: [

						{ xtype: 'fieldset', title: Oger._('Grabungsstamm'),
							items: [
								{ name: 'excavationInsert', xtype: 'checkbox', boxLabel: Oger._('Als neue Grabung importieren'), uncheckedValue: '0',
									listeners: {
										change: function(cmp, newValue, oldValue, opts ) {
											var otherField = cmp.up('form').getForm().findField('excavationUpdate');
											if (newValue) {
												otherField.disable();
											}
											else {
												otherField.enable();
											}
										}
									}
								},
								{ name: 'excavationUpdate', xtype: 'combo', fieldLabel: Oger._('Bestehender Datensatz'), value: '',
									width: 400, labelWidth: 150,
									store: Ext.create('Ext.data.Store', {
										fields: [ 'id', 'name' ],
										data: [
											{ id: '', name: Oger._('Beibehalten / Import ablehnen') },
											{ id: 'REPLACE', name: Oger._('Ersetzen durch Import') },
											//{ id: 'MERGE_EMPTY', name: Oger._('Leere Felder von Import Ergänzen') },
										]
									}),
									queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
								},
							],
						},

						{ xtype: 'fieldset', title: Oger._('Vorauswahl für Fund + Stratum + Objekt + Objektgruppe'),
							items: [
								{ name: 'allItemsInsert', xtype: 'combo', fieldLabel: Oger._('Neue Datensätze'), value: '',
									width: 400, labelWidth: 150, submitValue: false,
									store: Ext.create('Ext.data.Store', {
										fields: [ 'id', 'name' ],
										data: [
											{ id: '', name: Oger._('Ignorieren') },
											{ id: 'INSERT', name: Oger._('Übernehmen') },
										]
									}),
									queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
									listeners: {
										change: function(cmp, newValue, oldValue, opts ) {
											var otherField = cmp.up('form').getForm().findField('archFindInsert');
											otherField.setValue(newValue);
											var otherField = cmp.up('form').getForm().findField('stratumInsert');
											otherField.setValue(newValue);
											var otherField = cmp.up('form').getForm().findField('archObjectInsert');
											otherField.setValue(newValue);
											var otherField = cmp.up('form').getForm().findField('archObjGroupInsert');
											otherField.setValue(newValue);
										},
									},
								},
								{ name: 'allItemsUpdate', xtype: 'combo', fieldLabel: Oger._('Bestehende Datensätze'), value: '',
									width: 400, labelWidth: 150, submitValue: false,
									store: Ext.create('Ext.data.Store', {
										fields: [ 'id', 'name' ],
										data: [
											{ id: '', name: Oger._('Beibehalten / Import ablehnen') },
											{ id: 'REPLACE', name: Oger._('Ersetzen durch Import') },
											//{ id: 'MERGE_EMPTY', name: Oger._('Leere Felder von Import Ergänzen') },
										]
									}),
									queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
									listeners: {
										change: function(cmp, newValue, oldValue, opts ) {
											var otherField = cmp.up('form').getForm().findField('archFindUpdate');
											otherField.setValue(newValue);
											var otherField = cmp.up('form').getForm().findField('stratumUpdate');
											otherField.setValue(newValue);
											var otherField = cmp.up('form').getForm().findField('archObjectUpdate');
											otherField.setValue(newValue);
											var otherField = cmp.up('form').getForm().findField('archObjGroupUpdate');
											otherField.setValue(newValue);
										},
									},
								},
								{ name: 'allItemsRemoveRefs', xtype: 'checkbox',  submitValue: false,
									boxLabel: Oger._('Bestehende Verweise löschen - GEFÄHRLICH!'), hideEmptyLabel: false, labelWidth: 150,
									listeners: {
										change: function(cmp, newValue, oldValue, opts ) {
											var otherField = cmp.up('form').getForm().findField('archFindRemoveRefs');
											otherField.setValue(newValue);
											var otherField = cmp.up('form').getForm().findField('stratumRemoveRefs');
											otherField.setValue(newValue);
											var otherField = cmp.up('form').getForm().findField('archObjectRemoveRefs');
											otherField.setValue(newValue);
											var otherField = cmp.up('form').getForm().findField('archObjGroupRemoveRefs');
											otherField.setValue(newValue);
										},
									},
								},
							],
						},

						{ xtype: 'fieldset', title: Oger._('Fund'),
							items: [
								{ xtype: 'fieldcontainer', layout: 'hbox',
									items: [
										{ name: 'archFindBeginId', xtype: 'textfield', fieldLabel: Oger._('Von Nummer'), validator: xidValid },
										{ xtype: 'tbspacer', width: 20 },
										{ name: 'archFindEndId', xtype: 'textfield', fieldLabel: Oger._('Bis Nummer'), validator: xidValid },
									],
								},
								{ name: 'archFindInsert', xtype: 'combo', fieldLabel: Oger._('Neue Datensätze'), value: '',
									width: 400, labelWidth: 150,
									store: Ext.create('Ext.data.Store', {
										fields: [ 'id', 'name' ],
										data: [
											{ id: '', name: Oger._('Ignorieren') },
											{ id: 'INSERT', name: Oger._('Übernehmen') },
										]
									}),
									queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
								},
								{ name: 'archFindUpdate', xtype: 'combo', fieldLabel: Oger._('Bestehende Datensätze'), value: '',
									width: 400, labelWidth: 150,
									store: Ext.create('Ext.data.Store', {
										fields: [ 'id', 'name' ],
										data: [
											{ id: '', name: Oger._('Beibehalten / Import ablehnen') },
											{ id: 'REPLACE', name: Oger._('Ersetzen durch Import') },
											//{ id: 'MERGE_EMPTY', name: Oger._('Leere Felder von Import Ergänzen') },
										]
									}),
									queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
								},
								{ name: 'archFindRemoveRefs', xtype: 'checkbox',
									boxLabel: Oger._('Bestehende Verweise löschen - GEFÄHRLICH!'), hideEmptyLabel: false, labelWidth: 150,
								},
							],
						},

						{ xtype: 'fieldset', title: Oger._('Stratum'),
							items: [
								{ xtype: 'fieldcontainer', layout: 'hbox',
									items: [
										{ name: 'stratumBeginId', xtype: 'textfield', fieldLabel: Oger._('Von Nummer'), validator: xidValid },
										{ xtype: 'tbspacer', width: 20 },
										{ name: 'stratumEndId', xtype: 'textfield', fieldLabel: Oger._('Bis Nummer'), validator: xidValid },
									],
								},
								{ name: 'stratumInsert', xtype: 'combo', fieldLabel: Oger._('Neue Datensätze'), value: '',
									width: 400, labelWidth: 150,
									store: Ext.create('Ext.data.Store', {
										fields: [ 'id', 'name' ],
										data: [
											{ id: '', name: Oger._('Ignorieren') },
											{ id: 'INSERT', name: Oger._('Übernehmen') },
										]
									}),
									queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
								},
								{ name: 'stratumUpdate', xtype: 'combo', fieldLabel: Oger._('Bestehende Datensätze'), value: '',
									width: 400, labelWidth: 150,
									store: Ext.create('Ext.data.Store', {
										fields: [ 'id', 'name' ],
										data: [
											{ id: '', name: Oger._('Beibehalten / Import ablehnen') },
											{ id: 'REPLACE', name: Oger._('Ersetzen durch Import') },
											//{ id: 'MERGE_EMPTY', name: Oger._('Leere Felder von Import Ergänzen') },
										]
									}),
									queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
								},
								{ name: 'stratumRemoveRefs', xtype: 'checkbox',
									boxLabel: Oger._('Bestehende Verweise löschen - GEFÄHRLICH!'), hideEmptyLabel: false, labelWidth: 150,
								},
								{ name: 'stratumType', xtype: 'combo', fieldLabel: Oger._('Unbekannte Stratum Art/Bezeichn.'),
									width: 500, labelWidth: 200, value: 'TEXTVALUE_ONLY',
									store: Ext.create('Ext.data.Store', {
										fields: [ 'id', 'name' ],
										data: [
											{ id: 'TEXTVALUE_ONLY', name: Oger._('Nie Stammdaten anlegen / nur Text übernehmen') },
											{ id: 'INHERIT_SOURCE', name: Oger._('Stamm oder Text - wie importiert') },
											{ id: 'MASTERDATA_ONLY', name: Oger._('Immer als Stammdaten anlegen') },
										]
									}),
									queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
								},
							],
						},

						{ xtype: 'fieldset', title: Oger._('Objekt'),
							items: [
								{ xtype: 'fieldcontainer', layout: 'hbox',
									items: [
										{ name: 'archObjectBeginId', xtype: 'textfield', fieldLabel: Oger._('Von Nummer'), validator: xidValid },
										{ xtype: 'tbspacer', width: 20 },
										{ name: 'archObjectEndId', xtype: 'textfield', fieldLabel: Oger._('Bis Nummer'), validator: xidValid },
									],
								},
								{ name: 'archObjectInsert', xtype: 'combo', fieldLabel: Oger._('Neue Datensätze'), value: '',
									width: 400, labelWidth: 150,
									store: Ext.create('Ext.data.Store', {
										fields: [ 'id', 'name' ],
										data: [
											{ id: '', name: Oger._('Ignorieren') },
											{ id: 'INSERT', name: Oger._('Übernehmen') },
										]
									}),
									queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
								},
								{ name: 'archObjectUpdate', xtype: 'combo', fieldLabel: Oger._('Bestehende Datensätze'), value: '',
									width: 400, labelWidth: 150,
									store: Ext.create('Ext.data.Store', {
										fields: [ 'id', 'name' ],
										data: [
											{ id: '', name: Oger._('Beibehalten / Import ablehnen') },
											{ id: 'REPLACE', name: Oger._('Ersetzen durch Import') },
											//{ id: 'MERGE_EMPTY', name: Oger._('Leere Felder von Import Ergänzen') },
										]
									}),
									queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
								},
								{ name: 'archObjectRemoveRefs', xtype: 'checkbox',
									boxLabel: Oger._('Bestehende Verweise löschen - GEFÄHRLICH!'), hideEmptyLabel: false, labelWidth: 150,
								},
								{ name: 'archObjectType', xtype: 'combo', fieldLabel: Oger._('Unbekannte Objekt Art/Bezeichn.'),
									width: 500, labelWidth: 200, value: 'TEXTVALUE_ONLY',
									store: Ext.create('Ext.data.Store', {
										fields: [ 'id', 'name' ],
										data: [
											{ id: 'TEXTVALUE_ONLY', name: Oger._('Nie Stammdaten anlegen / nur Text übernehmen') },
											{ id: 'INHERIT_SOURCE', name: Oger._('Stamm oder Text - wie importiert') },
											{ id: 'MASTERDATA_ONLY', name: Oger._('Immer als Stammdaten anlegen') },
										]
									}),
									queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
								},
							],
						},

						{ xtype: 'fieldset', title: Oger._('Objektgruppe'),
							items: [
								{ xtype: 'fieldcontainer', layout: 'hbox',
									items: [
										{ name: 'archObjGroupBeginId', xtype: 'textfield', fieldLabel: Oger._('Von Nummer'), validator: xidValid },
										{ xtype: 'tbspacer', width: 20 },
										{ name: 'archObjGroupEndId', xtype: 'textfield', fieldLabel: Oger._('Bis Nummer'), validator: xidValid },
									],
								},
								{ name: 'archObjGroupInsert', xtype: 'combo', fieldLabel: Oger._('Neue Datensätze'), value: '',
									width: 400, labelWidth: 150,
									store: Ext.create('Ext.data.Store', {
										fields: [ 'id', 'name' ],
										data: [
											{ id: '', name: Oger._('Ignorieren') },
											{ id: 'INSERT', name: Oger._('Übernehmen') },
										]
									}),
									queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
								},
								{ name: 'archObjGroupUpdate', xtype: 'combo', fieldLabel: Oger._('Bestehende Datensätze'), value: '',
									width: 400, labelWidth: 150,
									store: Ext.create('Ext.data.Store', {
										fields: [ 'id', 'name' ],
										data: [
											{ id: '', name: Oger._('Beibehalten / Import ablehnen') },
											{ id: 'REPLACE', name: Oger._('Ersetzen durch Import') },
											//{ id: 'MERGE_EMPTY', name: Oger._('Leere Felder von Import Ergänzen') },
										]
									}),
									queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
								},
								{ name: 'archObjGroupRemoveRefs', xtype: 'checkbox',
									boxLabel: Oger._('Bestehende Verweise löschen - GEFÄHRLICH!'), hideEmptyLabel: false, labelWidth: 150,
								},
								{ name: 'archObjGroupType', xtype: 'combo', fieldLabel: Oger._('Unbekannte Obj.Grp Art/Bezeichn.'),
									width: 500, labelWidth: 200, value: 'TEXTVALUE_ONLY',
									store: Ext.create('Ext.data.Store', {
										fields: [ 'id', 'name' ],
										data: [
											{ id: 'TEXTVALUE_ONLY', name: Oger._('Nie Stammdaten anlegen / nur Text übernehmen') },
											{ id: 'INHERIT_SOURCE', name: Oger._('Stamm oder Text - wie importiert') },
											{ id: 'MASTERDATA_ONLY', name: Oger._('Immer als Stammdaten anlegen') },
										]
									}),
									queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
								},
							],
						},

					],
				},  // eo excav elements

				{ xtype: 'panel',
					title: Oger._('Stammdaten'),
					layout: 'anchor',
					bodyPadding: 15,
					border: false,
					hideMode: 'offsets',
					autoScroll: true,
					items: [

						{ xtype: 'fieldset', title: Oger._('Basisdaten'),
							items: [
								{ name: 'companyMaster', xtype: 'combo', fieldLabel: Oger._('Firma'), value: '',
									width: 580,
									store: Ext.create('Ext.data.Store', {
										fields: [ 'id', 'name' ],
										data: [
											{ id: '', name: Oger._('Nicht übernehmen') },
											{ id: 'INSERT', name: Oger._('Nur übernehmen, wenn noch kein Datensatz vorhanden ist') },
											{ id: 'REPLACE_OR_INSERT', name: Oger._('Übernehmen - bestehenden Datensatz ersetzen, wenn schon vorhanden') },
											//{ id: 'MERGE_EMPTY_OR_INSERT', name: Oger._('Leere Felder von Import Ergänzen') },
										]
									}),
									queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
								},

							],
						},

						{ xtype: 'fieldset', title: Oger._('Allgemeine Stammdaten'),
							defaults: {
								width: 500,
								labelWidth: 200,
							},
							items: [
								{ name: 'stratumCategoryMaster', xtype: 'checkbox', boxLabel: Oger._('Stratum Kategorien'), uncheckedValue: '0', disabled: true },
								{ name: 'stratumTypeMaster', xtype: 'checkbox', boxLabel: Oger._('Stratum Art/Bezeichnung'), uncheckedValue: '0' },
								{ name: 'archObjectTypeMaster', xtype: 'checkbox', boxLabel: Oger._('Objekt Art/Bezeichnung'), uncheckedValue: '0' },
								{ name: 'archObjGroupTypeMaster', xtype: 'checkbox', boxLabel: Oger._('Objektgruppe Art/Bezeichnung'), uncheckedValue: '0' },
							],
						},

					],
				},  // eo excav elements .. extended

				{ xtype: 'panel',
					title: Oger._('Sonderdaten/Extras'),
					layout: 'anchor',
					bodyPadding: 15,
					border: false,
					hideMode: 'offsets',
					autoScroll: true,
					items: [

						{ xtype: 'fieldset', title: Oger._('Sonderdaten'), disabled: true,
							items: [
								{ name: 'dbStruct', xtype: 'checkbox', fieldLabel: Oger._('Datenbankstruktur'), uncheckedValue: '0' },
							],
						},

						{ xtype: 'fieldset', title: Oger._('Stratify LST'), disabled: true,
							items: [
								{ name: 'ignoreStratumIdList', xtype: 'textfield', fieldLabel: Oger._('Ignoriere Stratumliste'), width: 500 },
							],
						},

					],
				},  // eo extras

			],
		},  // excav elements / more tab



	],  // eo form items

	url: 'php/scripts/import.php',

	// ########################################################


});
