/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Check data consitency window
*/
Ext.define('App.view.checkConsistency.CheckLevelInfoWindow', {
	extend: 'Ext.window.Window',

	title: Oger._('Info zu Check Level'),
	width: 550,
	height: 350,
	modal: true,
	//autoScroll: true,
	layout: 'fit',

	items: [
		{ xtype: 'textarea', readOnly: true,
			value:  '- Interne und fatale Fehler sind solche, die in erster Linie durch Programmfehler' +
							' oder direkte Manipulation der Datenbank entstehen.' +
							' Auf interne und fatale Fehler wird immer geprüft.\n' +
							'  - Interne Fehler können nur durch direkten Eingriff in die Datenbank behoben werden.\n' +
							'  - Fatale Fehler können über die normale Eingabe beseitigt werden.\n' +
							'\n' +
							'- Fehler (Normale Fehler) sind Unstimmigkeiten in den Daten.\n' +
							'  Zum Beispiel Stratum-Angabe bei Fund, aber Stratum ist noch nicht angelegt, usw\n' +
							'\n' +
							'- Warnungen erfolgen bei ungewöhnlichen Datensätzen, die möglicherweise fehlerhaft sind, ' +
							'  die aber ebensogut beabsichtigt sein können.\n' +
							'  Zum Beispiel wenn auf einem Fund weder Fundmaterial noch eine Probe angegeben wird.\n' +
							'\n' +
							'- Hinweise betreffen mögliche Fehler mit untergeordneter Bedeutung.\n' +
							'  Zum Beispielfehlende Codes für Stratumtypen, was einen Datenaustausch erschwert.\n' +
							'\n' +
							'- Extrameldungen sind zusätzliche und ausführlichere Hinweise.\n' +
							'\n' +
							'- Debug Meldungen dienen der Programmverfolgung bei der Entwicklung.\n' +
							'  Zum Beispiel Angaben zu fehlerfrei bestandenen Prüfungen.\n',
		}
	],

	buttonAlign: 'center',
	buttons: [
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



});
