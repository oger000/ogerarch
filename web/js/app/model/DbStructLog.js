/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


Ext.define('App.model.DbStructLog', {
	extend: 'Ext.data.Model',

	fields: [
	// autogen-begin>
		'id',
		'beginTime',
		'structSerial',
		'structTime',
		'preCheck',
		'cmdLog',
		'log',
		'error',
		'postCheck',
		'surplus',
		'endTime',
	// <autogen-end
	],
});
