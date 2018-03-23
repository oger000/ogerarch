/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/



/**
* Picture file form
*/
Ext.define('App.view.fileUpload.picture.Form', {
	extend: 'Ext.form.Panel',
	alias: 'widget.ic_picturefileform',

	disabled: true,

	bodyPadding: 15,
	border: false,
	autoScroll: true,
	layout: 'anchor',
	trackResetOnLoad: true,

	items: [

		{ xtype: 'hidden', name: 'id' },
		{ xtype: 'hidden', name: 'excavId' },

		{ xtype: 'fieldcontainer', hideLabel: true, fieldLabel: Oger._('Dateiname'), isFileNameAndDownLoadId: true,
			layout: 'hbox',
			items: [
				{ xtype: 'textfield', name: 'fileName', width: 350, readOnly: true },
				{ xtype: 'displayfield', width: 5, value: ' ' },
				{ xtype: 'button', text: Oger._('Herunterladen'), width: 80,
					handler: function(button, event) {
						var pForm = this.up('ic_picturefileform');

						var vals = { _action: 'loadContent', id: pForm.getForm().findField('id').getValue() };
						Ext.Object.merge(vals, Ext.Ajax.getExtraParams());

						var url = pForm.url + '?' + Ext.Object.toQueryString(vals);
						window.open(url,
												'FILE',
												'left=' + Math.floor(window.innerWidth * 0.1) + ',top=' + Math.floor(window.innerHeight * 0.1) +
												',width=' + Math.floor(window.innerWidth * 0.8) + ',height=' + Math.floor(window.innerHeight * 0.8));
					}
				},
			]
		},
		{ xtype: 'filefield', fieldLabel: Oger._('Neue Datei'), name: 'uploadFileName', width: 380 },

		{ xtype: 'tabpanel',
			isMasterTabId: true,
			plain: true,
			activeTab: 0,
			deferredRender: false,
			items: [
				{ xtype: 'panel',
					isCommonInfoPanelId: true,
					title: Oger._('Angaben'),
					layout: 'anchor',
					bodyPadding: 15,
					border: false,
					hideMode: 'offsets',
					autoScroll: true,
					items: [
						{ xtype: 'datefield', fieldLabel: Oger._('Datum'), name: 'date', submitFormat: 'Y-m-d' },
						{ xtype: 'textfield', fieldLabel: Oger._('Titel'), name: 'title', width: 300 },
						{ xtype: 'checkbox', fieldLabel: Oger._('Ist Übersicht'), name: 'isOverview', uncheckedValue: '0' },
						{ xtype: 'numberfield', fieldLabel: Oger._('Relevanz (-1..100)'), name: 'relevance', allowDecimals: false, minValue: -1, maxValue: 100 },
						//{ xtype: 'fieldset', title: Oger._('Schichtgrabung'),
						//  items: [
								{ xtype: 'textfield', fieldLabel: Oger._('Stratum'), name: 'auxStratumIdList', maskRe: /[\d,]+/, disabled: true },  //allowBlank: false,
						//  ]
						//},
						{ xtype: 'fieldset', title: Oger._('Planumsgrabung'), isExcavMethodPlanumFieldSetId: true,
							items: [
								{ xtype: 'textfield', fieldLabel: Oger._('Schnitt'), name: 'auxSection' },
								{ xtype: 'textfield', fieldLabel: Oger._('Sektor'), name: 'auxSektor' },
								{ xtype: 'textfield', fieldLabel: Oger._('Planum/DOKN'), name: 'auxPlanum' },
								{ xtype: 'textfield', fieldLabel: Oger._('Profil'), name: 'auxProfile' },
								{ xtype: 'textfield', fieldLabel: Oger._('Objekt'), name: 'auxObject' },
								{ xtype: 'textfield', fieldLabel: Oger._('Grab'), name: 'auxGrave' },
								{ xtype: 'textfield', fieldLabel: Oger._('Mauer'), name: 'auxWall' },
								{ xtype: 'textfield', fieldLabel: Oger._('Komplex'), name: 'auxComplex' },
							]
						},
						{ name: 'datingSpec', xtype: 'textfield', fieldLabel: Oger._('Datierung') },
						{ name: 'datingPeriodId', xtype: 'combo', fieldLabel: Oger._('Periode'),
							queryMode: 'remote', valueField: 'id', displayField: 'name', triggerAction: 'all',
							store: Ext.create('App.store.DatingPeriods'),
						},
						{ fieldLabel: Oger._('Anmerkungen'), xtype: 'displayfield' },
						{ name: 'comment', xtype: 'textarea', hideLabel: true, width: 400, height: 200 },
					],
				},
				{ xtype: 'panel',
					isPreviewPanelId: true,
					title: Oger._('Vorschau'),
					layout: 'fit',
					bodyPadding: 15,
					border: false,
					hideMode: 'offsets',
					autoScroll: true,
					items: [
						{ xtype: 'component', isPreviewFieldId: true, autoEl: { tag: 'img', src: 'http://mafalda/ogertest.jpg'  } },
					],
					listeners: {
						'activate': function(panel, options) {
							var pForm = this.up('ic_picturefileform');
							var previewCmp = pForm.down('component[isPreviewFieldId]');
							var url = pForm.url + '?_action=loadPreview&id=' +
												 pForm.getForm().findField('id').getValue()
							previewCmp.el.dom.src = url;
						}
					},  // eo listeners
				},  // eo preview
			],
			listeners: {
				'beforetabchange': function(panel, newTab, curTab) {
					var pForm = this.up('ic_picturefileform');
					if (newTab != pForm.down('component[isCommonInfoPanelId]') && !pForm.getForm().findField('id').getValue()) {
						Ext.Msg.alert('Hinweis', 'Vorschau erst nach Auswahl bzw. Hochladen möglich.');
						return false;
					}
				},
			},
		},
	],

	url: 'php/scripts/pictureFile.php',

	buttonAlign: 'center',
	buttons: [
		{ text: Oger._('Speichern'),
			handler: function(button, event) {
				this.up('ic_picturefileform').saveRecord(button, event);
			},
		},
	],  // eo buttons

	listeners: {
		'actioncomplete': function(form, action) {  // for radioboxes and alike
			if (action.type == 'load') {
				Oger.extjs.resetDirty(form);
			}
		}
	},  // eo listeners



	// ########################################################

	saveRecord: function(button, event) {
		var bForm = this.getForm();
		var id = bForm.findField('id').getValue();
		var grid = this.up('panel').down('grid');
		bForm.submit(
			{ url: this.url,
				params: { _action: 'save', dbAction: (id ? 'UPDATE' : 'INSERT') },
				clientValidation: true,
				waitMsg: 'Datei wird hochgeladen ...',
				success: function(form, action) {
					Oger.extjs.resetDirty(form);
					var readerData = grid.getStore().getProxy().getReader().read(action.result);
					grid.getStore().loadData(readerData.records, true);
					grid.getSelectionModel().select(readerData.records[0], false);
					//grid.getStore().sort();
				},
				failure: function(form, action) {
					if (!Oger.extjs.handleFormSubmitFailure(form, action)) {
						//handle remaining failures
					}
				}
			}
		)  // eo submit function
	},  // eo save record


});  // eo file upload form
