/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/



// TODO: link from stratumIdList to stratum(s)?

/**
* Arch find form
*/
Ext.define('App.view.inputCenter.archFind.Form', {
	extend: 'Ext.form.Panel',
	alias: 'widget.ic_archfindform',

	bodyPadding: 15,
	border: false,
	autoScroll: true,
	layout: 'anchor',
	trackResetOnLoad: true,

	items: [
		{ xtype: 'hidden', name: 'dbAction' },
		{ xtype: 'hidden', name: 'excavId' },
		{ xtype: 'fieldcontainer', layout: 'hbox',
			items: [
				{ name: 'archFindId', xtype: 'textfield', fieldLabel: Oger._('Fundnummer'), selectOnFocus: true,
					allowBlank: false, validator: xidValid, readOnly: true,
				},
				{ name: 'jumpToArchFindId', xtype: 'textfield', fieldLabel: Oger._('Springe zu Nr'), validator: xidValid,
					width: 250, labelWidth: 120, labelAlign: 'right',
					listeners: {
						change: function(field, newValue, oldValue, options) {
							field.resetOriginalValue();
						},
					},
				},
				{ xtype: 'button', text: Oger._('Springen'), width: 80,
					handler: function(button, event) {
						this.up('window').jumpToRecord();
					}
				},
			],
		},
		{ xtype: 'fieldcontainer', layout: 'hbox',
			items: [
				{ name: 'stratumIdList', xtype: 'textfield', fieldLabel: Oger._('Stratum'),
					validator: multiXidValid, //width: 210, // allowBlank: false,
				},
				/*  // for now do explicit check for isStrayFind on server side
				{ xtype: 'tbspacer', width: 5 },
				{ xtype: 'checkbox', boxLabel: Oger._('Ohne'), width: 50 },
				{ xtype: 'tbspacer', width: 10 },
				*/
				{ name: 'numCopies', xtype: 'numberfield', value: 1, minValue: 1,
					fieldLabel: Oger._('Exemplare'), width: 200, labelWidth: 120, labelAlign: 'right',
					listeners: {
						change: function(field, newValue, oldValue, options) {
							if ((1 * newValue) < 1) {
								field.setValue(1);
								return;
							}
							field.resetOriginalValue();
						},
					},
				},
				{ xtype: 'button', text: Oger._('Drucken + Speichern'), minWidth: 30,
					handler: function(button, event) {
						this.up('window').saveAndPrint();
					}
				},  // eo button
				{ xtype: 'tbspacer', width: 10 },
				{ xtype: 'button', text: Oger._('...'), minWidth: 10,
					handler: function(button, event) {
						this.up('window').multiPrint();
					}
				},  // eo button
			],
		},

		{ xtype: 'tabpanel',
			activeTab: 0,
			//height: 800,  // corresponds with autscroll ???
			plain: true,
			autoScroll: true,
			deferredRender: false,
			items: [
				{ xtype: 'panel',
					title: Oger._('Allgemein'),
					layout: 'anchor',
					bodyPadding: 15,
					border: false,
					hideMode: 'offsets',
					//autoScroll: true,

					items: [
						{ name: 'date', xtype: 'datefield', fieldLabel: Oger._('Datum'), submitFormat: 'Y-m-d' },
						{ name: 'interpretation', xtype: 'textfield', fieldLabel: Oger._('Interpretation'), width: 500 },
						{ xtype: 'fieldcontainer', layout: 'hbox',
							items: [
								{ name: 'datingSpec', xtype: 'textfield', fieldLabel: Oger._('Datierung'), width: 300 + 20 },
								{ name: 'datingPeriodId', xtype: 'combo', fieldLabel: Oger._('Periode'), width: 250,
									labelAlign: 'right',
									queryMode: 'local', valueField: 'id', displayField: 'name', triggerAction: 'all',
									forceSelection: true,
									store: { type: 'datingperiod', autoLoad: true },
								},
							],
						},
						{ name: 'planName', xtype: 'textfield', fieldLabel: Oger._('Plan'), width: 500 },
						{ xtype: 'displayfield', fieldLabel: Oger._('Bemerkungen'), value: '' },
						{ name: 'comment', xtype: 'textarea', hideLabel: true, width: 500, height: 150 },
					],
				},  // eo basics tab


				{ xtype: 'panel',
					title: Oger._('Lage/Verweis'),
					layout: 'anchor',
					bodyPadding: 15,
					border: false,
					hideMode: 'offsets',
					//autoScroll: true,
					defaults: {
						width: 500,
					},
					items: [
						{ xtype: 'fieldcontainer', layout: 'hbox',
							items: [
								{ name: 'plotName', xtype: 'textfield', fieldLabel: Oger._('Grundst-Nr'), width: 250 },
								{ name: 'fieldName', xtype: 'textfield', fieldLabel: Oger._('Flur'), width: 250, labelAlign: 'right' },
							],
						},
						{ xtype: 'fieldcontainer', layout: 'hbox',
							items: [
								{ name: 'section', xtype: 'textfield', fieldLabel: Oger._('Schnitt'), validator: multiXidValid, width: 250 },
								{ name: 'area', xtype: 'textfield', fieldLabel: Oger._('Fläche'), width: 250, labelAlign: 'right', validator: multiXidValid },
							],
						},
						{ xtype: 'fieldcontainer', layout: 'hbox',
							items: [
								{ name: 'profile', xtype: 'textfield', fieldLabel: Oger._('Profil'), validator: multiXidValid, width: 250 },
								{ name: 'isStrayFind', xtype: 'checkbox', hideEmptyLabel: false , width: 250, labelAlign: 'right',
									inputValue: '1', uncheckedValue: '0', boxLabel: Oger._('Streu-/Putzfund/Sonde'),
								},
							],
						},
						{ xtype: 'checkboxgroup', fieldLabel: Oger._('Bei Arbeitsschritt'),
							columns: 2,
							items: [
								{ name: 'atStepLowering', boxLabel: Oger._('Abtiefen'), inputValue: '1', uncheckedValue: '0' },
								{ name: 'atStepCleaningRaw', boxLabel: Oger._('Grobputzen'), inputValue: '1', uncheckedValue: '0' },
								{ name: 'atStepCleaningFine', boxLabel: Oger._('Feinputzen'), inputValue: '1', uncheckedValue: '0' },
								{ name: 'atStepOther', boxLabel: Oger._('Sonstiges'), inputValue: '1', uncheckedValue: '0' },
							]
						},
						//{ xtype: 'component', html: '<HR>' },
						{ xtype: 'fieldset', title: Oger._('Angaben ohne automatische Quer-Aktualisierung'),
							items: [
								{ xtype: 'fieldcontainer', layout: 'hbox',
									items: [
										{ name: 'interfaceIdList', xtype: 'textfield', fieldLabel: Oger._('Interface'), validator: multiXidValid, width: 250 },
									],
								},
								{ xtype: 'fieldcontainer', layout: 'hbox',
									items: [
										{ name: 'archObjectIdList', xtype: 'textfield', fieldLabel: Oger._('Objekt'), validator: multiXidValid, width: 250 },
										{ name: 'archObjGroupIdList', xtype: 'textfield', fieldLabel: Oger._('Objektgruppe'), validator: multiXidValid, width: 250, labelAlign: 'right' },
									],
								},
							],
						},
					],
				},  // eo location tab

				{ xtype: 'panel',
					title: Oger._('Details'),
					layout: 'anchor',
					bodyPadding: 15,
					border: false,
					hideMode: 'offsets',
					autoScroll: true,
					labelWidth: 75,
					defaults: {
						width: 500,
					},
					items: [
						{ xtype: 'textfield', fieldLabel: Oger._('Sonderfund'), name: 'specialArchFind' },

						{ xtype: 'radiogroup', fieldLabel: 'Keramik',
							columns: [ 60, 60, 100, 60 ],
							items: [
								{ boxLabel: '1 Stk', name: 'ceramicsCountId', inputValue: 1 },
								{ boxLabel: '1 EH', name: 'ceramicsCountId', inputValue: 2 },
								{ boxLabel: 'Mehrere EH', name: 'ceramicsCountId', inputValue: 3 },
								{ boxLabel: 'Nein', name: 'ceramicsCountId', inputValue: 0 },
							]
						},  // eo radio grp

						{ xtype: 'radiogroup', fieldLabel: 'Tierknochen',
							columns: [ 60, 60, 100, 60 ],
							items: [
								{ boxLabel: '1 Stk', name: 'animalBoneCountId', inputValue: 1, width: 60 },
								{ boxLabel: '1 EH', name: 'animalBoneCountId', inputValue: 2 },
								{ boxLabel: 'Mehrere EH', name: 'animalBoneCountId', inputValue: 3 },
								{ boxLabel: 'Nein', name: 'animalBoneCountId', inputValue: 0, },
							],
						},  // eo radio grp

						{ xtype: 'radiogroup', fieldLabel: 'Menschen knochen',
							columns: [ 60, 60, 100, 60 ],
							items: [
								{ boxLabel: '1 Stk', name: 'humanBoneCountId', inputValue: 1 },
								{ boxLabel: '1 EH', name: 'humanBoneCountId', inputValue: 2 },
								{ boxLabel: 'Mehrere EH', name: 'humanBoneCountId', inputValue: 3 },
								{ boxLabel: 'Nein', name: 'humanBoneCountId', inputValue: 0 },
							]
						},  // eo radio grp
						{ xtype: 'radiogroup', fieldLabel: 'Eisen',
							columns: [ 60, 60, 100, 60 ],
							items: [
								{ boxLabel: '1 Stk', name: 'ferrousCountId', inputValue: 1 },
								{ boxLabel: '1 EH', name: 'ferrousCountId', inputValue: 2 },
								{ boxLabel: 'Mehrere EH', name: 'ferrousCountId', inputValue: 3 },
								{ boxLabel: 'Nein', name: 'ferrousCountId', inputValue: 0 },
							]
						},  // eo radio grp
						{ xtype: 'radiogroup', fieldLabel: 'Buntmetall',
							columns: [ 60, 60, 100, 60 ],
							items: [
								{ boxLabel: '1 Stk', name: 'nonFerrousMetalCountId', inputValue: 1 },
								{ boxLabel: '1 EH', name: 'nonFerrousMetalCountId', inputValue: 2 },
								{ boxLabel: 'Mehrere EH', name: 'nonFerrousMetalCountId', inputValue: 3 },
								{ boxLabel: 'Nein', name: 'nonFerrousMetalCountId', inputValue: 0 },
							]
						},  // eo radio grp
						{ xtype: 'radiogroup', fieldLabel: 'Glas',
							columns: [ 60, 60, 100, 60 ],
							items: [
								{ boxLabel: '1 Stk', name: 'glassCountId', inputValue: 1 },
								{ boxLabel: '1 EH', name: 'glassCountId', inputValue: 2 },
								{ boxLabel: 'Mehrere EH', name: 'glassCountId', inputValue: 3 },
								{ boxLabel: 'Nein', name: 'glassCountId', inputValue: 0 },
							]
						},  // eo radio grp
						{ xtype: 'radiogroup', fieldLabel: 'Baukeramik',
							columns: [ 60, 60, 100, 60 ],
							items: [
								{ boxLabel: '1 Stk', name: 'architecturalCeramicsCountId', inputValue: 1 },
								{ boxLabel: '1 EH', name: 'architecturalCeramicsCountId', inputValue: 2 },
								{ boxLabel: 'Mehrere EH', name: 'architecturalCeramicsCountId', inputValue: 3 },
								{ boxLabel: 'Nein', name: 'architecturalCeramicsCountId', inputValue: 0 },
							]
						},  // eo radio grp
						{ xtype: 'radiogroup', fieldLabel: 'Hüttenlehm',
							columns: [ 60, 60, 100, 60 ],
							items: [
								{ boxLabel: '1 Stk', name: 'daubCountId', inputValue: 1 },
								{ boxLabel: '1 EH', name: 'daubCountId', inputValue: 2 },
								{ boxLabel: 'Mehrere EH', name: 'daubCountId', inputValue: 3 },
								{ boxLabel: 'Nein', name: 'daubCountId', inputValue: 0 },
							]
						},  // eo radio grp
						{ xtype: 'radiogroup', fieldLabel: 'Stein',
							columns: [ 60, 60, 100, 60 ],
							items: [
								{ boxLabel: '1 Stk', name: 'stoneCountId', inputValue: 1 },
								{ boxLabel: '1 EH', name: 'stoneCountId', inputValue: 2 },
								{ boxLabel: 'Mehrere EH', name: 'stoneCountId', inputValue: 3 },
								{ boxLabel: 'Nein', name: 'stoneCountId', inputValue: 0 },
							]
						},  // eo radio grp
						{ xtype: 'radiogroup', fieldLabel: 'Silex',
							columns: [ 60, 60, 100, 60 ],
							items: [
								{ boxLabel: '1 Stk', name: 'silexCountId', inputValue: 1 },
								{ boxLabel: '1 EH', name: 'silexCountId', inputValue: 2 },
								{ boxLabel: 'Mehrere EH', name: 'silexCountId', inputValue: 3 },
								{ boxLabel: 'Nein', name: 'silexCountId', inputValue: 0 },
							]
						},  // eo radio grp
						{ xtype: 'radiogroup', fieldLabel: 'Mörtel',
							columns: [ 60, 60, 100, 60 ],
							items: [
								{ boxLabel: '1 Stk', name: 'mortarCountId', inputValue: 1 },
								{ boxLabel: '1 EH', name: 'mortarCountId', inputValue: 2 },
								{ boxLabel: 'Mehrere EH', name: 'mortarCountId', inputValue: 3 },
								{ boxLabel: 'Nein', name: 'mortarCountId', inputValue: 0 },
							]
						},  // eo radio grp
						{ xtype: 'radiogroup', fieldLabel: 'Holz',
							columns: [ 60, 60, 100, 60 ],
							items: [
								{ boxLabel: '1 Stk', name: 'timberCountId', inputValue: 1 },
								{ boxLabel: '1 EH', name: 'timberCountId', inputValue: 2 },
								{ boxLabel: 'Mehrere EH', name: 'timberCountId', inputValue: 3 },
								{ boxLabel: 'Nein', name: 'timberCountId', inputValue: 0 },
							]
						},  // eo radio grp

						{ xtype: 'panel', html: '<BR>', border: false },
						{ name: 'organic', xtype: 'textfield', fieldLabel: Oger._('Organisches'), width: 500 },
						{ name: 'archFindOther', xtype: 'textfield', fieldLabel: Oger._('Sonst. Funde'), width: 500 },

					],
				},  // eo find detail tab

				{ xtype: 'panel',
					title: Oger._('Proben'),
					layout: 'anchor',
					bodyPadding: 15,
					border: false,
					hideMode: 'offsets',
					//autoScroll: true,
					defaults: {
						width: 500,
					},
					items: [
						{ name: 'sedimentSampleCountId', xtype: 'checkbox', fieldLabel: Oger._('Sedimentprobe'),
							inputValue: '1', uncheckedValue: '0'
						},
						{ name: 'slurrySampleCountId', xtype: 'checkbox', fieldLabel: Oger._('Schlämmprobe'),
							inputValue: '1', uncheckedValue: '0'
						},
						{ name: 'charcoalSampleCountId', xtype: 'checkbox', fieldLabel: Oger._('Holzkohleprobe'),
							inputValue: '1', uncheckedValue: '0'
						},
						{ name: 'mortarSampleCountId', xtype: 'checkbox', fieldLabel: Oger._('Mörtelprobe'),
							inputValue: '1', uncheckedValue: '0'
						},
						{ name: 'slagSampleCountId', xtype: 'checkbox', fieldLabel: Oger._('Schlackeprobe'), inputValue: '1',
							uncheckedValue: '0'
						},
						{ name: 'sampleOther', xtype: 'textfield', fieldLabel: Oger._('Sonst. Proben') },
					],
				},  // eo basics tab

				/*
				{ xtype: 'panel',
					title: Oger._('Planum'),
					isPlanumPanel: true,
					layout: 'anchor',
					bodyPadding: 15,
					border: false,
					hideMode: 'offsets',
					//autoScroll: true,
					items: [
						{ xtype: 'textfield', fieldLabel: Oger._('Planum'), name: 'auxPlanum' },
						{ xtype: 'textfield', fieldLabel: Oger._('Objekt'), name: 'auxObject' },
						{ xtype: 'textfield', fieldLabel: Oger._('Grab'), name: 'auxGrave' },
						{ xtype: 'textfield', fieldLabel: Oger._('Mauer'), name: 'auxWall' },
					],
				},
				*/

				{ xtype: 'panel',
					title: Oger._('Verbleib'),
					disabled: true,
					hideMode: 'offsets',
				},

			], // eo tabpanel items
		},  // eo tabpanel inside form
	],  // eo form items

	url: 'php/scripts/archFind.php',

	listeners: {
		actioncomplete: function(form, action) {  // for radioboxes and alike
			if (action.type == 'load') {
				if (!form.preserveJumpToId) {
					form.findField('jumpToArchFindId').setValue('');
				}
				form.preserveJumpToId = false;

				form.findField('dbAction').setValue('UPDATE');
				form.findField('archFindId').setReadOnly(true);
				Oger.extjs.resetDirty(form);

				var win = form.owner.up('window');
				if (win.afterLoadCallback) {
					win.afterLoadCallback();
					delete win.afterLoadCallback;
				}
			}
		},
		actionfailed: function(form, action) {  // for end of next/prev jumps
			if (action.type == 'load') {
				var win = form.owner.up('window');
				delete win.afterLoadCallback;

				Oger.extjs.resetDirty(form);
				if (action.result && action.result.msg) {
					Ext.create('Oger.extjs.MessageBox').alert(Oger._('Fehler'), Oger._(action.result.msg));
					return;
				}
				Oger.extjs.actionSuccess(action); // show common errors
			}
		},
	},  // eo listeners


	// ########################################################



});
