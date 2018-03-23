/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/

/*
 * ATTENTION - there is a bug in 4.2.1 (or earlier) till now (5.1.1.451)
 *
 * tree stores cannot be referenced by { type: 'store-alias' }
 * or only parial at least
 * see: <https://www.sencha.com/forum/showthread.php?284776-Unable-to-create-inline-treestore-using-alias>
 */


Ext.define('App.store.OgerTreeStore', {
	extend: 'Ext.data.TreeStore',


	// dont share proxy between instances, because
	// setting extraprams to proxy are shared too !!!
	// see <http://www.sencha.com/forum/showthread.php?227180-Custom-generic-store-then-extending-for-concrete-stores>
	constructor: function() {
		this.proxy = Ext.clone(this.proxy);
		this.callParent(arguments);
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
					var msg = Oger._('Unbekannter Fehler beim Laden der Treestore-Daten.');
				}
				Ext.create('Oger.extjs.MessageBox').alert(
					Oger._('Fehler'), msg);
			}
		},
	},  // eo listeners

});
