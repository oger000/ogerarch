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
Ext.define('App.view.system.ProtoWin', {
	extend: 'Ext.window.Window',

	controller: 'systemProtoWin',

	title: Oger._('Protokoll'),
	width: 700,
	height: 500,
	modal: true,
	autoScroll: true,
	layout: 'fit',
	items: [
		{ xtype: 'form', reference: 'protoForm',
			layout: 'fit', border: false,
			bodyStyle: 'padding:15px; background:transparent',
			items: [
				{ xtype: 'textarea', name: 'protoText', itemId: 'protoText' },
			],
		},
	],
	buttonAlign: 'center',
	buttons: [
		{ text: Oger._('Drucken'), handler: 'printProto' },
		{ text: Oger._('Schliessen'), handler: 'closeWindow' },
	],


	// ###################################


	// set proto text
	setProtoText: function(text) {
		var me = this;

		me.down('#protoText').setValue(text);
	},  // eo set text



	// load remote proto text
	loadProtoText: function(opts) {
		var me = this;
		opts = opts || {};
		if (!opts.protoParam) {
			opts.protoParam = 'proto';
		}

		Ext.Ajax.request({
			url: opts.url,
			params: opts.params,
			success: function(resp) {
				var respObj = Ext.decode(resp.responseText);
				var text = respObj[opts.protoParam];
				if (!text && respObj.data && respObj.data[opts.protoParam]) {
					text = respObj.data[opts.protoParam];
				}
				me.setProtoText(text);
			},
			failure: Oger.extjs.showAjaxFailure,
		});

	},  // eo load text




});

