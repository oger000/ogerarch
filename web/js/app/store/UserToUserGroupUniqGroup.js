/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


Ext.define('App.store.UserToUserGroupUniqGroup', {
	extend: 'App.store.OgerStore',
	alias: 'store.userToUserGroupUniqGroup',

	model: 'App.model.UserToUserGroupUniqGroup',

	proxy: {
		type: 'ajax', url: 'php/system/user.php',
		extraParams: { _action: 'loadGrid' },
		reader: { type: 'json', rootProperty: 'data' },
	},

});
