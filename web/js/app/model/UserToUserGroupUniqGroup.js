/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


Ext.define('App.model.UserToUserGroupUniqGroup', {
	extend: 'App.model.UserToUserGroup',

	// we load only user groups for ONE user into the store
	// and we rely on the user group id to be unique for this usage !!!
	idProperty: 'userGroupId',


});
