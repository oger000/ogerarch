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
Ext.define('App.view.inputCenter.stock.prepFind.Window', {
	extend: 'Ext.window.Window',
	alias: 'widget.ic_stockprepfindwindow',
	controller: 'ic_stockPrepFindWindow',

	title: Oger._('Fund/Lager'),
	width: 700, height: 550,
	// modal: true,
	//autoScroll: true,
	layout: 'fit',

	items: [
		{ xtype: 'form',
			url: 'php/scripts/prepFind.php',

			bodyPadding: 15, border: false,
			autoScroll: true,
			trackResetOnLoad: true,
			layout: 'anchor',

			items: [
				{ xtype: 'hidden', name: 'dbAction' },
				{ xtype: 'hidden', name: 'excavId' },
				{ xtype: 'fieldcontainer', layout: 'hbox',
					items: [
						{ name: 'stockLocationName', xtype: 'textfield',
							fieldLabel: Oger._('Behälter'), labelWidth: 80,
							readOnly: true, submitValue: false,
						},
						{ xtype: 'tbspacer', width: 30 },
						{ name: 'archFindId', xtype: 'textfield', readOnly: true,
							fieldLabel: Oger._('Fundnummer'), width: 200,
						},
						{ xtype: 'tbspacer', width: 10 },
						{ name: 'archFindSubId', xtype: 'textfield', readOnly: true,
							fieldLabel: Oger._('Sub'), labelWidth: 40, width: 120,
						},
					],
				},

				{ xtype: 'tabpanel',
					activeTab: 0,
					//height: 800,  // corresponds with autscroll ???
					plain: true,
					autoScroll: true,
					deferredRender: false,
					items: [

						{ xtype: 'ic_stockprepfindstateinputpanel',
							title: Oger._('Status'),
							hideMode: 'offsets',
						},  // eo find detail tab

						{ xtype: 'ic_stockprepfindmaterialinputpanel',
							title: Oger._('Material'),
							hideMode: 'offsets',
						},  // eo material tab

						{ title: Oger._('Allgemein'),
							xtype: 'panel', hideMode: 'offsets',
							bodyPadding: 15, border: false,
							//autoScroll: true,
							layout: 'anchor',

							items: [
								{ xtype: 'fieldcontainer', layout: 'hbox',
									items: [
										{ name: 'oriArchFindId', xtype: 'textfield', fieldLabel: Oger._('Original Fundnr'),
											allowBlank: false, validator: xidValid,
										},
										{ xtype: 'tbspacer', width: 10 },
										{ xtype: 'button', text: Oger._('...'), width: 30, handler: 'jumpToOriArchFind' },
									],
								},
								{ name: 'datingSpec', xtype: 'textfield', fieldLabel: Oger._('Datierung'), width: 300 + 20 },
								{ xtype: 'displayfield', fieldLabel: Oger._('Bemerkungen'), value: '' },
								{ name: 'comment', xtype: 'textarea', hideLabel: true, width: 500, height: 150 },
							],
						},  // eo basics tab

						{ xtype: 'panel',
							title: Oger._('Lagerort'),
							layout: 'anchor',
							bodyPadding: 15,
							border: false,
							hideMode: 'offsets',
							//autoScroll: true,

							items: [
								//{ xtype: 'displayfield', fieldLabel: Oger._('Bemerkungen'), value: '' },
								{ name: 'stockLocFullName', xtype: 'textarea', hideLabel: true,
									width: 500, height: 150, readOnly: true, submitValue: false,
								},
							],
						},  // eo stock location tab

					], // eo tabpanel items
				},  // eo tabpanel inside form
			],  // eo form items
		},  // eo form
	],

	buttonAlign: 'center',
	minButtonWidth: 30,
	buttons: [
		{ text: Oger._('Speichern'), handler: 'saveRecord' },
		{ text: Oger._('Zurücksetzen'), handler: 'resetForm' },
	],  // eo buttons


	listeners: {
		beforeclose: Oger.extjs.defaultOnBeforeWinClose,
		close: 'onClose',
	},


});
