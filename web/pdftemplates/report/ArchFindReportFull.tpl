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
	CELL   [ FIT ] [ ,B,10 ]           #Stratum:
	CELLAT [ 50 ] [ FIT ] []           #{stratumIdList}
	NEWLINE
	CELL   [ FIT ] [ ,B ]              #Sonderfund:
	CELLAT [ 50 ]                      #{specialArchFind}
	NEWLINE
	CELL   [ FIT ] [ ,B ]              #Material:
	MCELL  [ 0,0,0,,,1, [ 50] ]        #{detailFindList}
	//NEWLINE
	CELL   [ FIT ] [ ,B ]              #Sonstige Funde:
	CELLAT [ 50 ]                      #{archFindOther}
	NEWLINE
	CELL   [ FIT ] [ ,B ]              #Organisch:
	CELLAT [ 50 ]                      #{organic}
	NEWLINE
	CELL   [ FIT ] [ ,B ]              #Proben:
	MCELL  [ 0,0,0,,,1, [ 50] ]        #{detailSampleList}
	//NEWLINE
	CELL   [ FIT ] [ ,B ]              #Sonstige Proben:
	CELLAT [ 50 ]                      #{sampleOther}
	NEWLINE
	CELL   [ FIT ] [ ,B,10 ]           #Datierung:
	CELLAT [ 50 ]                      #{datingSpec}
	NEWLINE
	CELL   [ FIT ] [ ,B,10 ]           #Bezeichnung:
	CELLAT [ 50 ] []                   #{interpretation}
	NEWLINE
	CELL   [ FIT ] [ ,B ]              #GrstNr:
	CELLAT [ 50 ] []                   #{plotName}
	NEWLINE
	CELL   [ FIT ] [ ,B ]              #Schnitt:
	CELLAT [ 50 ] []                   #{section}
	NEWLINE
	CELL   [ FIT ] [ ,B ]              #Fläche:
	CELLAT [ 50  ] []                  #{area}
	NEWLINE
	CELL   [ FIT ] [ ,B ]              #Profil:
	CELLAT [ 50 ] []                   #{profile}
	NEWLINE
	CELL   [ FIT ] [ ,B ]              #Arbeitsschritt:
	CELLAT [ 50 ]                      #{atStepList}
	NEWLINE
	CELL   [ FIT ] [ ,B ]              #Interface:
	CELLAT [ 50 ]                      #{interfaceIdList}
	NEWLINE
	CELL   [ FIT ] [ ,B ]              #Objekt:
	CELLAT [ 50 ]                      #{archObjectIdList}
	NEWLINE
	CELL   [ FIT ] [ ,B ]              #Objektgruppe:
	CELLAT [ 50 ]                      #{archObjGroupIdList}
	NEWLINE
	CELL   [ FIT ] [ ,B,10 ]           #Datum:
	CELLAT [ 50 ] []                   #{date datetime:d.m.Y}
	NEWLINE
	CELL   [ FIT ] [ ,B ]              #Plan:
	CELLAT [ 50 ]                      #{planName}
	NEWLINE
	CELL  [ FIT ] [ ,B ]               #Bemerkungen:
	MCELL  [ 0,0,0,,,1, 50 ]           #{comment}
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
