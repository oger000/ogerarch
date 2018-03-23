/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Check consistency form
*/
Ext.define('App.view.checkConsistency.Form', {
	extend: 'Ext.form.Panel',
	alias: 'widget.checkconsistencyform',

	bodyPadding: 15,
	border: false,
	autoScroll: true,
	layout: 'anchor',
	trackResetOnLoad: true,

	items: [

		{ xtype: 'fieldset', title: Oger._('Fund'),
			items: [
				{ name: 'checkArchFind', xtype: 'checkbox', fieldLabel: Oger._('Prüfen'), uncheckedValue: '0', checked: true,
					listeners: {
						change: function(cmp, newValue, oldValue, opts) {
							var details = this.up('form').getForm().findField('fakeArchFindCheckGroup');
							if (newValue) {
								details.enable();
							}
							else {
								details.disable();
							}
						},
					},
				},
				{ name: 'fakeArchFindCheckGroup', xtype: 'checkboxgroup', columns: 1, fieldLabel: Oger._('Detailprüfung'),
					items: [
						{ name: 'archFindCheckStratum', boxLabel: Oger._('ob zugeordnetes Stratum existiert'), uncheckedValue: '0', checked: true,
							listeners: {
								change: function(cmp, newValue, oldValue, opts) {
									/*
									var field = this.up('form').getForm().findField('archFindCheckStratumExtras');
									if (newValue) {
										field.enable();
									}
									else {
										field.disable();
									}
									*/
								},
							},
						},
					],
				},
			],
		},

		{ xtype: 'fieldset', title: Oger._('Stratum'),
			items: [
				{ name: 'checkStratum', xtype: 'checkbox', fieldLabel: Oger._('Prüfen'), uncheckedValue: '0', checked: true,
					listeners: {
						change: function(cmp, newValue, oldValue, opts) {
							var details = this.up('form').getForm().findField('fakeStratumCheckGroup');
							if (newValue) {
								details.enable();
							}
							else {
								details.disable();
							}
						},
					},
				},
				{ name: 'fakeStratumCheckGroup', xtype: 'checkboxgroup', columns: 1, fieldLabel: Oger._('Detailprüfung'),
					items: [
						{ name: 'stratumCheckArchFind', boxLabel: Oger._('ob Fund-/Probeangabe korrekt ist'), uncheckedValue: '0', checked: true },
						{ name: 'stratumCheckMatrix', boxLabel: Oger._('Matrix (wird bei Matrixerstellung geprüft)'), uncheckedValue: '0', checked: false, disabled: true },
						{ name: 'stratumCheckArchObject', boxLabel: Oger._('ob zugeordnetes Objekt existiert'), uncheckedValue: '0', checked: true },
						{ name: 'stratumCheckArchObjGroup', boxLabel: Oger._('ob Objektgruppen-Angabe korrekt ist'), uncheckedValue: '0', checked: true },
					],
				},
			],
		},

		{ xtype: 'fieldset', title: Oger._('Stammdaten'),
			items: [
				{ name: 'checkMasterData', xtype: 'checkbox', fieldLabel: Oger._('Prüfen'), uncheckedValue: '0', checked: true },
			],
		},

		{ xtype: 'fieldcontainer', layout: 'hbox',
			items: [
				{ name: 'checkLevel', xtype: 'combo', fieldLabel: Oger._('Level'),
					allowBlank: false, forceSelection: true,
					queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
					listeners: {
						beforerender: function (cmp, opts) {
							cmp.setStore(Ext.create('App.store.GenericTypes'));
							cmp.getStore().load({ url: 'checkConsistency.php?_action=loadList'});
						},
					},
				},
				{ xtype: 'tbspacer', width: 20 },
				{ xtype: 'button', text: Oger._('Info'),
					handler: function (cmp, ev) {
						this.up('window').showCheckLevelInfoWindow();
					},
				},
			],
		},

	],  // eo form items

	url: 'checkConsistency.php',

	// ########################################################




});
