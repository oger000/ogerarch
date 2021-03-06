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
Ext.define('App.view.report.stock.location.ContentSheetWin', {
	extend: 'Ext.window.Window',
	alias: 'widget.reportstockcontentsheetwindow',

	title: Oger._('Lagerzettel (Beschriftung + Inhalt)'),
	width: 550, height: 350,
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

			url: 'php/scripts/stockLocation.php',

			defaults: { labelWidth: 120 },

			items: [

				{ name: 'stockLocationId', xtype: 'hidden' },
				{ name: 'excavId', xtype: 'hidden' },

				{ name: 'name', xtype: 'textfield', fieldLabel: Oger._('Lagerort'),
					width: 300, readOnly: true,
				},

				{ xtype: 'panel', html: '<hr>', border: false },
				{ xtype: 'panel', html: '<br>', border: false },

				{ xtype: 'radiogroup', fieldLabel: 'Grabung',
					items: [
						{ boxLabel: 'Aktuelle Grabung', name: 'excavScope', inputValue: 'current', checked: true },
						{ boxLabel: 'Alle Grabungen', name: 'excavScope', inputValue: 'all' },
					]
				},  // eo radio grp

				{ name: 'listInnerLoc', xtype: 'checkbox',
					inputValue: '1', uncheckedValue: '0',
					boxLabel: Oger._('Untergeordnete Lagerorte berücksichtigen'),
					listeners: {
						change: function(cmp, newValue, oldValue) {
							var other = cmp.up('form').getForm().findField('listEmptyInnerLoc');
							other.setDisabled(!newValue);
						},
					},
				},

				{ name: 'listEmptyInnerLoc', xtype: 'checkbox', disabled: true,
					inputValue: '1', uncheckedValue: '0',
					boxLabel: Oger._('Leere untergeordnete Lagerorte berücksichtigen'),
				},

				{ xtype: 'panel', html: '<hr>', border: false },

				{ name: 'hideArchFindSubId', xtype: 'checkbox', checked: true,
					inputValue: '1', uncheckedValue: '0',
					boxLabel: Oger._('Subnummer ignorieren/ausblenden'),
				},

				{ name: 'printMaterialList', xtype: 'checkbox', checked: true,
					inputValue: '1', uncheckedValue: '0',
					boxLabel: Oger._('Materialliste drucken'),
				},

				{ name: 'printLogo', xtype: 'checkbox', checked: true,
					inputValue: '1', uncheckedValue: '0',
					boxLabel: Oger._('Firmenlogo drucken'),
				},

				{ name: 'numCopies', xtype: 'numberfield', fieldLabel: Oger._('Anzahl'), value: 1 },

			],
		},
	],

	buttonAlign: 'center',
	minButtonWidth: 30,
	buttons: [
		{ text: Oger._('Starten'), itemId: 'applyButton',
			listeners: {
				click: function(cmp) {
					cmp.up('window').doList();
				},
			},
		},
		{ text: Oger._('Schliessen'), itemId: 'closeButton',
			listeners: {
				click: function(cmp) {
					cmp.up('window').close();
				},
			},
		},
	],


	// ########################################################################


	// inject data
	injectData: function(data) {
		var me = this;
		var bForm = me.down('form').getForm();
		bForm.setValues(data);
	},  // eo inject data


	// start list output
	doList: function() {
		var me = this;

		var pForm = me.down('form');
		var bForm = pForm.getForm();

		if (!bForm.isValid()) {
			Ext.Msg.alert(Oger._('Hinweis'), Oger._('Fehler im Auswahlformular.'));
			return;
		}

		var vals = bForm.getValues();
		vals._action = 'locContentSheet';
		Ext.Object.merge(vals, Ext.Ajax.getExtraParams());

		if (vals.excavScope == 'all') {
			delete vals.excavId;
		}

		delete vals.name;
		var urlStr = pForm.url + '?' + Ext.Object.toQueryString(vals);
		window.open(urlStr,
			'REPORT',
			'left=' + Math.floor(window.innerWidth * 0.1) + ',top=' + Math.floor(window.innerHeight * 0.1) +
			',width=' + Math.floor(window.innerWidth * 0.8) + ',height=' + Math.floor(window.innerHeight * 0.8) +
			',menubar=yes,toolbar=yes,scrollbars=yes,resizeable=yes');
	},  // eo start list

});
