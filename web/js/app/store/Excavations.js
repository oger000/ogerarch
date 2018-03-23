/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Excavations store
*/
Ext.define('App.store.Excavations', {
	extend: 'Ext.data.Store',

	model: 'App.model.Excavation',

	proxy: {
		type: 'ajax', url: 'php/scripts/excavation.php?_action=loadList',
		reader: { type: 'json', rootProperty: 'data' }
	},
});


