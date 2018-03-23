/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/



/**
* Excavation selection grid
*/
Ext.define('App.view.common.ExcavationSelectionGrid', {
	extend: 'Ext.grid.Panel',
	alias: 'widget.commonexcavationselectiongrid',

	stripeRows: true,
	autoScroll: true,

	store: Ext.create('App.store.Excavations',
										{ remoteSort: true,
											remoteFilter: true,

										}),

	columns: [
		{ header: Oger._('Gr'), dataIndex: 'id', width: 30, hidden: true },
		{ header: Oger._('Grabung'), dataIndex: 'name', width: 300 },
		{ header: Oger._('Massnahme'), dataIndex: 'officialId' },
		{ header: Oger._('Beginn'), xtype: 'datecolumn', dataIndex: 'beginDate', width: 70 },
		{ header: Oger._('Ende'), xtype: 'datecolumn', dataIndex: 'endDate', width: 70 },
		{ header: Oger._('Methode'), dataIndex: 'excavMethodName', width: 80, sortable: false },

		{ header: Oger._('Geschäftszahl'), dataIndex: 'officialId2', hidden: true },
		{ header: Oger._('Verantwortlich'), dataIndex: 'authorizedPerson', hidden: true },
		{ header: Oger._('BearbeiterIn'), dataIndex: 'originator', hidden: true },
		{ header: Oger._('Land'), dataIndex: 'countryName', hidden: true },
		{ header: Oger._('Bundesland'), dataIndex: 'regionName', hidden: true },
		{ header: Oger._('Bezirk'), dataIndex: 'districtName', hidden: true },
		{ header: Oger._('Gemeinde'), dataIndex: 'communeName', hidden: true },
		{ header: Oger._('Kat.Gem'), dataIndex: 'cadastralCommunityName', hidden: true },
		{ header: Oger._('Flur'), dataIndex: 'fieldName', hidden: true },
		{ header: Oger._('Grst.Nr'), dataIndex: 'plotName', hidden: true },
		{ header: Oger._('Datierung'), dataIndex: 'datingSpec', hidden: true },
		{ header: Oger._('Ost'), dataIndex: 'gpsX', hidden: true },
		{ header: Oger._('Nord'), dataIndex: 'gpsY', hidden: true },
		{ header: Oger._('Seeh'), dataIndex: 'gpsZ', hidden: true },

		{ header: Oger._('Fund'), xtype: 'numbercolumn', format: '0,000', align: 'right', dataIndex: 'archFindCount', width: 50 },
		{ header: Oger._('Stratum'), xtype: 'numbercolumn', format: '0,000', align: 'right', dataIndex: 'stratumCount', width: 50 },
		{ header: Oger._('Objekt'), xtype: 'numbercolumn', format: '0,000', align: 'right', dataIndex: 'archObjectCount', width: 50 },
		{ header: Oger._('Obj.Grp'), xtype: 'numbercolumn', format: '0,000', align: 'right', dataIndex: 'archObjGroupCount', width: 50 },

		{ header: Oger._('Inaktiv'), align: 'center', dataIndex: 'inactive', width: 50,
			renderer: function(value) {
				var text = '<input type="checkbox" disabled="disabled"';
				if(value > 0) {
					text += ' checked="checked"';
				}
				return text + '/>';
			}
		},
	],

	// filter panel at the top
	tbar: {
		xtype: 'form',
		height: 60,
		border: false,
		bodyPadding: 5,
		collapsible: true,
		autoScroll: true,
		bodyStyle: 'background-color:#d3e1f1',
		title: Oger._('Filter'),
		layout: 'hbox',
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
			{ xtype: 'tbspacer', width: 30 },
			{ name: 'filterYear', xtype: 'combo', fieldLabel: Oger._('Jahr'), width: 120, labelWidth: 40,
				checkChangeBuffer: CHKCHANGE_DEFER,
				queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
				listeners: {
					beforerender: function(cmp, options) {
						cmp.setStore(Ext.create(Ext.data.Store, { fields: [ 'id', 'name' ], }));
						var tmpYear = new Date().getFullYear();
						for (var i = 0; i < 10; i++) {
							cmp.getStore().add([{ id: tmpYear, name: tmpYear }]);
							tmpYear--;
						}
					},
					change: function(cmp, newValue, oldValue, opts) {
						cmp.up('form').doFilter();
					},
					select: function(cmp, records, opts ) {
						cmp.up('form').doFilter();
					},
				},  // eo listerners
			},
			{ xtype: 'tbspacer', width: 30 },
			{ name: 'showInactive', xtype: 'checkbox', boxLabel: Oger._('Inaktive einblenden'),
				inputValue: '1',
				checkChangeBuffer: CHKCHANGE_DEFER,
				listeners: {
					change: function(cmp, newValue, oldValue, opts) {
						cmp.up('form').doFilter();
					}
				},
			},
		],

		doFilter: function() {
			var form = this;
			var grid = form.up('grid');
			var store = grid.getStore();
			store.clearFilter(true);
			var filterArr = [];
			//filterArr.push({ property: 'excavId', value: grid.excavId });
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
	},

	listeners: {
		render: function(cmp, options) {
			cmp.getStore().clearFilter(true);
			cmp.down('pagingtoolbar').bindStore(cmp.getStore());
			cmp.down('pagingtoolbar').moveFirst();
		},
		afterrender: function(cmp, options) {
			if (cmp.gluePanel) {
				cmp.gluePanelTitle = cmp.gluePanel.title;
			}
		},
		select: function(seleModel, record, index, options) {
			var me = this;
			if (me.gluePanel) {
				var tmpBeginDate = new Date(record.data.beginDate);
				var title = Oger._('Grabung: ') + record.data.name + ' ' + tmpBeginDate.getFullYear();
				me.gluePanel.setTitle(title);
				me.gluePanel.excavRecord = record;
			}
		},
		deselect: function(seleModel, record, index, options) {
			var me = this;
			if (me.gluePanel) {
				me.gluePanel.setTitle((me.gluePanelTitle ? me.gluePanelTitle : Oger._('Keine Grabung ausgewählt')));
				me.gluePanel.excavRecord = null;
			}
		},
	},


	// #######################################################


});
