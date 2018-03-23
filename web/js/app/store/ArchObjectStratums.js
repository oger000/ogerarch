/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Stratums to one arch object store
*/
Ext.define('App.store.ArchObjectStratums', {
	extend: 'Ext.data.Store',

	fields: [ 'id', 'excavId', 'objectId', 'stratumId', 'date', 'categoryName', 'typeName' ],
	proxy: {
		type: 'ajax', url: 'php/scripts/archObject.php?_action=loadStratumList',
		reader: { type: 'json', rootProperty: 'data' }
	},
});
