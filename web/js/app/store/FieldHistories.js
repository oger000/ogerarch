/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* History store for input field entries.
*/
Ext.define('App.store.FieldHistories', {
	extend: 'Ext.data.Store',

	fields: [ 'id', 'text' ],
	proxy: {
		type: 'ajax', url: 'php/scripts/dummy.php',
		reader: { type: 'json', rootProperty: 'data' }
	},
});  // eo db list store
