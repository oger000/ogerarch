/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Stratum store
*/
Ext.define('App.store.StratumComplexParts', {
	extend: 'Ext.data.Store',

	fields: [ 'id', 'excavId', 'stratumId', 'date', 'categoryId', 'categoryName', 'typeName' ],
	proxy: {
		type: 'ajax', url: 'php/scripts/stratum.php?_action=loadComplexPartList',
		reader: { type: 'json', rootProperty: 'data' }
	},
});
