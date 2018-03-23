/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Stratum types for all categories
*/
Ext.define('App.store.StratumTypes', {
	extend: 'Ext.data.Store',

	fields: [ 'id', 'name', 'code', 'categoryId', 'categoryName' ],
	proxy: {
		type: 'ajax', url: 'php/scripts/stratumType.php?_action=loadList',
		reader: { type: 'json', rootProperty: 'data' }
	},
});
