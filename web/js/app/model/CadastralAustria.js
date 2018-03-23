/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


Ext.define('App.model.CadastralAustria', {
	extend: 'Ext.data.Model',

	fields: [
	// autogen-begin>
		'cadastralId',
		'name',
		'districtName',
		'surveyOfficeName',
		'regionId',
		'unknown1',
		'communeId',
		'communeName',
		'unknown2',
		'geo1a',
		'geo1b',
		'geo2a',
		'geo2b',
	// <autogen-end
	],
});
