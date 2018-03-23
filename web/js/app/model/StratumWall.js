/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


Ext.define('App.model.StratumWall', {
	extend: 'Ext.data.Model',

	fields: [
	// autogen-begin>
		'id',
		'excavId',
		'stratumId',
		'datingStratigraphy',
		'datingWallStructure',
		'lengthApplyTo',
		'widthApplyTo',
		'heightRaising',
		'heightRaisingApplyTo',
		'heightFooting',
		'heightFootingApplyTo',
		'constructionType',
		'wallBaseType',
		'structureType',
		'relationDescription',
		'layerDescription',
		'shellDescription',
		'kernelDescription',
		'formworkDescription',
		'hasPutlogHole',
		'putlogHoleDescription',
		'hasBarHole',
		'barHoleDescription',
		'materialType',
		'stoneSize',
		'stoneMaterial',
		'stoneProcessing',
		'hasCommonBrick',
		'hasVaultBrick',
		'hasRoofTile',
		'hasFortificationBrick',
		'brickDescription',
		'hasProductionStampSign',
		'hasProductionFingerSign',
		'hasProductionOtherAttribute',
		'productionDescription',
		'mixedWallBrickPercent',
		'mixedWallDescription',
		'spoilDescription',
		'binderState',
		'binderType',
		'binderColor',
		'binderSandPercent',
		'binderLimeVisible',
		'binderGrainSize',
		'binderConsistency',
		'additivePebbleSize',
		'additiveLimepopSize',
		'additiveCrushedTilesSize',
		'additiveCharcoalSize',
		'additiveStrawSize',
		'additiveOtherSize',
		'additiveOtherDescription',
		'abreuvoirType',
		'abreuvoirDescription',
		'plasterSurface',
		'plasterThickness',
		'plasterExtend',
		'plasterColor',
		'plasterMixture',
		'plasterGrainSize',
		'plasterConsistency',
		'plasterAdditives',
		'plasterLayer',
	// <autogen-end
	],
});
