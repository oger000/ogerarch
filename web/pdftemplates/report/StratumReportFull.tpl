{ init
	INIT [ P, mm, A4]
	FONT [helvetica, , 12]
	MARGINS [ 20, 45, 20 ]
	AUTOPAGEBREAK [ 1, 30 ]
}

{ header
	CELLAT   [ 20,20 ], [], [,B,20] #Stratum-Protokoll {excavName}
	NEWLINE
	CELL     [], [,B,10] #Massnahme {excavOfficialId}  KG: {excavCadastralCommunityName}  Bundesland: {excavRegionName}
	NEWLINE
	CELL     [], [ ,,10] #Bezirk: {excavDistrictName}  Gemeinde: {excavCommuneName}  Flur: {excavFieldName}  Grst: {excavPlotName}
	NEWLINE
	LINE  [ 20, 41, 190, 41 ]
	NEWLINE
}



{ body_begin
	NEWLINE
	CELL  [ 0,0,1,0,C ] [ ,B,13 ]     #Stratum: {stratumId}
	NEWLINE
	NEWLINE
	CELL    [] [ ,B,10 ]         #Kategorie:
	CELLAT  [ 50 ]               #{categoryName}
	NEWLINE
	CELL    [] [ ,B,10 ]         #Art/Bezeichnung:
	CELLAT  [ 50 ]               #{typeName}
	NEWLINE
	CELL    [] [ ,B,10 ]         #Objektnummer:
	MCELL    [ 0,0,0,,,1, 50 ]   #{archObjectReferenceList}
	//NEWLINE
	CELL    [] [ ,B,10 ]         #Objektgruppe:
	MCELL    [ 0,0,0,,,1, 50 ]   #{archObjGroupReferenceList}
	//NEWLINE
	CELL    [] [ ,B ]            #Grundstück:
	CELLAT  [ 50 ]               #{plotName}
	NEWLINE
	CELL   [] [ ,B ]             #Schnitt:
	CELLAT [ 50 ] []             #{section}
	NEWLINE
	CELL   [] [ ,B ]              #Fläche:
	CELLAT [ 50 ] []              #{area}
	NEWLINE
	CELL   [] [ ,B ]              #Profil:
	CELLAT [ 50 ] []              #{profile}
	NEWLINE
	CELL    [] [ ,B ]             #Interpretation:
	CELLAT  [ 50 ]                #{interpretation}
	NEWLINE
	CELL    [] [ ,B ]             #Datierung:
	CELLAT  [ 50 ]                #{datingSpec}
	NEWLINE
	CELL    [] [ ,B ]                 #Zeichnung/Plan:
	CELLAT  [ 50 ]                    #{planTypeList}
	//CELLAT  [ 50 ] [ FIT ] [    ]     #Digtaler Plan:
	//CELL    [ FIT ] [    ]            # {planDigitalYesNo},
	//CELL    [ FIT ] [    ]            #   Analoger Plan:
	//CELL    [ FIT ] [    ]            # {planAnalogYesNo}
	NEWLINE
	CELL    [] [ ,B ]                 #Foto:
	CELLAT  [ 50 ]                    #{photoTypeList}
	//CELLAT  [ 50 ] [ FIT ] [    ]     #Fotogrammetrie:
	//CELL    [ FIT ] [    ]            # {photogrammetryYesNo},
	//CELL    [ FIT ] [    ]            #   Digitalfoto:
	//CELL    [ FIT ] [    ]            # {photoDigitalYesNo},
	//CELL    [ FIT ] [    ]            #   Dia:
	//CELL    [ FIT ] [    ]            # {photoSlideYesNo},
	//CELL    [ FIT ] [    ]            #   Papierfoto:
	//CELL    [ FIT ] [    ]            # {photoPrintYesNo}
	NEWLINE
	CELL     [] [ ,B ]                #Plan/Foto Anm:
	MCELL    [ 0,0,0,,,1, 50 ]        #{pictureReference}
	//NEWLINE
	CELL    [] [ ,B ]                      #Fundnummern:
	IF # {archFindIdList}
		MCELL    [ 0,0,0,,,1, 50 ]           #{archFindIdList}
	ENDIF
	IFNOT # {archFindIdList}
		NEWLINE
	ENDIF
	CELL     [] [ ,B ]                     #Probe:
	IF # {sampleReferenceList}
		MCELL    [ 0,0,0,,,1, 50 ]           #Art: {sampleReferenceList}
	ENDIF
	IFNOT # {sampleReferenceList}
		NEWLINE
	ENDIF
}



