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
Ext.define('App.view.inputCenter.stock.PanelCtrl', {
	extend: 'Ext.app.ViewController',
	alias: 'controller.ic_stockpanel',


	// activate panel
	activatePanel: function() {
		var me = this;

		var centerPanel = Ext.ComponentQuery.query('inputcenterpanel')[0];
		var excavId = centerPanel.excavRecord.data.id;

		var locGrid = me.lookupReference('stockLocationGrid');
		if (locGrid.excavId != excavId) {

			locGrid.excavId = excavId;

			var store = locGrid.getStore();
			var proxy = store.getProxy();
			proxy.setExtraParam('_action', 'loadExcavStockLocation');
			proxy.setExtraParam('excavId', excavId);
			store.load();
		}

		var prepFindGrid = me.lookupReference('stockPrepFindGrid');
		if (prepFindGrid.excavId != excavId) {

			prepFindGrid.excavId = excavId;

			var store = prepFindGrid.getStore();
			var proxy = store.getProxy();
			proxy.setExtraParam('_action', 'loadStockGrid');
			proxy.setExtraParam('excavId', excavId);
			store.load();
		}

	},  // eo activate stock panel


	// edit container content
	editContainerContent: function(cmp, gridView, rowIndex, colIndex, actionItem, event, record, row) {
		var me = this;

		var opts = {};
		opts._usecase = 'INPUTCENTER';
		opts.prepFindGrid = me.lookupReference('stockPrepFindGrid');
		var data = Ext.clone(record.data);
		//data.stockLocationId = data.id;
		data.excavId = Ext.ComponentQuery.query('inputcenterpanel')[0].excavRecord.data.id;

		var win = Oger.extjs.createOnce('ic_stocklocationcontentwindow', 'App.view.inputCenter.stock.location.ContentWindow');
		win.getController().prepForm('UPDATE', data, this.lookupReference('stockLocationGrid'), opts);
		win.show();
	},  // eo edit record


	// add sub location
	addSubLocation: function(cmp, gridView, rowIndex, colIndex, actionItem, event, record, row) {
		var me = this;

		var data = Ext.clone(record.data);
		data.excavId = Ext.ComponentQuery.query('inputcenterpanel')[0].excavRecord.data.id;

		var opts = {};
		opts._usecase = 'INPUTCENTER';

		var win = Oger.extjs.createOnce('stocklocationmasterwindow', 'App.view.master.stockLocation.DetailWindow');
		win.getController().prepForm('INSERT', data, this.lookupReference('stockLocationGrid'), opts);
		win.show();
	},  // eo add sub record


	// on location item click
	onLocItemClick: function(cmp, rec) {
		var me = this;
		var store = me.lookupReference('stockPrepFindGrid').getStore();
		store.filter('stockLocationId', rec.data.stockLocationId)
		//store.load(store.currentPage);
	},  // eo loc item click


	// reload location grid
	reloadLocationGrid: function() {
		var me = this;
		me.lookupReference('stockLocationGrid').getStore().load({ params: { stockLocationId: App.clazz.StockLocation.ROOT_ID }});
	},  // eo reload loc grid


	// show delete location window
	deleteLocation: function() {
		var me = this;

		var rec = me.lookupReference('stockLocationGrid').getSelectionModel().getSelection()[0];
		if (!rec) {
			Ext.create('Oger.extjs.MessageBox').alert(Oger._('Fehler'), Oger._('Bitte zuerst einen Lagerort auswählen.'));
			return;
		}

		var data = Ext.clone(rec.data);
		data.excavId = me.lookupReference('stockLocationGrid').excavId;  // we work excav specific, independent of location excav id
		var opts = { _usecase: 'INPUTCENTER' };

		var win = Oger.extjs.createOnce(null, 'App.view.master.stockLocation.DeleteWindow');
		win.getController().prepForm('DELETE', data, me.lookupReference('stockLocationGrid'), opts);
		win.show();
	},  // eo show del loc win


	// start location content list
	startLocationContentList: function() {
		var me = this;

		var rec = me.lookupReference('stockLocationGrid').getSelectionModel().getSelection()[0];
		if (!rec) {
			Ext.create('Oger.extjs.MessageBox').alert(Oger._('Fehler'), Oger._('Bitte zuerst einen Lagerort auswählen.'));
			return;
		}

		var data = Ext.clone(rec.data);
		data.excavId = me.lookupReference('stockLocationGrid').excavId;  // we work excav specific, independent of location excav id
		data._usecase = 'INPUTCENTER';

		var win = Ext.create('App.view.report.stock.location.ContentListWin');
		win.injectData(data);
		win.show();
	},  // eo show loc content list win


	// start location content sheet
	startLocationContentSheet: function() {
		var me = this;

		var rec = me.lookupReference('stockLocationGrid').getSelectionModel().getSelection()[0];
		if (!rec) {
			Ext.create('Oger.extjs.MessageBox').alert(Oger._('Fehler'), Oger._('Bitte zuerst einen Lagerort auswählen.'));
			return;
		}

		var data = Ext.clone(rec.data);
		data.excavId = me.lookupReference('stockLocationGrid').excavId;  // we work excav specific, independent of location excav id
		data._usecase = 'INPUTCENTER';

		var win = Ext.create('App.view.report.stock.location.ContentSheetWin');
		win.injectData(data);
		win.show();
	},  // eo show content sheet win


	// start packing list
	startLocationPackingList: function() {
		var me = this;

		var rec = me.lookupReference('stockLocationGrid').getSelectionModel().getSelection()[0];
		if (!rec) {
			Ext.create('Oger.extjs.MessageBox').alert(Oger._('Fehler'), Oger._('Bitte zuerst einen Lagerort auswählen.'));
			return;
		}

		var data = Ext.clone(rec.data);
		data.excavId = me.lookupReference('stockLocationGrid').excavId;  // we work excav specific, independent of location excav id
		data._usecase = 'INPUTCENTER';

		var win = Ext.create('App.view.report.stock.location.PackingListWin');
		win.injectData(data);
		win.show();
	},  // eo show content sheet win


	// get input before move nodes (container)
	onBeforeDrop: function(node, dataIn, overModel, dropPosition, dropHandlers, eOpts) {
		var me = this;

		// only assigning to another node (append) is handled
		if (dropPosition != 'append') {
			dropHandlers.cancelDrop();
			return;
		}

		// if no dataIn records are present we cancel
		if (!dataIn.records.length) {
			dropHandlers.cancelDrop();
			return;
		}

		dropHandlers.wait = true;

		var dataOut = Ext.clone(dataIn.records[0].data);
		dataOut.excavId = me.lookupReference('stockLocationGrid').excavId;  // we work excav specific, independent of locations own excav id
		dataOut.moveTo = overModel.data.stockLocationId;
		dataOut.moveToName = overModel.data.name;
		dataOut.records = Ext.clone(dataIn.records);

		var opts = {
			node: node, data: dataIn, overModel: overModel,
			dropPosition: dropPosition, dropHandlers: dropHandlers, eOpts: eOpts,
		};

		// action depends on data source
		// data source is recogniced by testing for existence of fields
		// that is guessed to be unique for one of the data sources.
		// There should be a better solution !!!
		if (typeof dataIn.records[0].data.oriArchFindId != 'undefined') {
			var win = Oger.extjs.createOnce(null, 'App.view.inputCenter.stock.prepFind.MoveWindow');
			win.getController().prepForm('MOVE', dataOut, me.lookupReference('stockPrepFindGrid'), opts);
			win.show();
			return;
		}

		if (typeof dataIn.records[0].data.outerId != 'undefined') {
			var win = Oger.extjs.createOnce(null, 'App.view.inputCenter.stock.location.MoveWindow');
			win.getController().prepForm('MOVE', dataOut, me.lookupReference('stockLocationGrid'), opts);
			win.show();

			return;
		}
	},  // eo before move/drop




	// ### prep find grid ################################################################################

	// on prep find item click
	onPrepFindItemClick: function(cmp, rec) {
		var me = this;

		var locGrid = me.lookupReference('stockLocationGrid');
		var locRec = locGrid.getStore().getNodeById(rec.data.stockLocationId);

		// if prep find has no location abort with message
		if (!locRec) {
			Ext.create('Oger.extjs.MessageBox').alert(
				Oger._('Hinweis'),
				Oger._('Dieser Fundnummer ist kein Lagerort zugewiesen.'));
			return;
		}

		locGrid.getSelectionModel().select(locRec);

		// expand path from root to requested stock location
		locRec.getOwnerTree().expandPath(locRec.getPath());
	},  // eo prep find item click


	onPrepFindItemDblClick: function(cmp, rec) {
		var me = this;
		me.editPrepFind(rec);
	},  // eo prep find item click


	// on prep find filter change
	onPrepFindFilterChange: function() {
		var me = this;

		var filterArr = [];
		var bForm = me.lookupReference('prepFindFilterForm').getForm();
		var vals = bForm.getValues();

		if (vals.archFindId && vals.archFindIdLikeFlag) {
			vals.archFindIdLike = '%' + vals.archFindId + '%';
			delete vals.archFindId;
		}
		delete vals.archFindIdLikeFlag;

		if (vals.searchText) {
			vals.searchText = '%' + vals.searchText + '%';
		}

		for (var prop in vals) {
			filterArr.push({ property: prop, value: vals[prop] });
		}

		var store = me.lookupReference('stockPrepFindGrid').getStore();
		store.clearFilter(true);
		store.filter(filterArr);

		// deselect location grid because we search all locations (for now)
		me.lookupReference('stockLocationGrid').getSelectionModel().deselectAll();
	},  // eo prep find filter

	// on clear prep find filter
	clearPrepFindFilter: function() {
		var me = this;

		Oger.extjs.emptyForm(me.lookupReference('prepFindFilterForm'));
		me.onPrepFindFilterChange();
	},  // eo on clear prep find filter


	// edit prep find
	editPrepFind: function() {
		var me = this;

		var grid = me.lookupReference('stockPrepFindGrid');

		var rec = grid.getSelectionModel().getSelection()[0];
		if (!rec) {
			Ext.create('Oger.extjs.MessageBox').alert(Oger._('Fehler'), Oger._('Bitte zuerst einen Datensatz auswählen.'));
			return;
		}

		var data = Ext.clone(rec.data);
		var win = Oger.extjs.createOnce('ic_stockprepfindwindow', 'App.view.inputCenter.stock.prepFind.Window');
		win.getController().prepForm('UPDATE', data, grid);
		win.show();
	},  // eo edit prep find


	// mass edit prep finds
	massEditPrepFind: function(rec) {
		var me = this;

		var grid = me.lookupReference('stockPrepFindGrid');

		var data = {};
		data.excavId = Ext.ComponentQuery.query('inputcenterpanel')[0].excavRecord.data.id;

		var win = Ext.create('App.view.inputCenter.stock.prepFind.MassEditWin');
		win.injectData(data, grid);
		win.show();
	},  // eo mass edit prep finds


	// rename prep find
	renamePrepFind: function() {
		var me = this;

		var grid = me.lookupReference('stockPrepFindGrid');
		var rec = grid.getSelectionModel().getSelection()[0];
		if (!rec) {
			Ext.create('Oger.extjs.MessageBox').alert(Oger._('Fehler'), Oger._('Bitte zuerst einen Datensatz auswählen.'));
			return;
		}

		var data = Ext.clone(rec.data);

		var win = Oger.extjs.createOnce('ic_prepfindrenamewindow', 'App.view.inputCenter.stock.prepFind.RenameWindow');
		win.getController().prepForm('RENAME', data, grid);
		win.show();
	},  // eo rename prep find


	// delete prep find
	deletePrepFind: function() {
		var me = this;

		var grid = me.lookupReference('stockPrepFindGrid');
		var rec = grid.getSelectionModel().getSelection()[0];
		if (!rec) {
			Ext.create('Oger.extjs.MessageBox').alert(Oger._('Fehler'), Oger._('Bitte zuerst einen Datensatz auswählen.'));
			return;
		}

		var data = Ext.clone(rec.data);

		var win = Oger.extjs.createOnce('ic_prepfinddeletewindow', 'App.view.inputCenter.stock.prepFind.DeleteWindow');
		win.getController().prepForm('DELETE', data, grid);
		win.show();
	},  // eo delete prep find


});
