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
Ext.define('App.view.pictureOrganize.FormWin', {
	extend: 'Ext.window.Window',
	controller: 'pictureOrganizeFormWinCtrl',


	title: Oger._('Fotodateien verwalten'),
	width: 700, height: 400,
	modal: true,
	//autoScroll: true,
	layout: 'fit',

	items: [

		{ xtype: 'form',
			url: 'php/scripts/pictureOrganize.php',
			trackResetOnLoad: true,

			bodyPadding: 15, border: false,
			autoScroll: true,
			layout: 'anchor',

			items: [

				{ name: 'excavId', xtype: 'hidden' },
				{ name: 'excavName', xtype: 'textfield', fieldLabel: Oger._('Grabung'), width: 400,
					readOnly: true, submitValue: false,
				},
				{ xtype: 'fieldcontainer', layout: 'hbox',
					items: [
						{ name: 'beginDate', xtype: 'datefield', fieldLabel: Oger._('Von Datum'),
							readOnly: true, submitValue: false,
						},
						{ xtype: 'tbspacer', width: 20 },
						{ name: 'endDate', xtype: 'datefield', fieldLabel: Oger._('Bis Datum'),
							readOnly: true, submitValue: false,
						},
					],
				},
				{ name: 'officialId', xtype: 'textfield', fieldLabel: Oger._('Massnahme'), width: 400,
					readOnly: true, submitValue: false,
				},

				{ xtype: 'fieldset', title: ' ',
					items: [

						{ name: 'configFileName', xtype: 'textfield', fieldLabel: Oger._('Konfigurationsdatei'),
							width: 400,
						},

						{ name: 'organizeAction', xtype: 'combo', fieldLabel: Oger._('Aktion'), width: 400,
							allowBlank: false, forceSelection: true, value: 'COPY',
							queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
							store: Ext.create('Ext.data.Store', {
								fields: [ 'id', 'name' ],
								data: [
									{ id: 'SHOWNEWCAMERAFILES', name: Oger._('Neue Kamera-Dateien zuordnen') },
									//{ id: 'POSTCONTROL', name: Oger._('Nach-Kontrolle') },
								]
							}),
						},

						/*
						{ name: 'ignoreUnassignedCameraFiles', xtype: 'checkbox',
							boxLabel: Oger._('Fotos ohne Stratum-Zuordnung ignorieren'),
							submitValue: '1', uncheckedValue: '0',
						},
						*/

						{ name: 'maxCameraFiles', xtype: 'numberfield', width: 400,
							fieldLabel: Oger._('Maximale Kamera-Dateien pro Durchgang (0=Alle)'),
							labelWidth: 300, minValue: 0, hideTrigger: true , allowDecimals: false,
							value: 10,
						},


					],
				},

			],
		},
	],

	buttonAlign: 'center',
	buttons: [
		{ text: Oger._('Organisieren starten'), handler: 'startPictureOrganize' },
		{ text: Oger._('Schliessen'), handler: 'closeWindow' },
		//{ text: Oger._('Hilfe'), handler: 'showHelp' },
	],



});
