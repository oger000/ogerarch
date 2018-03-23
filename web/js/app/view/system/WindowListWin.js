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
Ext.define('App.view.system.WindowListWin', {
	extend: 'Ext.window.Window',

	title: Oger._('Offene Fenster'),
	width: 300,
	height: 300,
	modal: true,
	autoScroll: true,
	layout: 'fit',
	items: [
		{ xtype: 'grid',
			stripeRows: true,
			columnLines: true,
			autoScroll: true,

			store: {
				type: 'array',
				fields: [ 'id', 'title', 'ogerId', 'ogerTitle' ],
			},

			columns: [
				{ header: Oger._('Titel'), dataIndex: 'ogerTitle', flex: 1, sortable: true },
			],

			listeners: {
				itemclick: function(view, record, item, index, event, opts) {
					var thisWin = this.up('window');
					var otherWin = thisWin.winList[record.data.ogerId];

					if (!otherWin.isVisible()) {
						Ext.create('Oger.MessageBox').alert(
							Oger._('#Hinweis'),
							Oger._('Dieses Fenster ist und bleibt versteckt.'));
						return;
					}

					if (otherWin.getX() < 0) {
						otherWin.setX(1);
					}
					if (otherWin.getY() < 0) {
						otherWin.setY(1);
					}
					otherWin.show();  // toFront() or show() ?
					thisWin.close();
				},
			},
		},  // eo grid
	],
	buttonAlign: 'center',
	buttons: [
		{ text: Oger._('Schliessen'),
			handler: function(button, event) {
				this.up('window').close();
			},
		},
	],

	listeners: {
		beforerender: function(cmp, opts) {
			cmp.fillStore();
		},
		afterrender: function(cmp, opts) {
			cmp.setXY([ 1, 1 ]);
		},
	},


	// ######################################



	// fill store with windows list
	fillStore: function() {

		var me = this;

		// collect windows
		me.winList = [];
		Ext.WindowManager.each(function(c) {
			if (c.isXType('window')) {
				// for testing: list hidden windows too
				var showHidden = true;
				if (c.isVisible() || showHidden) {
					c.ogerId = this.winList.length;
					c.ogerTitle = c.title;
					if (!c.isVisible()) {
						c.ogerTitle = '[ ' + c.ogerTitle + ' ]';
					}
					this.winList.push(c);
				}
			}
		}, me);

		var store = me.down('grid').getStore();
		for (var i=0; i < me.winList.length; i++) {
			store.add(me.winList[i]);
		}

	},  // eo fill store


});