{ body_interface
	CELL    [] [ ,B ]            #Form:
	CELLAT  [ 50 ]               #{shape}
	NEWLINE
	CELL    [] [ ,B ]            #Kontur:
	CELLAT  [ 50 ]               #{contour}
	NEWLINE
	CELL    [] [ ,B ]            #Ecken:
	CELLAT  [ 50 ]               #{vertex}
	NEWLINE
	CELL    [] [ ,B ]            #Seiten:
	CELLAT  [ 50 ]               #{sidewall}
	NEWLINE
	CELL    [] [ ,B ]            #Seitenübergang:
	CELLAT  [ 50 ]               #{intersection}
	NEWLINE
	CELL    [] [ ,B ]            #Basis:
	CELLAT  [ 50 ]               #{basis}
	NEWLINE
	CELL    [] [ ,B ]            #Enthält:
	CELLAT  [ 50 ]               #Stratum {containsStratumIdList}
	NEWLINE
	CELL    [] [ ,B ]            #Abmessung/cm:
	CELLAT  [ 50 ]               #Länge: {lengthValue},   Breite: {width},   Höhe/Stärke: {height}
	NEWLINE
}


{ body_deposit
	CELL    [] [ ,B ]            #Farbe:
	CELLAT  [ 50 ]               #{color}
	NEWLINE
	CELL    [] [ ,B ]            #Materialanspr:
	CELLAT  [ 50 ]               #{materialDenotation}
	NEWLINE
	CELL    [] [ ,B ]            #Konsistenz:
	CELLAT  [ 50 ]               #{consistency}
	NEWLINE
	CELL    [] [ ,B ]            #Einschlüsse:
	CELLAT  [ 50 ]               #{inclusion}
	NEWLINE
	CELL    [] [ ,B ]            #Härte:
	CELLAT  [ 50 ]               #{hardness}
	NEWLINE
	CELL    [] [ ,B ]            #Orientierung:
	CELLAT  [ 50 ]               #{orientation}
	NEWLINE
	CELL    [] [ ,B ]            #Gefälle:
	CELLAT  [ 50 ]               #{incline}
	NEWLINE
	CELL    [] [ ,B ]            #Abmessung/cm:
	CELLAT  [ 50 ]               #Länge: {lengthValue},   Breite: {width},   Höhe/Stärke: {height}
	NEWLINE
}

