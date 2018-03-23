/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Db name store for logon
*/
Ext.define('App.store.DbNames', {
	extend: 'Ext.data.Store',

	fields: [ 'dbDefAliasId', 'dbName', 'allowAutoLogon' ],
	proxy: {
		type: 'ajax', url: 'php/system/logon.php?_action=loadDbList',
		reader: { type: 'json', rootProperty: 'data' }
	},
});  // eo db list store
