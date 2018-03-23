/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/



/**
* Export main panel
*/
Ext.define('App.view.export.Panel', {
	extend: 'Ext.panel.Panel',
	alias: 'widget.exportmainpanel',

	title: Oger._('Alle Grabungen'),
	autoScroll: true,
	layout: 'fit',
	items: [

		{ xtype: 'tabpanel',
			activeTab: 0,
			items: [

				/*
				{ xtype: 'panel',
					title: Oger._('Grabung'),
					layout: 'fit',
					autoScroll: true,
					items: [ { xtype: 'commonexcavationselectiongrid' } ],
				}, // eo excavation main tab panel
				*/

				{ xtype: 'panel',
					title: Oger._('Detailauswahl'),
					layout: 'fit',
					autoScroll: true,
					items: [ { xtype: 'exportform' } ],
				},  // eo export form

			],

		},  // eo tabpanel
	],

	listeners: {
		beforerender: function(cmp, opts) {
			cmp.onBeforeRender(cmp, opts);
		},
		afterrender: function(cmp, opts) {
			cmp.onAfterRender(cmp, opts);
		},
	},  // eo listeners


	// ###########################################################


	// before render top panel
	onBeforeRender: function(cmp, options) {
		//cmp.down('commonexcavationselectiongrid').gluePanel = cmp;
		var store = Ext.create('App.store.StratumCategories');
		store.load();
		//cmp.stratumCategoryStore.add({ id: '', name: '--- Alle ---' });
		cmp.down('exportform').getForm().findField('stratumCategoryId').setStore(store);
	},   // eo before render


	// after render top panel
	onAfterRender: function(cmp, options) {
		var me = this;
		var excavRec = Ext.ComponentQuery.query('inputcenterpanel')[0].excavRecord;
		// this is a paranoid check, because we checked in main menu before calling the export win
		if (!excavRec) {
			cmp.up('window').close();
			Ext.Msg.alert(Oger._('Fehler'), Oger._('Bitte zuerst eine Grabung auswählen.'));
			return;
		}
		var excavData = excavRec.data;
		var tmpBeginDate = new Date(excavData.beginDate);
		var title = Oger._('Grabung: ') + excavData.name + ' ' + tmpBeginDate.getFullYear();
		cmp.setTitle(title);
		me.excavRecord = Ext.clone(excavRec);
	},  // eo after render


});