{ body_skeleton
	CELL    [] [ ,BI ]            #* Skelett:
	NEWLINE
	CELL    [] [ ,B ]            #Orientierung:
	CELLAT  [ 50 ]               #{orientation}
	NEWLINE
	CELL    [] [ ,B ]            #Lage:
	CELLAT  [ 50 ]               #{bodyPositionName}
	NEWLINE
	CELL    [] [ ,B ]            #Erhaltungszust.:
	CELLAT  [ 50 ]               #{boneQualityName}
	NEWLINE
	CELL    [] [ ,B ]            #Dislozierung:
	CELLAT  [ 50 ]               #{dislocationList}
	NEWLINE
	CELL    [] [ ,B ]            #Geschlecht:
	CELLAT  [ 50 ]               #Biologisch: {sexName},   Gender: {genderName}
	NEWLINE
	CELL    [] [ ,B ]            #Alter:
	CELLAT  [ 50 ]               #{ageName}
	NEWLINE
	CELL    [] [ ,B ]            #Bergung:
	CELLAT  [ 50 ]               #Einzelknochen: {recoverySingleBonesYesNo},   Block: {recoveryBlockYesNo},   Härtung: {recoveryHardenedYesNo}
	NEWLINE
	CELL    [] [ ,B ]            #Sonderbestatt.:
	CELLAT  [ 50 ]               #{specialBurialYesNo}
	NEWLINE
	CELL    [] [ ,B ]            #Blickrichtung:
	CELLAT  [ 50 ]               #{viewDirection}
	NEWLINE
	CELL    [] [ ,B ]            #Position:
	CELLAT  [ 50 ]               #Arme: {armPositionName},   Beine: {legPositionName}
	NEWLINE
	CELL    [] [ ,BI ]            #* Skelettmasse (mm):
	NEWLINE
	CELL    [] [ ,B ]            #Körperlänge:
	CELLAT  [ 50 ]               #{bodyLength}
	NEWLINE
	CELL    [] [ ,B ]            #Oberarm:
	CELLAT  [ 50 ]               #Rechts: {upperArmRightLength},   Links: {upperArmLeftLength}
	NEWLINE
	CELL    [] [ ,B ]            #Unterarm:
	CELLAT  [ 50 ]               #Rechts: {foreArmRightLength},   Links: {foreArmLeftLength}
	NEWLINE
	CELL    [] [ ,B ]            #Oberschenkel:
	CELLAT  [ 50 ]               #Rechts: {thighRightLength},   Links: {thighLeftLength}
	NEWLINE
	CELL    [] [ ,B ]            #Unterschenkel:
	CELLAT  [ 50 ]               #Rechts: {shinRightLength},   Links: {shinLeftLength}
	NEWLINE
	CELL     [] [ ,B ]                #Anmerkungen:
	MCELL    [ 0,0,0,,,1, 50 ]        #{positionDescription}
	//NEWLINE
	CELL    [] [ ,BI ]            #* Brandbestattung:
	NEWLINE
	CELL    [] [ ,B ]            #Art:
	CELLAT  [ 50 ]               #{burialCremationName}
	NEWLINE
	CELL    [] [ ,B ]            #Störung:
	CELLAT  [ 50 ]               #Stratum {cremationDemageStratumIdList}
	NEWLINE
	CELL     [] [ ,B ]                #Anmerkungen:
	MCELL    [ 0,0,0,,,1, 50 ]        #{cremationDemageDescription}
	//NEWLINE
	CELL    [] [ ,BI ]            #* Grabkonstruktion/Einbau:
	NEWLINE
	CELL    [] [ ,B ]            #Sarg:
	CELLAT  [ 50 ]               #Stratum {coffinStratumIdList}
	NEWLINE
	CELL    [] [ ,B ]            #Holzeinbau:
	CELLAT  [ 50 ]               #Stratum {tombTimberStratumIdList}
	NEWLINE
	CELL    [] [ ,B ]            #Steineinbau:
	CELLAT  [ 50 ]               #Stratum {tombStoneStratumIdList}
	NEWLINE
	CELL    [] [ ,B ]            #Ziegeleinbau:
	CELLAT  [ 50 ]               #Stratum {tombBrickStratumIdList}
	NEWLINE
	CELL    [] [ ,B ]            #Sonstiges:
	CELLAT  [ 50 ]               #Stratum {tombOtherMaterialStratumIdList}
	NEWLINE
	CELL    [] [ ,BI ]            #* Grabkonstruktion/Form:
	NEWLINE
	CELL    [] [ ,B ]            #Rund:
	CELLAT  [ 50 ]               #Stratum {tombFormCircleStratumIdList}
	NEWLINE
	CELL    [] [ ,B ]            #Oval:
	CELLAT  [ 50 ]               #Stratum {tombFormOvalStratumIdList}
	NEWLINE
	CELL    [] [ ,B ]            #Reckteckig:
	CELLAT  [ 50 ]               #Stratum {tombFormRectangleStratumIdList}
	NEWLINE
	CELL    [] [ ,B ]            #Quadratisch:
	CELLAT  [ 50 ]               #Stratum {tombFormSquareStratumIdList}
	NEWLINE
	CELL    [] [ ,B ]            #Sonstiges:
	CELLAT  [ 50 ]               #Stratum {tombFormOtherStratumIdList}
	NEWLINE
	CELL    [] [ ,BI ]            #* Grabkonstruktion/Störung:
	NEWLINE
	CELL    [] [ ,B ]            #Störung:
	CELLAT  [ 50 ]               #Stratum {tombDemageStratumIdList}
	NEWLINE
	CELL     [ FIT ] [ ,B ]      #Beschreibung Grabmarkierung/-überbau und Grabform:
	MCELL    [ 0,0,0,,,1, [ 50, CURRENT ] ]        # {tombDescription}
	//NEWLINE
	CELL    [] [ ,BI ]            #* Fundmaterial:
	NEWLINE
	CELL    [] [ ,B ]            #Beigaben:
	CELLAT  [ 50 ]               #Fundnummer {burialObjectArchFindIdList}
	NEWLINE
	CELL    [] [ ,B ]            #Tracht:
	CELLAT  [ 50 ]               #Fundnummer {costumeArchFindIdList}
	NEWLINE
	CELL    [] [ ,B ]            #Verfüllung:
	CELLAT  [ 50 ]               #Fundnummer {depositArchFindIdList}
	NEWLINE
	CELL    [] [ ,B ]            #Grabkonstrukt.:
	CELLAT  [ 50 ]               #Fundnummer {tombConstructArchFindIdList}
	NEWLINE
	CELL    [] [ ]               #---
	NEWLINE
}




