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
Ext.define('App.view.inputCenter.stock.prepFind.MaterialInputPanel', {
	extend: 'Ext.form.Panel',
	alias: 'widget.ic_stockprepfindmaterialinputpanel',

	layout: 'anchor',
	bodyPadding: 15, border: false,
	autoScroll: true,
	labelWidth: 100,
	defaults: {
		width: 500,
	},
	items: [
		//{ xtype: 'textfield', fieldLabel: Oger._('Sonderfund'), name: 'specialArchFind' },


		{ xtype: 'radiogroup', fieldLabel: 'Keramik',
			style: { 'background-color': '#D8D8D8' },
			columns: [ 60, 60, 100, 60 ], ogerExtraHide: true,
			items: [
				{ boxLabel: 'Nein', name: 'ceramicsCountId', inputValue: 0 },
				{ boxLabel: 'Ja', name: 'ceramicsCountId', inputValue: 1 },
				{ boxLabel: 'Unverändert', name: 'ceramicsCountId', inputValue: -1,
					hidden: true, ogerHidden: true,
				},
			]
		},  // eo radio grp

		{ xtype: 'radiogroup', fieldLabel: 'Tierknochen',
			columns: [ 60, 60, 100, 60 ], ogerExtraHide: true,
			items: [
				{ boxLabel: 'Nein', name: 'animalBoneCountId', inputValue: 0, width: 60 },
				{ boxLabel: 'Ja', name: 'animalBoneCountId', inputValue: 1 },
				{ boxLabel: 'Unverändert', name: 'animalBoneCountId', inputValue: -1,
					hidden: true, ogerHidden: true,
				},
			],
		},  // eo radio grp

		{ xtype: 'radiogroup', fieldLabel: 'Mensch.knochen',
			style: { 'background-color': '#D8D8D8' },
			columns: [ 60, 60, 100, 60 ], ogerExtraHide: true,
			items: [
				{ boxLabel: 'Nein', name: 'humanBoneCountId', inputValue: 0 },
				{ boxLabel: 'Ja', name: 'humanBoneCountId', inputValue: 1 },
				{ boxLabel: 'Unverändert', name: 'humanBoneCountId', inputValue: -1,
					hidden: true, ogerHidden: true,
				},
			]
		},  // eo radio grp
		{ xtype: 'radiogroup', fieldLabel: 'Eisen',
			columns: [ 60, 60, 100, 60 ], ogerExtraHide: true,
			items: [
				{ boxLabel: 'Nein', name: 'ferrousCountId', inputValue: 0 },
				{ boxLabel: 'Ja', name: 'ferrousCountId', inputValue: 1 },
				{ boxLabel: 'Unverändert', name: 'ferrousCountId', inputValue: -1,
					hidden: true, ogerHidden: true,
				},
			]
		},  // eo radio grp
		{ xtype: 'radiogroup', fieldLabel: 'Buntmetall',
			style: { 'background-color': '#D8D8D8' },
			columns: [ 60, 60, 100, 60 ], ogerExtraHide: true,
			items: [
				{ boxLabel: 'Nein', name: 'nonFerrousMetalCountId', inputValue: 0 },
				{ boxLabel: 'Ja', name: 'nonFerrousMetalCountId', inputValue: 1 },
				{ boxLabel: 'Unverändert', name: 'nonFerrousMetalCountId', inputValue: -1,
					hidden: true, ogerHidden: true,
				},
			]
		},  // eo radio grp
		{ xtype: 'radiogroup', fieldLabel: 'Glas',
			columns: [ 60, 60, 100, 60 ], ogerExtraHide: true,
			items: [
				{ boxLabel: 'Nein', name: 'glassCountId', inputValue: 0 },
				{ boxLabel: 'Ja', name: 'glassCountId', inputValue: 1 },
				{ boxLabel: 'Unverändert', name: 'glassCountId', inputValue: -1,
					hidden: true, ogerHidden: true,
				},
			]
		},  // eo radio grp
		{ xtype: 'radiogroup', fieldLabel: 'Baukeramik',
			style: { 'background-color': '#D8D8D8' },
			columns: [ 60, 60, 100, 60 ], ogerExtraHide: true,
			items: [
				{ boxLabel: 'Nein', name: 'architecturalCeramicsCountId', inputValue: 0 },
				{ boxLabel: 'Ja', name: 'architecturalCeramicsCountId', inputValue: 1 },
				{ boxLabel: 'Unverändert', name: 'architecturalCeramicsCountId', inputValue: -1,
					hidden: true, ogerHidden: true,
				},
			]
		},  // eo radio grp
		{ xtype: 'radiogroup', fieldLabel: 'Hüttenlehm',
			columns: [ 60, 60, 100, 60 ], ogerExtraHide: true,
			items: [
				{ boxLabel: 'Nein', name: 'daubCountId', inputValue: 0 },
				{ boxLabel: 'Ja', name: 'daubCountId', inputValue: 1 },
				{ boxLabel: 'Unverändert', name: 'daubCountId', inputValue: -1,
					hidden: true, ogerHidden: true,
				},
			]
		},  // eo radio grp
		{ xtype: 'radiogroup', fieldLabel: 'Stein',
			style: { 'background-color': '#D8D8D8' },
			columns: [ 60, 60, 100, 60 ], ogerExtraHide: true,
			items: [
				{ boxLabel: 'Nein', name: 'stoneCountId', inputValue: 0 },
				{ boxLabel: 'Ja', name: 'stoneCountId', inputValue: 1 },
				{ boxLabel: 'Unverändert', name: 'stoneCountId', inputValue: -1,
					hidden: true, ogerHidden: true,
				},
			]
		},  // eo radio grp
		{ xtype: 'radiogroup', fieldLabel: 'Silex',
			columns: [ 60, 60, 100, 60 ], ogerExtraHide: true,
			items: [
				{ boxLabel: 'Nein', name: 'silexCountId', inputValue: 0 },
				{ boxLabel: 'Ja', name: 'silexCountId', inputValue: 1 },
				{ boxLabel: 'Unverändert', name: 'silexCountId', inputValue: -1,
					hidden: true, ogerHidden: true,
				},
			]
		},  // eo radio grp
		{ xtype: 'radiogroup', fieldLabel: 'Mörtel',
			style: { 'background-color': '#D8D8D8' },
			columns: [ 60, 60, 100, 60 ], ogerExtraHide: true,
			items: [
				{ boxLabel: 'Nein', name: 'mortarCountId', inputValue: 0 },
				{ boxLabel: 'Ja', name: 'mortarCountId', inputValue: 1 },
				{ boxLabel: 'Unverändert', name: 'mortarCountId', inputValue: -1,
					hidden: true, ogerHidden: true,
				},
			]
		},  // eo radio grp
		{ xtype: 'radiogroup', fieldLabel: 'Holz',
			columns: [ 60, 60, 100, 60 ], ogerExtraHide: true,
			items: [
				{ boxLabel: 'Nein', name: 'timberCountId', inputValue: 0 },
				{ boxLabel: 'Ja', name: 'timberCountId', inputValue: 1 },
				{ boxLabel: 'Unverändert', name: 'timberCountId', inputValue: -1,
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
