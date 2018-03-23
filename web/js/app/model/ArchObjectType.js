/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


Ext.define('App.model.ArchObjectType', {
	extend: 'Ext.data.Model',

	fields: [
	// autogen-begin>
		'id',
		'name',
		'code',
		{ name: 'beginDate', type: 'date' },
		{ name: 'endDate', type: 'date' },
	// <autogen-end
	],
});
