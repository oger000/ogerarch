/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


Ext.define('App.model.ArchFindCatalog', {
	extend: 'Ext.data.Model',

	fields: [
	// autogen-begin>
		'excavId',
		'catalogId',
		'partId',
		'archFindId',
		'denotation',
		'type',
		'subType',
		'material',
		'lengthValue',
		'width',
		'height',
		'diaMeter',
		'description',
		'comment',
	// <autogen-end
	],
});
