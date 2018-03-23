{ init
	INIT [ P, mm, A4]
	FONT [helvetica, , 12]
	MARGINS [ 20, 50, 20 ]
	AUTOPAGEBREAK [ 1, 30 ]
}

{ header
	CELLAT   [ 20,20 ], [], [ ,B,16 ] #Objektliste {excavName}
	NEWLINE
	CELL     [], [,B,10] #Massnahme {excavOfficialId}  KG: {excavCadastralCommunityName}  Bundesland: {excavRegionName}
	NEWLINE
	CELL     [], [ ,,10] #Bezirk: {excavDistrictName}  Gemeinde: {excavCommuneName}  Flur: {excavFieldName}  Grst: {excavPlotName}
	NEWLINE
	NEWLINE
	LINE  [ 20, 41, 190, 41 ]

	LINE  [ 20, 45, 190, 45 ]
	CELLAT     [ 20,45 ] [ 15]     [ ,B,10 ]           # Objekt
	CLIPCELL   [ 35, 5, 0, 0]      [ ,B,10 ]           # Bezeichnung
	CLIPCELL   [ 70, 5, 0, 0]      [ ,B,10 ]           # Zugehörige Strata
	CLIPCELL   [ 50, 5, 0, 0]      [ ,B,10 ]           # Anmerkung
	LINE  [ 20, 50, 190, 50 ]

	// vertical lines
	LINE [  20, 45,  20, 265 ]
	LINE [  35, 45,  35, 265 ]
	LINE [  70, 45,  70, 265 ]
	LINE [ 140, 45, 140, 265 ]
	LINE [ 190, 45, 190, 265 ]


}


{ body
	CELL       [ 15, 5, 0, 0, C]   [ ,,10 ]         #{archObjectId}
	CLIPCELL   [ 35, 5, 0, 0, C]   [ ,,10 ]         #{typeName}
	//STORE [ POS_X, POS_Y ], [ stratumIdList ]
	MCELL      [ 70,,,,,0 ]  [ ,,10 ]               #{stratumIdList}
	//RESTORE [ POS_Y ], [ stratumIdList ]
	//CLIPCELL   [ 50, 5 ]   [ ,,10 ]                 #{listComment}
	MCELL      [ 50,,,,,1 ]  [ ,,10 ]               #{listComment}

	//NEWLINE
	LINE  [ 20, CURRENT, 190, CURRENT ]
	//NEWLINE
}


{ footer
	LINE  [ 20, 270, 190, 270 ]
	CELLAT   [ 20,275 ], [ 0,0,0,0, L ], [,,10] #{companyShortName}
	//CELLAT   [ 20,275 ], [ 0,0,0,0, C ], [,,10] #{__TIME__ datetime:d.m.Y}
	//CELLAT   [ 20,275 ], [ 0,0,0,0, R ], [,,10] #Seite {__PAGENO__} von {__NBPAGES__}
	CELLAT   [ 20,275 ], [ 0,0,0,0, R ], [,,10] #Seite {__PAGENO__}
}
