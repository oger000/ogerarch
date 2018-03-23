/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/



/**
* file upload panel
*/
Ext.define('App.view.fileUpload.Panel', {
	extend: 'Ext.panel.Panel',
	alias: 'widget.fileuploadmainpanel',

	title: Oger._('Grabung auswählen'),
	autoScroll: true,
	layout: 'fit',

	items: [

		{ xtype: 'tabpanel',
			activeTab: 0,
			items: [

				{ xtype: 'panel',
					title: Oger._('Grabung'),
					isExcavTab: true,
					layout: 'fit',
					autoScroll: true,
					items: [ { xtype: 'commonexcavationselectiongrid' } ],
				}, // eo excavation main tab panel

				{ xtype: 'panel',
					title: Oger._('Foto'),
					isPictureTab: true,
					layout: 'border',
					autoScroll: true,
					items: [
						{ xtype: 'ic_picturefilegrid', region: 'center' },
						{ xtype: 'ic_picturefileform', region: 'east', split: true, width: 500, },
					],
					listeners: {
						activate: function(cmp, options) {
							var grid = cmp.down('grid');
							if (cmp.gluePanel.excavRecord && grid.excavId != cmp.gluePanel.excavRecord.data.id) {
								grid.excavId = cmp.gluePanel.excavRecord.data.id;
								var store = grid.getStore();
								store.clearFilter();
								store.filter('excavId', grid.excavId);
								cmp.down('pagingtoolbar').moveFirst();
								var pForm = cmp.down('ic_picturefileform');
								Oger.extjs.emptyForm(pForm);
								pForm.disable();
							}
						},
					},  // eo listeners
				},  // eo picture

			],

			listeners: {
				beforetabchange: function(panel, newTab, curTab, opts) {
					// change to excav tab is always possible
					var upPanel = panel.up('fileuploadmainpanel');
					if (!newTab.isExcavTab && (!upPanel.excavRecord || !upPanel.excavRecord.data.id)) {
						Ext.Msg.alert(Oger._('Hinweis'), Oger._('Bitte zuerst Grabung auswählen.'));
						return false;
					}
					return true;
				},
			},  // eo listeners

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
		cmp.down('component[isPictureTab]').gluePanel = cmp;
		cmp.down('ic_picturefilegrid').gluePanel = cmp;
		cmp.down('ic_picturefileform').gluePanel = cmp;
	}

});
