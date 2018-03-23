/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Matrix startup main form
*/
Ext.define('App.view.matrix.Form', {
	extend: 'Ext.form.Panel',
	alias: 'widget.matrixmainseleform',

	bodyPadding: 15,
	border: false,
	autoScroll: true,
	layout: 'anchor',
	trackResetOnLoad: true,

	items: [

		/*
		{ xtype: 'fieldcontainer', layout: 'hbox',
			items: [
				{ name: 'beginDate', xtype: 'datefield', fieldLabel: Oger._('Von Datum'), submitFormat: 'Y-m-d' },
				{ xtype: 'tbspacer', width: 20 },
				{ name: 'endDate', xtype: 'datefield', fieldLabel: Oger._('Bis Datum'), submitFormat: 'Y-m-d' },
			],
		},
		*/

		/*
		{ xtype: 'fieldcontainer', layout: 'hbox',
			items: [
				{ name: 'beginId', xtype: 'textfield', fieldLabel: Oger._('Von Nummer'), validator: xidValid },
				{ xtype: 'tbspacer', width: 20 },
				{ name: 'endId', xtype: 'textfield', fieldLabel: Oger._('Bis Nummer'), validator: xidValid },
			],
		},
		*/

		/*
		{ xtype: 'fieldset', title: Oger._('HINWEIS'),
			items: [
				{ xtype: 'panel', border: false,
					html: 'Manche der Auswahlkombinationen werden nicht von allen Exportformaten unterstützt. ' +
								'Es wird davon ausgegangen, dass die Möglichkeiten des Folgeprogrammes bekannt sind ' +
								'und die Auswahl dementsprechend getroffen wird.<br>',
				},
			],
		},
		*/

		{ name: 'fileFormat', xtype: 'combo', fieldLabel: Oger._('Exportformat'), width: 450,
			allowBlank: false, forceSelection: true, value: 'PROTOCOL_ONLY',
			store: Ext.create('Ext.data.Store', {
				fields: [ 'id', 'name' ],
				data: [
					{ id: 'PROTOCOL_ONLY', name: Oger._('Nur Protokoll - kein Export') },
					{ id: 'EXPORT_GRAPHVIZ_DOT', name: Oger._('Export für Graphviz (dot)') },
					{ id: 'EXPORT_GRAPHML_YED', name: Oger._('Export für yED (graphml)') },
					{ id: 'EXPORT_GRAPHML', name: Oger._('Export als Standard GraphML (graphml)') },
					{ id: 'EXPORT_STRATIFY_CSV', name: Oger._('Export für Stratify 1.5 (csv)') },
					{ id: 'EXPORT_BASP_LST', name: Oger._('Bonn Archaeological Software Package/BASP (lst)') },
					//{ id: 'EXPORT_TEXTLIST', name: Oger._('Textliste (txt)') },

					//{ id: 'FORMAT_JPEG', name: Oger._('JPEG') },
					//{ id: 'FORMAT_PNG', name: Oger._('PNG') },
					//{ id: 'FORMAT_PDF', name: Oger._('PDF') },
					//{ id: 'FORMAT_SVG', name: Oger._('SVG') },
				]
			}),
			queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
			listeners: {
				change: function(cmp, newValue, oldValue, eOpts) {
					cmp.up('form').onFileFormatChange(cmp, newValue, oldValue, eOpts);
				},
			},
		},

		{ xtype: 'fieldset',
			title: Oger._('Prüfung / Vorbehandlung'),
			items: [
				{ name: 'maxErrorCount', xtype: 'numberfield',
					fieldLabel: Oger._('Maximale Fehleranzahl (0=unbegrenzt)'), labelWidth: 300,
					value: 200, minValue: 0, hideTrigger: true , allowDecimals: false,
				},
				{ name: 'autoCorrect', xtype: 'checkbox', checked: true,
					boxLabel: Oger._('Fehlerbereinigung durch ignorieren. Matrix kann unvollständig oder falsch sein - Protokoll beachten'),
					submitValue: '1', uncheckedValue: '0',
				},
				{ name: 'joinEqual', xtype: 'checkbox',
					boxLabel: Oger._('Knoten über die \'Ist Ident mit\' Beziehung zusammenfassen'),
					submitValue: '1', uncheckedValue: '0',
				},
				{ name: 'removeRedundant', xtype: 'checkbox', checked: true,
					boxLabel: Oger._('Redundante Beziehungen entfernen'),
					submitValue: '1', uncheckedValue: '0',
				},
				{ name: 'contempWithLines', xtype: 'checkbox', checked: true,
					boxLabel: Oger._('Hilfslinien für \'Zeitgleich mit\' Beziehungen erstellen'),
					submitValue: '1', uncheckedValue: '0',
				},
			],
		},

		{ xtype: 'fieldset',
			title: Oger._('Knoten aufbereiten'),
			items: [
				{ xtype: 'fieldcontainer', layout: 'hbox',
					items: [
						{ xtype: 'displayfield', value: '', flex: 1,
							fieldLabel: Oger._('<b>Clusterbildung auf Ebene</b>'), labelWidth: 190,
						},
						{ xtype: 'displayfield', value: '', flex: 1,
							fieldLabel: Oger._('<b>Beschriftung erweitern um</b>'), labelWidth: 190,
						},
					],
				},
				{ xtype: 'panel', html: '<hr>', border: false },
				{ xtype: 'fieldcontainer', layout: 'hbox',
					items: [
						{ xtype: 'displayfield', fieldLabel: Oger._('Stratum'), value: '', flex: 1 },
						{ xtype: 'checkboxgroup', flex: 1,
							items: [
								{ name: 'labelCategoryName', boxLabel: Oger._('Kategorie') },
								{ name: 'labelStratumTypeName', boxLabel: Oger._('Art/Bezeichnung') },
							],
						},
					],
				},
				{ xtype: 'panel', html: '<hr>', border: false },
				{ xtype: 'fieldcontainer', layout: 'hbox',
					items: [
						{ name: 'buildInterfaceCluster', xtype: 'checkbox', boxLabel: Oger._('Interface'), flex: 1,
							listeners: {
								change: function(cmp, newValue, oldValue, options) {
									var field2 = cmp.up('form').getForm().findField('labelInterfaceTypeName');
									if (newValue) {
										field2.enable();
									}
									else {
										field2.disable();
									}
								},
							},
						},
						{ name: 'labelInterfaceTypeName', xtype: 'checkbox', boxLabel: Oger._('Art/Bezeichnung'), disabled: true, flex: 1 },
					],
				},
				{ xtype: 'panel', html: '<hr>', border: false },
				{ xtype: 'fieldcontainer', layout: 'hbox',
					items: [
						{ name: 'buildComplexCluster', xtype: 'checkbox', boxLabel: Oger._('Komplex'), flex: 1, disabled: true,
							listeners: {
								change: function(cmp, newValue, oldValue, options) {
									var field2 = cmp.up('form').getForm().findField('labelComplexTypeName');
									if (newValue) {
										field2.enable();
									}
									else {
										field2.disable();
									}
								},
							},
						},
						{ name: 'labelComplexTypeName', xtype: 'checkbox', boxLabel: Oger._('Art/Bezeichnung'), disabled: true, flex: 1 },
					],
				},
				{ xtype: 'panel', html: '<hr>', border: false },
				{ xtype: 'fieldcontainer', layout: 'hbox',
					items: [
						{ name: 'buildArchObjectCluster', xtype: 'checkbox', boxLabel: Oger._('Objekt'), flex: 1,
							listeners: {
								change: function(cmp, newValue, oldValue, options) {
									var field2 = cmp.up('form').getForm().findField('labelArchObjectTypeName');
									if (newValue) {
										field2.enable();
									}
									else {
										field2.disable();
									}
								},
							},
						},
						{ name: 'labelArchObjectTypeName', xtype: 'checkbox', boxLabel: Oger._('Art/Bezeichnung'), disabled: true, flex: 1 },
					],
				},
				{ xtype: 'panel', html: '<hr>', border: false },
				{ xtype: 'fieldcontainer', layout: 'hbox',
					items: [
						{ name: 'buildArchObjGroupCluster', xtype: 'checkbox', boxLabel: Oger._('Objektgruppe'), flex: 1,
							listeners: {
								change: function(cmp, newValue, oldValue, options) {
									var field2 = cmp.up('form').getForm().findField('labelArchObjGroupTypeName');
									if (newValue) {
										field2.enable();
									}
									else {
										field2.disable();
									}
								},
							},
						},
						{ name: 'labelArchObjGroupTypeName', xtype: 'checkbox', boxLabel: Oger._('Art/Bezeichnung'), disabled: true, flex: 1 },
					],
				},
				{ xtype: 'panel', html: '<hr>', border: false },
				{ name: 'allowMultiCluster', xtype: 'checkbox', fieldLabel: Oger._('Cluster-Zuordnung'), labelWidth: 200,
					boxLabel: Oger._('Mehrfache Clusterzuordnung erlauben'), //disabled: true,
				},
			],
		},

	],  // eo form items

	url: 'php/scripts/matrix.php',

	// ########################################################


	onFileFormatChange: function(cmp, newValue, oldValue) {
		var me = this;

		var vals = {};

		switch (newValue) {
		case 'PROTOCOL_ONLY':
			break;
		case 'EXPORT_GRAPHVIZ_DOT':
			vals = {
				joinEqual: '1',
				removeRedundant: '1',
				//contempWithLines: '1',
			}
			break;
		case 'EXPORT_GRAPHML_YED':
			vals = {
				joinEqual: '1',
				removeRedundant: '1',
				//contempWithLines: '1',
			}
			break;
		case 'EXPORT_GRAPHML':
			vals = {
				joinEqual: '1',
				removeRedundant: '1',
				//contempWithLines: '1',
			}
			break;
		case 'EXPORT_STRATIFY_CSV':
			vals = {
				joinEqual: '0',
				//removeRedundant: '1',
				//contempWithLines: '0',
			}
			break;
		case 'EXPORT_BASP_LST':
			vals = {
				joinEqual: '0',
				//removeRedundant: '1',
				//contempWithLines: '0',
			}
			break;
		}

		me.getForm().setValues(vals);

	},  // eo file format change


});
