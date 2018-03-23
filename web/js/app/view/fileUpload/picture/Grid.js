/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/




/**
* Picture file grid
*/
Ext.define('App.view.fileUpload.picture.Grid', {
	extend: 'Ext.grid.Panel',
	alias: 'widget.ic_picturefilegrid',

	stripeRows: true,
	autoScroll: true,

	sortableColumns: false,
	store: Ext.create('App.store.PictureFiles'),
	columns: [
		{ header: Oger._('Gr'), dataIndex: 'excavId', width: 30, hidden: true },
		{ header: Oger._('Grabung'), dataIndex: 'excavName', hidden: true },
		{ text: Oger._('Dateiname'), width: 300, dataIndex: 'fileName' },
		{ text: Oger._('Datum'), xtype: 'datecolumn', dataIndex: 'date', width: 70 },
		{ text: Oger._('Titel'), width: 90, dataIndex: 'title' },
		{ text: Oger._('Üs'), width: 15, dataIndex: 'isOverview' },
		{ text: Oger._('Relev'), xtype: 'numbercolumn', dataIndex: 'relevance', width: 40, format: '000' },
		{ text: Oger._('Stratum'), dataIndex: 'auxStratumIdList' },
		//{ text: Oger._('Fund'), dataIndex: 'auxArchFindIdList' },
		{ text: Oger._('Schnitt'), dataIndex: 'auxSection' },
		{ text: Oger._('Sektor'), dataIndex: 'auxSektor' },
		{ text: Oger._('Planum'), dataIndex: 'auxPlanum' },
		{ text: Oger._('Profil'), dataIndex: 'auxProfile' },
		{ text: Oger._('Objekt'), dataIndex: 'auxObject' },
		{ text: Oger._('Grab'), dataIndex: 'auxGrave' },
		{ text: Oger._('Mauer'), dataIndex: 'auxWall' },
		{ text: Oger._('Komplex'), dataIndex: 'auxComplex' },
	],

	// paging bar on the bottom
	bbar: {
		xtype: 'pagingtoolbar',
		displayInfo: true,
		items: [
			'-',
			{ text: Oger._('Neues Foto'),
				handler: function(cmp, ev, options ) {
					this.up('grid').newRecord();
				}
			},
			'-',
			{ text: Oger._('Eintrag löschen'),
				handler: function() {
					this.up('grid').delRecord();
				}
			},

		]
	},  // eo bbar

	listeners: {
		beforerender: function(cmp, options) {
			this.down('pagingtoolbar').bindStore(this.getStore());
			this.assignedPForm = this.up('panel').down('ic_picturefileform');
		},
		itemdblclick: function(view, record, item, index, event, options) {
			this.editRecord(record.data.id);
		},
		beforeselect: function(view, node, selections, options) {
			return !Oger.extjs.formIsDirty(this.assignedPForm, true);
		},
		selectionchange: function(view, selections, options) {
		 if (selections[0]) {
			 this.editRecord(selections[0].data.id);
		 }
		}
	},


	// #######################################################

	// prepare form for new record
	newRecord: function() {

		if (Oger.extjs.formIsDirty(this.assignedPForm)) {
			this.dirtyMsg();
			return;
		}

		this.getSelectionModel().deselectAll();
		this.editRecord();

	},  // eo new record

	// edit record
	editRecord: function(id) {

		if (Oger.extjs.formIsDirty(this.assignedPForm)) {
			this.dirtyMsg();
			return;
		}

		// show/hide excav method related items
		if (this.gluePanel.excavRecord.data.excavMethodId == EXCAVMETHODID_PLANUM) {
			this.assignedPForm.getForm().findField('auxStratumIdList').hide();
			this.assignedPForm.down('component[isExcavMethodPlanumFieldSetId]').show();
		}
		else {  // default to stratum method
			this.assignedPForm.getForm().findField('auxStratumIdList').show();
			this.assignedPForm.down('component[isExcavMethodPlanumFieldSetId]').hide();
		}

		// show/hide related to new/edit
		Oger.extjs.emptyForm(this.assignedPForm);
		if (!id) {  // new record
			this.assignedPForm.down('component[isMasterTabId]').setActiveTab(0);
			this.assignedPForm.down('component[isFileNameAndDownLoadId]').hide();
			this.assignedPForm.getForm().findField('uploadFileName').show();

			this.assignedPForm.getForm().findField('excavId').setValue(this.gluePanel.excavRecord.data.id);
		}
		else {  // edit record
			this.assignedPForm.load({ url: this.assignedPForm.url, params: { _action: 'loadRecord', id: id } });
			this.assignedPForm.down('component[isFileNameAndDownLoadId]').show();
			this.assignedPForm.getForm().findField('uploadFileName').hide();
			if (this.assignedPForm.down('component[isMasterTabId]').getActiveTab() ==
					this.assignedPForm.down('component[isPreviewPanelId]')) {
				this.assignedPForm.down('component[isPreviewFieldId]').el.dom.src =
					this.assignedPForm.url + '?_action=loadPreview&id=' + id;
			}  // update preview
		}   // eo edit

		Oger.extjs.resetDirty(this.assignedPForm);
		this.assignedPForm.enable();
	},  // eo edit record

	// delete record
	delRecord: function() {

		var me = this;

		if (Oger.extjs.formIsDirty(me.assignedPForm)) {
			me.dirtyMsg();
			return;
		}

		var record = me.getSelectionModel().getSelection()[0];
		if (!record) {
			Ext.Msg.alert(Oger._('Hinweis'), Oger._('Bitte zuerst einen Eintrag auswählen.'));
			return false;
		}

		var tmpDate = new Date(record.data.date);
		Ext.Msg.confirm(Oger._('Löschen'), Oger._('Datei ' + record.data.fileName +
																							' vom ' + Ext.util.Format.date(tmpDate) + ' wirklich löschen?'),
			function(answerId) {
				if (answerId == 'yes') {
					Ext.Ajax.request({
						url: me.assignedPForm.url + '?_action=delete&id=' + record.data.id,
						success: function(response) {
							var responseObj = Ext.decode(response.responseText);
							if (responseObj.success == true) {
								Ext.Msg.alert(Oger._('Antwort'), Oger._('Datei erfolgreich gelöscht.'));
								me.getStore().remove(record);
								Oger.extjs.emptyForm(me.assignedPForm, true);
								me.assignedPForm.disable();
							}
							else {
								Ext.Msg.alert(Oger._('Antwort'), responseObj.msg);
							}
						},
						failure: Oger.extjs.handleAjaxFailure,
					});
				}
			}
		);  // eo confirm

	},

	// show dirty message
	dirtyMsg: function() {
		Ext.Msg.alert(Oger._('Warnung'), Oger._('Bitte Änderungen speichern.'));
	}



});
