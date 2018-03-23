/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/



/**
* Stratum form
*/
Ext.define('App.view.inputCenter.stratum.Form', {
	extend: 'Ext.form.Panel',
	alias: 'widget.ic_stratumform',

	bodyPadding: 15,
	border: false,
	autoScroll: true,
	layout: 'anchor',
	trackResetOnLoad: true,

	items: [
		{ xtype: 'hidden', name: 'dbAction' },
		{ xtype: 'hidden', name: 'id' },
		{ xtype: 'hidden', name: 'excavId' },
		{ xtype: 'hidden', name: 'oldCategoryId' },
		{ xtype: 'fieldcontainer', layout: 'hbox',
			items: [
				{ name: 'stratumId', xtype: 'textfield', fieldLabel: Oger._('Stratum-Nr'), selectOnFocus: true,
					allowBlank: false, validator: xidValid,
				},
				{ name: 'jumpToStratumId', xtype: 'textfield', fieldLabel: Oger._('<u>S</u>pringe zu Nr'), validator: xidValid,
					width: 300, labelWidth: 170, labelAlign: 'right',
					listeners: {
						change: function(field, newValue, oldValue, options) {
							field.resetOriginalValue();
						},
					},
				},
				{ xtype: 'button', text: Oger._('S<u>p</u>ringen'), width: 80,
					handler: function(button, event) {
						this.up('window').jumpToRecord();
					}
				},
			],
		},

		{ xtype: 'fieldcontainer', layout: 'hbox',
			items: [
				{ name: 'categoryId', xtype: 'combo', fieldLabel: Oger._('Kategorie'), width: 250,
					forceSelection: true, allowBlank: false,
					queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
					listeners: {
						beforerender: function(cmp, options) {
							cmp.setStore(Ext.ComponentQuery.query('inputcenterpanel')[0].stratumCategoryStore);
						},
						change: function(cmp, newValue, oldValue, options) {   // this is a little overkill but usefull
							cmp.up('form').adjustDetailPanel();                   // to detect setting categoryId to empty
						},                                                      // for example via form.reset()
						select: function(cmp, records, eOpts) {
							cmp.up('form').adjustDetailPanel();
						},
					},  // eo listerners
				},
				{ xtype: 'tbspacer', width: 25 },
				{ name: 'typeId', xtype: 'combo', regex: TYPENAME_REGEX, width: 300,
					fieldLabel: Oger._('Art/Bezeichnung'), labelAlign: 'right',
					queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all', value: '',
					listeners: {
						beforerender: function(cmp, options) {
							cmp.setStore(this.up('window').gluePanel.filteredStratumTypeStore);
						},
					}  // eo listerners
				},
			],
		},

		{ xtype: 'tabpanel',
			activeTab: 0,
			plain: true,
			//autoScroll: true,
			deferredRender: false,
			items: [

				{ xtype: 'panel',
					title: Oger._('Allgemein <u>1</u>'),
					layout: 'anchor',
					bodyPadding: 15,
					border: false,
					hideMode: 'offsets',
					autoScroll: true,
					items: [
						{ xtype: 'fieldcontainer', layout: 'hbox',
							items: [
								{ xtype: 'datefield', fieldLabel: Oger._('Datum'), name: 'date', submitFormat: 'Y-m-d', width: 200 },
								{ xtype: 'textfield', fieldLabel: Oger._('BearbeiterIn'), name: 'originator', width: 400, labelAlign: 'right' },
							],
						},
						{ xtype: 'fieldcontainer', layout: 'hbox',
							items: [
								{ name: 'plotName', xtype: 'textfield', fieldLabel: Oger._('Grundst-Nr'), width: 250 },
								{ name: 'fieldName', xtype: 'textfield', fieldLabel: Oger._('Flur'), width: 250, labelAlign: 'right' },
							],
						},
						{ xtype: 'fieldcontainer', layout: 'hbox',
							items: [
								{ name: 'section', xtype: 'textfield', fieldLabel: Oger._('Schnitt'), width: 250, validator: multiXidValid },
								{ name: 'area', xtype: 'textfield', fieldLabel: Oger._('Fläche'), width: 250, labelAlign: 'right', validator: multiXidValid },
							],
						},
						{ name: 'profile', xtype: 'textfield', fieldLabel: Oger._('Profil'), width: 250, validator: multiXidValid },

						{ xtype: 'tbspacer', height: 20 },
						{ name: 'listComment', xtype: 'textfield', fieldLabel: Oger._('Anmerkung für BDA-Liste'), width: 600, labelWidth: 150 },
					],
				},  // eo location tab

				{ xtype: 'panel',
					title: Oger._('Allgemein 2'),
					layout: 'anchor',
					bodyPadding: 15,
					border: false,
					hideMode: 'offsets',
					autoScroll: true,
					items: [
						{ name: 'interpretation', xtype: 'textfield', fieldLabel: Oger._('Interpretation'), width: 600 },
						{ xtype: 'fieldcontainer', layout: 'hbox',
							items: [
								{ name: 'datingSpec', xtype: 'textfield', fieldLabel: Oger._('Datierung'), width: 300 + 20 },
								{ name: 'datingPeriodId', xtype: 'combo', fieldLabel: Oger._('Periode'), width: 280,
									labelAlign: 'right', labelWidth: 75 - 20,
									queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
									listeners: {
										beforerender: function(cmp, options) {
											cmp.setStore(this.up('window').gluePanel.datingPeriodStore);
										},
									}  // eo listerners
								},
							],
						},
						{ xtype: 'checkboxgroup', fieldLabel: Oger._('Basierend auf'), name: 'datingSource___',
							items: [
								{ name: 'dendrochronology', boxLabel: Oger._('Dendrochronologie'),
									inputValue: '1', uncheckedValue: '0'
								},
								{ name: 'datingStratigraphy', boxLabel: Oger._('Stratigrafie'),
									inputValue: '1', uncheckedValue: '0'
								},
								{ name: 'datingWallStructure', boxLabel: Oger._('Struktur'),
									inputValue: '1', uncheckedValue: '0'
								},
							]
						},
						{ xtype: 'fieldset', title: Oger._('Verweise auf zeichnerische und fotografische Dokumentation'),
							items: [
								{ xtype: 'checkboxgroup', fieldLabel: Oger._('Foto'),
									//columns: 2,
									items: [
										{ name: 'photoDigital', boxLabel: Oger._('Digital'), inputValue: '1', uncheckedValue: '0' },
										{ name: 'photogrammetry', boxLabel: Oger._('Fotogrammetrie'), inputValue: '1', uncheckedValue: '0' },
										{ name: 'photoSlide', boxLabel: Oger._('Dia'), inputValue: '1', uncheckedValue: '0' },
										{ name: 'photoPrint', boxLabel: Oger._('Papier'), inputValue: '1', uncheckedValue: '0' },
									]
								},
								{ xtype: 'checkboxgroup', fieldLabel: Oger._('Plan'), width: 350,
									//columns: 1,
									items: [
										{ name: 'planDigital', boxLabel: Oger._('Digital'), inputValue: '1', uncheckedValue: '0' },
										{ name: 'planAnalog', boxLabel: Oger._('Papier'), inputValue: '1', uncheckedValue: '0' },
									]
								},
								{ name: 'pictureReference', xtype: 'textarea', hideLabel: true, width: 600, height: 150 },
							],
						},
					],
				},  // eo common tab

				{ xtype: 'panel',
					title: Oger._('Detail'),
					layout: 'anchor',
					bodyPadding: 15,
					border: false,
					hideMode: 'offsets',
					autoScroll: true,
					labelWidth: 120,
					items: [

						{ xtype: 'panel', border: false,
							isDetailPanel: true, isSpecificDetailPanel: true,
							layout: 'card',
							items: [

								{ xtype: 'panel',  // --- deposit
									border: false, disabled: true, deferredRender: true,
									isDetailPanel: true, isStratumDetailPanel: true,
									layout: 'anchor',
									defaults: {
										width: 500,
									},
									items: [
										{ name: 'color',  xtype: 'combo', fieldLabel: Oger._('Farbe'),
											hideTrigger: true, autoSelect: false,
											queryMode: 'local', valueField: 'id', displayField: 'text', triggerAction: 'all',
											listeners: {
												beforerender: function(cmp, options) {
													cmp.setStore(Ext.ComponentQuery.query('inputcenterpanel')[0].getFieldHistoryStore(
																			'stratum', STRATUMCATEGORYID_DEPOSIT, 'color'));
												},
											},
										},
										{ name: 'materialDenotation',  xtype: 'combo', fieldLabel: Oger._('Mat.Ansprache'),
											hideTrigger: true, autoSelect: false,
											queryMode: 'local', valueField: 'id', displayField: 'text', triggerAction: 'all',
											listeners: {
												beforerender: function(cmp, options) {
													cmp.setStore(Ext.ComponentQuery.query('inputcenterpanel')[0].getFieldHistoryStore(
																			'stratum', STRATUMCATEGORYID_DEPOSIT, 'materialDenotation'));
												},
											},
										},
										{ name: 'consistency',  xtype: 'combo', fieldLabel: Oger._('Konsistenz'),
											hideTrigger: true, autoSelect: false,
											queryMode: 'local', valueField: 'id', displayField: 'text', triggerAction: 'all',
											listeners: {
												beforerender: function(cmp, options) {
													cmp.setStore(Ext.ComponentQuery.query('inputcenterpanel')[0].getFieldHistoryStore(
																			'stratum', STRATUMCATEGORYID_DEPOSIT, 'consistency'));
												},
											},
										},
										{ name: 'inclusion',  xtype: 'combo', fieldLabel: Oger._('Einschlüsse'),
											hideTrigger: true, autoSelect: false,
											queryMode: 'local', valueField: 'id', displayField: 'text', triggerAction: 'all',
											listeners: {
												beforerender: function(cmp, options) {
													cmp.setStore(Ext.ComponentQuery.query('inputcenterpanel')[0].getFieldHistoryStore(
																			'stratum', STRATUMCATEGORYID_DEPOSIT, 'inclusion'));
												},
											},
										},
										{ name: 'hardness',  xtype: 'combo', fieldLabel: Oger._('Härte'),
											hideTrigger: true, autoSelect: false,
											queryMode: 'local', valueField: 'id', displayField: 'text', triggerAction: 'all',
											listeners: {
												beforerender: function(cmp, options) {
													cmp.setStore(Ext.ComponentQuery.query('inputcenterpanel')[0].getFieldHistoryStore(
																			'stratum', STRATUMCATEGORYID_DEPOSIT, 'hardness'));
												},
											},
										},
										{ name: STRATUMCATEGORYID_DEPOSIT + '___orientation',  xtype: 'combo',
											fieldLabel: Oger._('Ausrichtung'),
											hideTrigger: true, autoSelect: false,
											queryMode: 'local', valueField: 'id', displayField: 'text', triggerAction: 'all',
											listeners: {
												beforerender: function(cmp, options) {
													cmp.setStore(Ext.ComponentQuery.query('inputcenterpanel')[0].getFieldHistoryStore(
																			'stratum', STRATUMCATEGORYID_DEPOSIT, 'orientation'));
												},
											},
										},
										{ name: 'incline',  xtype: 'combo', fieldLabel: Oger._('Gefälle'),
											hideTrigger: true, autoSelect: false,
											queryMode: 'local', valueField: 'id', displayField: 'text', triggerAction: 'all',
											listeners: {
												beforerender: function(cmp, options) {
													cmp.setStore(Ext.ComponentQuery.query('inputcenterpanel')[0].getFieldHistoryStore(
																			'stratum', STRATUMCATEGORYID_DEPOSIT, 'incline'));
												},
											},
										},
									],
								},  // eo stratum

								{ xtype: 'panel',   // --- interface
									border: false, disabled: true, deferredRender: true,
									isDetailPanel: true, isInterfaceDetailPanel: true,
									layout: 'anchor',
									defaults: {
										width: 500,
									},
									items: [
										{ name: 'shape',  xtype: 'combo', fieldLabel: Oger._('Form'),
											hideTrigger: true, autoSelect: false,
											queryMode: 'local', valueField: 'id', displayField: 'text', triggerAction: 'all',
											listeners: {
												beforerender: function(cmp, options) {
													cmp.setStore(Ext.ComponentQuery.query('inputcenterpanel')[0].getFieldHistoryStore(
																			'stratum', STRATUMCATEGORYID_INTERFACE, 'shape'));
												},
											},
										},
										{ name: 'contour',  xtype: 'combo', fieldLabel: Oger._('Kontur'),
											hideTrigger: true, autoSelect: false,
											queryMode: 'local', valueField: 'id', displayField: 'text', triggerAction: 'all',
											listeners: {
												beforerender: function(cmp, options) {
													cmp.setStore(Ext.ComponentQuery.query('inputcenterpanel')[0].getFieldHistoryStore(
																			'stratum', STRATUMCATEGORYID_INTERFACE, 'contour'));
												},
											},
										},
										{ name: 'vertex',  xtype: 'combo', fieldLabel: Oger._('Ecken'),
											hideTrigger: true, autoSelect: false,
											queryMode: 'local', valueField: 'id', displayField: 'text', triggerAction: 'all',
											listeners: {
												beforerender: function(cmp, options) {
													cmp.setStore(Ext.ComponentQuery.query('inputcenterpanel')[0].getFieldHistoryStore(
																			'stratum', STRATUMCATEGORYID_INTERFACE, 'vertex'));
												},
											},
										},
										{ name: 'sidewall',  xtype: 'combo', fieldLabel: Oger._('Seiten'),
											hideTrigger: true, autoSelect: false,
											queryMode: 'local', valueField: 'id', displayField: 'text', triggerAction: 'all',
											listeners: {
												beforerender: function(cmp, options) {
													cmp.setStore(Ext.ComponentQuery.query('inputcenterpanel')[0].getFieldHistoryStore(
																			'stratum', STRATUMCATEGORYID_INTERFACE, 'sidewall'));
												},
											},
										},
										{ name: 'intersection',  xtype: 'combo', fieldLabel: Oger._('Seitenübergang'),
											hideTrigger: true, autoSelect: false,
											queryMode: 'local', valueField: 'id', displayField: 'text', triggerAction: 'all',
											listeners: {
												beforerender: function(cmp, options) {
													cmp.setStore(Ext.ComponentQuery.query('inputcenterpanel')[0].getFieldHistoryStore(
																			'stratum', STRATUMCATEGORYID_INTERFACE, 'intersection'));
												},
											},
										},
										{ name: 'basis',  xtype: 'combo', fieldLabel: Oger._('Basis'),
											hideTrigger: true, autoSelect: false,
											queryMode: 'local', valueField: 'id', displayField: 'text', triggerAction: 'all',
											listeners: {
												beforerender: function(cmp, options) {
													cmp.setStore(Ext.ComponentQuery.query('inputcenterpanel')[0].getFieldHistoryStore(
																			'stratum', STRATUMCATEGORYID_INTERFACE, 'basis'));
												},
											},
										},
									],
								},  // eo interface

								{ xtype: 'tabpanel',   // --- wall
									border: false, disabled: true, deferredRender: false,
									isDetailPanel: true, isWallDetailPanel: true,
									activeTab: 0,
									plain: true,
									//autoScroll: true,
									items: [
										{ xtype: 'panel',
											title: Oger._('Allgemein'),
											layout: 'anchor',
											bodyPadding: 15,
											border: false,
											hideMode: 'offsets',
											autoScroll: true,
											items: [
												{ xtype: 'fieldcontainer', layout: 'hbox',
													items: [
														{ name: 'constructionType', xtype: 'combo', fieldLabel: Oger._('Bauart'), width: 250,
															queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
															forceSelection: true,
															listeners: {
																beforerender: function(cmp, options) {
																	cmp.setStore(Ext.ComponentQuery.query('inputcenterpanel')[0].wallConstructionTypeStore);
																},
															}  // eo listerners
														},
														{ xtype: 'tbspacer', width: 20 },
														{ name: 'structureType', xtype: 'combo', fieldLabel: Oger._('Struktur'), width: 250, labelAlign: 'right',
															queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
															forceSelection: true,
															listeners: {
																beforerender: function(cmp, options) {
																	cmp.setStore(Ext.ComponentQuery.query('inputcenterpanel')[0].wallStructureTypeStore);
																},
															}  // eo listerners
														},
													],
												},
												{ name: 'wallBaseType', xtype: 'combo', fieldLabel: Oger._('Mauerwerk/Typ'), width: 250,
													queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
													forceSelection: true,
													listeners: {
														beforerender: function(cmp, options) {
															cmp.setStore(Ext.ComponentQuery.query('inputcenterpanel')[0].wallBaseTypeStore);
														},
													}  // eo listerners
												},
												{ xtype: 'displayfield', fieldLabel: Oger._('Verhältnisse zu anderen Bauteilen'), value: '', width: 500, labelWidth: 300 },
												{ name: STRATUMCATEGORYID_WALL + '___relationDescription', xtype: 'textarea', hideLabel: true, width: 500, height: 100 },
											],
										},  // eo wall common tab
										{ xtype: 'panel',
											title: Oger._('Beschreibung 1'),
											layout: 'anchor',
											bodyPadding: 15,
											border: false,
											hideMode: 'offsets',
											autoScroll: true,
											items: [
												{ xtype: 'displayfield', fieldLabel: Oger._('Beschreibung Lagen'), value: '', width: 500, labelWidth: 300 },
												{ name: 'layerDescription', xtype: 'textarea', hideLabel: true, width: 500, height: 100 },
												{ xtype: 'displayfield', fieldLabel: Oger._('Beschreibung Mauerschale'), value: '', width: 500, labelWidth: 300 },
												{ name: 'shellDescription', xtype: 'textarea', hideLabel: true, width: 500, height: 100 },
												{ xtype: 'displayfield', fieldLabel: Oger._('Beschreibung Mauerkern'), value: '', width: 500, labelWidth: 300 },
												{ name: 'kernelDescription', xtype: 'textarea', hideLabel: true, width: 500, height: 100 },
												{ xtype: 'displayfield', fieldLabel: Oger._('Beschreibung Schalung'), value: '', width: 500, labelWidth: 300 },
												{ name: 'formworkDescription', xtype: 'textarea', hideLabel: true, width: 500, height: 100 },
											],
										},  // eo wall description1 tab
										{ xtype: 'panel',
											title: Oger._('Beschreibung 2'),
											layout: 'anchor',
											bodyPadding: 15,
											border: false,
											hideMode: 'offsets',
											autoScroll: true,
											items: [
												{ xtype: 'fieldset', title: Oger._('Bauschliessen'), disabled: true,
													items: [
														{ name: 'UNKNOWN_bauschliessen', xtype: 'checkbox', fieldLabel: Oger._('Vorhanden'),
															inputValue: '1', uncheckedValue: '0'
														},
														{ xtype: 'displayfield', fieldLabel: Oger._('Beschreibung: Form'), value: '', width: 500, labelWidth: 300 },
														{ name: '', xtype: 'textarea', hideLabel: true, width: 500, height: 100 },
													],
												},
												{ xtype: 'fieldset', title: Oger._('Gerüstlöcher'),
													items: [
														{ name: 'hasPutlogHole', xtype: 'checkbox', fieldLabel: Oger._('Vorhanden'),
															inputValue: '1', uncheckedValue: '0'
														},
														{ xtype: 'displayfield', fieldLabel: Oger._('Beschreibung: Lage, Masse'), value: '', width: 500, labelWidth: 300 },
														{ name: 'putlogHoleDescription', xtype: 'textarea', hideLabel: true, width: 500, height: 100 },
													],
												},
												{ xtype: 'fieldset', title: Oger._('Balkenlöcher'),
													items: [
														{ name: 'hasBarHole', xtype: 'checkbox', fieldLabel: Oger._('Vorhanden'),
															inputValue: '1', uncheckedValue: '0'
														},
														{ xtype: 'displayfield', fieldLabel: Oger._('Beschreibung: Lage, Masse'), value: '', width: 500, labelWidth: 300 },
														{ name: 'barHoleDescription', xtype: 'textarea', hideLabel: true, width: 500, height: 100 },
													],
												},
											],
										},  // eo wall description2 tab

										{ xtype: 'panel',
											title: Oger._('Material'),
											bodyPadding: 15,
											layout: 'anchor',
											items: [
												{ xtype: 'tabpanel',
													deferredRender: false,
													activeTab: 0,
													plain: true,
													//autoScroll: true,
													items: [
														{ xtype: 'panel',
															title: Oger._('Allgemein'),
															layout: 'anchor',
															bodyPadding: 15,
															border: false,
															hideMode: 'offsets',
															autoScroll: true,
															items: [
																{ name: 'materialType', xtype: 'combo', fieldLabel: Oger._('Material'), width: 250,
																	queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
																	forceSelection: true,
																	listeners: {
																		beforerender: function(cmp, options) {
																			cmp.setStore(Ext.ComponentQuery.query('inputcenterpanel')[0].wallMaterialTypeStore);
																		},
																	}  // eo listerners
																},
																{ xtype: 'displayfield', fieldLabel: Oger._('Spolien - Beschreibung und Datierung'), value: '', width: 450, labelWidth: 300 },
																{ name: 'spoilDescription', xtype: 'textarea', hideLabel: true, width: 500, height: 150 },
															],
														},
														{ xtype: 'panel',
															title: Oger._('Stein'),
															layout: 'anchor',
															bodyPadding: 15,
															border: false,
															hideMode: 'offsets',
															autoScroll: true,
															items: [
																{ name: 'stoneSize', xtype: 'textfield', fieldLabel: Oger._('Steingrösse'), width: 500 },
																{ name: 'stoneMaterial', xtype: 'textfield', fieldLabel: Oger._('Steinmaterial'), width: 500 },
																{ name: 'stoneProcessing', xtype: 'textfield', fieldLabel: Oger._('Bearbeitung'), width: 500 },
															],
														},
														{ xtype: 'panel',
															title: Oger._('Ziegel 1'),
															layout: 'anchor',
															bodyPadding: 15,
															border: false,
															hideMode: 'offsets',
															autoScroll: true,
															items: [
															 { xtype: 'checkboxgroup', fieldLabel: Oger._('Ziegelart'),
																	items: [
																		{ name: 'hasCommonBrick', boxLabel: Oger._('Mauerziegel'),
																			inputValue: '1', uncheckedValue: '0'
																		},
																		{ name: 'hasVaultBrick', boxLabel: Oger._('Gewölbeziegel'),
																			inputValue: '1', uncheckedValue: '0'
																		},
																		{ name: 'hasRoofTile', boxLabel: Oger._('Dachziegel'),
																			inputValue: '1', uncheckedValue: '0'
																		},
																		{ name: 'hasFortificationBrick', boxLabel: Oger._('Fortifikationsziegel'),
																			inputValue: '1', uncheckedValue: '0'
																		},
																	],
																},
																{ xtype: 'displayfield', fieldLabel: Oger._('Ziegelgrösse (Originalmasse) je Ziegelart'), value: '', width: 450, labelWidth: 300 },
																{ name: 'brickDescription', xtype: 'textarea', hideLabel: true, width: 500, height: 150 },
															],
														},
														{ xtype: 'panel',
															title: Oger._('Ziegel 2'),
															layout: 'anchor',
															bodyPadding: 15,
															border: false,
															hideMode: 'offsets',
															autoScroll: true,
															items: [
																{ xtype: 'checkboxgroup', fieldLabel: Oger._('Herstellungs-merkmale'),
																	columns: 1,
																	items: [
																		{ name: 'hasProductionStampSign', boxLabel: Oger._('Zeichen (erhaben, vertieft, Stempel)'),
																			inputValue: '1', uncheckedValue: '0'
																		},
																		{ name: 'hasProductionFingerSign', boxLabel: Oger._('Fingerstriche'),
																			inputValue: '1', uncheckedValue: '0'
																		},
																		{ name: 'hasProductionOtherAttribute', boxLabel: Oger._('Wischzeichen, Tierspuren, Sonstiges'),
																			inputValue: '1', uncheckedValue: '0'
																		},
																	],
																},
																{ xtype: 'displayfield', fieldLabel: Oger._('Herstellungsmerkmale (Detailbeschreibung)'), value: '', width: 450, labelWidth: 300 },
																{ name: 'productionDescription', xtype: 'textarea', hideLabel: true, width: 500, height: 150 },
															],
														},
														{ xtype: 'panel',
															title: Oger._('Mischmauerwerk'),
															layout: 'anchor',
															bodyPadding: 15,
															border: false,
															hideMode: 'offsets',
															autoScroll: true,
															items: [
																{ name: 'mixedWallBrickPercent', xtype: 'textfield', fieldLabel: Oger._('Ziegelanteil in Prozent'), width: 500 },
																{ xtype: 'displayfield', fieldLabel: Oger._('Mischmauerwerk - Beschreibung'), value: '', width: 450, labelWidth: 300 },
																{ name: 'mixedWallDescription', xtype: 'textarea', hideLabel: true, width: 500, height: 150 },
															],
														},
													],
												},
											],
										},   // eo wall-material

										{ xtype: 'panel',
											title: Oger._('Bindung'),
											layout: 'anchor',
											bodyPadding: 15,
											items: [
												{ xtype: 'tabpanel',
													deferredRender: false,
													activeTab: 0,
													plain: true,
													//autoScroll: true,
													items: [
														{ xtype: 'panel',
															title: Oger._('Allgemein'),
															layout: 'anchor',
															bodyPadding: 15,
															border: false,
															hideMode: 'offsets',
															autoScroll: true,
															items: [
																{ name: 'binderState', xtype: 'combo', fieldLabel: Oger._('Zustand'), width: 250,
																	queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
																	forceSelection: true,
																	listeners: {
																		beforerender: function(cmp, options) {
																			cmp.setStore(Ext.ComponentQuery.query('inputcenterpanel')[0].wallBinderStateStore);
																		},
																	}  // eo listerners
																},
																{ name: 'binderType', xtype: 'combo', fieldLabel: Oger._('Bindemittel'), width: 250,
																	queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
																	forceSelection: true,
																	listeners: {
																		beforerender: function(cmp, options) {
																			cmp.setStore(Ext.ComponentQuery.query('inputcenterpanel')[0].wallBinderTypeStore);
																		},
																	}  // eo listerners
																},
																{ name: 'binderColor', xtype: 'textfield', fieldLabel: Oger._('Farbe'), width: 500 },
																{ xtype: 'fieldcontainer', layout: 'hbox',
																	items: [
																		{ name: 'binderSandPercent', xtype: 'textfield', fieldLabel: Oger._('Sandanteil') },
																		{ xtype: 'tbspacer', width: 20 },
																		{ name: 'binderLimeVisible', xtype: 'checkbox', fieldLabel: Oger._('Kalk sichtbar'),
																			inputValue: '1', uncheckedValue: '0'
																		},
																	],
																},
																{ name: 'binderGrainSize', xtype: 'combo', fieldLabel: Oger._('Korngrösse'), width: 250,
																	queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
																	forceSelection: true,
																	listeners: {
																		beforerender: function(cmp, options) {
																			cmp.setStore(Ext.ComponentQuery.query('inputcenterpanel')[0].wallBinderGrainSizeStore);
																		},
																	}  // eo listerners
																},
																{ name: 'binderConsistency', xtype: 'combo', fieldLabel: Oger._('Konsistenz'), width: 250,
																	queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
																	forceSelection: true,
																	listeners: {
																		beforerender: function(cmp, options) {
																			cmp.setStore(Ext.ComponentQuery.query('inputcenterpanel')[0].wallBinderConsistencyStore);
																		},
																	}  // eo listerners
																},
															],
														},
														{ xtype: 'panel',
															title: Oger._('Zuschlagstoffe'),
															layout: 'anchor',
															bodyPadding: 15,
															border: false,
															hideMode: 'offsets',
															autoScroll: true,
															items: [
																{ xtype: 'fieldset', title: Oger._('Zuschlagstoffe in cm'),
																	items: [
																		{ name: 'additivePebbleSize', xtype: 'textfield', fieldLabel: Oger._('Kiesel'), width: 500 },
																		{ name: 'additiveLimepopSize', xtype: 'textfield', fieldLabel: Oger._('Kalkspatzen'), width: 500 },
																		{ name: 'additiveCrushedTilesSize', xtype: 'textfield', fieldLabel: Oger._('Ziegelsplitt'), width: 500 },
																		{ name: 'additiveCharcoalSize', xtype: 'textfield', fieldLabel: Oger._('Holzkohle'), width: 500 },
																		{ name: 'additiveStrawSize', xtype: 'textfield', fieldLabel: Oger._('Stroh'), width: 500 },
																		{ name: 'additiveOtherSize', xtype: 'textfield', fieldLabel: Oger._('Sonstiges'), width: 500 },
																	],
																},
																{ xtype: 'displayfield', fieldLabel: Oger._('Beschreibung sonstige Zuschlagstoffe'), value: '', width: 450, labelWidth: 300 },
																{ name: 'additiveOtherDescription', xtype: 'textarea', hideLabel: true, width: 500, height: 100 },
															],
														},
														{ xtype: 'panel',
															title: Oger._('Fuge'),
															layout: 'anchor',
															bodyPadding: 15,
															border: false,
															hideMode: 'offsets',
															autoScroll: true,
															items: [
																{ name: 'abreuvoirType', xtype: 'combo', fieldLabel: Oger._('Fugenbild'), width: 250,
																	queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
																	forceSelection: true,
																	listeners: {
																		beforerender: function(cmp, options) {
																			cmp.setStore(Ext.ComponentQuery.query('inputcenterpanel')[0].wallAbreuvoirTypeStore);
																		},
																	}  // eo listerners
																},
																{ xtype: 'displayfield', fieldLabel: Oger._('Fugendimensionen'), value: '', width: 450, labelWidth: 300 },
																{ name: 'abreuvoirDescription', xtype: 'textarea', hideLabel: true, width: 500, height: 100 },
															],
														},
													],
												},
											],
										},  // eo wall binder tab

										{ xtype: 'panel',
											title: Oger._('Verputz'),
											layout: 'anchor',
											bodyPadding: 15,
											items: [
												{ name: 'plasterSurface', xtype: 'combo', fieldLabel: Oger._('Oberflächengestaltung'), width: 300, labelWidth: 150,
													queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
													forceSelection: true,
													listeners: {
														beforerender: function(cmp, options) {
															cmp.setStore(Ext.ComponentQuery.query('inputcenterpanel')[0].wallPlasterSurfaceStore);
														},
													}  // eo listerners
												},
												{ name: 'plasterThickness', xtype: 'textfield', fieldLabel: Oger._('Putzstärke (mm)'), width: 500, labelWidth: 150 },
												{ name: 'plasterExtend', xtype: 'textfield', fieldLabel: Oger._('Ausdehnung und Verlauf'), width: 500, labelWidth: 150 },
												{ name: 'plasterColor', xtype: 'textfield', fieldLabel: Oger._('Farbe'), width: 500, labelWidth: 150 },
												{ name: 'plasterMixture', xtype: 'textfield', fieldLabel: Oger._('Zusammensetzung'), width: 500, labelWidth: 150 },
												{ name: 'plasterGrainSize', xtype: 'textfield', fieldLabel: Oger._('Korngrösse'), width: 500, labelWidth: 150 },
												{ name: 'plasterConsistency', xtype: 'textfield', fieldLabel: Oger._('Konsistenz'), width: 500, labelWidth: 150 },
												{ name: 'plasterAdditives', xtype: 'textfield', fieldLabel: Oger._('Zuschlagstoffe (in cm)'), width: 500, labelWidth: 150 },
												{ name: 'plasterLayer', xtype: 'textfield', fieldLabel: Oger._('Mehrlagigkeit'), width: 500, labelWidth: 150 },
											],
										},  // eo wall plaster tab

									],
								},  // eo wall

								{ xtype: 'tabpanel',   // --- skeleton
									border: false, disabled: true, deferredRender: false,
									isDetailPanel: true, isSkeletonDetailPanel: true,
									activeTab: 0,
									plain: true,
									//autoScroll: true,
									items: [
										{ xtype: 'panel',
											title: Oger._('Skelett'),
											layout: 'anchor',
											bodyPadding: 15,
											border: false,
											hideMode: 'offsets',
											autoScroll: true,
											items: [
												{ xtype: 'fieldcontainer', layout: 'hbox',
													items: [
														{ name: 'bodyPosition', xtype: 'combo', fieldLabel: Oger._('Körperlage'), width: 260,
															queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
															forceSelection: true,
															listeners: {
																beforerender: function(cmp, options) {
																	cmp.setStore(Ext.ComponentQuery.query('inputcenterpanel')[0].skeletonBodyPositionTypeStore);
																},
															}  // eo listerners
														},
														{ xtype: 'tbspacer', width: 20 },
														{ name: STRATUMCATEGORYID_SKELETON + '___orientation', xtype: 'textfield',
															fieldLabel: Oger._('Orientierung'), labelAlign: 'right'
														},
													],
												},
												{ xtype: 'fieldcontainer', layout: 'hbox',
													items: [
														{ name: 'armPosition', xtype: 'combo', fieldLabel: Oger._('Arme'), width: 260, labelWidth: 50,
															queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
															forceSelection: true,
															listeners: {
																beforerender: function(cmp, options) {
																	cmp.setStore(Ext.ComponentQuery.query('inputcenterpanel')[0].skeletonArmPositionTypeStore);
																},
															}  // eo listerners
														},
														{ xtype: 'tbspacer', width: 20 },
														{ name: 'legPosition', xtype: 'combo', fieldLabel: Oger._('Beine'), width: 260,
															labelWidth: 50, labelAlign: 'right',
															queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
															forceSelection: true,
															listeners: {
																beforerender: function(cmp, options) {
																	cmp.setStore(Ext.ComponentQuery.query('inputcenterpanel')[0].skeletonLegPositionTypeStore);
																},
															}  // eo listerners
														},
														{ xtype: 'tbspacer', width: 10 },
														{ xtype: 'button', text: Oger._('Info'), minWidth: 30,
															handler: function(button, event) {
																window.open('img/stratum/skeletonArmLegPositions.jpg',
																						'IMG',
																						'left=' + Math.floor(window.innerWidth * 0.1) + ',top=' + Math.floor(window.innerHeight * 0.1) +
																						',width=' + Math.floor(window.innerWidth * 0.8) + ',height=' + Math.floor(window.innerHeight * 0.8));
															}
														},
													],
												},
												{ xtype: 'fieldcontainer', layout: 'hbox',
													items: [
														{ name: 'viewDirection', xtype: 'textfield', fieldLabel: Oger._('Blickrichtung') },
														{ xtype: 'tbspacer', width: 50 },
														{ name: 'specialBurial', xtype: 'checkbox', inputValue: '1', uncheckedValue: '0',
															fieldLabel: Oger._('Sonderbestattung'), labelAlign: 'right'
														},
													],
												},
												{ xtype: 'checkboxgroup', fieldLabel: Oger._('Dislozierung'), border: 3,
													items: [
														{ name: 'dislocationNone', boxLabel: Oger._('Keine'), inputValue: '1', uncheckedValue: '0' },
														{ name: 'dislocationBase', boxLabel: Oger._('An Grabsohle'), inputValue: '1', uncheckedValue: '0' },
														{ name: 'dislocationShaft', boxLabel: Oger._('Im Schacht'), inputValue: '1', uncheckedValue: '0' },
														{ name: 'dislocationPrivation', boxLabel: Oger._('Beraubung'), inputValue: '1', uncheckedValue: '0' },
														{ name: 'dislocationDen', boxLabel: Oger._('Tierbau'), inputValue: '1', uncheckedValue: '0' },
													],
												},
												{ xtype: 'checkboxgroup', fieldLabel: Oger._('Bergung'),
													items: [
														{ name: 'recoverySingleBones', boxLabel: Oger._('Einzelknochen'), inputValue: '1', uncheckedValue: '0' },
														{ name: 'recoveryBlock', boxLabel: Oger._('Block'), inputValue: '1', uncheckedValue: '0' },
														{ name: 'recoveryHardened', boxLabel: Oger._('Härtung'), inputValue: '1', uncheckedValue: '0' },
													],
												},
												{ xtype: 'displayfield', value: '', width: 600, labelWidth: 500,
													fieldLabel: Oger._('Skelettanmerkungen'),
												},
												{ name: 'positionDescription', xtype: 'textarea', hideLabel: true, width: 600, height: 100 },
											],
										},  // eo skeleton 1 position tab
										{ xtype: 'panel',
											title: Oger._('Knochen'),
											layout: 'anchor',
											bodyPadding: 15,
											border: false,
											hideMode: 'offsets',
											autoScroll: true,
											items: [
												{ xtype: 'fieldcontainer', layout: 'hbox',
													items: [
														{ name: 'upperArmRightLength', xtype: 'numberfield', fieldLabel: Oger._('Rechter Oberarm (mm)'),
															width: 250, labelWidth: 150, allowDecimals: false, minValue: 0,
														},
														{ xtype: 'tbspacer', width: 20 },
														{ name: 'upperArmLeftLength', xtype: 'numberfield', fieldLabel: Oger._('Linker Oberarm (mm)'),
															width: 250, labelWidth: 150, labelAlign: 'right', allowDecimals: false, minValue: 0,
														},
													],
												},
												{ xtype: 'fieldcontainer', layout: 'hbox',
													items: [
														{ name: 'foreArmRightLength', xtype: 'numberfield', fieldLabel: Oger._('Rechter Unterarm (mm)'),
															width: 250, labelWidth: 150, allowDecimals: false, minValue: 0,
														},
														{ xtype: 'tbspacer', width: 20 },
														{ name: 'foreArmLeftLength', xtype: 'numberfield', fieldLabel: Oger._('Linker Unterarm (mm)'),
															width: 250, labelWidth: 150, labelAlign: 'right', allowDecimals: false, minValue: 0,
														},
													],
												},
												{ xtype: 'fieldcontainer', layout: 'hbox',
													items: [
														{ name: 'thighRightLength', xtype: 'numberfield', fieldLabel: Oger._('Recht. Oberschenkel (mm)'),
															width: 250, labelWidth: 150, allowDecimals: false, minValue: 0,
														},
														{ xtype: 'tbspacer', width: 20 },
														{ name: 'thighLeftLength', xtype: 'numberfield', fieldLabel: Oger._('Linker Oberschenkel (mm)'),
															width: 250, labelWidth: 150, labelAlign: 'right', allowDecimals: false, minValue: 0,
														},
													],
												},
												{ xtype: 'fieldcontainer', layout: 'hbox',
													items: [
														{ name: 'shinRightLength', xtype: 'numberfield', fieldLabel: Oger._('Rechtes Schienbein (mm)'),
															width: 250, labelWidth: 150, allowDecimals: false, minValue: 0,
														},
														{ xtype: 'tbspacer', width: 20 },
														{ name: 'shinLeftLength', xtype: 'numberfield', fieldLabel: Oger._('Linkes Schienbein (mm)'),
															width: 250, labelWidth: 150, labelAlign: 'right', allowDecimals: false, minValue: 0,
														},
													],
												},
												{ xtype: 'fieldcontainer', layout: 'hbox',
													items: [
														{ name: 'bodyLength', xtype: 'numberfield', fieldLabel: Oger._('Körperlänge (mm)'),
															width: 250, labelWidth: 150, allowDecimals: false, minValue: 0,
														},
														{ xtype: 'tbspacer', width: 20 },
														{ xtype: 'button', text: Oger._('Info'), minWidth: 30,
															handler: function(button, event) {
																window.open('img/stratum/skeletonSizes.jpg',
																						'IMG',
																						'left=' + Math.floor(window.innerWidth * 0.1) + ',top=' + Math.floor(window.innerHeight * 0.1) +
																						',width=' + Math.floor(window.innerWidth * 0.8) + ',height=' + Math.floor(window.innerHeight * 0.8));
															}
														},
													],
												},
												{ xtype: 'fieldcontainer', layout: 'hbox',
													items: [
														{ name: 'boneQuality', xtype: 'combo', fieldLabel: Oger._('Erhaltungszustand'), width: 250,
															labelWidth: 120,
															queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
															forceSelection: true,
															listeners: {
																beforerender: function(cmp, options) {
																	cmp.setStore(Ext.ComponentQuery.query('inputcenterpanel')[0].skeletonBoneQualityTypeStore);
																},
															}  // eo listerners
														},
														{ xtype: 'tbspacer', width: 20 },
														//{ name: 'viewDirection', xtype: 'textfield', fieldLabel: Oger._('Blickrichtung'), labelAlign: 'right' },
													],
												},
											],
										},  // eo skeleton bone tab
										{ xtype: 'panel',
											title: Oger._('Anthro'),
											layout: 'anchor',
											bodyPadding: 15,
											border: false,
											hideMode: 'offsets',
											autoScroll: true,
											items: [
												{ xtype: 'fieldcontainer', layout: 'hbox',
													items: [
														{ name: 'sex', xtype: 'combo', fieldLabel: Oger._('Geschlecht'), width: 250,
															queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
															forceSelection: true,
															listeners: {
																beforerender: function(cmp, options) {
																	cmp.setStore(Ext.ComponentQuery.query('inputcenterpanel')[0].skeletonSexTypeStore);
																},
															}  // eo listerners
														},
														{ xtype: 'tbspacer', width: 20 },
														{ name: 'gender', xtype: 'combo', fieldLabel: Oger._('Gender'), width: 250, labelAlign: 'right',
															queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
															forceSelection: true,
															listeners: {
																beforerender: function(cmp, options) {
																	cmp.setStore(Ext.ComponentQuery.query('inputcenterpanel')[0].skeletonGenderTypeStore);
																},
															}  // eo listerners
														},
													],
												},
												{ name: 'age', xtype: 'ux_multicombo', fieldLabel: Oger._('Alter'), width: 500,
													queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
													forceSelection: true,
													listeners: {
														beforerender: function(cmp, options) {
															cmp.setStore(Ext.ComponentQuery.query('inputcenterpanel')[0].skeletonAgeTypeStore);
														},
													}  // eo listerners
												},
											],
										},  // eo wall anthropology tab

										{ xtype: 'panel',
											title: Oger._('Brandbestattung'),
											layout: 'anchor',
											bodyPadding: 15,
											border: false,
											hideMode: 'offsets',
											autoScroll: true,
											items: [
												{ name: 'burialCremationId', xtype: 'combo', fieldLabel: Oger._('Brandbestattung'), width: 300,
													queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
													listeners: {
														beforerender: function(cmp, options) {
															cmp.setStore(this.up('window').gluePanel.skeletonBurialCremationTypeStore);
														},
													}  // eo listerners
												},
												{ xtype: 'fieldset', title: Oger._('Störung'),
													items: [
														{ name: 'cremationDemageStratumIdList', xtype: 'textfield', fieldLabel: Oger._('Stratum'), validator: multiXidValid },
													],
												},
												{ xtype: 'displayfield', fieldLabel: Oger._('Anmerkungen'), value: '', width: 500, labelWidth: 300 },
												{ name: 'cremationDemageDescription', xtype: 'textarea', hideLabel: true, width: 550, height: 150 },
											],
										},  // eo skeletion cremation burial tab

										{ xtype: 'panel',
											title: Oger._('Grabkonstruktion'),
											layout: 'anchor',
											bodyPadding: 15,
											border: false,
											hideMode: 'offsets',
											autoScroll: true,
											items: [
												{ xtype: 'fieldset', title: Oger._('Strata zur Grabkonstruktion'),
													items: [
														{ layout: 'column',
															border: false,
															items: [
																{ columnWidth: .5,
																	border: false,
																	items: [
																		{ xtype: 'fieldset', title: Oger._('Einbau'),
																			items: [
																				{ name: 'coffinStratumIdList', xtype: 'textfield', fieldLabel: Oger._('Sarg'), validator: multiXidValid },
																				{ name: 'tombTimberStratumIdList', xtype: 'textfield', fieldLabel: Oger._('Holzeinbau'), validator: multiXidValid },
																				{ name: 'tombStoneStratumIdList', xtype: 'textfield', fieldLabel: Oger._('Steineinbau'), validator: multiXidValid },
																				{ name: 'tombBrickStratumIdList', xtype: 'textfield', fieldLabel: Oger._('Ziegeleinbau'), validator: multiXidValid },
																				{ name: 'tombOtherMaterialStratumIdList', xtype: 'textfield', fieldLabel: Oger._('Sonstiges'), validator: multiXidValid },
																			],
																		},
																	],
																},
																{ columnWidth: .5,
																	border: false,
																	items: [
																		{ xtype: 'fieldset', title: Oger._('Form'),
																			items: [
																				{ name: 'tombFormCirleStratumIdList', xtype: 'textfield', fieldLabel: Oger._('Rund'),
																					labelAlign: 'right', validator: multiXidValid
																				},
																				{ name: 'tombFormOvalStratumIdList', xtype: 'textfield', fieldLabel: Oger._('Oval'),
																					labelAlign: 'right', validator: multiXidValid
																				},
																				{ name: 'tombFormRectangleStratumIdList', xtype: 'textfield', fieldLabel: Oger._('Rechteckig'),
																					labelAlign: 'right', validator: multiXidValid
																				},
																				{ name: 'tombFormSquareStratumIdList', xtype: 'textfield', fieldLabel: Oger._('Quadratisch'),
																					labelAlign: 'right', validator: multiXidValid
																				},
																				{ name: 'tombFormOtherStratumIdList', xtype: 'textfield', fieldLabel: Oger._('Sonstiges'),
																					labelAlign: 'right', validator: multiXidValid
																				},
																			],
																		},
																	],
																},
															],
														},
													],
												},  // eo tomb construction
												{ xtype: 'fieldset', title: Oger._('Störung'),
													items: [
														{ xtype: 'fieldcontainer', layout: 'hbox',
															items: [
																{ name: 'tombDemageStratumIdList', xtype: 'textfield', fieldLabel: Oger._('Stratum'), validator: multiXidValid, width: 250 },
																{ name: 'tombDemageFormId', xtype: 'combo', fieldLabel: Oger._('Form'), width: 250, labelAlign: 'right',
																	queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
																	listeners: {
																		beforerender: function(cmp, options) {
																			cmp.setStore(this.up('window').gluePanel.skeletonTombDemageFormTypeStore);
																		},
																	}  // eo listerners
																},
															],
														},
													],
												},
												{ xtype: 'displayfield', value: '', width: 600, labelWidth: 500,
													fieldLabel: Oger._('Beschreibung Grabmarkierung/-überbau und Grabform'),
												},
												{ name: 'tombDescription', xtype: 'textarea', hideLabel: true, width: 550, height: 150 },
											],
										},  // eo skeletion tomb construction tab

										{ xtype: 'panel',
											title: Oger._('Grabfunde'),
											layout: 'anchor',
											bodyPadding: 15,
											border: false,
											hideMode: 'offsets',
											autoScroll: true,
											items: [
												{ xtype: 'fieldset', title: Oger._('Fundnummern zu'),
													items: [
														{ name: 'burialObjectArchFindIdList', xtype: 'textfield', fieldLabel: Oger._('Beigaben'), validator: multiXidValid },
														{ name: 'costumeArchFindIdList', xtype: 'textfield', fieldLabel: Oger._('Tracht-bestandteile'), validator: multiXidValid },
														{ name: 'depositArchFindIdList', xtype: 'textfield', fieldLabel: Oger._('Verfüllung'), validator: multiXidValid },
														{ name: 'tombConstructArchFindIdList', xtype: 'textfield', fieldLabel: Oger._('Bestandteile der Grabkonstruktion'), validator: multiXidValid },
													],
												},
											],
										},  // eo skeletion burial tab

									],
								},  // eo skeleton

								{ xtype: 'tabpanel',   // --- timber
									border: false, disabled: true, deferredRender: false,
									isDetailPanel: true, isTimberDetailPanel: true,
									activeTab: 0,
									plain: true,
									//autoScroll: true,
									items: [

										{ xtype: 'panel',
											title: Oger._('Allgemein'),
											layout: 'anchor',
											bodyPadding: 15,
											border: false,
											hideMode: 'offsets',
											autoScroll: true,
											items: [
												{ name: STRATUMCATEGORYID_TIMBER + '___orientation', xtype: 'textfield',
													fieldLabel: Oger._('Orientierung'), width: 500,
												},
												{ xtype: 'displayfield', fieldLabel: Oger._('Funktion/Ansprache'), value: '', width: 500, labelWidth: 300 },
												{ name: 'functionDescription', xtype: 'textarea', hideLabel: true, width: 500, height: 100 },
												{ xtype: 'displayfield', fieldLabel: Oger._('Kontext/Bauart'), value: '', width: 500, labelWidth: 300 },
												{ name: 'constructDescription', xtype: 'textarea', hideLabel: true, width: 500, height: 100 },
												{ xtype: 'displayfield', fieldLabel: Oger._('Verhältnisse zu anderen Bauteilen'), value: '', width: 500, labelWidth: 300 },
												{ name: STRATUMCATEGORYID_TIMBER + '___relationDescription', xtype: 'textarea', hideLabel: true, width: 500, height: 100 },
											],
										},  // eo timber common tab

										{ xtype: 'panel',
											title: Oger._('Material'),
											layout: 'anchor',
											bodyPadding: 15,
											border: false,
											hideMode: 'offsets',
											autoScroll: true,
											items: [
												{ name: 'timberType', xtype: 'textfield', fieldLabel: Oger._('Holzart'), width: 500 },
												{ name: 'infill', xtype: 'textfield', fieldLabel: Oger._('Ausfachung'), width: 500 },
												{ name: 'otherConstructMaterial', xtype: 'textfield', fieldLabel: Oger._('Sonstige Baustoffe'), width: 500 },
												{ name: 'surface', xtype: 'textfield', fieldLabel: Oger._('Oberfläche'), width: 500 },
												{ name: 'preservationStatus', xtype: 'textfield', fieldLabel: Oger._('Erhaltungs-zustand'), width: 500 },
												{ xtype: 'checkboxgroup', fieldLabel: Oger._('Physiologische Zone'),
													items: [
														{ name: 'physioZoneDullEdge', boxLabel: Oger._('Waldkante'), inputValue: '1', uncheckedValue: '0' },
														{ name: 'physioZoneSeapWood', boxLabel: Oger._('Splint'), inputValue: '1', uncheckedValue: '0' },
														{ name: 'physioZoneHeartWood', boxLabel: Oger._('Kern'), inputValue: '1', uncheckedValue: '0' },
													]
												},
											],
										},  // eo timber material1

										{ xtype: 'panel',
											title: Oger._('Ver-/Bearbeitung'),
											layout: 'anchor',
											bodyPadding: 15,
											border: false,
											hideMode: 'offsets',
											autoScroll: true,
											items: [
												{ name: 'secundaryUsage', xtype: 'checkbox', inputValue: '1', uncheckedValue: '0',
													fieldLabel: Oger._('Sekundäre Verwendung'),
												},
												{ name: '', xtype: 'textfield', fieldLabel: Oger._('Stellung'), width: 500, disabled: true },
												{ name: 'processSign', xtype: 'textfield', fieldLabel: Oger._('Bearbeitungs-spuren'), width: 500 },
												{ name: 'processDetail', xtype: 'textfield', fieldLabel: Oger._('Zeichen, ...'), width: 500 },
												{ name: 'connection', xtype: 'textfield', fieldLabel: Oger._('Verbindungen'), width: 500 },
											],
										},  // eo timber other

									],
								},  // eo timber

								{ xtype: 'panel',  // --- complex
									border: false, disabled: true,
									isDetailPanel: true, isComplexDetailPanel: true,
									layout: 'anchor',
									defaults: {
										width: 500,
									},
									items: [
										{ name: 'complexPartIdList', xtype: 'textfield', fieldLabel: Oger._('Stratumliste'), validator: multiXidValid },
										{ xtype: 'displayfield', value: '' },
										{ xtype: 'grid',
											isComplexGrid: true,
											stripeRows: true,
											autoScroll: true,
											sortableColumns: false,
											store: Ext.create('App.store.StratumComplexParts'),
											columns: [
												{ header: Oger._('Gr'), dataIndex: 'excavId', width: 30, hidden: true },
												{ header: Oger._('Grabung'), dataIndex: 'excavName', hidden: true },
												{ header: Oger._('Nummer'), dataIndex: 'stratumId', width: 50 },
												{ header: Oger._('Datum'), xtype: 'datecolumn', dataIndex: 'date', width: 70 },
												{ header: Oger._('Kategorie'), dataIndex: 'categoryName' },
												{ header: Oger._('Art/Bezeichnung'), dataIndex: 'typeName' },
											],
										},
									],
								},  // eo complex

							],  // eo detail cards -----------------------------
						}, // eo detail panel
					],  // eo detail tab items
				},  // eo detail tab

				{ xtype: 'panel',
					title: Oger._('Abmessung'),
					layout: 'anchor',
					bodyPadding: 15,
					border: false,
					hideMode: 'offsets',
					autoScroll: true,
					items: [
						{ xtype: 'fieldcontainer', layout: 'hbox',
							items: [
								{ name: 'lengthValue', xtype: 'textfield', fieldLabel: Oger._('Länge (cm)'), labelWidth: 140 },
								{ name: 'lengthApplyTo',  xtype: 'combo', fieldLabel: Oger._('Bezug'), labelAlign: 'right',
									queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
									listeners: {
										beforerender: function(cmp, options) {
											cmp.setStore(Ext.ComponentQuery.query('inputcenterpanel')[0].wallLengthApplyToStore);
										},
									},
								},
							],
						},
						{ xtype: 'fieldcontainer', layout: 'hbox',
							items: [
								{ name: 'width', xtype: 'textfield', fieldLabel: Oger._('Breite (cm)'), labelWidth: 140 },
								{ name: 'widthApplyTo',  xtype: 'combo', fieldLabel: Oger._('Bezug'), labelAlign: 'right',
									queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
									listeners: {
										beforerender: function(cmp, options) {
											cmp.setStore(Ext.ComponentQuery.query('inputcenterpanel')[0].wallWidthApplyToStore);
										},
									},
								},
							],
						},
						{ name: 'diaMeter', xtype: 'textfield', fieldLabel: Oger._('Durchmesser (cm)'), labelWidth: 140 },
						{ xtype: 'fieldcontainer', layout: 'hbox',
							items: [
								{ name: 'height', xtype: 'textfield', fieldLabel: Oger._('Tiefe/Höhe (cm)'), labelWidth: 140 },
								{ name: 'heightApplyTo',  xtype: 'combo', fieldLabel: Oger._('Bezug'), labelAlign: 'right',
									queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
									listeners: {
										beforerender: function(cmp, options) {
											cmp.setStore(Ext.ComponentQuery.query('inputcenterpanel')[0].wallHeightApplyToStore);
										},
									},
								},
							],
						},
						{ xtype: 'fieldcontainer', layout: 'hbox',
							items: [
								{ name: 'heightRaising', xtype: 'textfield', fieldLabel: Oger._('Höhe Aufgehend (cm)'), labelWidth: 140 },
								{ name: 'heightRaisingApplyTo',  xtype: 'combo', fieldLabel: Oger._('Bezug'), labelAlign: 'right',
									queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
									listeners: {
										beforerender: function(cmp, options) {
											cmp.setStore(Ext.ComponentQuery.query('inputcenterpanel')[0].wallHeightRaisingApplyToStore);
										},
									},
								},
							],
						},
						{ xtype: 'fieldcontainer', layout: 'hbox',
							items: [
								{ name: 'heightFooting', xtype: 'textfield', fieldLabel: Oger._('Höhe Fundament (cm)'), labelWidth: 140 },
								{ name: 'heightFootingApplyTo',  xtype: 'combo', fieldLabel: Oger._('Bezug'), labelAlign: 'right',
									queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
									listeners: {
										beforerender: function(cmp, options) {
											cmp.setStore(Ext.ComponentQuery.query('inputcenterpanel')[0].wallHeightFootingApplyToStore);
										},
									},
								},
							],
						},
					],

				},  // eo dimension tab

				{ xtype: 'panel',
					title: Oger._('Matrix'),
					layout: 'anchor',
					bodyPadding: 15,
					border: false,
					hideMode: 'offsets',
					//autoScroll: true,
					items: [
						{ name: 'earlierThanIdList', xtype: 'textarea', fieldLabel: Oger._('Früher als (unter)'), width: 600, height: 35,
							validator: multiXidValid,
						},
						{ name: 'reverseEarlierThanIdList', xtype: 'textarea', fieldLabel: Oger._('Später als (über)'), width: 600, height: 35,
							validator: multiXidValid,
						},
						{ name: 'equalToIdList', xtype: 'textarea', fieldLabel: Oger._('Ist ident mit'), width: 600, height: 35,
							validator: multiXidValid,
						},
						{ name: 'contempWithIdList', xtype: 'textarea', fieldLabel: Oger._('Zeitgleich mit'), width: 600, height: 35,
							validator: multiXidValid,
						},
						{ xtype: 'fieldset', title: Oger._('Interface Info'),
							items: [
								{ xtype: 'fieldcontainer', layout: 'hbox',
									items: [
										{ name: 'containedInInterfaceIdList', xtype: 'textfield', fieldLabel: Oger._('Interface'),
											readOnly: true, submitValue: false, readOnlyCls: 'x-item-disabled',
										},
										{ xtype: 'tbspacer', width: 20 },
										{ name: 'containsStratumIdList', xtype: 'textfield', fieldLabel: Oger._('enthält Stratum'), labelAlign: 'right',
										 readOnly: true, submitValue: false, readOnlyCls: 'x-item-disabled',
										},
									],
								},
							],
						},
						{ xtype: 'checkboxgroup', fieldLabel: Oger._('Sonderposition'), columns: 1,
							items: [
								{ name: 'isTopEdge', boxLabel: Oger._('Grabungsoberkante (Baggerinterface)'),
									inputValue: '1', uncheckedValue: '0' },
								{ name: 'isBottomEdge', boxLabel: Oger._('Grabungsunterkante (Geologie)'),
									inputValue: '1', uncheckedValue: '0'
								},
								{ name: 'hasAutoInterface', boxLabel: Oger._('Stratum-Unterkante als Interface behandeln'),
									inputValue: '1', uncheckedValue: '0'
								},
							],
						}
					],
				},  // eo matrix tab

				{ xtype: 'panel',
					title: Oger._('Verweis'),
					layout: 'anchor',
					bodyPadding: 15,
					border: false,
					hideMode: 'offsets',
					//autoScroll: true,
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
									//autoScroll: true,
									items: [
										{ xtype: 'fieldcontainer', layout: 'hbox',
											items: [
												{ name: 'hasArchFind', xtype: 'checkbox', inputValue: '1', uncheckedValue: '0',
													fieldLabel: Oger._('Fund vorhanden'), labelWidth: 130
												},
												{ xtype: 'tbspacer', width: 20 },
												{ name: 'archFindIdList', xtype: 'textfield', fieldLabel: Oger._('Fund-Nr'),
													width: 350, labelWidth: 70, labelAlign: 'right', validator: multiXidValid,
												},
											],
										},
										{ name: 'hasSample', xtype: 'checkbox', inputValue: '1', uncheckedValue: '0',
											fieldLabel: Oger._('Probe vorhanden'), labelWidth: 130
										},
										{ xtype: 'fieldcontainer', layout: 'hbox',
											items: [
												{ name: 'hasArchObject', xtype: 'checkbox', inputValue: '1', uncheckedValue: '0',
													fieldLabel: Oger._('Gehört zu Objekt'), labelWidth: 130
												},
												{ xtype: 'tbspacer', width: 20 },
												{ name: 'archObjectIdList', xtype: 'textfield', fieldLabel: Oger._('Objekt'),
													width: 350, labelWidth: 70, labelAlign: 'right', validator: multiXidValid,
												},
											],
										},
										{ xtype: 'fieldcontainer', layout: 'hbox',
											items: [
												{ name: 'hasArchObjGroup', xtype: 'checkbox', inputValue: '1', uncheckedValue: '0',
													fieldLabel: Oger._('Gehört zu ObjGrp'), labelWidth: 130
												},
												{ xtype: 'tbspacer', width: 20 },
												{ name: 'archObjGroupIdList', xtype: 'textfield', fieldLabel: Oger._('Obj.Gruppe'), labelWidth: 70,
													width: 350, labelAlign: 'right', readOnly: true, submitValue: false, readOnlyCls: 'x-item-disabled',
												},
											],
										},
									],
								},

								{ xtype: 'ic_stratumarchfindgrid',
									isStratumArchFindGrid: true,
									title: Oger._('Fund/Probe'),
								},

								{ xtype: 'grid',
									isStratumArchObjectGrid: true,
									title: Oger._('Objekt'),
									stripeRows: true,
									autoScroll: true,
									sortableColumns: false,
									store: Ext.create('App.store.StratumArchObjects'),
									columns: [
										{ header: Oger._('Gr'), dataIndex: 'excavId', width: 30, hidden: true },
										{ header: Oger._('Grabung'), dataIndex: 'excavName', hidden: true },
										{ header: Oger._('Nummer'), dataIndex: 'archObjectId', width: 50 },
										{ header: Oger._('Art/Bezeichnung'), dataIndex: 'typeName', width: 150 },
										{ header: Oger._('Art-Zähler'), dataIndex: 'typeSerial', width: 50, hidden: true },
										{ header: Oger._('Objektgruppe'), dataIndex: 'archObjGroupIdList', width: 200 },
									],
								},

								{ xtype: 'grid',
									isStratumArchObjGroupGrid: true,
									title: Oger._('Objektgruppe'),
									stripeRows: true,
									autoScroll: true,
									sortableColumns: false,
									store: Ext.create('App.store.StratumArchObjGroups'),
									columns: [
										{ header: Oger._('Gr'), dataIndex: 'excavId', width: 30, hidden: true },
										{ header: Oger._('Grabung'), dataIndex: 'excavName', hidden: true },
										{ header: Oger._('Nummer'), dataIndex: 'archObjGroupId', width: 50 },
										{ header: Oger._('Art/Bezeichnung'), dataIndex: 'typeName', width: 150 },
										{ header: Oger._('Objektliste'), dataIndex: 'archObjectIdList' },
									],
								},

							],
						},
					],
				},  // eo arch relation tab

				{ xtype: 'panel',
					title: Oger._('Beschreibung'),
					layout: 'anchor',
					bodyPadding: 15,
					border: false,
					hideMode: 'offsets',
					//autoScroll: true,
					items: [
						//{ xtype: 'displayfield', fieldLabel: Oger._('Beschreibung'), value: '' },
						{ name: 'comment', xtype: 'textarea', hideLabel: true, width: 600, height: 300 },
					],
				},  // eo description tab

			], // eo tabpanel items
		},  // eo tabpanel inside form
	],  // eo form items

	url: 'php/scripts/stratum.php',

	listeners: {
		actioncomplete: function(form, action) {  // for radioboxes and alike
			if (action.type == 'load') {
				if (!form.preserveJumpToId) {
					form.findField('jumpToStratumId').setValue('');
				}
				form.preserveJumpToId = false;

				form.findField('dbAction').setValue('UPDATE');
				form.findField('stratumId').setReadOnly(true);
				// form.findField('oldCategoryId').setValue(form.findField('categoryId').setValue());
				form.findField('oldCategoryId').setValue(action.result.data.categoryId);
				Oger.extjs.resetDirty(form);
				this.actionCompleteLoad(form);

				var win = form.owner.up('window');
				if (win.afterLoadCallback) {
					win.afterLoadCallback();
					delete win.afterLoadCallback;
				}
			}
		},
		actionfailed: function(form, action) {  // for end of next/prev jumps
			if (action.type == 'load') {
				var win = form.owner.up('window');
				delete win.afterLoadCallback;

				Oger.extjs.resetDirty(form);
				if (action.result && action.result.msg) {
					Ext.create('Oger.extjs.MessageBox').alert(Oger._('Fehler'), Oger._(action.result.msg));
					return;
				}
				Oger.extjs.actionSuccess(action); // show common errors
			}
		},
	},  // eo listeners


	// ########################################################

	adjustDetailPanel: function() {

		var categoryId = this.getForm().findField('categoryId').getValue();

		var typeStore = Ext.ComponentQuery.query('inputcenterpanel')[0].stratumTypeStore;
		var filteredStore = Ext.ComponentQuery.query('inputcenterpanel')[0].filteredStratumTypeStore;
		filteredStore.removeAll();

		var specificDetailPanel = Ext.ComponentQuery.query('component[isSpecificDetailPanel]', this)[0];

		if (categoryId) {
			typeStore.clearFilter();
			typeStore.filter('categoryId', categoryId);
			filteredStore.insert(0, typeStore.getRange());
			specificDetailPanel.show();
		}
		else {
			specificDetailPanel.hide();
		}

		var newDetailCard = null;
		var sizesToShow = new Array();
		var datingSource = new Array();

		switch (categoryId) {
		case STRATUMCATEGORYID_DEPOSIT:
			newDetailCard = Ext.ComponentQuery.query('component[isStratumDetailPanel]', this)[0];
			sizesToShow = [ 'lengthValue', 'width', 'height', 'diaMeter' ];
			break;
		case STRATUMCATEGORYID_INTERFACE:
			newDetailCard = Ext.ComponentQuery.query('component[isInterfaceDetailPanel]', this)[0];
			sizesToShow = [ 'lengthValue', 'width', 'height', 'diaMeter' ];
			break;
		case STRATUMCATEGORYID_WALL:
			newDetailCard = Ext.ComponentQuery.query('component[isWallDetailPanel]', this)[0];
			sizesToShow = [ 'lengthValue', 'width', 'heightRaising', 'heightFooting',
											'lengthApplyTo', 'widthApplyTo', 'heightRaisingApplyTo', 'heightFootingApplyTo' ];
			datingSource = [ 'datingStratigraphy', 'datingWallStructure' ];
			break;
		case STRATUMCATEGORYID_TIMBER:
			newDetailCard = Ext.ComponentQuery.query('component[isTimberDetailPanel]', this)[0];
			sizesToShow = [ 'lengthValue', 'width', 'height',
											'lengthApplyTo', 'widthApplyTo', 'heightApplyTo'];
			datingSource = [ 'dendrochronology' ];
			break;
		case STRATUMCATEGORYID_SKELETON:
			newDetailCard = Ext.ComponentQuery.query('component[isSkeletonDetailPanel]', this)[0];
			sizesToShow = [ 'lengthValue', 'width', 'height', 'diaMeter' ];
			break;
		case STRATUMCATEGORYID_COMPLEX:
			newDetailCard = Ext.ComponentQuery.query('component[isComplexDetailPanel]', this)[0];
			sizesToShow = [ 'lengthValue', 'width', 'height', 'diaMeter' ];
			break;
		}  // eo switch


		var oldDetailCard = specificDetailPanel.getLayout().getActiveItem();
		if (newDetailCard != oldDetailCard) {
			oldDetailCard.disable();
		}
		if (newDetailCard) {
			specificDetailPanel.getLayout().setActiveItem(newDetailCard);
			newDetailCard.enable();
		}

		// adjust sizes panel (hide all fields and show specific)
		var varName = null;
		var field = null;
		var disableFields = [ 'lengthValue', 'width', 'height', 'heightRaising', 'heightFooting', 'diaMeter',
													'lengthApplyTo', 'widthApplyTo', 'heightApplyTo', 'heightRaisingApplyTo', 'heightFootingApplyTo' ];
		for (var i = 0; i < disableFields.length; i++) {
			varName = disableFields[i];
			field = this.getForm().findField(varName);
			field.disable();
			field.hide();
		}
		for (var i = 0; i < sizesToShow.length; i++) {
			varName = sizesToShow[i];
			field = this.getForm().findField(varName);
			field.show();
			field.enable();
		}

		// adjust dating source
		var disableFields = [ 'dendrochronology', 'datingStratigraphy', 'datingWallStructure', 'datingSource___' ];
		for (var i = 0; i < disableFields.length; i++) {
			varName = disableFields[i];
			field = this.getForm().findField(varName);
			field.disable();
			field.hide();
		}
		if (datingSource.length > 0) {
			field = this.getForm().findField('datingSource___');
			field.show();
			field.enable();
		}
		for (var i = 0; i < datingSource.length; i++) {
			varName = datingSource[i];
			field = this.getForm().findField(varName);
			field.show();
			field.enable();
		}

	},  // eo adjust detail panel


	actionCompleteLoad: function(form) {

		//form.owner.adjustDetailPanel();  // this.adjustDetailPanel(); should work too even if form = basicform and not formpanel
		Oger.extjs.resetDirty(form);
		// ugly hack to reassign combo value to get correct display field
		form.findField('typeId').setValue(form.findField('typeId').getValue());

		var grid = Ext.ComponentQuery.query('component[isComplexGrid]', this)[0];
		var store = grid.getStore();
		//store.clearFilter();
		//store.filter('id', form.findField('id').getValue());
		//store.filter('excavId', form.findField('excavId').getValue());
		//store.filter('stratumId', form.findField('stratumId').getValue());
		store.load({
			params: { excavId: form.findField('excavId').getValue(),
								stratumId: form.findField('stratumId').getValue(),
							},
		});

		var grid = Ext.ComponentQuery.query('component[isStratumArchFindGrid]', this)[0];
		var store = grid.getStore();
		store.load({
			params: { excavId: form.findField('excavId').getValue(),
								stratumId: form.findField('stratumId').getValue(),
							},
		});

		var grid = Ext.ComponentQuery.query('component[isStratumArchObjectGrid]', this)[0];
		var store = grid.getStore();
		store.load({
			params: { excavId: form.findField('excavId').getValue(),
								stratumId: form.findField('stratumId').getValue(),
							},
		});

		var grid = Ext.ComponentQuery.query('component[isStratumArchObjGroupGrid]', this)[0];
		var store = grid.getStore();
		store.load({
			params: { excavId: form.findField('excavId').getValue(),
								stratumId: form.findField('stratumId').getValue(),
							},
		});

	},  // eo action complete load




});
