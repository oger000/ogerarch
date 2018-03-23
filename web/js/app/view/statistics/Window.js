/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Statistics selection window
*/
Ext.define('App.view.statistics.Window', {
	extend: 'Ext.window.Window',

	title: Oger._('Statistik'),
	width: 700,
	height: 500,
	modal: true,
	//autoScroll: true,
	layout: 'fit',

	items: [ { xtype: 'statisticsmainselepanel' } ],

	buttonAlign: 'center',
	buttons: [
		{ text: Oger._('Statistik starten'),
			handler: function(button, event) {
				this.up('window').startStatistics();
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

	// start statistics
	startStatistics: function() {
		var me = this;
		var pForm = me.down('statisticsmainseleform');
		var bForm = pForm.getForm();
		if (!bForm.isValid()) {
			Ext.Msg.alert(Oger._('Hinweis'), Oger._('Fehler im Auswahlformular.'));
			return;
		}
		var excavId = '';
		if (this.down('statisticsmainselepanel').excavRecord) {
			excavId = this.down('statisticsmainselepanel').excavRecord.data.id;
		}
		if (!excavId) {
			Ext.Msg.alert(Oger._('Hinweis'),
				Oger._('Es wurde keine Grabung ausgewählt. Die Statistik ist pro Grabung getrennt zu erstellen.'));
			return;
		}
		me.doStatistics(excavId, pForm, bForm);
	},  // eo start statistics


	// process statistics
	doStatistics: function(excavId, pForm, bForm) {

		var vals = bForm.getValues();
		Ext.Object.merge(vals, { _action: 'statistics', excavId: excavId }, Ext.Ajax.getExtraParams());

		var urlStr = pForm.url + '?' + Ext.Object.toQueryString(vals);
		window.open(urlStr,
								'STATISTICS',
								'left=' + Math.floor(window.innerWidth * 0.1) + ',top=' + Math.floor(window.innerHeight * 0.1) +
								',width=' + Math.floor(window.innerWidth * 0.8) + ',height=' + Math.floor(window.innerHeight * 0.8) +
								',menubar=yes,toolbar=yes,scrollbars=yes,resizeable=yes');
	},  // eo perform statistics


});
