/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Stratum - arch object GROUPS store
*/
Ext.define('App.store.StratumArchObjGroups', {
	extend: 'Ext.data.Store',

	fields: [ 'id', 'excavId', 'archObjGroupId', 'typeName', 'archObjectIdList' ],
	proxy: {
		type: 'ajax', url: 'php/scripts/stratum.php?_action=loadArchObjGroupRecords',
		reader: { type: 'json', rootProperty: 'data' }
	},
});
