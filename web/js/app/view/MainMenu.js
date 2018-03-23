/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Main menu
*/
Ext.define('App.view.MainMenu', {
	extend: 'Ext.tree.Panel',
	alias: 'widget.mainmenu',

	//title: Oger._('Menü-Main'),
	autoScroll: true,
	border: false,
	rootVisible: false,
	root: {
		//text: Oger._('Menü-Tree'),
		expanded: true,

		children:[

			{ text: Oger._('Grabung'), expanded: true,
				children: [
					{ text: Oger._('Grabung/Fund/Stratum'), id: 'excavInputCenterMenuItemId', leaf: true },
					{ text: Oger._('Nachschlaglisten aktualisieren'), id: 'excavInputCenterCreateLookUpStoresMenuItemId', leaf: true },
					{ text: Oger._('Blanko Fundzettel'), id: 'emptyFindSheetMenuItemId', leaf: true },
					//{ text: Oger._('Grabung Anlegen/ändern'), id: 'excavMasterDataMenuItemId', leaf: true },
				]
			},

			{ text: Oger._('Auswertungen'),
				children: [
					{ text: Oger._('Konsistenzprüfung'), id: 'checkConsistencyMenuItemId', leaf: true },
					{ text: Oger._('Protokolle/Listen'), id: 'reportAllMenuItemId', leaf: true },
					{ text: Oger._('Matrix'), id: 'matrixMenuItemId', leaf: true },
					{ text: Oger._('Statistik'), id: 'statisticsMenuItemId', leaf: true },
				]
			},

			{ text: Oger._('Stammdaten'),
				children: [
					{ text: Oger._('Stratum Art/Bezeichnung'), id: 'stratumTypeMenuItemId', leaf: true },
					{ text: Oger._('Objekt Art/Bezeichnung'), id: 'archObjectTypeMenuItemId', leaf: true },
					{ text: Oger._('Objektgruppe Art/Bezeichnung'), id: 'archObjGroupTypeMenuItemId', leaf: true },
					{ text: Oger._('Fundverbleib'),
						children: [
							{ text: Oger._('Lagerort'), id: 'stockLocationId', leaf: true },
							{ text: Oger._('Lagerbehälter Art/Bezeichnung'), id: 'stockLocationTypeId', leaf: true },
						],
					},
					{ text: Oger._('Firma'), id: 'companyMenuItemId', leaf: true },
				],
			},

			{ text: Oger._('Import/Export'),
				children: [
					{ text: Oger._('Export'),
						children: [
							{ text: Oger._('Export Grabungsdaten'), id: 'exportMenuItemId', leaf: true },
							{ text: Oger._('Backup (SQL-Dump)'), id: 'backupMenuItemId', leaf: true },
						],
					},
					{ text: Oger._('Import'),
						children: [
							{ text: Oger._('Import Grabungsdaten'), id: 'importMenuItemId', leaf: true },
						],
					},
				]
			},

			{ text: Oger._('Extras'),
				children: [
					{ text: Oger._('Datei hochladen'), id: 'fileUploadMenuItemId', leaf: true },
					{ text: Oger._('Fotos organisieren'), id: 'pictureOrganizeItemId', leaf: true },
				],
			},

			{ text: Oger._('System'),
				children: [
					{ text: Oger._('#Userverwaltung'), id: 'userAdminMenuItemId', leaf: true, disabled: true },
					{ text: Oger._('#Passwort ändern'), id: 'changePasswordMenuItemId', leaf: true, disabled: true },
					{ text: Oger._('#Remote Fehlerprotokoll'), id: 'remoteErrorLogMenuItemId', leaf:true },
					{ text: Oger._('Initialwerte erstellen'), id: 'initialDbValuesMenuItemId', leaf:true },
				]
			},

			{ text: Oger._('Hilfe'), leaf:true, id: 'helpMenuItemId' },
			{ text: Oger._('Über'), leaf:true, id: 'aboutMenuItemId' },
			{ text: Oger._('Abmelden'), leaf:true, id: 'logoffMenuItemId' },
		]
	},

	listeners: {
		itemclick: function(cmp, record, item, index, eventObj) {
			this.onMainMenuItemClick(cmp, record, item, index, eventObj);
		},
	},


	// ###################################################################


	// start menu items
	onMainMenuItemClick: function(cmp, record, item, index, eventObj) {
		var me = this;

		if (record.data.id == 'excavInputCenterMenuItemId') {

			// if panel is already present than ask for reloading the look-up stores
			var inputCenterPanel = Ext.ComponentQuery.query('inputcenterpanel')[0];
			if (inputCenterPanel) {
				// DO NOTHING - reloading of look-up stores done in extra menu item
				return;
			}
		}

		else if (record.data.id == 'excavInputCenterCreateLookUpStoresMenuItemId') {

			var inputCenterPanel = Ext.ComponentQuery.query('inputcenterpanel')[0];
			if (!inputCenterPanel) {
				Ext.Msg.alert(Oger._('Warnung'),
					Oger._('Die Eingabe für Grabungsdaten ist derzeit nicht aktiv. Die Nachschlagelisten werden automatisch aktualisiert, wenn die Eingabe für die Grabungsdaten aktiviert wird.'));
				return;
			}

			inputCenterPanel.createLookUpStores(inputCenterPanel);
			Ext.Msg.alert(Oger._('Hinweis'),
				Oger._('Nachschlagelisten wurden aktualisiert.<hr>Eventuell geöffnete Detailfenster (Fund, Stratum, usw) müssen geschlossen werden damit die Änderung dafür wirksam wird.'));
		}

		else if (record.data.id == 'emptyFindSheetMenuItemId') {
			var win = Ext.create('App.view.inputCenter.emptyFindSheet.Window');
			win.show();
		}


		else if (record.data.id == 'fileUploadMenuItemId') {
			this.showCenterView(Ext.create('App.view.fileUpload.Panel'));
		}

		else if (record.data.id == 'pictureOrganizeItemId') {
			var excavRec = Ext.ComponentQuery.query('inputcenterpanel')[0].excavRecord;
			if (!excavRec) {
				Ext.create('Oger.extjs.MessageBox').alert(
					Oger._('Hinweis'),
					Oger._('Bitte zuerst Grabung auswählen.'));
				return;
			}
			var win = Ext.create('App.view.pictureOrganize.FormWin');
			var vals = Ext.clone(excavRec.data);
			vals.excavId = vals.id;
			vals.excavName = vals.name;
			vals.configFileName = vals.projectBaseDir;  // TODO create separate db field
			win.getController().prepForm(vals);
			win.show();
		}

		else if (record.data.id == 'checkConsistencyMenuItemId') {
			var win = Ext.create('App.view.checkConsistency.Window');
			win.show();
		}

		else if (record.data.id == 'reportAllMenuItemId') {
			var win = Ext.create('App.view.report.Window');
			win.show();
		}

		else if (record.data.id == 'matrixMenuItemId') {
			var win = Ext.create('App.view.matrix.Window');
			win.show();
		}

		else if (record.data.id == 'statisticsMenuItemId') {
			var win = Ext.create('App.view.statistics.Window');
			win.show();
		}

		else if (record.data.id == 'stratumTypeMenuItemId') {
			var win = Ext.create('App.view.master.stratumType.GridWindow');
			win.show();
		}
		else if (record.data.id == 'archObjectTypeMenuItemId') {
			var win = Ext.create('App.view.master.archObjectType.GridWindow');
			win.show();
		}
		else if (record.data.id == 'archObjGroupTypeMenuItemId') {
			var win = Ext.create('App.view.master.archObjGroupType.GridWindow');
			win.show();
		}
		else if (record.data.id == 'stockLocationId') {
			var win = Oger.extjs.createOnce('stocklocationmastergridwin', 'App.view.master.stockLocation.GridWindow');
			win.show();
		}
		else if (record.data.id == 'stockLocationTypeId') {
			var win = Ext.create('App.view.master.stockLocationType.GridWindow');
			win.show();
		}
		else if (record.data.id == 'companyMenuItemId') {
			var win = Ext.create('App.view.master.company.Window');
			win.show();
		}

		else if (record.data.id == 'exportMenuItemId') {
			var excavRec = Ext.ComponentQuery.query('inputcenterpanel')[0].excavRecord;
			if (!excavRec) {
				Ext.Msg.alert(Oger._('Fehler'), Oger._('Bitte zuerst eine Grabung auswählen.'));
				return;
			}
			var win = Ext.create('App.view.export.Window');
			win.show();
		}
		else if (record.data.id == 'backupMenuItemId') {
			this.onBackupMenuItem();
		}

		else if (record.data.id == 'importMenuItemId') {
			var win = Ext.create('App.view.import.Window');
			win.show();
		}



		else if (record.data.id == 'userAdminMenuItemId') {
			//showUserAdminWindow();
		}
		else if (record.data.id == 'changePasswordMenuItemId') {
			//showChangePasswordWindow();
		}
		else if (record.data.id == 'remoteErrorLogMenuItemId') {
			/*
			Ext.Ajax.request({
				url: 'php/system/showErrorLog.php',
				success: function(response) {
					var responseObj = Ext.decode(response.responseText);
					if (responseObj.success == true) {
						showErrorLogWindow(responseObj);
					}
					else {
						Ext.Msg.alert(Oger._('Antwort'), responseObj.msg);
					}
				},
				failure: Oger.extjs.handleAjaxFailure,
			});
			*/
		}
		else if (record.data.id == 'initialDbValuesMenuItemId') {
			Ext.Ajax.request({
				url: 'php/system/initDbValues.php',
				success: function(response) {
					var responseObj = Ext.decode(response.responseText);
					Ext.create('Oger.extjs.MessageBox').alert(Oger._('Antwort'), responseObj.msg);
				},
				failure: Oger.extjs.handleAjaxFailure,
			});
		}
		else if (record.data.id == 'aboutMenuItemId') {
			this.onAboutMenuItem();
		}
		else if (record.data.id == 'logoffMenuItemId') {
			this.onLogoffMenuItem();
		}
		else if (record.data.id == 'helpMenuItemId') {
			window.open('help',
									'HELP',
									'left=' + Math.floor(window.innerWidth * 0.1) + ',top=' + Math.floor(window.innerHeight * 0.1) +
									',width=' + Math.floor(window.innerWidth * 0.8) + ',height=' + Math.floor(window.innerHeight * 0.8) +
									',menubar=yes,toolbar=yes,scrollbars=yes,resizeable=yes');
		}

	}, // eo on main menu click



	// ###################################################


	// own properties
	showCenterView: function(cmp) {
		var target = Ext.ComponentQuery.query('mainviewport > component[region="center"]')[0];
		target.show();
		target.removeAll();
		target.add(cmp);
		target.doLayout();
	}, // eo show center view

	// backup
	onBackupMenuItem: function() {
		Ext.Msg.confirm(Oger._('Backup (SQL-Dump)'),
			Oger._('Ein komplettes Abbild der Datenbank wird erstellt und heruntergeladen. Backup jetzt starten?'),
			function(answerId) {
				if(answerId == 'yes') {
					window.open('php/scripts/exportSql.php' + '?' + Ext.Object.toQueryString(Ext.Ajax.getExtraParams()),
											'BACKUP',
											'left=' + Math.floor(window.innerWidth * 0.1) + ',top=' + Math.floor(window.innerHeight * 0.1) +
											',width=' + Math.floor(window.innerWidth * 0.8) + ',height=' + Math.floor(window.innerHeight * 0.8));
				}
			}
		);
	},  // eo backup


	// logoff
	onLogoffMenuItem: function() {
		var win = Ext.create('App.view.system.LogoffWin');
		win.show();
		return;
	},  // eo logoff


	// about
	onAboutMenuItem: function() {
		var win = Ext.create('App.view.system.AboutWin');
		win.show();
		return;
	},  // eo about



});
