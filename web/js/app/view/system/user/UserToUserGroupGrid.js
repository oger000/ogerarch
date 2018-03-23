/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/



/**
*/
Ext.define('App.view.system.user.UserToUserGroupGrid', {
	extend: 'Ext.grid.Panel',
	alias: 'widget.systemUserToUserGroupGrid',

	//controller: 'systemUserGroupGrid',

	stripeRows: true,
	columnLines: true,
	autoScroll: true,

	multiSelect: true,

	store: {
		type: 'userToUserGroupUniqGroup', pageSize: 0, //autoLoad: true,
		//remoteSort: true, remoteFilter: true,
	},

	columns: [
		{ header: Oger._('UserId'), dataIndex: 'userId', width: 50, hidden: true },
		{ header: Oger._('GroupId'), dataIndex: 'userGroupId', width: 50, hidden: true },
		{ header: Oger._('Bezeichung'), dataIndex: 'name', width: 150 },
		//{ header: Oger._('Dummy'), dataIndex: 'dummyPerm', width: 50 },
	],


});
