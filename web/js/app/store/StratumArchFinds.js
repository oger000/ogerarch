/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Stratum arch find store
*/
Ext.define('App.store.StratumArchFinds', {
	extend: 'Ext.data.Store',

	fields: [ 'id', 'excavId', 'archFindId', 'date', 'stratumIdList', 'specialArchFind',
						'ceramicsCountId',  'animalBoneCountId', 'humanBoneCountId',
						'ferrousCountId', 'nonFerrousMetalCountId', 'glassCountId',
						'architecturalCeramicsCountId', 'daubCountId', 'stoneCountId',
						'silexCountId', 'mortarCountId', 'timberCountId' ],
	//sorters: [ { property: 'archFindId', direction: 'DESC' } ],
	proxy: {
		type: 'ajax', url: 'php/scripts/stratum.php?_action=loadArchFindRecords',
		reader: { type: 'json', rootProperty: 'data' }
	},
});
