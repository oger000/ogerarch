/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Objects to one arch object GROUP store
*/
Ext.define('App.store.ArchObjGroupArchObjects', {
	extend: 'Ext.data.Store',

	// typename is type of arch object (not of group!)
	fields: [ 'id', 'excavId', 'archObjGroupId', 'archObjectId', 'typeName', 'stratumIdList' ],
	proxy: {
		type: 'ajax', url: 'php/scripts/archObjGroup.php?_action=loadArchObjectList',
		reader: { type: 'json', rootProperty: 'data' }
	},
});
