/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


Ext.define('App.store.DbDefList', {
	extend: 'App.store.OgerStore',
	alias: 'store.dbDefList',

	fields: [ 'dbDefId', 'name', 'autoLogon' ],

	proxy: {
		type: 'ajax', url: 'php/system/logon.php',
		extraParams: { _action: 'loadDbDefList' },
		reader: { type: 'json', rootProperty: 'data' },
	},

});