{ body_timber
	CELL    [] [ ,B ]            #Dendrochronol.:
	CELLAT  [ 50 ]               #{dendrochronologyYesNo}
	NEWLINE
	CELL    [] [ ,B ]            #Orientierung:
	CELLAT  [ 50 ]               #{orientation}
	NEWLINE
	CELL     [] [ ,B ]                #Funktion/Anspr:
	MCELL    [ 0,0,0,,,1, 50 ]        #{functionDescription}
	//NEWLINE
	CELL     [] [ ,B ]                #Kontext/Bauart:
	MCELL    [ 0,0,0,,,1, 50 ]        #{constructDescription}
	//NEWLINE
	CELL    [] [ ,B ]            #Holzart:
	CELLAT  [ 50 ]               #{timberType}
	NEWLINE
	CELL    [] [ ,B ]            #Ausfachung:
	CELLAT  [ 50 ]               #{infill}
	NEWLINE
	CELL     [] [ ,B ]                #Sonst.Baustoffe:
	MCELL    [ 0,0,0,,,1, 50 ]        #{otherConstructMaterial}
	//NEWLINE
	CELL    [] [ ,B ]            #Oberfläche:
	CELLAT  [ 50 ]               #{surface}
	NEWLINE
	CELL    [] [ ,B ]            #Erhaltungszust.:
	CELLAT  [ 50 ]               #{preservationStatus}
	NEWLINE
	CELL    [] [ ,B ]            #Physiolog. Zone:
	CELLAT  [ 50 ]               #Waldkante: {physioZoneDullEdgeYesNo},   Splintholz: {physioZoneSeapWoodYesNo},   Kernholz: {physioZoneHeartWoodYesNo}
	NEWLINE
	CELL    [] [ ,B ]            #Sekundärverw.:
	CELLAT  [ 50 ]               #{secundaryUsageYesNo}
	NEWLINE
	CELL    [] [ ,B ]            #Stellung:
	CELLAT  [ 50 ]               #
	NEWLINE
	CELL    [] [ ,B ]            #Bearbeit.spuren:
	CELLAT  [ 50 ]               #{processSign}
	NEWLINE
	CELL    [] [ ,B ]            #Bearbeit.details:
	CELLAT  [ 50 ]               #{processDetail}
	NEWLINE
	CELL    [] [ ,B ]            #Verbindungen:
	CELLAT  [ 50 ]               #{connection}
	NEWLINE
	CELL     [] [ ,B ]                #Verhältnis:
	MCELL    [ 0,0,0,,,1, 50 ]        #Zu anderen Bauteilen: {relationDescription}
	//NEWLINE
	CELL    [] [ ,B ]            #Abmessung/cm:
	CELLAT  [ 50 ] [ FIT ]       #Länge: {lengthValue}
	IF # {lengthApplyToName}
		CELL [ FIT ]               # ({lengthApplyToName})
	ENDIF
	CELL [ FIT ]                 #,   Breite: {width}
	IF # {widthApplyToName}
		CELL [ FIT ]               # ({widthApplyToName})
	ENDIF
	CELL [ FIT ]                 #,   Höhe/Stärke: {height}
	IF # {heightApplyToName}
		CELL [ FIT ]               # ({heightApplyToName})
	ENDIF
	NEWLINE
}




