/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Export form
*/
Ext.define('App.view.export.Form', {
	extend: 'Ext.form.Panel',
	alias: 'widget.exportform',

	border: false,
	autoScroll: true,
	layout: 'anchor',
	trackResetOnLoad: true,

	items: [

		{ xtype: 'tabpanel',
			activeTab: 0,
			plain: true,
			border: false,
			//autoScroll: true,
			deferredRender: false,
			items: [

				{ xtype: 'panel',
					title: Oger._('Allgemein'),
					layout: 'anchor',
					border: false,
					bodyPadding: 15,
					hideMode: 'offsets',
					items: [
						{ xtype: 'fieldset', title: Oger._('HINWEIS'),
							items: [
								{ xtype: 'panel', border: false,
									html: 'Keines dieser Exportformate kann direkt für die Abgabe an das BDA verwendet werden.<br>' +
												'Zum Austausch mit anderen OgerArch Installationen ist das "OgerArch JSON" Format vorgesehen.',
								},
							],
						},
						{ name: 'fileFormat', xtype: 'combo', fieldLabel: Oger._('Format'), width: 400,
							value: 'JSON',
							allowBlank: false, forceSelection: true,
							store: Ext.create('Ext.data.Store', {
								fields: [ 'id', 'name' ],
								data: [
									{ id: 'JSON', name: Oger._('OgerArch JSON') },
									{ id: 'JSON_FORMATED', name: Oger._('OgerArch JSON (formatiert)') },
									{ id: 'XML', name: Oger._('OgerArchML (XML)') },
									{ id: 'CSV', name: Oger._('Strichpunkt getrennte Werte (CSV)') },
								]
							}),
							queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
						},
					],
				},  // eo general tab

				{ xtype: 'panel',
					title: Oger._('Grabungsdaten'),
					layout: 'anchor',
					//autoScroll: true,
					border: false,
					bodyPadding: 15,
					hideMode: 'offsets',
					items: [
						{ xtype: 'fieldset', title: Oger._('Grabungsstamm'),
							items: [
								{ name: 'excavation', xtype: 'checkbox', boxLabel: Oger._('Grabung'), uncheckedValue: '0',
									checked: true, readOnly: true,
								},
							],
						},
						{ xtype: 'fieldset', title: Oger._('Fund'),
							items: [
								{ name: 'archFind', xtype: 'checkbox', boxLabel: Oger._('Fund'), uncheckedValue: '0', checked: true },
								{ xtype: 'fieldcontainer', layout: 'hbox',
									items: [
										{ name: 'archFindBeginId', xtype: 'textfield', fieldLabel: Oger._('Von Nummer'), validator: xidValid },
										{ xtype: 'tbspacer', width: 20 },
										{ name: 'archFindEndId', xtype: 'textfield', fieldLabel: Oger._('Bis Nummer'), validator: xidValid },
									],
								},
							],
						},
						{ xtype: 'fieldset', title: Oger._('Stratum'),
							items: [
								{ name: 'stratum', xtype: 'checkbox', boxLabel: Oger._('Stratum'), uncheckedValue: '0', checked: true },
								{ xtype: 'fieldcontainer', layout: 'hbox',
									items: [
										{ name: 'stratumBeginId', xtype: 'textfield', fieldLabel: Oger._('Von Nummer'), validator: xidValid },
										{ xtype: 'tbspacer', width: 20 },
										{ name: 'stratumEndId', xtype: 'textfield', fieldLabel: Oger._('Bis Nummer'), validator: xidValid },
									],
								},
								{ name: 'stratumCategoryId', xtype: 'combo', fieldLabel: Oger._('Kategorie'),
									queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all', autoSelect: false,
								},
							],
						},
						{ xtype: 'fieldset', title: Oger._('Objekt'),
							items: [
								{ name: 'archObject', xtype: 'checkbox', boxLabel: Oger._('Objekt'), uncheckedValue: '0', checked: true },
								{ xtype: 'fieldcontainer', layout: 'hbox',
									items: [
										{ name: 'archObjectBeginId', xtype: 'textfield', fieldLabel: Oger._('Von Nummer'), validator: xidValid },
										{ xtype: 'tbspacer', width: 20 },
										{ name: 'archObjectEndId', xtype: 'textfield', fieldLabel: Oger._('Bis Nummer'), validator: xidValid },
									],
								},
							],
						},
						{ xtype: 'fieldset', title: Oger._('Objektgruppe'),
							items: [
								{ name: 'archObjGroup', xtype: 'checkbox', boxLabel: Oger._('Objektgruppe'), uncheckedValue: '0', checked: true },
								{ xtype: 'fieldcontainer', layout: 'hbox',
									items: [
										{ name: 'archObjGroupBeginId', xtype: 'textfield', fieldLabel: Oger._('Von Nummer'), validator: xidValid },
										{ xtype: 'tbspacer', width: 20 },
										{ name: 'archObjGroupEndId', xtype: 'textfield', fieldLabel: Oger._('Bis Nummer'), validator: xidValid },
									],
								},
							],
						},
					],
				},  // eo excav data tab

				{ xtype: 'panel',
					title: Oger._('Stammdaten'),
					layout: 'anchor',
					border: false,
					bodyPadding: 15,
					hideMode: 'offsets',
					items: [
						{ xtype: 'fieldset', title: Oger._('Basisdaten'),
							items: [
								{ name: 'companyMaster', xtype: 'checkbox', boxLabel: Oger._('Firma'), uncheckedValue: '0' },
							],
						},
						{ xtype: 'fieldset', title: Oger._('Allgemeine Stammdaten'),
							items: [
								{ name: 'stratumCategoryMaster', xtype: 'checkbox', boxLabel: Oger._('Stratum Kategorien'), uncheckedValue: '0' },
								{ name: 'stratumTypeMaster', xtype: 'checkbox', boxLabel: Oger._('Stratum Art/Bezeichnung'), uncheckedValue: '0' },
								{ name: 'archObjectTypeMaster', xtype: 'checkbox', boxLabel: Oger._('Objekt Art/Bezeichnung'), uncheckedValue: '0' },
								{ name: 'archObjGroupTypeMaster', xtype: 'checkbox', boxLabel: Oger._('Objektgruppe Art/Bezeichnung'), uncheckedValue: '0' },
							],
						},
					],
				},  // eo master data tab

				{ xtype: 'panel',
					title: Oger._('Sonderdaten'),
					layout: 'anchor',
					border: false,
					bodyPadding: 15,
					hideMode: 'offsets',
					items: [
						{ name: 'dbStruct', xtype: 'checkbox', boxLabel: Oger._('Datenbankstruktur'), uncheckedValue: '0' },
					],
				},  // eo extra data tab
			],

		},
	],  // eo form items

	url: 'php/scripts/export.php',

	// ########################################################


});
