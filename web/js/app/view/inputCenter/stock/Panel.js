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
Ext.define('App.view.inputCenter.stock.Panel', {
	extend: 'Ext.panel.Panel',
	alias: 'widget.ic_stockpanel',
	controller: 'ic_stockpanel',

	layout: 'border',
	items: [
		/*
		{ region: 'north',
			xtype: 'container',
			height: 30,
			border: false,
			margins: '0 0 0 0',
			items: [ { xtype: 'mainstatus' } ],
		},
		*/
		{ region: 'west', reference: 'stockLocationGrid',
			layout: 'fit',
			xtype: 'ic_stocklocationgrid',
			collapsible: true, split: true,
			width: 450,
		},
		{ region: 'center', reference: 'stockPrepFindGrid',
			layout: 'fit',
			xtype: 'ic_stockprepfindgrid',
		},
		/*
		{ region: 'south',
			xtype: 'container',
			height: 30,
			border: false,
			margins: '0 0 0 0',
			//items: [ { xtype: 'panel' } ],
		},
		*/
	],


	listeners: {
		activate: 'activatePanel',
	},



});
