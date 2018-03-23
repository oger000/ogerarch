/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/*
 * Main viewport for app
 */
Ext.define('App.view.MainViewport', {
	extend: 'Ext.container.Viewport',
	alias: 'widget.mainviewport',

	layout: 'border',
	//autoScroll: true,
	items: [
		{ region: 'north',
			xtype: 'mainstatus',
			height: 30,
			border: false,
			margins: '0 0 0 0',
		},
		{ region: 'west',
			xtype: 'mainmenu',
			title: Oger._('Menü'),
			layout: 'fit',
			collapsible: true,
			width: 200,
			split: true,
		},
		{ region: 'center',
			xtype: 'container',
			layout: 'fit',
			//html: 'center',
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

});
