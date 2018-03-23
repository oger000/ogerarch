/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/* DEMOCODE for overwriting constructor:
* // from <http://www.sencha.com/forum/showthread.php?137612-Override-constructor-in-JsExt-4>
*
* this.callParent(config) would be the new way of calling the ancestor class,
* as opposed to MyGrid.superclass.constructor.call.
*
* Other than that, I tend to think that it's a good idea to stick with the single config argument,
* as all the other components rely on it, and you might introduce confusion down the line:
*
* Ext.define('MyGrid',
* {    extend: 'Ext.grid.Panel',
*
*		constructor: function(config)
*		{    this.param = config.param; // get your param value from the config object
*				config.store = Ext.create('Ext.data.Store', ...
*				...);
*				this.callParent(arguments);  // oger000: the name 'arguments' is used by design
*		}
* });
*/




/**
* Excavation grid
*/
Ext.define('App.view.inputCenter.excavation.Grid', {
	extend: 'Ext.grid.Panel',
	alias: 'widget.ic_excavationgrid',

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
		{ header: Oger._('Methode'), dataIndex: 'excavMethodName', width: 80 },

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
		{ header: Oger._('Lager'), xtype: 'numbercolumn', format: '0,000', align: 'right', dataIndex: 'prepFindCount', width: 50 },

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



	/*
	dockedItems: [
		{ xtype: 'pagingtoolbar',
			store: this.getStore(),   // same store GridPanel is using
			dock: 'bottom',
			displayInfo: true
		}
	],
	*/

	// paging bar on the bottom
	bbar: {
		xtype: 'pagingtoolbar',
		// store: Cache.get('excavStore'),    // 'excavationsStoreId',
		displayInfo: true,
		items: [
			'-',
			{ text: 'Stammdaten',
				handler: function() {
					this.up('panel').editRecord();
				}
			},
			'-',
			{ text: 'Löschen',
				handler: function() {
					this.up('panel').deleteExcav();
				}
			},
		],
	},

	listeners: {
		afterrender: function(cmp, options) {
			cmp.down('pagingtoolbar').bindStore(this.getStore());
			cmp.down('pagingtoolbar').moveFirst();
		},
		itemdblclick: function(view, record, item, index, event, options) {
			//this.editRecord(record.data.id);
			this.gluePanel.down('tabpanel').setActiveTab(1);  // TODO use component query
		},
		select: function(seleModel, record, index, options) {
			var tmpBeginDate = new Date(record.data.beginDate);
			var title = Oger._('Grabung: ') + record.data.name + ' ' + tmpBeginDate.getFullYear();
			this.gluePanel.setTitle(title);
			this.gluePanel.excavRecord = record;
		},
		deselect: function(seleModel, record, index, options) {
			this.gluePanel.setTitle(Oger._('Keine Grabung ausgewählt'));
			this.gluePanel.excavRecord = null;
		},
	},



	// edit current record or add new  if none selected
	'editRecord': function(id) {
		if (!id) {
			var record = this.getSelectionModel().getSelection()[0];
			if (record) {
				id = record.data.id;
			}
		}

		var win = Ext.create('App.view.inputCenter.excavation.Window');
		win.assignedGrid = this;
		win.gluePanel = this.gluePanel;
		win.show();
		if (id) {
			win.editRecord(id);
		}
		else {
			win.newRecord();
		}
	},


	// delete excavation
	'deleteExcav': function() {

		var record = this.getSelectionModel().getSelection()[0];
		if (!record) {
			Ext.Msg.alert(Oger._('Hinweis'), Oger._('Bitte zuerst Grabung auswählen.'));
			return false;
		}

		var win = Ext.create('App.view.inputCenter.excavation.DeleteWindow');
		win.assignedGrid = this;
		win.gluePanel = this.gluePanel;
		win.show();
		win.prep(record);
	},


});
