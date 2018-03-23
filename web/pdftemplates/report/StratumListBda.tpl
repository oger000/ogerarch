{ init
	INIT [ P, mm, A4]
	FONT [helvetica, , 12]
	MARGINS [ 20, 45, 20 ]
	AUTOPAGEBREAK [ 1, 30 ]
}

{ header
	CELLAT   [ 20,20 ], [], [ ,B,16 ] #Stratumliste {excavName}
	NEWLINE
	CELL     [], [,B,10] #Massnahme {excavOfficialId}  KG: {excavCadastralCommunityName}  Bundesland: {excavRegionName}
	NEWLINE
	CELL     [], [ ,,10] #Bezirk: {excavDistrictName}  Gemeinde: {excavCommuneName}  Flur: {excavFieldName}  Grst: {excavPlotName}
	NEWLINE
	NEWLINE

	LINE  [ 20, 40, 190, 40 ]
	CLIPCELL   [ 15, 5, 0, 0]      [ ,B,9 ]           # Stratum
	CLIPCELL   [ 25, 5, 0, 0]      [ ,B,9 ]           # Bezeichnung
	CLIPCELL   [ 15, 5, 0, 0, C ]  [ ,B,9 ]           #Verbal
	CLIPCELL   [ 15, 5, 0, 0, C ]  [ ,B,9 ]           #Foto
	CLIPCELL   [ 15, 5, 0, 0, C ]  [ ,B,8 ]           #Plan Digital
	CLIPCELL   [ 15, 5, 0, 0, C ]  [ ,B,8 ]           #Plan Zeichnung
	CLIPCELL   [ 70, 5, 0, 0]      [ ,B,9 ]           # Anmerkung
	LINE  [ 20, 45, 190, 45 ]

	//NEWLINE

		// vertical lines
	LINE [  20, 40,  20, 265 ]
	LINE [  35, 40,  35, 265 ]
	LINE [  60, 40,  60, 265 ]
	LINE [  75, 40,  75, 265 ]
	LINE [  90, 40,  90, 265 ]
	LINE [ 105, 40, 105, 265 ]
	LINE [ 120, 40, 120, 265 ]
	LINE [ 190, 40, 190, 265 ]

}


{ body_end
	CELL       [ 15, 5, 0, 0, C]   [ ,,9 ]         #{stratumId}
	CLIPCELL   [ 25, 5, 0, 0, C]   [ ,,9 ]         #{categoryName}
	CLIPCELL   [ 15, 5, 0, 0, C ]  [ ,,9 ]         #{hasVerbalDescription}
	CLIPCELL   [ 15, 5, 0, 0, C ]  [ ,,9 ]         #{hasPictureReference}
	CLIPCELL   [ 15, 5, 0, 0, C ]  [ ,,9 ]         #{hasDigitalDocu}
	CLIPCELL   [ 15, 5, 0, 0, C ]  [ ,,9 ]         #{hasAnalogDocu}
	//CLIPCELL   [ 70, 5, 1 ],       [ ,,9 ]         #{listComment}
	//NEWLINE
	MCELL      [ 70,,,,,1 ]  [ ,,10 ]              #{listComment}
	LINE  [ 20, CURRENT, 190, CURRENT ]
}

{ footer
	LINE  [ 20, 270, 190, 270 ]
	CELLAT   [ 20,275 ], [ 0,0,0,0, L ], [,,10] #{companyShortName}
	//CELLAT   [ 20,275 ], [ 0,0,0,0, C ], [,,10] #{__TIME__ datetime:d.m.Y}
	//CELLAT   [ 20,275 ], [ 0,0,0,0, R ], [,,10] #Seite {__PAGENO__} von {__NBPAGES__}
	CELLAT   [ 20,275 ], [ 0,0,0,0, R ], [,,10] #Seite {__PAGENO__}
}
