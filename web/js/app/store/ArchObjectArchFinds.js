/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Arch object - arch find store
*/
Ext.define('App.store.ArchObjectArchFinds', {
	extend: 'Ext.data.Store',

	fields: [ 'id', 'excavId', 'archFindId', 'date', 'stratumIdList', 'specialArchFind',
						'ceramicsCountId',  'animalBoneCountId', 'humanBoneCountId',
						'ferrousCountId', 'nonFerrousMetalCountId', 'glassCountId',
						'architecturalCeramicsCountId', 'daubCountId', 'stoneCountId',
						'silexCountId', 'mortarCountId', 'timberCountId' ],
	//sorters: [ { property: 'archFindId', direction: 'DESC' } ],
	proxy: {
		type: 'ajax', url: 'php/scripts/archObject.php?_action=loadArchFindRecords',
		reader: { type: 'json', rootProperty: 'data' }
	},
});
