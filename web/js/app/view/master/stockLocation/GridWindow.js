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
Ext.define('App.view.master.stockLocation.GridWindow', {
	extend: 'Ext.window.Window',
	alias: 'widget.stocklocationmastergridwin',
	controller: 'stockLocationMasterGridWin',

	title: Oger._('Lagerorte und Sonderbehälter'),
	width: 750, height: 500,
	modal: true,
	//autoScroll: true,
	layout: 'fit',

	items: [ { xtype: 'stocklocationmastergrid', reference: 'stockLocationGrid' } ],

	buttonAlign: 'center',
	minButtonWidth: 30,
	buttons: [
		{ text: Oger._('Schliessen'), handler: 'closeWindow' },
	],


	listeners: {
		afterrender: 'onRender',
	},


});