{ body_wall
	CELL    [] [ ,B ]            #Bauart:
	CELLAT  [ 50 ]               #{constructionTypeName}
	NEWLINE
	CELL    [] [ ,B ]            #Mauerwerk/Typ:
	CELLAT  [ 50 ]               #{wallBaseTypeName}
	NEWLINE
	CELL    [] [ ,B ]            #Struktur:
	CELLAT  [ 50 ]               #{structureTypeName}
	NEWLINE
	CELL    [] [ ,B ]            #Datierungsbasis:
	CELLAT  [ 50 ]               #{datingBaseList}
	NEWLINE
	CELL     [] [ ,B ]                #Lagen:
	MCELL    [ 0,0,0,,,1, 50 ]        #{layerDescription}
	//NEWLINE
	CELL     [] [ ,B ]                #Mauerschale:
	MCELL    [ 0,0,0,,,1, 50 ]        #{shellDescription}
	//NEWLINE
	CELL     [] [ ,B ]                #Mauerkern:
	MCELL    [ 0,0,0,,,1, 50 ]        #{kernelDescription}
	//NEWLINE
	CELL     [] [ ,B ]                #Schalung:
	MCELL    [ 0,0,0,,,1, 50 ]        #{formworkDescription}
	//NEWLINE
	CELL     [] [ ,B ]                #Bauschliessen:
	NEWLINE
	CELL     [] [ ,B ]                         #Gerüstlöcher:
	CELLAT  [ 50 ] [ FIT ]                     #{hasPutlogHoleYesNo}
	MCELL    [ 0,0,0,,,1, [ 50,CURRENT] ]      #   {putlogHoleDescription}
	//NEWLINE
	CELL     [] [ ,B ]                         #Balkenlöcher:
	CELLAT  [ 50 ] [ FIT ]                     #{hasBarHoleYesNo}
	MCELL    [ 0,0,0,,,1, [ 50,CURRENT] ]      #   {barHoleDescription}
	//NEWLINE
	CELL     [] [ ,B ]                #Verhältnis:
	MCELL    [ 0,0,0,,,1, 50 ]        #Zu anderen Bauteilen: {relationDescription}
	//NEWLINE
	CELL    [] [ ,B ]            #Materialtyp:
	CELLAT  [ 50 ]               #{materialTypeName}
	NEWLINE
	CELL    [] [ ,BI ]            #* Stein:
	NEWLINE
	CELL    [] [ ,B ]            #Steingrösse:
	CELLAT  [ 50 ]               #{stoneSize}
	NEWLINE
	CELL    [] [ ,B ]            #Steinmaterial:
	CELLAT  [ 50 ]               #{stoneMaterial}
	NEWLINE
	CELL    [] [ ,B ]            #Steinbearbeit.:
	CELLAT  [ 50 ]               #{stoneProcessing}
	NEWLINE
	CELL    [] [ ,BI ]            #* Ziegel:
	NEWLINE
	CELL    [] [ ,B ]            #Ziegelart:
	CELLAT  [ 50 ]               #{brickTypeList}
	NEWLINE
	CELL     [] [ ,B ]                #Ziegeldetails:
	MCELL    [ 0,0,0,,,1, 50 ]        #{brickDescription}
	//NEWLINE
	CELL    [] [ ,B ]            #Herstell.Merkm.:
	//CELLAT  [ 50 ]               #{brickProductionSignList}
	CELLAT  [ 50 ]               #Stempel: {hasProductionStampSignYesNo},   Fingerstrich: {hasProductionFingerSignYesNo},   Sonstige Zeichen: {hasProductionOtherAttributeYesNo}
	NEWLINE
	CELL     [] [ ,B ]                #Herst.Details:
	MCELL    [ 0,0,0,,,1, 50 ]        #{productionDescription}
	//NEWLINE
	CELL    [] [ ,BI ]            #* Mischmauerwerk:
	NEWLINE
	CELL    [] [ ,B ]            #Ziegelanteil/%:
	CELLAT  [ 50 ]               #{mixedWallBrickPercent}
	NEWLINE
	CELL     [] [ ,B ]                #Mischm.Details:
	MCELL    [ 0,0,0,,,1, 50 ]        #{mixedWallDescription}
	//NEWLINE
	CELL    [] [ ,BI ]                 #* Sonstiges Material:
	NEWLINE
	CELL    [] [ ,B ]                 #Spolien:
	MCELL    [ 0,0,0,,,1, 50 ]        #{spoilDescription}
	//NEWLINE
	CELL    [] [ ,BI ]            #* Bindung:
	NEWLINE
	CELL    [] [ ,B ]            #Zustand:
	CELLAT  [ 50 ]               #{binderStateName}
	NEWLINE
	CELL    [] [ ,B ]            #Art:
	CELLAT  [ 50 ]               #{binderTypeName}
	NEWLINE
	CELL    [] [ ,B ]            #Farbe:
	CELLAT  [ 50 ]               #{binderColor}
	NEWLINE
	CELL    [] [ ,B ]            #Zusammensetz.:
	CELLAT  [ 50 ]               #Kalk sichtbar: {binderLimeVisibleYesNo},   Sandanteil: {binderSandPercent}
	NEWLINE
	CELL    [] [ ,B ]            #Korngrösse:
	CELLAT  [ 50 ]               #{binderGrainSizeName}
	NEWLINE
	CELL    [] [ ,B ]            #Konsistenz:
	CELLAT  [ 50 ]               #{binderConsistencyName}
	NEWLINE
	CELL    [] [ ,B ]            #Zuschlagstoffe (in cm):
	NEWLINE
	CELLAT  [ 50 ]               #Kiesel: {additivePebbleSize}
	NEWLINE
	CELLAT  [ 50 ]               #Kalkspatzen: {additiveLimepopSize}
	NEWLINE
	CELLAT  [ 50 ]               #Ziegelsplit: {additiveCrushedTilesSize}
	NEWLINE
	CELLAT  [ 50 ]               #Holzkohle: {additiveCharcoalSize}
	NEWLINE
	CELLAT  [ 50 ]               #Stroh: {additiveStrawSize}
	NEWLINE
	CELLAT  [ 50 ]               #Sonstiges: {additiveOtherSize},   Art: {additiveOtherDescription}
	NEWLINE
	CELL    [] [ ,B ]            #Fugenbild:
	CELLAT  [ 50 ]               #{abreuvoirTypeName}
	NEWLINE
	CELL     [] [ ,B ]                #Fugendetails:
	MCELL    [ 0,0,0,,,1, 50 ]        #{abreuvoirDescription}
	//NEWLINE
	CELL     [] [ ,BI ]           #* Verputz:
	NEWLINE
	CELL    [] [ ,B ]            #Oberfläche:
	CELLAT  [ 50 ]               #{plasterSurfaceName}
	NEWLINE
	CELL    [] [ ,B ]            #Stärke:
	CELLAT  [ 50 ]               #{plasterThickness}
	NEWLINE
	CELL    [] [ ,B ]            #Ausdehnung:
	CELLAT  [ 50 ]               #{plasterExtend}
	NEWLINE
	CELL    [] [ ,B ]            #Farbe:
	CELLAT  [ 50 ]               #{plasterColor}
	NEWLINE
	CELL    [] [ ,B ]            #Zusammensetz.:
	CELLAT  [ 50 ]               #{plasterMixture}
	NEWLINE
	CELL    [] [ ,B ]            #Korngrösse:
	CELLAT  [ 50 ]               #{plasterGrainSize}
	NEWLINE
	CELL    [] [ ,B ]            #Konsistenz:
	CELLAT  [ 50 ]               #{plasterConsistency}
	NEWLINE
	CELL    [] [ ,B ]            #Zuschlagst/cm:
	CELLAT  [ 50 ]               #{plasterAdditives}
	NEWLINE
	CELL    [] [ ,B ]            #Mehrlagigkeit:
	CELLAT  [ 50 ]               #{plasterLayer}
	NEWLINE
	CELL    [] [ ]               #---
	NEWLINE
	CELL    [] [ ,B ]            #Abmessung/cm:
	CELLAT  [ 50 ] [ FIT ]       #Länge: {lengthValue}
	IF # {lengthApplyToName}
		CELL [ FIT ]               # ({lengthApplyToName})
	ENDIF
	CELL [ FIT ]                 #,   Breite: {width}
	IF # {widthApplyToName}
		CELL [ FIT ]               # ({widthApplyToName})
	ENDIF
	NEWLINE
	CELLAT [ 50 ] [ FIT ]        #Höhe aufgehendes Mauerwerk: {heightRaising}
	IF # {heightRaisingApplyToName}
		CELL [ FIT ]               # ({heightRaisingApplyToName})
	ENDIF
	CELL [ FIT ]                 #,   Fundamenthöhe: {heightFooting}
	IF # {heightFootingApplyToName}
		CELL [ FIT ]               # ({heightFootingApplyToName})
	ENDIF
	NEWLINE
}




