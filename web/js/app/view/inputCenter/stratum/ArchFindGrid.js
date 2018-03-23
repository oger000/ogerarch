/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/



/**
* Stratum arch find grid
*/
Ext.define('App.view.inputCenter.stratum.ArchFindGrid', {
	extend: 'Ext.grid.Panel',
	alias: 'widget.ic_stratumarchfindgrid',

	stripeRows: true,
	autoScroll: true,

	sortableColumns: false,
	store: Ext.create('App.store.StratumArchFinds'),
	columns: [
		{ header: Oger._('Gr'), dataIndex: 'excavId', width: 30, hidden: true },
		{ header: Oger._('Grabung'), dataIndex: 'excavName', hidden: true },
		{ header: Oger._('Nummer'), dataIndex: 'archFindId', width: 50 },   // , locked: true
		{ header: Oger._('Stratum'), dataIndex: 'stratumIdList', width: 90, align: 'center' },
		{ header: Oger._('Datum'), xtype: 'datecolumn', dataIndex: 'date', width: 70 },
		{ header: Oger._('Sonderfund'), dataIndex: 'specialArchFind', width: 150 },
		{ header: Oger._('KER'), dataIndex: 'ceramicsCountId', width: 50 },
		{ header: Oger._('TKN'), dataIndex: 'animalBoneCountId', width: 50 },
		{ header: Oger._('HOMO'), dataIndex: 'humanBoneCountId', width: 50 },
		{ header: Oger._('FE'), dataIndex: 'ferrousCountId', width: 50 },
		{ header: Oger._('BMET'), dataIndex: 'nonFerrousMetalCountId', width: 50 },
		{ header: Oger._('GLAS'), dataIndex: 'glassCountId', width: 50 },
		{ header: Oger._('BAUK'), dataIndex: 'architecturalCeramicsCountId', width: 50 },
		{ header: Oger._('HL'), dataIndex: 'daubCountId', width: 50 },
		{ header: Oger._('ST'), dataIndex: 'stoneCountId', width: 50 },
		{ header: Oger._('SIL'), dataIndex: 'silexCountId', width: 50 },
		{ header: Oger._('MÖR'), dataIndex: 'mortarCountId', width: 50 },
		{ header: Oger._('HOLZ'), dataIndex: 'timberCountId', width: 50 },
		{ header: Oger._('Sedi'), dataIndex: 'sedimentSampleCountId', width: 50 },
		{ header: Oger._('Schlä'), dataIndex: 'slurrySampleCountId', width: 50 },
		{ header: Oger._('Holzk'), dataIndex: 'charcoalSampleCountId', width: 50 },
		{ header: Oger._('Mört'), dataIndex: 'mortarSampleCountId', width: 50 },
		{ header: Oger._('Schla'), dataIndex: 'slagSampleCountId', width: 50 },
	],


	// ##################################################


});
