/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


Ext.define('App.model.StockLocation', {
	extend: 'Ext.data.Model',

	fields: [
	// autogen-begin>
		'stockLocationId',
		'excavId',
		'name',
		'outerId',
		'movable',
		'reusable',
		'typeId',
		'maxInnerTypeId',
		'canItem',
		'canExcavMovable',
		'canReusableMovable',
		'contentComment',
	// <autogen-end
		'parentName',
		{ name: 'id', mapping: 'stockLocationId' },  // for node interface
		/*
		{ name: 'id', type:'string',   // for node interface
			convert: function (val, rec) {
				return rec.get('stockLocationId');
			}
		},
		*/
	],

});
