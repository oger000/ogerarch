{ init
	INIT [ P, mm, A4]
	FONT [helvetica, , 12]
	MARGINS [ 20, 45, 20 ]
	AUTOPAGEBREAK [ 1, 30 ]
}

{ header
	CELLAT   [ 20,20 ], [], [,B,20] #Objekt-Protokoll {excavName}
	NEWLINE
	CELL     [], [,B,10] #Massnahme {excavOfficialId}  KG: {excavCadastralCommunityName}  Bundesland: {excavRegionName}
	NEWLINE
	CELL     [], [ ,,10] #Bezirk: {excavDistrictName}  Gemeinde: {excavCommuneName}  Flur: {excavFieldName}  Grst: {excavPlotName}
	NEWLINE
	LINE  [ 20, 41, 190, 41 ]
	NEWLINE
}



{ body
	NEWLINE
	CELL  [ 0,0,1,0,C ] [ ,B,13 ]     #Objekt: {archObjectId}
	NEWLINE
	NEWLINE
	CELL    [] [ ,B,10 ]         #Art/Bezeichnung:
	CELLAT  [ 50 ]               #{typeName}
	NEWLINE
	CELL    [] [ ,B,10 ]         #Stratumliste:
	MCELL    [ 0,0,0,,,1, 50 ]   #{stratumIdList}
	//NEWLINE
	CELL    [] [ ,B ]             #Interpretation:
	CELLAT  [ 50 ]                #{interpretation}
	NEWLINE
	CELL    [] [ ,B ]             #Datierung:
	CELLAT  [ 50 ]                #{datingSpec}
	NEWLINE
	CELL    [] [ ,B ]             #Periode:
	CELLAT  [ 50 ]                #{datingPeriodName}
	NEWLINE
	CELL    [] [ ,B ]             #Hinweis:
	CELLAT  [ 50 ]                #{listComment}
	NEWLINE
	CELL     [] [ ,B ]                #Beschreibung:
	MCELL    [ 0,0,0,,,1, 50 ]        #{comment}
	//NEWLINE
}


{ footer
	LINE  [ 20, 270, 190, 270 ]
	CELLAT   [ 20,275 ], [ 0,0,0,0, L ], [,,10] #{companyShortName}
	//CELLAT   [ 20,275 ], [ 0,0,0,0, C ], [,,10] #{__TIME__ datetime:d.m.Y}
	//CELLAT   [ 20,275 ], [ 0,0,0,0, R ], [,,10] #Seite {__PAGENO__} von {__NBPAGES__}
	CELLAT   [ 20,275 ], [ 0,0,0,0, R ], [,,10] #Seite {__PAGENO__}
}

