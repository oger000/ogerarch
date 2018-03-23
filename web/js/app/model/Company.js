/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


Ext.define('App.model.Company', {
	extend: 'Ext.data.Model',

	fields: [
	// autogen-begin>
		'id',
		'name1',
		'name2',
		'street',
		'postalCode',
		'city',
		'countryName',
		'shortName',
	// <autogen-end
	],
});