{ body_complex
	CELL    [] [ ,B ]            #Bestehend aus:
	MCELL   [ 0,0,0,,,1, 50 ]    #Stratum {complexPartIdList}
	//NEWLINE
}




{ body_end
	CELL    [] [ ,B ]            #Interface-Nr:
	CELLAT  [ 50 ]               #{containedInInterfaceIdList}
	NEWLINE
	CELL    [] [ ,B ]            #Matrix:
	CELLAT  [ 50 ]               #Älter als: {earlierThanIdList}
	NEWLINE
	CELLAT  [ 50 ]               #Jünger als: {reverseEarlierThanIdList}
	NEWLINE
	CELLAT  [ 50 ]               #Ident mit: {equalToIdList}
	NEWLINE
	CELLAT  [ 50 ]               #Zeitgleich mit: {contempWithIdList}
	NEWLINE

	CELL    [] [ ,B ]             #Hinweis:
	CELLAT  [ 50 ]                #{listComment}
	NEWLINE
	CELL     [] [ ,B ]                #Bemerkungen:
	MCELL    [ 0,0,0,,,1, 50 ]        #{comment}
	//NEWLINE
	CELL     [] [ ,B ]                #BearbeiterIn:
	MCELL    [ 0,0,0,,,1, 50 ]        #{originator}
	//NEWLINE
	CELL    [] [ ,B ]                 #Datum:
	CELLAT  [ 50 ]                    #{date datetime:d.m.Y}
	NEWLINE
}


{ footer
	LINE  [ 20, 270, 190, 270 ]
	CELLAT   [ 20,275 ], [ 0,0,0,0, L ], [,,10] #{companyShortName}
	//CELLAT   [ 20,275 ], [ 0,0,0,0, C ], [,,10] #{__TIME__ datetime:d.m.Y}
	//CELLAT   [ 20,275 ], [ 0,0,0,0, R ], [,,10] #Seite {__PAGENO__} von {__NBPAGES__}
	CELLAT   [ 20,275 ], [ 0,0,0,0, R ], [,,10] #Seite {__PAGENO__}
}

