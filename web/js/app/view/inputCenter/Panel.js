/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/



/**
* Excavation input center panel
*/
Ext.define('App.view.inputCenter.Panel', {
	extend: 'Ext.panel.Panel',
	alias: 'widget.inputcenterpanel',

	title: Oger._('Grabung auswählen'),
	//autoScroll: true,
	layout: 'fit',

	items: [

		{ xtype: 'tabpanel',
			activeTab: 0,
			items: [

				{ xtype: 'panel',
					title: Oger._('Grabung/Projekt'),
					itemId: 'excavTab',
					layout: 'fit',
					autoScroll: true,
					items: [ { xtype: 'ic_excavationgrid' } ],
				}, // eo excavation main tab panel

				{ xtype: 'panel',
					title: Oger._('Fund'),
					itemId: 'archFindTab',
					layout: 'fit',
					autoScroll: true,
					items: [ { xtype: 'ic_archfindgrid' } ],
					listeners: {
						activate: function(cmp, options) {
							cmp.up('inputcenterpanel').activateArchFindGrid(cmp, options);
						},
					},
				},  // eo find sheet

				{ xtype: 'panel',
					title: Oger._('Stratum'),
					itemId: 'stratumTab',
					layout: 'fit',
					autoScroll: true,
					items: [ { xtype: 'ic_stratumgrid' } ],
					listeners: {
						activate: function(cmp, options) {
							cmp.up('inputcenterpanel').activateStratumGrid(cmp, options);
						},
					},
				},  // eo stratum

				{ xtype: 'panel',
					title: Oger._('Matrix'),
					itemId: 'qmatrixTab',
					layout: 'fit',
					autoScroll: true,
					items: [ { xtype: 'ic_qmatrixgrid' } ],
					listeners: {
						activate: function(cmp, options) {
							cmp.up('inputcenterpanel').activateQmatrixGrid(cmp, options);
						},
					},
				},  // eo quick matrix

				{ xtype: 'panel',
					title: Oger._('Objekt'),
					layout: 'fit',
					autoScroll: true,
					items: [ { xtype: 'ic_archobjectgrid' } ],
					listeners: {
						activate: function(cmp, options) {
							cmp.up('inputcenterpanel').activateArchObjectGrid(cmp, options);
						},
					},
				},  // eo arch object

				{ xtype: 'panel',
					title: Oger._('Objektgruppe'),
					layout: 'fit',
					autoScroll: true,
					items: [ { xtype: 'ic_archobjgroupgrid' } ],
					listeners: {
						activate: function(cmp, options) {
							cmp.up('inputcenterpanel').activateArchObjGroupGrid(cmp, options);
						},
					},
				},  // eo arch object group
/*
				{ xtype: 'panel',
					title: Oger._('Katalog'),
					isFindCatalogTab: true,
					layout: 'fit',
					autoScroll: true,
					items: [ { xtype: 'ic_findcataloggrid' } ],
					listeners: {
						activate: function(cmp, options) {
							cmp.up('inputcenterpanel').activateFindCatalogGrid(cmp, options);
						},
					},
				},  // eo find catalog
*/
				{ title: Oger._('Lager'),
					xtype: 'ic_stockpanel',
				},  // eo stock

			],

			listeners: {
				beforetabchange: function(panel, newTab, curTab, opts) {
					me = this;
					// change to excav tab is always possible. Other tabs only if excvation is selected.
					var upPanel = panel.up('inputcenterpanel');
					if (newTab.itemId != 'excavTab' && (!upPanel.excavRecord || !upPanel.excavRecord.data.id)) {
						Ext.Msg.alert(Oger._('Hinweis'), Oger._('Bitte zuerst Grabung auswählen.'));
						return false;
					}

					// change of excavation is only possible if detail windows are closed
					if (newTab.itemId == 'excavTab') {
						if (Ext.ComponentQuery.query('ic_archfindwindow')[0]) {
							Ext.Msg.alert(Oger._('Hinweis'), Oger._('Bitte zuerst Fund Detailfenster schliessen.'));
							return false;
						}
						if (Ext.ComponentQuery.query('ic_stratumwindow')[0]) {
							Ext.Msg.alert(Oger._('Hinweis'), Oger._('Bitte zuerst Stratum Detailfenster schliessen.'));
							return false;
						}
						if (Ext.ComponentQuery.query('ic_archobjectwindow')[0]) {
							Ext.Msg.alert(Oger._('Hinweis'), Oger._('Bitte zuerst Objekt Detailfenster schliessen.'));
							return false;
						}
						if (Ext.ComponentQuery.query('ic_archobjgroupwindow')[0]) {
							Ext.Msg.alert(Oger._('Hinweis'), Oger._('Bitte zuerst Objektgruppe Detailfenster schliessen.'));
							return false;
						}
/*
						if (Ext.ComponentQuery.query('ic_findcatalogwindow')[0]) {
							Ext.Msg.alert(Oger._('Hinweis'), Oger._('Bitte zuerst Fundkatalog Detailfenster schliessen.'));
							return false;
						}
*/
					}  // force closing of detailwindow before excav change

					// use excavation with planum method at own risk for arch finds
					if (newTab.itemId == 'archFindTab' && upPanel.excavRecord.data.excavMethodId != EXCAVMETHODID_STRATUM &&
							!upPanel.forceArchFindTab) {
						var win = Ext.create('Ext.window.Window', {
							title: Oger._('Warnung'),
							width: 100,
							height: 150,
							modal: true,
							autoScroll: true,
							layout: 'fit',

							items: [
								{ xtype: 'form',
									layout: 'fit',
									items: [
										{ xtype: 'textarea', readOnly: true, hideLabel: true,
											value: Oger._('Die Fund-Erfassung ist für Planum-Grabungen nicht implementiert.'),
										},
									],
								}
							],

							buttonAlign: 'center',
							buttons: [
								{ text: Oger._('Ok'),
									handler: function(button, event) {
										this.up('window').close();
									},
								},
								{ text: Oger._('Auf eigenes Risiko'),
									handler: function(button, event) {
										upPanel.forceArchFindTab = true;
										me.setActiveTab(newTab);
										upPanel.forceArchFindTab = false;
										this.up('window').close();
									},
								},
							],
						});
						win.show();
						return false;
					}  // eo planum + arch find

					// use excavation with planum method at own risk for arch finds
					if (newTab.itemId == 'stratumTab' && (upPanel.excavRecord.data.excavMethodId != EXCAVMETHODID_STRATUM &&
							!upPanel.forceStratumTab)) {
						var win = Ext.create('Ext.window.Window', {
							title: Oger._('Warnung'),
							width: 100,
							height: 150,
							modal: true,
							autoScroll: true,
							layout: 'fit',

							items: [
								{ xtype: 'form',
									layout: 'fit',
									items: [
										{ xtype: 'textarea', readOnly: true, hideLabel: true,
											value: Oger._('Eine Stratum-Erfassung ist für Planum-Grabungen nicht vorgesehen.'),
										},
									],
								}
							],

							buttonAlign: 'center',
							buttons: [
								{ text: Oger._('Ok'),
									handler: function(button, event) {
										this.up('window').close();
									},
								},
								{ text: Oger._('Auf eigenes Risiko'),
									handler: function(button, event) {
										upPanel.forceStratumTab = true;
										me.setActiveTab(newTab);
										upPanel.forceStratumTab = false;
										this.up('window').close();
									},
								},
							],
						});
						win.show();
						return false;
					}  // eo planum + stratum

					return true;
				},
			},  // eo listeners
		},  // eo tabpanel
	],

	listeners: {
		beforerender: function(cmp, options) {
			cmp.onBeforeRenderInputCenterPanel(cmp, options);
		},
	},  // eo listeners


	// ###########################################################


	// before render top panel
	onBeforeRenderInputCenterPanel: function(cmp, opts) {

		var me = this;

		// --
		cmp.down('ic_excavationgrid').gluePanel = cmp;
		cmp.down('ic_archfindgrid').gluePanel = cmp;
		cmp.down('ic_stratumgrid').gluePanel = cmp;
		cmp.down('ic_qmatrixgrid').gluePanel = cmp;
		cmp.down('ic_archobjectgrid').gluePanel = cmp;
		cmp.down('ic_archobjgroupgrid').gluePanel = cmp;

		// --

		me.createLookUpStores(cmp, opts);

	},  // eo before render

	// create look-up stores
	createLookUpStores: function(cmp, opts) {

		// --
		cmp.stratumCategoryStore = Ext.create('App.store.StratumCategories');
		cmp.stratumCategoryStore.load({ params: { start: 0, limit: 0 } });

		// --
		cmp.filteredStratumTypeStore = Ext.create('App.store.StratumTypes');

		// --
		cmp.stratumTypeStore = Ext.create('App.store.StratumTypes');
		cmp.stratumTypeStore.load({ params: { start: 0, limit: 0 } });

		// --
		cmp.datingPeriodStore = Ext.create('App.store.DatingPeriods');
		cmp.datingPeriodStore.load({ params: { start: 0, limit: 0 } });


		// -- wall
		cmp.wallConstructionTypeStore = Ext.create('App.store.GenericTypes');
		cmp.wallConstructionTypeStore.load({ url: 'php/scripts/wallConstructionType.php?_action=loadList' });
		cmp.wallStructureTypeStore = Ext.create('App.store.GenericTypes');
		cmp.wallStructureTypeStore.load({ url: 'php/scripts/wallStructureType.php?_action=loadList' });
		cmp.wallBaseTypeStore = Ext.create('App.store.GenericTypes');
		cmp.wallBaseTypeStore.load({ url: 'php/scripts/wallBaseType.php?_action=loadList' });
		cmp.wallMaterialTypeStore = Ext.create('App.store.GenericTypes');
		cmp.wallMaterialTypeStore.load({ url: 'php/scripts/wallMaterialType.php?_action=loadList' });
		cmp.wallBinderTypeStore = Ext.create('App.store.GenericTypes');
		cmp.wallBinderTypeStore.load({ url: 'php/scripts/wallBinderType.php?_action=loadList' });
		cmp.wallBinderStateStore = Ext.create('App.store.GenericTypes');
		cmp.wallBinderStateStore.load({ url: 'php/scripts/wallBinderState.php?_action=loadList' });
		cmp.wallBinderConsistencyStore = Ext.create('App.store.GenericTypes');
		cmp.wallBinderConsistencyStore.load({ url: 'php/scripts/wallBinderConsistency.php?_action=loadList' });
		cmp.wallBinderGrainSizeStore = Ext.create('App.store.GenericTypes');
		cmp.wallBinderGrainSizeStore.load({ url: 'php/scripts/wallBinderGrainSize.php?_action=loadList' });
		cmp.wallAbreuvoirTypeStore = Ext.create('App.store.GenericTypes');
		cmp.wallAbreuvoirTypeStore.load({ url: 'php/scripts/wallAbreuvoirType.php?_action=loadList' });
		cmp.wallPlasterSurfaceStore = Ext.create('App.store.GenericTypes');
		cmp.wallPlasterSurfaceStore.load({ url: 'php/scripts/wallPlasterSurface.php?_action=loadList' });
		cmp.wallLengthApplyToStore = Ext.create('App.store.GenericTypes');
		cmp.wallLengthApplyToStore.load({ url: 'php/scripts/wallSizeApplyToType.php?_action=loadList' });
		cmp.wallWidthApplyToStore = Ext.create('App.store.GenericTypes');
		cmp.wallWidthApplyToStore.load({ url: 'php/scripts/wallSizeApplyToType.php?_action=loadList' });
		cmp.wallHeightApplyToStore = Ext.create('App.store.GenericTypes');
		cmp.wallHeightApplyToStore.load({ url: 'php/scripts/wallSizeApplyToType.php?_action=loadList' });
		cmp.wallHeightRaisingApplyToStore = Ext.create('App.store.GenericTypes');
		cmp.wallHeightRaisingApplyToStore.load({ url: 'php/scripts/wallSizeApplyToType.php?_action=loadList' });
		cmp.wallHeightFootingApplyToStore = Ext.create('App.store.GenericTypes');
		cmp.wallHeightFootingApplyToStore.load({ url: 'php/scripts/wallSizeApplyToType.php?_action=loadList' });

		// -- timber
		/*
		// we use the same fields and stores as for wall
		// (including wallHeightApplyToStore which does not realy exist for wall and is only faked for timber)
		cmp.timberLengthApplyToStore = Ext.create('App.store.GenericTypes');
		cmp.timberLengthApplyToStore.load({ url: 'php/scripts/wallSizeApplyToType.php?_action=loadList' });
		cmp.timberWidthApplyToStore = Ext.create('App.store.GenericTypes');
		cmp.timberWidthApplyToStore.load({ url: 'php/scripts/wallSizeApplyToType.php?_action=loadList' });
		cmp.timberHeightApplyToStore = Ext.create('App.store.GenericTypes');
		cmp.timberHeightApplyToStore.load({ url: 'php/scripts/wallSizeApplyToType.php?_action=loadList' });
		*/

		// -- skeleton
		//cmp.skeletonXyzTypeStore.proxy.url = 'php/scripts/skeletonSexType.php?_action=loadList';
		//cmp.skeletonXyzTypeStore.load();
		cmp.skeletonBodyPositionTypeStore = Ext.create('App.store.GenericTypes');
		cmp.skeletonBodyPositionTypeStore.load({ url: 'php/scripts/skeletonBodyPositionType.php?_action=loadList' });
		cmp.skeletonArmPositionTypeStore = Ext.create('App.store.GenericTypes');
		cmp.skeletonArmPositionTypeStore.load({ url: 'php/scripts/skeletonArmPositionType.php?_action=loadList' });
		cmp.skeletonLegPositionTypeStore = Ext.create('App.store.GenericTypes');
		cmp.skeletonLegPositionTypeStore.load({ url: 'php/scripts/skeletonLegPositionType.php?_action=loadList' });
		cmp.skeletonBoneQualityTypeStore = Ext.create('App.store.GenericTypes');
		cmp.skeletonBoneQualityTypeStore.load({ url: 'php/scripts/skeletonBoneQualityType.php?_action=loadList' });
		cmp.skeletonSexTypeStore = Ext.create('App.store.GenericTypes');
		cmp.skeletonSexTypeStore.load({ url: 'php/scripts/skeletonSexType.php?_action=loadList' });
		cmp.skeletonGenderTypeStore = Ext.create('App.store.GenericTypes');
		cmp.skeletonGenderTypeStore.load({ url: 'php/scripts/skeletonSexType.php?_action=loadList' });  // reuse sex types
		cmp.skeletonAgeTypeStore = Ext.create('App.store.GenericTypes');
		cmp.skeletonAgeTypeStore.load({ url: 'php/scripts/skeletonAgeType.php?_action=loadList' });
		cmp.skeletonBurialCremationTypeStore = Ext.create('App.store.GenericTypes');
		cmp.skeletonBurialCremationTypeStore.load({ url: 'php/scripts/skeletonBurialCremationType.php?_action=loadList' });
		cmp.skeletonTombDemageFormTypeStore = Ext.create('App.store.GenericTypes');
		cmp.skeletonTombDemageFormTypeStore.load({ url: 'php/scripts/skeletonTombDemageFormType.php?_action=loadList' });

	},  // eo create look-up stores

	// activate arch find grid
	activateArchFindGrid: function(cmp, options) {
		var grid = cmp.down('grid');
		var inputCenterPanel = cmp.up('inputcenterpanel');
		if (inputCenterPanel.excavRecord && grid.excavId != inputCenterPanel.excavRecord.data.id) {
			grid.excavId = inputCenterPanel.excavRecord.data.id;
			var store = grid.getStore();
			store.clearFilter(true);
			store.filter('excavId', grid.excavId);
		}
	},  // eo activate arch find grid

	// activate stratum overview grid
	activateStratumGrid: function(cmp, options) {
		var grid = cmp.down('grid');
		var inputCenterPanel = cmp.up('inputcenterpanel');
		if (inputCenterPanel.excavRecord && grid.excavId != inputCenterPanel.excavRecord.data.id) {
			// load store for stratum grid
			grid.excavId = inputCenterPanel.excavRecord.data.id;
			var store = grid.getStore();
			store.clearFilter(true);
			store.filter('excavId', grid.excavId);
			// load stores for field histories (interface)
			inputCenterPanel.loadFieldHistoryStore('stratum', STRATUMCATEGORYID_INTERFACE, 'shape');
			inputCenterPanel.loadFieldHistoryStore('stratum', STRATUMCATEGORYID_INTERFACE, 'contour');
			inputCenterPanel.loadFieldHistoryStore('stratum', STRATUMCATEGORYID_INTERFACE, 'vertex');
			inputCenterPanel.loadFieldHistoryStore('stratum', STRATUMCATEGORYID_INTERFACE, 'sidewall');
			inputCenterPanel.loadFieldHistoryStore('stratum', STRATUMCATEGORYID_INTERFACE, 'intersection');
			inputCenterPanel.loadFieldHistoryStore('stratum', STRATUMCATEGORYID_INTERFACE, 'basis');
			// load stores for field histories (stratum)
			inputCenterPanel.loadFieldHistoryStore('stratum', STRATUMCATEGORYID_DEPOSIT, 'color');
			inputCenterPanel.loadFieldHistoryStore('stratum', STRATUMCATEGORYID_DEPOSIT, 'materialDenotation');
			inputCenterPanel.loadFieldHistoryStore('stratum', STRATUMCATEGORYID_DEPOSIT, 'hardness');
			inputCenterPanel.loadFieldHistoryStore('stratum', STRATUMCATEGORYID_DEPOSIT, 'consistency');
			inputCenterPanel.loadFieldHistoryStore('stratum', STRATUMCATEGORYID_DEPOSIT, 'inclusion');
			inputCenterPanel.loadFieldHistoryStore('stratum', STRATUMCATEGORYID_DEPOSIT, 'orientation');
			inputCenterPanel.loadFieldHistoryStore('stratum', STRATUMCATEGORYID_DEPOSIT, 'incline');
		}
	},  // eo activate stratum grid

	// activate qmatrix overview grid
	activateQmatrixGrid: function(cmp, options) {
		var grid = cmp.down('grid');
		var inputCenterPanel = cmp.up('inputcenterpanel');
		if (inputCenterPanel.excavRecord && grid.excavId != inputCenterPanel.excavRecord.data.id) {
			// load store for stratum grid
			grid.excavId = inputCenterPanel.excavRecord.data.id;
			var store = grid.getStore();
			store.clearFilter(true);
			store.filter('excavId', grid.excavId);
			// empty docked form
			grid.newRecord();
		}
	},  // eo activate qmatrix grid

	// activate arch object grid
	activateArchObjectGrid: function(cmp, options) {
		var grid = cmp.down('grid');
		var inputCenterPanel = cmp.up('inputcenterpanel');
		if (inputCenterPanel.excavRecord && grid.excavId != inputCenterPanel.excavRecord.data.id) {
			grid.excavId = inputCenterPanel.excavRecord.data.id;
			var store = grid.getStore();
			store.clearFilter(true);
			store.filter('excavId', grid.excavId);
			cmp.down('pagingtoolbar').moveFirst();  // local filter do not call load TODO remove when remote
		}
	},  // eo activate arch object grid


	// activate arch object group grid
	activateArchObjGroupGrid: function(cmp, options) {
		var grid = cmp.down('grid');
		var inputCenterPanel = cmp.up('inputcenterpanel');
		if (inputCenterPanel.excavRecord && grid.excavId != inputCenterPanel.excavRecord.data.id) {
			grid.excavId = inputCenterPanel.excavRecord.data.id;
			var store = grid.getStore();
			store.clearFilter(true);
			store.filter('excavId', grid.excavId);
			cmp.down('pagingtoolbar').moveFirst();  // local filter do not call load TODO remove when remote
		}
	},  // eo activate arch object group grid

/*
	// activate find catalog grid
	activateFindCatalogGrid: function(cmp, options) {
		var grid = cmp.down('grid');
		var inputCenterPanel = cmp.up('inputcenterpanel');
		if (inputCenterPanel.excavRecord && grid.excavId != inputCenterPanel.excavRecord.data.id) {
			grid.excavId = inputCenterPanel.excavRecord.data.id;
			var store = grid.getStore();
			store.filter('excavId', grid.excavId);
		}
	},  // eo activate find catalog grid
*/


	// #########################################################


	// load field history store
	loadFieldHistoryStore: function(section, category, field) {

		var me = this;

		if (!me.fieldHistoryStore) {
			me.fieldHistoryStore = {};
		}
		if (!me.fieldHistoryStore[section]) {
			me.fieldHistoryStore[section] = {};
		}
		if (!me.fieldHistoryStore[section][category]) {
			me.fieldHistoryStore[section][category] = {};
		}
		if (!me.fieldHistoryStore[section][category][field]) {
			me.fieldHistoryStore[section][category][field] = null;
		}

		var action = '';
		var url = '';
		if (section == 'stratum') {
			action = 'loadFieldHistory';
			url = 'php/scripts/stratum.php';
		}

		me.fieldHistoryStore[section][category][field] = Ext.create('App.store.FieldHistories');
		me.fieldHistoryStore[section][category][field].load({
			url: url,
			params: { _action: action, excavId: me.excavRecord.data.id,
								categoryId: category, fieldName: field },
		});


	},  // eo load field history store


	// get field history store
	getFieldHistoryStore: function(section, category, field) {

		var me = this;

		if (!me.fieldHistoryStore || !me.fieldHistoryStore[section] ||
				!me.fieldHistoryStore[section][category] || !me.fieldHistoryStore[section][category][field]) {
			return;
		}

		return me.fieldHistoryStore[section][category][field];
	},  // eo get field history store





});
