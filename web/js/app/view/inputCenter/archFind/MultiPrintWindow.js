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
Ext.define('App.view.inputCenter.archFind.MultiPrintWindow', {
	extend: 'Ext.window.Window',

	title: Oger._('Stapeldruck Fundzettel'),
	width: 500,
	height: 450,
	modal: true,
	//autoScroll: true,
	layout: 'fit',

	items: [

		{ xtype: 'form',
			bodyPadding: 15,
			border: false,
			autoScroll: true,
			layout: 'anchor',
			trackResetOnLoad: true,

			items: [

				{ xtype: 'hidden', name: 'excavId' },

				{ xtype: 'fieldcontainer', layout: 'hbox',
					items: [
						{ name: 'archFindId0', xtype: 'textfield', fieldLabel: Oger._('Fundnummer'), width: 180, validator: xidValid },
						{ xtype: 'tbspacer', width: 10 },
						{ xtype: 'numberfield', name: 'numCopies0', value: 1, minValue: 0,
							fieldLabel: Oger._('Exemplare'), width: 180, labelAlign: 'right',
						},
					],
				},

				{ xtype: 'fieldcontainer', layout: 'hbox',
					items: [
						{ name: 'archFindId1', xtype: 'textfield', fieldLabel: Oger._('Fundnummer'), width: 180,
							selectOnFocus: true, validator: xidValid,
						},
						{ xtype: 'tbspacer', width: 10 },
						{ xtype: 'numberfield', name: 'numCopies1', minValue: 0,
							fieldLabel: Oger._('Exemplare'), width: 180, labelAlign: 'right',
						},
					],
				},

				{ xtype: 'fieldcontainer', layout: 'hbox',
					items: [
						{ name: 'archFindId2', xtype: 'textfield', fieldLabel: Oger._('Fundnummer'), width: 180,
							selectOnFocus: true, validator: xidValid,
						},
						{ xtype: 'tbspacer', width: 10 },
						{ xtype: 'numberfield', name: 'numCopies2', minValue: 0,
							fieldLabel: Oger._('Exemplare'), width: 180, labelAlign: 'right',
						},
					],
				},

				{ xtype: 'fieldcontainer', layout: 'hbox',
					items: [
						{ name: 'archFindId3', xtype: 'textfield', fieldLabel: Oger._('Fundnummer'), width: 180,
							selectOnFocus: true, validator: xidValid,
						},
						{ xtype: 'tbspacer', width: 10 },
						{ xtype: 'numberfield', name: 'numCopies3', minValue: 0,
							fieldLabel: Oger._('Exemplare'), width: 180, labelAlign: 'right',
						},
					],
				},

				{ xtype: 'fieldcontainer', layout: 'hbox',
					items: [
						{ name: 'archFindId4', xtype: 'textfield', fieldLabel: Oger._('Fundnummer'), width: 180,
							selectOnFocus: true, validator: xidValid,
						},
						{ xtype: 'tbspacer', width: 10 },
						{ xtype: 'numberfield', name: 'numCopies4', minValue: 0,
							fieldLabel: Oger._('Exemplare'), width: 180, labelAlign: 'right',
						},
					],
				},

				{ xtype: 'fieldcontainer', layout: 'hbox',
					items: [
						{ name: 'archFindId5', xtype: 'textfield', fieldLabel: Oger._('Fundnummer'), width: 180,
							selectOnFocus: true, validator: xidValid,
						},
						{ xtype: 'tbspacer', width: 10 },
						{ xtype: 'numberfield', name: 'numCopies5', minValue: 0,
							fieldLabel: Oger._('Exemplare'), width: 180, labelAlign: 'right',
						},
					],
				},

				 { xtype: 'fieldcontainer', layout: 'hbox',
					items: [
						{ name: 'archFindId6', xtype: 'textfield', fieldLabel: Oger._('Fundnummer'), width: 180,
							selectOnFocus: true, validator: xidValid,
						},
						{ xtype: 'tbspacer', width: 10 },
						{ xtype: 'numberfield', name: 'numCopies6', minValue: 0,
							fieldLabel: Oger._('Exemplare'), width: 180, labelAlign: 'right',
						},
					],
				},

				{ xtype: 'fieldcontainer', layout: 'hbox',
					items: [
						{ name: 'archFindId7', xtype: 'textfield', fieldLabel: Oger._('Fundnummer'), width: 180,
							selectOnFocus: true, validator: xidValid,
						},
						{ xtype: 'tbspacer', width: 10 },
						{ xtype: 'numberfield', name: 'numCopies7', minValue: 0,
							fieldLabel: Oger._('Exemplare'), width: 180, labelAlign: 'right',
						},
					],
				},

				{ xtype: 'fieldcontainer', layout: 'hbox',
					items: [
						{ name: 'archFindId8', xtype: 'textfield', fieldLabel: Oger._('Fundnummer'), width: 180,
							selectOnFocus: true, validator: xidValid,
						},
						{ xtype: 'tbspacer', width: 10 },
						{ xtype: 'numberfield', name: 'numCopies8', minValue: 0,
							fieldLabel: Oger._('Exemplare'), width: 180, labelAlign: 'right',
						},
					],
				},

				{ xtype: 'fieldcontainer', layout: 'hbox',
					items: [
						{ name: 'archFindId9', xtype: 'textfield', fieldLabel: Oger._('Fundnummer'), width: 180,
							selectOnFocus: true, validator: xidValid,
						},
						{ xtype: 'tbspacer', width: 10 },
						{ xtype: 'numberfield', name: 'numCopies9', minValue: 0,
							fieldLabel: Oger._('Exemplare'), width: 180, labelAlign: 'right',
						},
					],
				},

			],

			url: 'php/scripts/archFind.php',

		},  // eo form

	],

	buttonAlign: 'center',
	minButtonWidth: 30,
	buttons: [
		{ text: Oger._('Drucken'),
			handler: function(button, event) {
				this.up('window').multiPrint(button, event);
			}
		},
		{ text: Oger._('Schliessen'),
			handler: function(button, event) {
				this.up('window').close();
			}
		},
	],  // eo buttons

	listeners: {
		beforerender: function(cmp, options) {
			cmp.onBeforeRender(cmp, options);
		},
	},



	// ####################################


	// before render
	onBeforeRender: function() {
		var me = this;
		var bForm = me.down('form').getForm();
		var ignored = 0;
		for (var i = 0; i < me.assignedGrid.unprintQueue.length; i++) {
			if (i > 9) {  // sanity check
				break;
			}
			var value = me.assignedGrid.unprintQueue[i];
			if (value == bForm.findField('archFindId0').getValue()) {
				ignored++;
				continue;
			}
			bForm.findField('archFindId' + (i + 1 - ignored)).setValue(value);
		}
	},

	// print multiple arch find sheets
	multiPrint: function(button, event) {
		var me = this;
		var pForm = me.down('form');
		var bForm = pForm.getForm();
		if (!bForm.isValid()) {
			Ext.Msg.alert(Oger._('Hinweis'), Oger._('Fehler im Formular.'));
			return;
		}

		var vals = bForm.getValues();
		Ext.Object.merge(vals, { _action: 'printMultiFindSheets' }, Ext.Ajax.getExtraParams());

		var urlStr = pForm.url + '?' + Ext.Object.toQueryString(vals);
		window.open(urlStr,
								'ARCHFINDSHEET',
								'left=' + Math.floor(window.innerWidth * 0.1) + ',top=' + Math.floor(window.innerHeight * 0.1) +
								',width=' + Math.floor(window.innerWidth * 0.8) + ',height=' + Math.floor(window.innerHeight * 0.8));
		/*
		// remove arch find id from unprinted queue
		for (var i = 0; i <= 9; i++) {
			var archFindId = bForm.findField('archFindId' + i).getValue();
			var numCopies = bForm.findField('numCopies' + i).getValue();
			if (archFindId && numCopies) {
				me.assignedGrid.unprintQueueRemove(archFindId);
			}
		}
		*/
		// remove all arch find id from unprined queue - even if not printed
		me.assignedGrid.unprintQueue = [];
	},  // eo print sheet

});
