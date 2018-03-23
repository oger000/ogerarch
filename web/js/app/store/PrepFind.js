/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
*/
Ext.define('App.store.PrepFind', {
	extend: 'Ext.data.Store',
	model: 'App.model.PrepFind',
	alias: 'store.prepFind',

	proxy: {
		type: 'ajax', url: 'php/scripts/prepFind.php',
		reader: { type: 'json', rootProperty: 'data' }
	},
});
