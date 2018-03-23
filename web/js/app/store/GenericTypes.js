/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Generic store for arbitary types.
* Stores are loaded explicitly providing an valid url.
*/
Ext.define('App.store.GenericTypes', {
	extend: 'Ext.data.Store',

	fields: [ 'id', 'name', 'code', 'beginDate', 'endDate' ],
	proxy: {
		type: 'ajax', url: 'php/scripts/dummy.php',
		reader: { type: 'json', rootProperty: 'data' }
	},
});
