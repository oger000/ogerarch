{ init
	INIT [ P, mm, A4]
	FONT [helvetica, , 12]
	MARGINS [ 20, 45, 20 ]
	AUTOPAGEBREAK [ 1, 30 ]
}

{ header
	CELLAT   [ 20,20 ], [], [ ,B,16 ] #Fundprotokoll {excavName}
	NEWLINE
	CELL     [], [,B,10] #Massnahme {excavOfficialId}  KG: {excavCadastralCommunityName}  Bundesland: {excavRegionName}
	NEWLINE
	CELL     [], [ ,,10] #Bezirk: {excavDistrictName}  Gemeinde: {excavCommuneName}  Flur: {excavFieldName}  Grst: {excavPlotName}
	NEWLINE
	LINE  [ 20, 41, 190, 41 ]
	NEWLINE
}


{ body
	CELL    [ 0,0,1,0,C ] [ ,B,13 ]     #Fund: {archFindId}
	NEWLINE
	NEWLINE
	CELL  [ FIT ] [ ,B,10 ]    #Stratum:
	CELL  [ FIT ] []           # {stratumIdList}
	NEWLINE
	CELL  [ FIT ] [ ,B ]       #Sonderfund:
	CELL                       # {specialArchFind}
	NEWLINE
	CELL  [ FIT ] [ ,B ]                     #Material:
	MCELL [ 0,0,0,,,1, [ 25, [CURRENT,2] ] ]    #{detailFindList}
	CELL  [ FIT ] [ ,B ]                        #Proben:
	MCELL [ 0,0,0,,,1, [ 25, [CURRENT,2] ] ]    #{detailSampleList}
	//NEWLINE
	CELL  [ FIT ] [ ,B ]       #Organisch:
	CELL  [ FIT ]              # {organic}
	CELL  [ FIT ] [ ,B,10 ]    #   Sonst:
	CELL  [ FIT ] []           # {archFindOther}
	NEWLINE
	CELL  [ FIT ] [ ,B,10 ]    #Datierung:
	CELL  [ FIT ] []           # {datingSpec}
	CELL  [ FIT ] [ ,B,10 ]    #   Bezeichnung:
	CELL  [ FIT ] []           # {interpretation}
	NEWLINE
	CELL  [ FIT ] [ ,B ]       #Schnitt:
	CELL  [ FIT ] []           # {section}
	CELL  [ FIT ] [ ,B ]       #   Fläche:
	CELL  [ FIT ] []           # {area}
	CELL  [ FIT ] [ ,B ]       #   Profil:
	CELL  [ FIT ] []           # {profile}
	CELL  [ FIT ] [ ,B ]       #   GrstNr:
	CELL  [ FIT ] []           # {plotName}
	NEWLINE
	CELL  [ FIT ] [ ,B ]       #Interface:
	CELL  [ FIT ] []           # {interfaceIdList}
	CELL  [ FIT ] [ ,B ]       #   Objekt:
	CELL  [ FIT ] []           # {archObjectIdList}
	CELL  [ FIT ] [ ,B ]       #   Obj.Gruppe:
	CELL  [ FIT ] []           # {archObjGroupIdList}
	NEWLINE
	CELL  [ FIT ] [ ,B,10 ]    #Datum:
	CELL  [ FIT ] []           # {date datetime:d.m.Y}
	CELL  [ FIT ] [ ,B ]       #   Plan:
	CELL  [ FIT ]              # {planName}
	CELL  [ FIT ] [ ,B ]       #   Bei Arbeitsschritt:
	CELL  [ FIT ]              # {atStepList}
	NEWLINE
	CELL  [ FIT ] [ ,B ]       #Bemerkungen:
	MCELL  [ 0,0,0,,,1, [25, [CURRENT,2] ] ]   #{comment}
	// the following line is only a workaround - otherwise after the
	// line there are as many newlines inserted as the comment has lines
	// if we use newline at all
	CELLAT [ 60 ] [ FIT ] [ ,B ]       #
	NEWLINE
}

{ footer
	LINE  [ 20, 270, 190, 270 ]
	CELLAT   [ 20,275 ], [ 0,0,0,0, L ], [,,10] #{companyShortName}
	//CELLAT   [ 20,275 ], [ 0,0,0,0, C ], [,,10] #{__TIME__ datetime:d.m.Y}
	//CELLAT   [ 20,275 ], [ 0,0,0,0, R ], [,,10] #Seite {__PAGENO__} von {__NBPAGES__}
	CELLAT   [ 20,275 ], [ 0,0,0,0, R ], [,,10] #Seite {__PAGENO__}
}
