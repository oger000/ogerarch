/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


Ext.define('App.model.StratumTimber', {
	extend: 'Ext.data.Model',

	fields: [
	// autogen-begin>
		'id',
		'excavId',
		'stratumId',
		'dendrochronology',
		'lengthApplyTo',
		'widthApplyTo',
		'heightApplyTo',
		'orientation',
		'functionDescription',
		'constructDescription',
		'relationDescription',
		'timberType',
		'infill',
		'otherConstructMaterial',
		'surface',
		'preservationStatus',
		'physioZoneDullEdge',
		'physioZoneSeapWood',
		'physioZoneHeartWood',
		'secundaryUsage',
		'processSign',
		'processDetail',
		'connection',
	// <autogen-end
	],
});
