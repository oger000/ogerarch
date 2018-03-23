/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Stratum type detail window
*/
Ext.define('App.view.master.stockLocation.DetailWindow', {
	extend: 'Ext.window.Window',
	alias: 'widget.stocklocationmasterwindow',
	controller: 'stockLocationMasterDetailWindow',

	title: Oger._('Lagerort'),
	width: 600, height: 450,
	modal: true,
	//autoScroll: true,
	layout: 'fit',

	items: [ { xtype: 'stocklocationmasterform' } ],

	buttonAlign: 'center',
	minButtonWidth: 30,
	buttons: [
		{ text: Oger._('Speichern'), handler: 'saveRecord' },
		{ text: Oger._('Zurücksetzen'), handler: 'resetForm' },
		{ text: Oger._('Schliessen'), handler: 'closeWindow' },
	],


	listeners: {
		beforeclose: Oger.extjs.defaultOnBeforeWinClose,
		close: 'onClose',
	},

});
