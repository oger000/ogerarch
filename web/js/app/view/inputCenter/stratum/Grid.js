/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/



/**
* Stratum grid
*/
Ext.define('App.view.inputCenter.stratum.Grid', {
	extend: 'Ext.grid.Panel',
	alias: 'widget.ic_stratumgrid',

	stripeRows: true,
	columnLines: true,
	autoScroll: true,

	sortableColumns: true,
	store: Ext.create('App.store.Stratums',
										{ remoteSort: true,
											remoteFilter: true,

										}),

	columns: [
		{ header: Oger._('Gr'), dataIndex: 'excavId', width: 30, hidden: true, ogerHidden: true },
		{ header: Oger._('Grabung'), dataIndex: 'excavName', hidden: true, ogerHidden: true },
		{ header: Oger._('Nummer'), dataIndex: 'stratumId', width: 50 },
		{ header: Oger._('Datum'), xtype: 'datecolumn', dataIndex: 'date', width: 70 },
		{ header: Oger._('Kategorie'), dataIndex: 'categoryName' },
		{ header: Oger._('Art/Bezeichnung'), dataIndex: 'typeName' },

		{ header: Oger._('BearbeiterIn'), dataIndex: 'originator', hidden: true, ogerHidden: true },
		{ header: Oger._('Grst'), dataIndex: 'plotName', hidden: true, ogerHidden: true },
		{ header: Oger._('Flur'), dataIndex: 'fieldName', hidden: true, ogerHidden: true },
		{ header: Oger._('Schnitt'), dataIndex: 'section', hidden: true, ogerHidden: true },
		{ header: Oger._('Fläche'), dataIndex: 'area', hidden: true, ogerHidden: true },
		{ header: Oger._('Profil'), dataIndex: 'profile', hidden: true, ogerHidden: true },

		// common 2
		{ header: Oger._('Interpretation'), dataIndex: 'interpretation', editor: 'textfield' },
		{ header: Oger._('Datierung'), dataIndex: 'datingSpec' },
		{ header: Oger._('Periode'), dataIndex: 'datingPeriodId', hidden: true, ogerHidden: true },

		{ header: Oger._('Fot.Dig'), dataIndex: 'photoDigital', hidden: true, ogerHidden: true },
		{ header: Oger._('Fotgram'), dataIndex: 'photogrammetry', hidden: true, ogerHidden: true },
		{ header: Oger._('Dia'), dataIndex: 'photoSlide', hidden: true, ogerHidden: true },
		{ header: Oger._('Fot.Papier'), dataIndex: 'photoPrint', hidden: true, ogerHidden: true },
		{ header: Oger._('PlanDig'), dataIndex: 'Digital', hidden: true, ogerHidden: true },
		{ header: Oger._('PlanPap'), dataIndex: 'Papier', hidden: true, ogerHidden: true },
		{ header: Oger._('Foto Dokumentation'), dataIndex: 'pictureReference', hidden: 0,
			editor: { xtype: 'textarea', height: 150 },  // width setting is ignored and derivated from column width
		},


		// common - more
		{ header: Oger._('Länge (cm)'), dataIndex: 'lengthvalue', hidden: true, ogerHidden: true },
		{ header: Oger._('Breite (cm)'), dataIndex: 'width', hidden: true, ogerHidden: true },
		{ header: Oger._('Höhe (cm)'), dataIndex: 'height', hidden: true, ogerHidden: true },
		{ header: Oger._('Durchm (cm)'), dataIndex: 'diameter', hidden: true, ogerHidden: true },

		{ header: Oger._('Fund vh'), dataIndex: 'hasArchFind', hidden: true, ogerHidden: true },
		{ header: Oger._('FundNr'), dataIndex: 'archFindIdList'  },
		{ header: Oger._('Probe vh'), dataIndex: 'hasSample', hidden: true, ogerHidden: true },
		{ header: Oger._('Obj vh'), dataIndex: 'hasArchObject', hidden: true, ogerHidden: true },
		{ header: Oger._('ObjNr'), dataIndex: 'archObjectIdList' },
		{ header: Oger._('ObjGrp vh'), dataIndex: 'hasArchObjGroup', hidden: true, ogerHidden: true },
		{ header: Oger._('Oberk'), dataIndex: 'isTopEdge', hidden: true, ogerHidden: true },
		{ header: Oger._('Unterk'), dataIndex: 'isBottomEdge', hidden: true, ogerHidden: true },
		{ header: Oger._('AutoIF'), dataIndex: 'hasAutoInterface', hidden: true, ogerHidden: true },

		{ header: Oger._('Anm.BDA-Liste'), dataIndex: 'listComment', hidden: true, ogerHidden: true },
		{ header: Oger._('Anmerkung'), dataIndex: 'comment', hidden: true, ogerHidden: true },


		// matrix
		{ header: Oger._('Älter als (unter)'), dataIndex: 'earlierThanIdList', hidden: true, ogerHidden: true },
		{ header: Oger._('Jünger als (über)'), dataIndex: 'reverseEarlierThanIdList', hidden: true, ogerHidden: true },
		{ header: Oger._('Ist ident mit'), dataIndex: 'equalToIdList', hidden: true, ogerHidden: true },
		{ header: Oger._('Zeitgleich mit'), dataIndex: 'contempWithIdList', hidden: true, ogerHidden: true },


		// detail - deposit
		{ header: Oger._('Farbe'), dataIndex: 'color', hidden: true, ogerHidden: true },
		{ header: Oger._('Mat.Ansprache'), dataIndex: 'materialDenotation', hidden: true, ogerHidden: true },
		{ header: Oger._('Konsistenz'), dataIndex: 'consistency', hidden: true, ogerHidden: true },
		{ header: Oger._('Einschlüsse'), dataIndex: 'inclusion', hidden: true, ogerHidden: true },
		{ header: Oger._('Härte'), dataIndex: 'hardness', hidden: true, ogerHidden: true },
		{ header: Oger._('Ausrichtung'), dataIndex: 'DEPOSIT___orientation', hidden: true, ogerHidden: true },
		{ header: Oger._('Gefälle'), dataIndex: 'incline', hidden: true, ogerHidden: true },

		// detail - interface
		{ header: Oger._('Form'), dataIndex: 'shape', hidden: true, ogerHidden: true },
		{ header: Oger._('Kontur'), dataIndex: 'contour', hidden: true, ogerHidden: true },
		{ header: Oger._('Ecken'), dataIndex: 'vertex', hidden: true, ogerHidden: true },
		{ header: Oger._('Seiten'), dataIndex: 'sidewall', hidden: true, ogerHidden: true },
		{ header: Oger._('Seitenübergang'), dataIndex: 'intersection', hidden: true, ogerHidden: true },
		{ header: Oger._('Basis'), dataIndex: 'basis', hidden: true, ogerHidden: true },

		// detail - wall/common
		{ header: Oger._('Stratigrafie'), dataIndex: 'datingStratigraphy', hidden: true, ogerHidden: true },
		{ header: Oger._('Struktur'), dataIndex: 'datingWallStructure', hidden: true, ogerHidden: true },
		/*
		{ header: Oger._('FotDig'), dataIndex: 'photoDigital', hidden: true, ogerHidden: true },
		{ header: Oger._('FotDig'), dataIndex: 'photoDigital', hidden: true, ogerHidden: true },
		{ header: Oger._('FotDig'), dataIndex: 'photoDigital', hidden: true, ogerHidden: true },
		{ header: Oger._('FotDig'), dataIndex: 'photoDigital', hidden: true, ogerHidden: true },
		{ header: Oger._('FotDig'), dataIndex: 'photoDigital', hidden: true, ogerHidden: true },
		{ header: Oger._('FotDig'), dataIndex: 'photoDigital', hidden: true, ogerHidden: true },
*/

		// detail - timber
		{ header: Oger._('Dendrochronologie'), dataIndex: 'dendrochronology', hidden: true, ogerHidden: true },


		// detail - calced
		{ header: Oger._('Interface'), dataIndex: 'containedInInterfaceIdList', width: 50, hidden: true, ogerHidden: true },
		{ header: Oger._('Objekt'), dataIndex: 'archObjectIdList', width: 50, hidden: true, ogerHidden: true },
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
			{ xtype: 'panel', layout: 'anchor',
				//bodyPadding: '0 5 5 5',
				bodyPadding: 5,
				border: false,
				bodyStyle: 'background-color:#d3e1f1',
				items: [
					{ name: 'searchText', xtype: 'textfield', width: 350,
						fieldLabel: Oger._('Textsuche'), labelWidth: 80,
						checkChangeBuffer: CHKCHANGE_DEFER,
						listeners: {
							change: function(cmp, newValue, oldValue, opts) {
								cmp.up('form').doFilter();
							},
						},
					},
					{ name: 'filterCategoryId', xtype: 'combo', fieldLabel: Oger._('Kategorie'), width: 250,
						forceSelection: true, allowBlank: true,
						queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
						listeners: {
							beforerender: function(cmp, options) {
								cmp.setStore(Ext.create('App.store.StratumCategories'));
								cmp.getStore().load();
							},
							change: function(cmp, newValue, oldValue, options) {
								cmp.up('form').doFilter();
							},
							select: function(cmp, records, eOpts) {
								//cmp.up('form').doFilter();
							},
						},  // eo listerners
					},
					/*
					{ name: 'showAllColumns', xtype: 'checkbox', boxLabel: Oger._('Alle Spalten (Bitte Geduld)'),
						inputValue: 1, uncheckedValue: 0,
						//checkChangeBuffer: CHKCHANGE_DEFER,
						listeners: {
							change: function(cmp, newValue, oldValue, opts) {
								if (newValue != oldValue) {
									var grid = cmp.up('grid');
									Ext.suspendLayouts();
									for (var i = 0; i < grid.columns.length; i++) {
										var col = grid.columns[i];
										if (newValue == 1) {
											col.show(); // slow
										}
										else {
											if (col.ogerHidden) { col.hide(); } // slow
										}
									}  // column loop
									Ext.resumeLayouts(true);
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
		],
	},

	listeners: {
		render: function(cmp, options) {
			cmp.down('pagingtoolbar').bindStore(this.getStore());
		},
//    itemdblclick: function(view, record, item, index, event, options) {
//      this.editRecord(record.data.stratumId);
//    },
	},


	plugins: [
		Ext.create('Ext.grid.plugin.CellEditing', {
			clicksToEdit: 2,
			listeners : {
				edit: function(editor, obj) {

					if (obj.value == obj.originalValue) {
						return;
					}

					var url = obj.getGrid().getStore().getProxy().url;
					url = url.split('?')[0];

					// categoryId is mandatory for save
					// TODO remove id after switch to excav/stratum key
					var params = { _action: 'save', dbAction: 'UPDATE',
													id: obj.record.data.id, excavId: obj.record.data.excavId, stratumId: obj.record.data.stratumId,
													categoryId: obj.record.data.categoryId };
					params[obj.field] = obj.value;

					Ext.Ajax.request({
						url: url,
						params: params,
						success: function(response) {
							var responseObj = {};
							if (response.responseText) {
								responseObj = Ext.decode(response.responseText);
							}
							if (responseObj.success == true) {
								// do not alert - we see if the dirty indicator is removed on reload
								//var mb = Ext.Msg.alert(Oger._('Hinweis'), Oger._('Datensatz erfolgreich gespeichert.'));
								//Ext.Function.defer(function() { mb.hide(); me.focus(); }, 1000);
								obj.getGrid().getStore().load();
							}
						},
						failure: Oger.extjs.handleAjaxFailure,
					});

				}
			}
		})
	],

	// ##############################################################


	// edit current record or add new  if none selected
	'editRecord': function(stratumId) {
		if (!stratumId) {
			var record = this.getSelectionModel().getSelection()[0];
			if (record) {
				stratumId = record.data.stratumId;
			}
		}

		// show existing window if present
		var win = Ext.ComponentQuery.query('ic_stratumwindow')[0];
		if (!win) {
			win = Ext.create('App.view.inputCenter.stratum.Window');
			win.assignedGrid = this;
			win.gluePanel = this.gluePanel;
			win.show();  // this sets dirty flag on categoryId combo, because of empty value!!!
			Oger.extjs.resetDirty(win.down('form'));
		}

		win.show();

		if (Oger.extjs.formIsDirty(win.down('form').getForm())) {
			return;
		}

		if (stratumId) {
			win.editRecord(stratumId);
		}
		else {
			win.newRecord();
		}
	},  // eo edit record


	// rename current record
	'renameRecord': function() {
		var me = this;

		var editWin = Ext.ComponentQuery.query('ic_stratumwindow')[0];
		if (editWin) {
			Ext.Msg.alert(Oger._('Fehler'), Oger._('Bitte zuerst Stratum Eingabefenster schliessen.'));
			return;
		}
		var record = me.getSelectionModel().getSelection()[0];
		if (!record) {
			Ext.Msg.alert(Oger._('Fehler'), Oger._('Bitte zuerst Stratum aus der Liste auswählen.'));
			return;
		}

		// show rename window
		var win = Ext.create('App.view.inputCenter.stratum.RenameWindow');
		win.assignedGrid = me;
		win.record = record;
		win.show();

	},  // eo rename record



	// delete current record
	'deleteRecord': function() {
		var me = this;

		var editWin = Ext.ComponentQuery.query('ic_stratumwindow')[0];
		if (editWin) {
			Ext.Msg.alert(Oger._('Fehler'), Oger._('Bitte zuerst Stratum Eingabefenster schliessen.'));
			return;
		}
		var record = me.getSelectionModel().getSelection()[0];
		if (!record) {
			Ext.Msg.alert(Oger._('Fehler'), Oger._('Bitte zuerst Stratum aus der Liste auswählen.'));
			return;
		}

		// show delete window
		var win = Ext.create('App.view.inputCenter.stratum.DeleteWindow');
		win.assignedGrid = me;
		win.record = record;
		win.show();

	},  // eo delete record

});
