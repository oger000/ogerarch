/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


Ext.define('App.store.UserGroup', {
	extend: 'App.store.OgerStore',
	alias: 'store.userGroup',

	model: 'App.model.UserGroup',

	proxy: {
		type: 'ajax', url: 'php/system/userGroup.php',
		extraParams: { _action: 'loadGrid' },
		reader: { type: 'json', rootProperty: 'data' },
	},

});
