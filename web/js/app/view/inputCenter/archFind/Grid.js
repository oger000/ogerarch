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
Ext.define('App.view.inputCenter.archFind.Grid', {
	extend: 'Ext.grid.Panel',
	alias: 'widget.ic_archfindgrid',

	stripeRows: true,
	columnLines: true,
	autoScroll: true,

	sortableColumns: true,
	store: { type: 'archFind', remoteSort: true, remoteFilter: true },

	columns: [
		{ header: Oger._('Gr'), dataIndex: 'excavId', width: 30, hidden: true, ogerHidden: true },
		{ header: Oger._('Grabung'), dataIndex: 'excavName', hidden: true, ogerHidden: true },
		{ header: Oger._('Nummer'), dataIndex: 'archFindId', width: 50 },   // , locked: true
		{ header: Oger._('Stratum'), dataIndex: 'stratumIdList', width: 90, align: 'center' },
		{ header: Oger._('Datum'), xtype: 'datecolumn', dataIndex: 'date', width: 70 },

		{ header: Oger._('Interpretation'), dataIndex: 'interpretation', hidden: true, ogerHidden: true },
		{ header: Oger._('Datierung'), dataIndex: 'datingSpec', hidden: true, ogerHidden: true },
		{ header: Oger._('Periode'), dataIndex: 'datingPeriodId', hidden: true, ogerHidden: true },
		{ header: Oger._('Plan'), dataIndex: 'planName', hidden: true, ogerHidden: true },

		{ header: Oger._('Grst'), dataIndex: 'plotName', hidden: true, ogerHidden: true },
		{ header: Oger._('Flur'), dataIndex: 'fieldName', hidden: true, ogerHidden: true },
		{ header: Oger._('Schnitt'), dataIndex: 'section', hidden: true, ogerHidden: true },
		{ header: Oger._('Fläche'), dataIndex: 'area', hidden: true, ogerHidden: true },
		{ header: Oger._('Profil'), dataIndex: 'profile', hidden: true, ogerHidden: true },
		{ header: Oger._('Streu'), dataIndex: 'isStrayFind', hidden: true, ogerHidden: true },
		{ header: Oger._('Abtief'), dataIndex: 'atStepLowering', hidden: true, ogerHidden: true },
		{ header: Oger._('GrobPu'), dataIndex: 'atStepCleaningRaw', hidden: true, ogerHidden: true },
		{ header: Oger._('FreinPu'), dataIndex: 'atStepCleaningFine', hidden: true, ogerHidden: true },
		{ header: Oger._('SoArb'), dataIndex: 'atStepOther', hidden: true, ogerHidden: true },

		{ header: Oger._('Interface'), dataIndex: 'interfaceIdList', hidden: true, ogerHidden: true },
		{ header: Oger._('Objekt'), dataIndex: 'archObjectIdList', hidden: true, ogerHidden: true },
		{ header: Oger._('ObjGrp'), dataIndex: 'archObjGroupIdList', hidden: true, ogerHidden: true },

		{ header: Oger._('Sonderfund'), dataIndex: 'specialArchFind', width: 150 },
		{ header: Oger._('KER'), dataIndex: 'ceramicsCountId', width: 40, sortable: true },
		{ header: Oger._('TKN'), dataIndex: 'animalBoneCountId', width: 40 },
		{ header: Oger._('HOMO'), dataIndex: 'humanBoneCountId', width: 40 },
		{ header: Oger._('FE'), dataIndex: 'ferrousCountId', width: 40 },
		{ header: Oger._('BMET'), dataIndex: 'nonFerrousMetalCountId', width: 40 },
		{ header: Oger._('GLAS'), dataIndex: 'glassCountId', width: 40 },
		{ header: Oger._('BAUK'), dataIndex: 'architecturalCeramicsCountId', width: 40 },
		{ header: Oger._('HL'), dataIndex: 'daubCountId', width: 40 },
		{ header: Oger._('ST'), dataIndex: 'stoneCountId', width: 40 },
		{ header: Oger._('SIL'), dataIndex: 'silexCountId', width: 40 },
		{ header: Oger._('MÖR'), dataIndex: 'mortarCountId', width: 40 },
		{ header: Oger._('HOLZ'), dataIndex: 'timberCountId', width: 40 },
		{ header: Oger._('Organisches'), dataIndex: 'organic', width: 150, hidden: true, ogerHidden: true },
		{ header: Oger._('Sonst. Funde'), dataIndex: 'archFindOther', width: 150, hidden: true, ogerHidden: true },

		{ header: Oger._('Sedi'), dataIndex: 'sedimentSampleCountId', width: 40 },
		{ header: Oger._('Schlä'), dataIndex: 'slurrySampleCountId', width: 40 },
		{ header: Oger._('Holzk'), dataIndex: 'charcoalSampleCountId', width: 40 },
		{ header: Oger._('Mört'), dataIndex: 'mortarSampleCountId', width: 40 },
		{ header: Oger._('Schla'), dataIndex: 'slagSampleCountId', width: 40 },
		{ header: Oger._('Sonst. Proben'), dataIndex: 'sampleOther', width: 150, hidden: true, ogerHidden: true },

		{ header: Oger._('Bemerkungen'), dataIndex: 'comment', hidden: true, ogerHidden: true },
	],


	// filter panel at the top
	tbar: {
		xtype: 'form', //layout: 'hbox',
		height: 130, //width: 300,
		border: false,
		collapsible: true,
		collapsed: true,
		autoScroll: true,
		bodyStyle: 'background-color:#d3e1f1',
		title: Oger._('Filter'),
		layout: {
			type: 'vbox',
			align : 'stretch',
			pack  : 'start',
		},
		items: [
			{ xtype: 'panel',
				border: false,
				layout: 'column',
				items: [
					{ xtype: 'panel', layout: 'anchor',
						bodyPadding: 5, border: false,
						bodyStyle: 'background-color:#d3e1f1',
						items: [
							{ name: 'hasCeramics', xtype: 'checkbox', boxLabel: Oger._('Keramik'),
								inputValue: 1,
								checkChangeBuffer: CHKCHANGE_DEFER,
								listeners: {
									change: function(cmp, newValue, oldValue, opts) {
										cmp.up('form').doFilter();
									}
								},
							},
							{ name: 'hasAnimalBone', xtype: 'checkbox', boxLabel: Oger._('Tierknochen'),
								inputValue: 1,
								checkChangeBuffer: CHKCHANGE_DEFER,
								listeners: {
									change: function(cmp, newValue, oldValue, opts) {
										cmp.up('form').doFilter();
									}
								},
							},
							{ name: 'hasHumanBone', xtype: 'checkbox', boxLabel: Oger._('Menschenknochen'),
								inputValue: 1,
								checkChangeBuffer: CHKCHANGE_DEFER,
								listeners: {
									change: function(cmp, newValue, oldValue, opts) {
										cmp.up('form').doFilter();
									}
								},
							},
						],
					},  // eo column
					{ xtype: 'panel', layout: 'anchor',
						bodyPadding: 5, border: false,
						bodyStyle: 'background-color:#d3e1f1',
						items: [
							{ name: 'hasFerrous', xtype: 'checkbox', boxLabel: Oger._('Eisen'),
								inputValue: 1,
								checkChangeBuffer: CHKCHANGE_DEFER,
								listeners: {
									change: function(cmp, newValue, oldValue, opts) {
										cmp.up('form').doFilter();
									}
								},
							},
							{ name: 'hasNonFerrousMetal', xtype: 'checkbox', boxLabel: Oger._('Buntmetal'),
								inputValue: 1,
								checkChangeBuffer: CHKCHANGE_DEFER,
								listeners: {
									change: function(cmp, newValue, oldValue, opts) {
										cmp.up('form').doFilter();
									}
								},
							},
							{ name: 'hasGlass', xtype: 'checkbox', boxLabel: Oger._('Glas'),
								inputValue: 1,
								checkChangeBuffer: CHKCHANGE_DEFER,
								listeners: {
									change: function(cmp, newValue, oldValue, opts) {
										cmp.up('form').doFilter();
									}
								},
							},
						],
					},  // eo column
					{ xtype: 'panel', layout: 'anchor',
						bodyPadding: 5, border: false,
						bodyStyle: 'background-color:#d3e1f1',
						items: [
							{ name: 'hasArchitecturalCeramics', xtype: 'checkbox', boxLabel: Oger._('Baukeramik'),
								inputValue: 1,
								checkChangeBuffer: CHKCHANGE_DEFER,
								listeners: {
									change: function(cmp, newValue, oldValue, opts) {
										cmp.up('form').doFilter();
									}
								},
							},
							{ name: 'hasDaub', xtype: 'checkbox', boxLabel: Oger._('Hüttenlehm'),
								inputValue: 1,
								checkChangeBuffer: CHKCHANGE_DEFER,
								listeners: {
									change: function(cmp, newValue, oldValue, opts) {
										cmp.up('form').doFilter();
									}
								},
							},
							{ name: 'hasStone', xtype: 'checkbox', boxLabel: Oger._('Stein'),
								inputValue: 1,
								checkChangeBuffer: CHKCHANGE_DEFER,
								listeners: {
									change: function(cmp, newValue, oldValue, opts) {
										cmp.up('form').doFilter();
									}
								},
							},
						],
					},  // eo column
					{ xtype: 'panel', layout: 'anchor',
						bodyPadding: 5, border: false,
						bodyStyle: 'background-color:#d3e1f1',
						items: [
							{ name: 'hasSilex', xtype: 'checkbox', boxLabel: Oger._('Silex'),
								inputValue: 1,
								checkChangeBuffer: CHKCHANGE_DEFER,
								listeners: {
									change: function(cmp, newValue, oldValue, opts) {
										cmp.up('form').doFilter();
									}
								},
							},
							{ name: 'hasMortar', xtype: 'checkbox', boxLabel: Oger._('Mörtel'),
								inputValue: 1,
								checkChangeBuffer: CHKCHANGE_DEFER,
								listeners: {
									change: function(cmp, newValue, oldValue, opts) {
										cmp.up('form').doFilter();
									}
								},
							},
							{ name: 'hasTimber', xtype: 'checkbox', boxLabel: Oger._('Holz'),
								inputValue: 1,
								checkChangeBuffer: CHKCHANGE_DEFER,
								listeners: {
									change: function(cmp, newValue, oldValue, opts) {
										cmp.up('form').doFilter();
									}
								},
							},
						],
					},  // eo column
					{ xtype: 'panel', layout: 'anchor',
						bodyPadding: 5, border: false,
						bodyStyle: 'background-color:#d3e1f1',
						items: [
							{ name: 'hasSedimentSample', xtype: 'checkbox', boxLabel: Oger._('Sedimentprobe'),
								inputValue: 1,
								checkChangeBuffer: CHKCHANGE_DEFER,
								listeners: {
									change: function(cmp, newValue, oldValue, opts) {
										cmp.up('form').doFilter();
									}
								},
							},
							{ name: 'hasSlurrySample', xtype: 'checkbox', boxLabel: Oger._('Schlämmprobe'),
								inputValue: 1,
								checkChangeBuffer: CHKCHANGE_DEFER,
								listeners: {
									change: function(cmp, newValue, oldValue, opts) {
										cmp.up('form').doFilter();
									}
								},
							},
							{ name: 'hasCharcoalSample', xtype: 'checkbox', boxLabel: Oger._('Holzkohleprobe'),
								inputValue: 1,
								checkChangeBuffer: CHKCHANGE_DEFER,
								listeners: {
									change: function(cmp, newValue, oldValue, opts) {
										cmp.up('form').doFilter();
									}
								},
							},
						],
					},  // eo column
					{ xtype: 'panel', layout: 'anchor',
						bodyPadding: 5, border: false,
						bodyStyle: 'background-color:#d3e1f1',
						items: [
							{ name: 'hasMortarSample', xtype: 'checkbox', boxLabel: Oger._('Mörtelprobe'),
								inputValue: 1,
								checkChangeBuffer: CHKCHANGE_DEFER,
								listeners: {
									change: function(cmp, newValue, oldValue, opts) {
										cmp.up('form').doFilter();
									}
								},
							},
							{ name: 'hasSlagSample', xtype: 'checkbox', boxLabel: Oger._('Schlackeprobe'),
								inputValue: 1,
								checkChangeBuffer: CHKCHANGE_DEFER,
								listeners: {
									change: function(cmp, newValue, oldValue, opts) {
										cmp.up('form').doFilter();
									}
								},
							},
							{ name: 'hasSampleOther', xtype: 'checkbox', boxLabel: Oger._('Sonst. Proben'),
								inputValue: '',
								checkChangeBuffer: CHKCHANGE_DEFER,
								listeners: {
									change: function(cmp, newValue, oldValue, opts) {
										cmp.up('form').doFilter();
									}
								},
							},
						],
					},  // eo column
					{ xtype: 'panel', layout: 'anchor',
						//bodyPadding: 5,
						border: false,
						columnWidth: 1,  bodyPadding: '5 0 5 5', // UGLY HACK to fill remaining space
						bodyStyle: 'background-color:#d3e1f1',
						items: [
							{ name: 'hasSpecialArchFind', xtype: 'checkbox', boxLabel: Oger._('Sonderfund'),
								inputValue: '',
								checkChangeBuffer: CHKCHANGE_DEFER,
								listeners: {
									change: function(cmp, newValue, oldValue, opts) {
										cmp.up('form').doFilter();
									}
								},
							},
							{ name: 'hasOrganic', xtype: 'checkbox', boxLabel: Oger._('Organisches'),
								inputValue: '',
								checkChangeBuffer: CHKCHANGE_DEFER,
								listeners: {
									change: function(cmp, newValue, oldValue, opts) {
										cmp.up('form').doFilter();
									}
								},
							},
							{ name: 'hasArchFindOther', xtype: 'checkbox', boxLabel: Oger._('Sonst. Funde'),
								inputValue: '',
								checkChangeBuffer: CHKCHANGE_DEFER,
								listeners: {
									change: function(cmp, newValue, oldValue, opts) {
										cmp.up('form').doFilter();
									}
								},
							},
						],
					},  // eo column

					/*
					// fill remaining space
					{ xtype: 'panel', layout: 'fit',
						bodyPadding: 0, border: false,
						bodyStyle: 'background-color:#d3e1f1',
						columnWidth: 1,  // fill remaining space
						items: [
							{ xtype: 'displayfield', value: '' },
							{ xtype: 'displayfield', value: '', fieldLabel: ' ' },
						],
					},  // eo column
					*/


				],
			},  // eo checkbox panel

			{ xtype: 'panel', layout: 'anchor',
				bodyPadding: '0 5 5 5', border: false,
				bodyStyle: 'background-color:#d3e1f1',
				items: [
					{ name: 'searchText', xtype: 'textfield', width: 350,
						fieldLabel: Oger._('Textsuche'), labelWidth: 80,
						checkChangeBuffer: CHKCHANGE_DEFER,
						listeners: {
							change: function(cmp, newValue, oldValue, opts) {
								cmp.up('form').doFilter();
							}
						},
					},
					/*
					{ name: 'showAllColumns', xtype: 'checkbox', boxLabel: Oger._('Alle Spalten (Bitte Geduld)'),
						inputValue: 1, uncheckedValue: 0,
						//checkChangeBuffer: CHKCHANGE_DEFER,
						listeners: {
							change: function(cmp, newValue, oldValue, opts) {
								if (newValue != oldValue) {
									var grid = cmp.up('grid');
									//--Ext.suspendLayouts();
									for (var i = 0; i < grid.columns.length; i++) {
										var col = grid.columns[i];
										if (newValue == 1) {
											col.hidden = false;
											//if (!col.isVisible()) {
											//  col.show(); // slow
											//}
										}
										else {
											col.hidden = false;
											if (col.ogerHidden) {
												col.hidden = col.ogerHidden;
											}
											//if (col.isVisible() && col.ogerHidden) {
											//  col.hide(); // slow
											//}
										}
									}  // column loop
									// doLayout();
									//grid.getView().refresh();
									//grid.updateLayout(); grid.down('headercontainer').updateLayout();
									//var gridJCols = Ext.JSON.encode(grid.columns);
									//grid.reconfigure(grid.getStore(), Ext.JSON.decode(gridJCols));
									//grid.reconfigure(null, Ext.JSON.decode(gridJCols));
									//grid.reconfigure(null, Ext.JSON.decode(gridJCols));
									//grid.headerCt.updateLayout();
									//--Ext.resumeLayouts(true);
								}
							}
						},
					},
					*/
				],
			},  // eo text
		],  // eo outer form items

		doFilter: function() {
			var form = this;
			var grid = form.up('grid');
			var store = grid.getStore();
			//var excavId = grid.gluePanel.excavRecord.data.id
			store.clearFilter(true);
			var filterArr = [];
			filterArr.push({ property: 'excavId', value: grid.excavId });
			var vals = form.getForm().getValues();
			if (vals['searchText']) {
				vals['searchText'] = '%' + vals['searchText'] + '%';
			}
			for (var prop in vals) {
				filterArr.push({ property: prop, value: vals[prop] });
			}
			store.filter(filterArr);
		},  // eo do filter

	},  // eo form (tbar)

	// paging bar on the bottom
	bbar: {
		xtype: 'pagingtoolbar',
		displayInfo: true,
		items: [
			'-',
			{ text: 'Erfassen',
				handler: function() {
					this.up('panel').editRecord();
				}
			},
			'-',
			{ text: 'Stapeldruck',
				handler: function() {
					this.up('panel').multiPrintFindSheet();
				}
			},
			'-',
			{ text: 'Umbenennen',
				handler: function() {
					this.up('panel').renameRecord();
				}
			},
			'-',
			{ text: 'Löschen',
				handler: function() {
					this.up('panel').deleteRecord();
				}
			},
		]
	},

	listeners: {
		render: function(cmp, options) {
			cmp.down('pagingtoolbar').bindStore(this.getStore());
		},
		itemdblclick: function(view, record, item, index, event, options) {
			this.editRecord(record.data.archFindId);
		},
		afterrender: function (cmp, opts) {
			/*
			 * this would be nice, but extra menu items get lost
			 * after show all columns
			 * maybe we can reassign afgter resumelayout (or reconfigure grid)
			var menu = cmp.headerCt.getMenu();
			menu.add([
				{ text: Oger._('Alle Spalten'),
					handler: function () {
						Ext.suspendLayouts();
						Ext.each(cmp.headerCt.getGridColumns(), function (column) {
							column.show();
						});
						Ext.resumeLayouts(true);
					},
				},
			]);
			menu.add([
				{ text: Oger._('Standard Spalten'),
					handler: function () {
						Ext.suspendLayouts();
						Ext.each(cmp.headerCt.getGridColumns(), function (column) {
							if (column.ogerHidden) {
								column.hide();
							}
						});
						Ext.resumeLayouts(true);
					},
				},
			]);
			*/
		},  // eo afterrender
	},  // eo listeners


	// ##################################################

	// unprinted queue for arch find sheets
	unprintQueue: [],

	// find position of unprinted arch find sheet
	unprintQueueAt: function(archFindId) {
		for (var i=0; i< this.unprintQueue.length; i++) {
			if (this.unprintQueue[i] == archFindId) {
				return i;
			}
		}
		return -1;
	},

	// remove arch find id from unprinted queue
	unprintQueueRemove: function(archFindId) {
		var pos = this.unprintQueueAt(archFindId);
		if (pos > -1) {
			this.unprintQueue.splice(pos, 1);
		}
	},

	// edit current record or add new  if none selected
	'editRecord': function(archFindId) {
		var me = this;
		if (!archFindId) {
			var record = me.getSelectionModel().getSelection()[0];
			if (record) {
				archFindId = record.data.archFindId;
			}
		}

		// show existing window if present
		var win = Ext.ComponentQuery.query('ic_archfindwindow')[0];
		if (!win) {
			win = Ext.create('App.view.inputCenter.archFind.Window');
			win.assignedGrid = me;
			win.gluePanel = me.gluePanel;
		}

		win.show();

		if (!Oger.extjs.formIsDirty(win.down('form').getForm())) {
			if (archFindId) {
				win.editRecord(archFindId);
			}
			else {
				win.newRecord();
			}
		}
	},  // eo edit record


	// print multiple arch find sheets
	multiPrintFindSheet: function() {
		var me = this;
		var win = Ext.create('App.view.inputCenter.archFind.MultiPrintWindow');
		win.assignedGrid = me;
		win.down('form').getForm().findField('excavId').setValue(me.gluePanel.excavRecord.data.id);
		win.show();
	},  // eo multi print


	// rename current record
	'renameRecord': function() {
		var me = this;

		var editWin = Ext.ComponentQuery.query('ic_archfindwindow')[0];
		if (editWin) {
			Ext.Msg.alert(Oger._('Fehler'), Oger._('Bitte zuerst Fund Eingabefenster schliessen.'));
			return;
		}
		var record = me.getSelectionModel().getSelection()[0];
		if (!record) {
			Ext.Msg.alert(Oger._('Fehler'), Oger._('Bitte zuerst Fund aus der Liste auswählen.'));
			return;
		}

		// show rename window
		var win = Ext.create('App.view.inputCenter.archFind.RenameWindow');
		win.assignedGrid = me;
		win.record = record;
		win.show();

	},  // eo rename record


	// delete current record
	'deleteRecord': function() {
		var me = this;

		var editWin = Ext.ComponentQuery.query('ic_archfindwindow')[0];
		if (editWin) {
			Ext.Msg.alert(Oger._('Fehler'), Oger._('Bitte zuerst Fund Eingabefenster schliessen.'));
			return;
		}
		var record = me.getSelectionModel().getSelection()[0];
		if (!record) {
			Ext.Msg.alert(Oger._('Fehler'), Oger._('Bitte zuerst Fund aus der Liste auswählen.'));
			return;
		}

		// show delete window
		var win = Ext.create('App.view.inputCenter.archFind.DeleteWindow');
		win.assignedGrid = me;
		win.record = record;
		win.show();

	},  // eo delete record

});
