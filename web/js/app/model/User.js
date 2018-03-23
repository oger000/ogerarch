/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


Ext.define('App.model.User', {
	extend: 'Ext.data.Model',

	fields: [
	// autogen-begin>
		'userId',
		'logonName',
		'realName',
		'password',
		'sslClientDN',
		'sslClientIssuerDN',
		'logonPerm',
		'superPerm',
		'comment',
	// <autogen-end
	],
});
