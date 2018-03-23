/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/



/**
* Arch object form
*/
Ext.define('App.view.inputCenter.archObject.Form', {
	extend: 'Ext.form.Panel',
	alias: 'widget.ic_archobjectform',

	bodyPadding: 15,
	border: false,
	autoScroll: true,
	layout: 'anchor',
	trackResetOnLoad: true,

	items: [
		{ xtype: 'hidden', name: 'id' },
		{ xtype: 'hidden', name: 'excavId' },
		{ xtype: 'fieldcontainer', layout: 'hbox',
			items: [
				{ name: 'archObjectId', xtype: 'textfield', fieldLabel: Oger._('Objektnummer'), selectOnFocus: true,
					allowBlank: false, validator: xidValid,
				},
				{ name: 'jumpToArchObjectId', xtype: 'textfield', fieldLabel: Oger._('Springe zu Nr'), validator: xidValid,
					width: 300, labelWidth: 170, labelAlign: 'right',
					listeners: {
						change: function(field, newValue, oldValue, options) {
							field.resetOriginalValue();
						},
					},
				},
				{ xtype: 'button', text: Oger._('Springen'), width: 80,
					handler: function(button, event) {
						this.up('window').loadRecordManually();
					}
				},
			],
		},

		{ xtype: 'fieldcontainer', layout: 'hbox',
			items: [
				{ name: 'typeId', xtype: 'combo', fieldLabel: Oger._('Art/Bezeichnung'), width: 300,
					queryMode: 'remote', valueField: 'id', displayField: 'name', triggerAction: 'all', value: null,
					allowBlank: false, //forceSelection: true,
					store: Ext.create('App.store.ArchObjectTypes'),
					listeners: {
						beforerender: function(cmp, opts) {
							cmp.getStore().load();
						},
					}  // eo listerners
				},
				//{ xtype: 'tbspacer', width: 10 },
				/*
				{ name: 'typeSerial', xtype: 'textfield', fieldLabel: Oger._('Art-Zähler'), labelAlign: 'right', validator: xidValid, disabled: true, width: 150, hidden: true },
				{ xtype: 'tbspacer', width: 10 },
				{ name: 'autoSerial', xtype: 'checkbox', uncheckedValue: '0', boxLabel: Oger._('Automatisch zählen'), hideLabel: true, disabled: true, width: 150, hidden: true },
				*/
			 ],
		},

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
						{ xtype: 'textfield', fieldLabel: Oger._('Interpretation'), name: 'interpretation', width: 400 },
						{ xtype: 'fieldcontainer', layout: 'hbox',
							items: [
								{ name: 'datingSpec', xtype: 'textfield', fieldLabel: Oger._('Datierung'), width: 300 + 20 },
								{ name: 'datingPeriodId', xtype: 'combo', fieldLabel: Oger._('Periode'), width: 280,
									labelAlign: 'right', labelWidth: 75 - 20, value: '',
									queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
									listeners: {
										beforerender: function(cmp, options) {
											cmp.setStore(this.up('window').gluePanel.datingPeriodStore);
										},
									}  // eo listerners
								},
							],
						},
						{ name: 'stratumIdList', xtype: 'textfield', fieldLabel: Oger._('Stratumliste'), validator: multiXidValid, width: 600 },
						{ name: 'archObjGroupIdList', xtype: 'textfield', fieldLabel: Oger._('Objektgruppe'), validator: multiXidValid, width: 600 },
						{ xtype: 'tbspacer', height: 20 },
						{ name: 'listComment', xtype: 'textfield', fieldLabel: Oger._('Anmerkung für BDA-Liste'), width: 600, labelWidth: 150 },
					],
				},

				{ xtype: 'panel',
					title: Oger._('Beschreibung'),
					layout: 'anchor',
					bodyPadding: 15,
					border: false,
					hideMode: 'offsets',
					autoScroll: true,
					items: [
						{ xtype: 'displayfield', fieldLabel: Oger._('Beschreibung'), value: '', width: 500, labelWidth: 300 },
						{ name: 'comment', xtype: 'textarea', hideLabel: true, width: 500, height: 200 },
					],
				},

				{ xtype: 'panel',   // stratumlist
					title: Oger._('Stratum'),
					border: false,
					layout: 'anchor',
					items: [
						{ xtype: 'displayfield', value: 'Stratumliste' },
						{ xtype: 'grid',
							isArchObjectStratumGrid: true,
							stripeRows: true,
							autoScroll: true,
							sortableColumns: false,
							store: Ext.create('App.store.ArchObjectStratums'),
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
				},  // eo stratumlist

				{ xtype: 'panel',   // objGroup list
					title: Oger._('Objektgruppe'),
					border: false,
					layout: 'anchor',
					items: [
						{ xtype: 'displayfield', value: 'Objektgruppen' },
						{ xtype: 'grid',
							isArchObjectArchObjGroupGrid: true,
							stripeRows: true,
							autoScroll: true,
							sortableColumns: false,
							store: Ext.create('App.store.ArchObjectArchObjGroups'),
							columns: [
								{ header: Oger._('Gr'), dataIndex: 'excavId', width: 30, hidden: true },
								{ header: Oger._('Grabung'), dataIndex: 'excavName', hidden: true },
								{ header: Oger._('Nummer'), dataIndex: 'archObjGroupId', width: 50 },
								{ header: Oger._('Art/Bezeichnung'), dataIndex: 'typeName' },
								{ header: Oger._('Objektliste'), dataIndex: 'archObjectIdList' },
							],
						},
					],
				},  // eo objGroup list

				// we reuse stratum component!
				{ xtype: 'ic_stratumarchfindgrid',
					isArchObjectArchFindGrid: true,
					title: Oger._('Fund/Probe'),
					store: Ext.create('App.store.ArchObjectArchFinds'),
				},

			], // eo tabpanel items
		},  // eo tabpanel inside form
	],  // eo form items

	url: 'php/scripts/archObject.php',

	listeners: {
		'actioncomplete': function(form, action) {  // for radioboxes and alike
			if (action.type == 'load') {
				Oger.extjs.resetDirty(form);

				var grid = Ext.ComponentQuery.query('component[isArchObjectStratumGrid]', this)[0];
				var store = grid.getStore();
				store.load({
					params: { excavId: form.findField('excavId').getValue(),
										archObjectId: form.findField('archObjectId').getValue(),
									},
				});

				var grid = Ext.ComponentQuery.query('component[isArchObjectArchObjGroupGrid]', this)[0];
				var store = grid.getStore();
				store.load({
					params: { excavId: form.findField('excavId').getValue(),
										archObjectId: form.findField('archObjectId').getValue(),
									},
				});

				var grid = Ext.ComponentQuery.query('component[isArchObjectArchFindGrid]', this)[0];
				var store = grid.getStore();
				store.load({
					params: { excavId: form.findField('excavId').getValue(),
										archObjectId: form.findField('archObjectId').getValue(),
									},
				});

			}
		},
	},  // eo listeners


	// ########################################################




});
