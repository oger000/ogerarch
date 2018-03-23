/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/



/**
* Report main panel
*/
Ext.define('App.view.report.Panel', {
	extend: 'Ext.panel.Panel',
	alias: 'widget.reportmainselepanel',

	title: Oger._('Alle Grabungen'),
	autoScroll: true,
	layout: 'fit',
	items: [

		{ xtype: 'tabpanel',
			activeTab: 0,
			items: [

				{ xtype: 'panel',
					title: Oger._('Grabung'),
					layout: 'fit',
					autoScroll: true,
					items: [ { xtype: 'commonexcavationselectiongrid' } ],
				}, // eo excavation main tab panel

				{ xtype: 'panel',
					title: Oger._('Detailauswahl'),
					layout: 'fit',
					autoScroll: true,
					items: [ { xtype: 'reportmainseleform' } ],
				},  // eo export form

			],

		},  // eo tabpanel
	],

	listeners: {
		beforerender: function(cmp, options) {
			cmp.onBeforeRender(cmp, options);
		},
	},  // eo listeners


	// ###########################################################


	// before render top panel
	onBeforeRender: function(cmp, options) {
		cmp.down('commonexcavationselectiongrid').gluePanel = cmp;
		/*
		* var store = Ext.create('App.store.StratumCategories');
		* store.load();
		* //cmp.stratumCategoryStore.add({ id: '', name: '--- Alle ---' });
		* cmp.down('reportmainseleform').getForm().findField('stratumCategoryId').setStore(store);
		*/
	}

});
