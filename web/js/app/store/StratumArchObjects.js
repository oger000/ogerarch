/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Stratum arch object store
*/
Ext.define('App.store.StratumArchObjects', {
	extend: 'Ext.data.Store',

	fields: [ 'id', 'excavId', 'archObjectId', 'typeName', 'archObjGroupIdList' ],
	proxy: {
		type: 'ajax', url: 'php/scripts/stratum.php?_action=loadArchObjectRecords',
		reader: { type: 'json', rootProperty: 'data' }
	},
});
