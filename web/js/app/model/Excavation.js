/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


Ext.define('App.model.Excavation', {
	extend: 'Ext.data.Model',

	fields: [
	// autogen-begin>
		'id',
		'name',
		'excavMethodId',
		{ name: 'beginDate', type: 'date' },
		{ name: 'endDate', type: 'date' },
		'authorizedPerson',
		'originator',
		'officialId',
		'officialId2',
		'countryName',
		'regionName',
		'districtName',
		'communeName',
		'cadastralCommunityName',
		'fieldName',
		'plotName',
		'datingSpec',
		'datingPeriodId',
		'gpsX',
		'gpsY',
		'gpsZ',
		'comment',
		'projectBaseDir',
		'inactive',
		'emailBda',
	// <autogen-end
		'excavMethodName', 'archFindCount', 'stratumCount', 'archObjectCount', 'archObjGroupCount', 'prepFindCount',
	],
});
