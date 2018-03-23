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
Ext.define('App.view.system.user.FormWin', {
	extend: 'Ext.window.Window',
	alias: 'widget.systemUserFormWin',

	controller: 'systemUserFormWin',

	title: Oger._('User'),
	width: 700, height: 500,
	//autoScroll: true,
	layout: 'fit',

	items: [
		{ xtype: 'form', reference: 'theForm',

			url: 'php/system/user.php',

			bodyPadding: 15, border: false,
			autoScroll: true,
			trackResetOnLoad: true,
			layout: 'anchor',

			items: [

				{ xtype: 'tabpanel',
					activeTab: 0,
					plain: true,
					deferredRender: false,

					items: [

						{ xtype: 'panel', title: Oger._('Userdaten'),
							bodyPadding: 15, border: false,
							hideMode: 'offsets', autoScroll: true,
							layout: 'anchor',
							items: [
								{ name: '_action', xtype: 'hidden', value: 'INSERT', reference: 'actionField' },
								{ name: 'userGroupIdList', xtype: 'hidden', value: '', reference: 'userGroupIdListField' },
								{ name: 'userId', fieldLabel: Oger._('User Id'), xtype: 'textfield', readOnly: true, hidden: true },
								{ name: 'logonName', fieldLabel: Oger._('Logon User'), xtype: 'textfield', allowBlank: false },
								{ name: 'realName', fieldLabel: Oger._('Person Name'), xtype: 'textfield' },
								{ xtype: 'fieldset',
									items: [
										{ xtype: 'fieldcontainer', layout: 'hbox',
											items: [
												{ name: 'newPassword', xtype: 'textfield',
													inputType: 'password', fieldLabel: Oger._('Neues Passwort'),
												},
												{ xtype: 'tbspacer', width: 20 },
												{ name: 'newPasswordRepeated', xtype: 'textfield',
													inputType: 'password', fieldLabel: Oger._('Pw wiederholen'),
												},
											],
										},
										{ xtype: 'fieldcontainer', layout: 'hbox',
											items: [
												{ name: 'sslClientDN', xtype: 'textfield', fieldLabel: Oger._('SSL Client DN') },
												{ xtype: 'tbspacer', width: 20 },
												{ name: 'sslClientIssuerDN', xtype: 'textfield', fieldLabel: Oger._('Client Issuer DN') },
											],
										},
										/*
										{ name: 'importSslClientCert', xtype: 'checkbox',
											boxLabel: Oger._('SSL Client Zertifikat der aktuellen Verbindung importieren'),
											inputValue: '1', uncheckedValue: '0',	disabled: !OgerApp.allowSslClientCertLogon,
											listeners: {
												change: 'onImportSslClientCertChange',
											},
										},
										*/
										{ xtype: 'button', handler: 'fetchSslClientCert',
											text: Oger._('SSL Client Zertifikat der aktuellen Verbindung importieren'),
											disabled: !OgerApp.allowSslClientCertLogon,
										},

									],
								},
								{ xtype: 'fieldset', title: Oger._('Rechte'), reference: 'permPanel',
									items: [
										{ name: 'logonPerm', xtype: 'checkbox', fieldLabel: Oger._('Anmelden'),
											inputValue: '1', uncheckedValue: '0',
										},
										{ name: 'superPerm', xtype: 'checkbox', fieldLabel: Oger._('Superadmin'),
											inputValue: '1', uncheckedValue: '0',
										},
									],
								},
							],
						},

						{ xtype: 'panel', reference: 'assignGroupTab',
							title: Oger._('Gruppenzuordnung'),
							border: false,
							hideMode: 'offsets',
							autoScroll: true,
							height: 350,
							layout: 'border',
							items: [
								{ region: 'west', xtype: 'panel',
									width: 300, split: true,
									title: Oger._('Zugeordnete Gruppen'),
									layout: 'fit',
									items: [
										{ xtype: 'systemUserToUserGroupGrid', reference: 'assignedUserGroupGrid',
											viewConfig: {
												plugins: {
													ptype: 'gridviewdragdrop',
													dragGroup: 'userToUserGroupAssignedUserGroup',
													dropGroup: 'userToUserGroupAvailableUserGroup',
												},
												listeners: {
													drop: 'onDropToAssigned',
												},
											},
										},
									],
								},
								{ region: 'center', xtype: 'panel',
									title: Oger._('Verfügbare Gruppen'),
									layout: 'fit',
									items: [
										{ xtype: 'systemUserToUserGroupGrid', reference: 'availableUserGroupGrid',
											viewConfig: {
												plugins: {
													ptype: 'gridviewdragdrop',
													dragGroup: 'userToUserGroupAvailableUserGroup',
													dropGroup: 'userToUserGroupAssignedUserGroup',
												},
												listeners: {
													drop: 'onDropToAvailable',
												},
											},  // eo viewconfig
											bbar: {
												layout: { pack: 'center' },
												items: [
													{ iconCls: Ext.baseCSSPrefix + 'tbar-loading', flex: 1,
														handler: 'refreshAvailableUserGroupGrid',
													},
												],
											},
										},  // eo grid
									],
								},
								{ region: 'south', xtype: 'panel',
									html: '<CENTER><br/>' + Oger._('Gruppen durch Ziehen mit der Maus zuordnen.') + '<br/></CENTER>',
								},
							],
						},  // eo group panel

					],  // eo tab panel items

				},  // eo tab panel

				{ xtype: 'panel', height: 5, border: false },
				{ name: 'oldPassword', xtype: 'textfield', inputType: 'password',
					fieldLabel: Oger._('Ihr Passwort'),
				},

				{ name: 'skipSignTimeout', xtype: 'numberfield', minValue: 0, maxValue: 30, hideTrigger: true,
					fieldLabel: Oger._('Ohne Unterschriftserfordernis (in Minuten)'), labelWidth: 300, width: 400,
				},

			],

		},  // eo form
	],

	buttonAlign: 'center',
	minButtonWidth: 30,
	buttons: [
		{ text: Oger._('Speichern'), handler: 'saveRecord' },
		{ text: Oger._('Abbrechen'), handler: 'closeWindow' },
	],


	listeners: {
		afterrender: 'onAfterRender',
		beforeclose: 'onBeforeClose',
		close: 'onClose',
	},


});
