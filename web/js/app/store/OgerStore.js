/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


Ext.define('App.store.OgerStore', {
	extend: 'Ext.data.Store',


	config: {
		proxyExtraParams: null,
	},


	// dont share proxy between instances, because
	// setting extraprams to proxy are shared too !!!
	// see <http://www.sencha.com/forum/showthread.php?227180-Custom-generic-store-then-extending-for-concrete-stores>
	constructor: function() {
		this.setProxy(Ext.clone(this.getProxy()));
		this.callParent(arguments);

		var proxyExtraParams = this.getProxyExtraParams();
		if (proxyExtraParams) {
			this.getProxy().setExtraParams(proxyExtraParams);
		}
	},  // eo constructor


	// have a verbose load listener
	listeners: {
		load: function(cmp, records, successful, opts) {
			if (!successful) {
				var reader = cmp.getProxy().getReader();
				if (reader.rawData && reader.rawData.msg) {
					var msg = reader.rawData.msg;
				}
				else {
					var msg = Oger._('Unbekannter Fehler beim Laden der Store-Daten.');
				}
				Ext.create('Oger.extjs.MessageBox').alert(
					Oger._('Fehler'), msg);
			}
		},
	},  // eo listeners

});
