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
Ext.define('App.view.inputCenter.stock.prepFind.StateInputPanel', {
	extend: 'Ext.form.Panel',
	alias: 'widget.ic_stockprepfindstateinputpanel',

	layout: 'anchor',
	bodyPadding: 15,
	border: false,
	autoScroll: true,
	labelWidth: 75,
	defaults: {
		width: 500,
	},
	items: [
		//{ xtype: 'textfield', fieldLabel: Oger._('Sonderfund'), name: 'specialArchFind' },

		{ xtype: 'radiogroup', fieldLabel: Oger._('Gereinigt'),
			columns: [ 70, 90, 90, 70, 100 ], ogerExtraHide: true,
			style: { 'background-color': '#D8D8D8' },
			items: [
				{ boxLabel: Oger._('Nein'), name: 'washStatusId', inputValue: 0 },
				{ boxLabel: Oger._('Geplant'), name: 'washStatusId', inputValue: 1 },
				{ boxLabel: Oger._('Teilweise'), name: 'washStatusId', inputValue: 2 },
				{ boxLabel: Oger._('Fertig'), name: 'washStatusId', inputValue: 3 },
				{ boxLabel: Oger._('Unverändert'), name: 'washStatusId', inputValue: -1,
					hidden: true, ogerHidden: true,
				},
			]
		},  // eo radio grp

		{ xtype: 'radiogroup', fieldLabel: Oger._('Beschriftet'),
			columns: [ 70, 90, 90, 70, 100 ], ogerExtraHide: true,
			//style: { 'background-color': '#D8D8D8' },
			items: [
				{ boxLabel: Oger._('Nein'), name: 'labelStatusId', inputValue: 0 },
				{ boxLabel: Oger._('Geplant'), name: 'labelStatusId', inputValue: 1 },
				{ boxLabel: Oger._('Teilweise'), name: 'labelStatusId', inputValue: 2 },
				{ boxLabel: Oger._('Fertig'), name: 'labelStatusId', inputValue: 3, },
				{ boxLabel: Oger._('Unverändert'), name: 'labelStatusId', inputValue: -1,
					hidden: true, ogerHidden: true,
				},
			],
		},  // eo radio grp

		{ xtype: 'radiogroup', fieldLabel: Oger._('Restauriert'),
			columns: [ 70, 90, 90, 70, 100 ], ogerExtraHide: true,
			style: { 'background-color': '#D8D8D8' },
			items: [
				{ boxLabel: Oger._('Nein'), name: 'restoreStatusId', inputValue: 0 },
				{ boxLabel: Oger._('Geplant'), name: 'restoreStatusId', inputValue: 1 },
				{ boxLabel: Oger._('Teilweise'), name: 'restoreStatusId', inputValue: 2 },
				{ boxLabel: Oger._('Fertig'), name: 'restoreStatusId', inputValue: 3 },
				{ boxLabel: Oger._('Unverändert'), name: 'restoreStatusId', inputValue: -1,
					hidden: true, ogerHidden: true,
				},
			]
		},  // eo radio grp
		{ xtype: 'radiogroup', fieldLabel: Oger._('Fotografiert'),
			columns: [ 70, 90, 90, 70, 100 ], ogerExtraHide: true,
			//style: { 'background-color': '#D8D8D8' },
			items: [
				{ boxLabel: Oger._('Nein'), name: 'photographStatusId', inputValue: 0 },
				{ boxLabel: Oger._('Geplant'), name: 'photographStatusId', inputValue: 1 },
				{ boxLabel: Oger._('Teilweise'), name: 'photographStatusId', inputValue: 2 },
				{ boxLabel: Oger._('Fertig'), name: 'photographStatusId', inputValue: 3 },
				{ boxLabel: Oger._('Unverändert'), name: 'photographStatusId', inputValue: -1,
					hidden: true, ogerHidden: true,
				},
			]
		},  // eo radio grp
		{ xtype: 'radiogroup', fieldLabel: Oger._('Gezeichnet'),
			columns: [ 70, 90, 90, 70, 100 ], ogerExtraHide: true,
			style: { 'background-color': '#D8D8D8' },
			items: [
				{ boxLabel: Oger._('Nein'), name: 'drawStatusId', inputValue: 0 },
				{ boxLabel: Oger._('Geplant'), name: 'drawStatusId', inputValue: 1 },
				{ boxLabel: Oger._('Teilweise'), name: 'drawStatusId', inputValue: 2 },
				{ boxLabel: Oger._('Fertig'), name: 'drawStatusId', inputValue: 3 },
				{ boxLabel: Oger._('Unverändert'), name: 'drawStatusId', inputValue: -1,
					hidden: true, ogerHidden: true,
				},
			]
		},  // eo radio grp
		{ xtype: 'radiogroup', fieldLabel: Oger._('Gesetzt'),
			columns: [ 70, 90, 90, 70, 100 ], ogerExtraHide: true,
			//style: { 'background-color': '#D8D8D8' },
			items: [
				{ boxLabel: Oger._('Nein'), name: 'layoutStatusId', inputValue: 0 },
				{ boxLabel: Oger._('Geplant'), name: 'layoutStatusId', inputValue: 1 },
				{ boxLabel: Oger._('Teilweise'), name: 'layoutStatusId', inputValue: 2 },
				{ boxLabel: Oger._('Fertig'), name: 'layoutStatusId', inputValue: 3 },
				{ boxLabel: Oger._('Unverändert'), name: 'layoutStatusId', inputValue: -1,
					hidden: true, ogerHidden: true,
				},
			]
		},  // eo radio grp
		{ xtype: 'radiogroup', fieldLabel: Oger._('Wissensch.Bearb.'),
			columns: [ 70, 90, 90, 70, 100 ], ogerExtraHide: true,
			style: { 'background-color': '#D8D8D8' },
			items: [
				{ boxLabel: Oger._('Nein'), name: 'scientificStatusId', inputValue: 0 },
				{ boxLabel: Oger._('Geplant'), name: 'scientificStatusId', inputValue: 1 },
				{ boxLabel: Oger._('Teilweise'), name: 'scientificStatusId', inputValue: 2 },
				{ boxLabel: Oger._('Fertig'), name: 'scientificStatusId', inputValue: 3 },
				{ boxLabel: Oger._('Unverändert'), name: 'scientificStatusId', inputValue: -1,
					hidden: true, ogerHidden: true,
				},
			]
		},  // eo radio grp
		{ xtype: 'radiogroup', fieldLabel: Oger._('Publiziert'),
			columns: [ 70, 90, 90, 70, 100 ], ogerExtraHide: true,
			//style: { 'background-color': '#D8D8D8' },
			items: [
				{ boxLabel: Oger._('Nein'), name: 'publishStatusId', inputValue: 0 },
				{ boxLabel: Oger._('Geplant'), name: 'publishStatusId', inputValue: 1 },
				{ boxLabel: Oger._('Teilweise'), name: 'publishStatusId', inputValue: 2 },
				{ boxLabel: Oger._('Fertig'), name: 'publishStatusId', inputValue: 3 },
				{ boxLabel: Oger._('Unverändert'), name: 'publishStatusId', inputValue: -1,
					hidden: true, ogerHidden: true,
				},
			]
		},  // eo radio grp

		/*
		{ xtype: 'panel', html: '<BR>', border: false },
		{ name: 'organic', xtype: 'textfield', fieldLabel: Oger._('Organisches'), width: 500 },
		{ name: 'archFindOther', xtype: 'textfield', fieldLabel: Oger._('Sonst. Funde'), width: 500 },
		*/

	],

});
