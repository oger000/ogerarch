/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
*/
Ext.define('App.view.inputCenter.excavation.DeleteWindow', {
	extend: 'Ext.window.Window',

	title: Oger._('Grabung löschen'),
	width: 600, height: 450,
	modal: true,
	//autoScroll: true,
	layout: 'fit',

	items: [

		{ xtype: 'form', layout: 'anchor',
			bodyPadding: 15, border: false,
			autoScroll: true,
			trackResetOnLoad: true,

			url: 'php/scripts/excavation.php',

			items: [

				{ name: 'excavName', xtype: 'textfield', readOnly: true,
					fieldLabel: Oger._('Grabung'), width: 500,
				},
				{ name: 'excavId', xtype: 'textfield', readOnly: true,
					fieldLabel: Oger._('Grabungs-ID'), width: 200,
				},
				{ html: '<hr>', border: false },

				{ xtype: 'fieldcontainer', layout: 'hbox',
					items: [
						{ name: 'deleFullExcav', xtype: 'checkbox', uncheckedValue: '0',
							fieldLabel: Oger._('Ganze Grabung'), boxLabel: Oger._('löschen'),
							listeners: {
								change: function(cmp, newValue) {
									this.up('window').onDeleExcavChange(cmp, newValue);
								},
							},
						},
						{ xtype: 'tbspacer', width: 50},
						{ name: 'excavCount', xtype: 'textfield', readOnly: true, value: 1,
							fieldLabel: Oger._('Anzahl'), labelWidth: 50, width: 150,
						},
					],
				},

				{ xtype: 'fieldcontainer', layout: 'hbox',
					items: [
						{ name: 'deleArchFind', xtype: 'checkbox', uncheckedValue: '0',
							fieldLabel: Oger._('Funde'), boxLabel: Oger._('löschen'),
						},
						{ xtype: 'tbspacer', width: 50},
						{ name: 'archFindCount', xtype: 'textfield', readOnly: true,
							fieldLabel: Oger._('Anzahl'), labelWidth: 50, width: 150,
						},
					],
				},

				{ xtype: 'fieldcontainer', layout: 'hbox',
					items: [
						{ name: 'deleStratum', xtype: 'checkbox', uncheckedValue: '0',
							fieldLabel: Oger._('Stratum'), boxLabel: Oger._('löschen'),
						},
						{ xtype: 'tbspacer', width: 50},
						{ name: 'stratumCount', xtype: 'textfield', readOnly: true,
							fieldLabel: Oger._('Anzahl'), labelWidth: 50, width: 150,
						},
					],
				},

				{ xtype: 'fieldcontainer', layout: 'hbox',
					items: [
						{ name: 'deleArchObject', xtype: 'checkbox', uncheckedValue: '0',
							fieldLabel: Oger._('Objekt'), boxLabel: Oger._('löschen'),
						},
						{ xtype: 'tbspacer', width: 50},
						{ name: 'archObjectCount', xtype: 'textfield', readOnly: true,
							fieldLabel: Oger._('Anzahl'), labelWidth: 50, width: 150,
						},
					],
				},

				{ xtype: 'fieldcontainer', layout: 'hbox',
					items: [
						{ name: 'deleArchObjGroup', xtype: 'checkbox', uncheckedValue: '0',
							fieldLabel: Oger._('Objektgruppe'), boxLabel: Oger._('löschen'),
						},
						{ xtype: 'tbspacer', width: 50},
						{ name: 'archObjGroupCount', xtype: 'textfield', readOnly: true,
							fieldLabel: Oger._('Anzahl'), labelWidth: 50, width: 150,
						},
					],
				},

				{ xtype: 'fieldcontainer', layout: 'hbox',
					items: [
						{ name: 'deleStockLocation', xtype: 'checkbox', uncheckedValue: '0',
							fieldLabel: Oger._('Lager-Behälter'), boxLabel: Oger._('löschen'),
						},
						{ xtype: 'tbspacer', width: 50},
						//{ name: 'stockLocationCount', xtype: 'textfield', readOnly: true,
						//	fieldLabel: Oger._('Anzahl'), labelWidth: 50, width: 150,
						//},
					],
				},

				{ xtype: 'fieldcontainer', layout: 'hbox',
					items: [
						{ name: 'delePrepFind', xtype: 'checkbox', uncheckedValue: '0',
							fieldLabel: Oger._('Lager-Funde'), boxLabel: Oger._('löschen'),
						},
						{ xtype: 'tbspacer', width: 50},
						{ name: 'prepFindCount', xtype: 'textfield', readOnly: true,
							fieldLabel: Oger._('Anzahl'), labelWidth: 50, width: 150,
						},
					],
				},

				{ html: '<hr>', border: false },

				{ name: 'deleId', xtype: 'textfield', readOnly: true,
					fieldLabel: Oger._('Lösch-ID'), width: 500,
				},
				{ name: 'deleCode', xtype: 'textfield',
					fieldLabel: Oger._('Lösch-Code'), width: 500,
				},
			],  // eo form items
		},
	],

	buttonAlign: 'center',
	buttons: [
		{ text: Oger._('Grabung löschen'),
			handler: function(button, event) {
				this.up('window').startDelete();
			}
		},
		{ text: Oger._('Schliessen'),
			handler: function(button, event) {
				this.up('window').close();
			}
		},
	],  // eo buttons

	listeners: {
		afterrender: function(cmp, options) {
			cmp.alignTo(Ext.ComponentQuery.query('mainviewport')[0], 'c-c?');
		},
	},

	// ####################################


	// prepare window
	prep: function(rec) {
		var me = this;

		var vals = Ext.clone(rec.data);
		vals.excavName = vals.name;
		vals.excavId = vals.id;
		vals.deleId = String(Math.floor(Date.now() / 1000));
		var idx = vals.deleId.length - 5;
		vals.deleId = vals.deleId.substring(0, idx) + '-' + vals.deleId.substring(idx);

		var pForm = me.down('form');
		var bForm = pForm.getForm();
		bForm.setValues(vals);
	},  // eo prep


	// start delete
	startDelete: function() {
		var me = this;

		var pForm = me.down('form');
		var bForm = pForm.getForm();
		if (!bForm.isValid()) {
			Oger.extjs.showInvalidFields(bForm);
			return;
		}

		var vals = bForm.getValues();
		Ext.Object.merge(vals, { _action: 'deleteExcavation' }, Ext.Ajax.getExtraParams());

		window.open(pForm.url + '?' + Ext.Object.toQueryString(vals),
								'DELETE',
								'left=' + Math.floor(window.innerWidth * 0.1) + ',top=' + Math.floor(window.innerHeight * 0.1) +
								',width=' + Math.floor(window.innerWidth * 0.8) + ',height=' + Math.floor(window.innerHeight * 0.8) +
								',menubar=yes,toolbar=yes,scrollbars=yes,resizeable=yes');

		// show msg to wait for proto
		Ext.Msg.alert(
			Oger._('Hinweis'),
			Oger._('Bitte warten bis der Löschvorgang beendet ist. Protokoll beachten.'),
			function() {
				var grid = me.assignedGrid;
				if (grid) {
					var store = grid.getStore();
					store.loadPage(store.currentPage);
				}
				//me.close();
			}
		);
	},  // eo delete


	// on delete all change
	onDeleExcavChange: function(cmp, newValue) {
		var me = this;

		var pForm = me.down('form');
		var bForm = pForm.getForm();

		var field = bForm.findField('deleArchFind');
		field.setValue(field.getValue() || newValue);
		field.setReadOnly(newValue);

		var field = bForm.findField('deleStratum');
		field.setValue(field.getValue() || newValue);
		field.setReadOnly(newValue);

		var field = bForm.findField('deleArchObject');
		field.setValue(field.getValue() || newValue);
		field.setReadOnly(newValue);

		var field = bForm.findField('deleArchObjGroup');
		field.setValue(field.getValue() || newValue);
		field.setReadOnly(newValue);

		var field = bForm.findField('delePrepFind');
		field.setValue(field.getValue() || newValue);
		field.setReadOnly(newValue);

		var field = bForm.findField('deleStockLocation');
		field.setValue(field.getValue() || newValue);
		field.setReadOnly(newValue);
	},  // eo on dele all change


});



