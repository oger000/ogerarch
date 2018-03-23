/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


Ext.define('App.model.UserGroup', {
	extend: 'Ext.data.Model',

	fields: [
	// autogen-begin>
		'userGroupId',
		'name',
		'updateMasterDataPerm',
		'insertBookingPerm',
		'updateBookingPerm',
	// <autogen-end
	],
});
