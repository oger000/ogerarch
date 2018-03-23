/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Import window
*/
Ext.define('App.view.import.Window', {
	extend: 'Ext.window.Window',

	title: Oger._('Import'),
	width: 700,
	height: 550,
	modal: true,
	//autoScroll: true,
	layout: 'fit',

	items: [ { xtype: 'importmainpanel' } ],

	buttonAlign: 'center',
	buttons: [
		{ text: Oger._('Import starten'),
			handler: function(button, event) {
				this.up('window').startImport();
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

	// start import
	startImport: function() {
		var me = this;
		var pForm = me.down('importform');
		var bForm = pForm.getForm();
		if (!bForm.isValid()) {
			Oger.extjs.showInvalidFields(bForm);
			return;
		}
		var excavId = '';
		if (this.down('importmainpanel').excavRecord) {
			excavId = this.down('importmainpanel').excavRecord.data.id;
		}
		/*
		 * we only check remote, because there are too many variants
		if (!(excavId || bForm.findField('excavationInsert').getValue())) {
			Ext.Msg.alert(Oger._('Fehler'), Oger._('Bitte Import als neue Grabung oder Zielgrabung ausgewählen.'));
			return;
		}
		*/
		me.doImport(excavId, pForm, bForm);
	},  // eo start import


	// process import
	doImport: function(excavId, pForm, bForm) {
		var me = this;
		var pForm = me.down('importform');
		var bForm = pForm.getForm();
		//var excavId = me.down('importmainpanel').excavRecord.data.id;
		//bForm.standardSubmit = true;  // this is the standard for file upload
		bForm.submit(
			{ url: pForm.url,
				params: { _action: 'upload', targetExcavId: excavId },
				clientValidation: true,
				waitMsg: 'Datei wird hochgeladen und verarbeitet ...',
				success: function(form, action) {
					var responseObj = Ext.decode(action.response.responseText);
					if (responseObj.success == true) {
						var win = Ext.create('Ext.window.Window', {
							title: Oger._('Import Upload Protokoll'),
							width: 350,
							height: 350,
							modal: true,
							autoScroll: true,
							layout: 'fit',
							//html: responseObj.html,
							items: [
								{ xtype: 'textarea', value: responseObj.data.log, readOnly: true },
							],
							buttonAlign: 'center',
							buttons: [
								{ text: Oger._('Ok'),
									handler: function(button, event) {
										win.close();
									},
								},  // eo ok button
							],  // eo buttons
						});
						win.show();

						var vals = { _action: 'import',  importId: responseObj.data.importId };
						Ext.Object.merge(vals, Ext.Ajax.getExtraParams());
						window.open(pForm.url + '?' + Ext.Object.toQueryString(vals),
												'IMPORT',
												'left=' + Math.floor(window.innerWidth * 0.1) + ',top=' + Math.floor(window.innerHeight * 0.1) +
												',width=' + Math.floor(window.innerWidth * 0.8) + ',height=' + Math.floor(window.innerHeight * 0.8) +
												',menubar=yes,toolbar=yes,scrollbars=yes,resizeable=yes');
					}
				},
			}
		)  // eo submit function
	},  // eo perform import





});
