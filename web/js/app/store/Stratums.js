/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Stratum store
*/
Ext.define('App.store.Stratums', {
	extend: 'Ext.data.Store',

	model: 'App.model.Stratum',

	proxy: {
		type: 'ajax', url: 'php/scripts/stratum.php?_action=loadList',
		reader: { type: 'json', rootProperty: 'data' }
	},
});
