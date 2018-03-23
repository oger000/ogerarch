{ init
	INIT [ L, mm, A4]
	FONT [helvetica, , 7]
}

{ offsets
	SHEETSPERPAGE: 2
	SHEET: 0,  15, 15
	SHEET: 1,  160,15
}


{ body

	RECT  [ 0, 0, 125, 180 ], [0.1]

	LINE  [ 0, 25, 125, 25 ]
	LINE  [ 95, 0, 95, 25 ]

	CLIPCELLAT  [ 2, 5], [ 95, 0], [,B,18 ]             #{excavName}
	CLIPCELLAT  [ 2, 15], [ 95, 0], [,B,15 ]            #M.Nr: {officialId}

	//CLIPCELLAT  [ 95, 5], [ 25, 0, 0, 0, C ], [,,10]        #Kiste Nr:
	//CLIPCELLAT  [ 95, 10], [ 25, 0, 0, 0, C ], [,B,16]      #{locationName}
	MCELLAT  [ 95, 0], [ 30,0, 0, C,,,,,,,,, 25, M ], [,B,16]      #{locationName}


	CELLAT [ 1, 30 ], [], [,B,10]                       #Fund Nr:
	MCELLAT [ 1, 35 ], [ 120,0, 0,,,,,,,,,,75 ]        #{archFindIdList}


	LINE [ 0, 125, 125, 125 ]

 	MCELLAT [ 1, 127 ], [ 115,0, 0,,,,,,,,,, 35 ]       #{contentComment}


	LINE [ 0, 160, 125, 160 ]
	LINE [ 0, 170, 100, 170 ]

	LINE [  25, 160,  25, 180 ]
	LINE [  50, 160,  50, 180 ]
	LINE [  75, 160,  75, 180 ]
	LINE [ 100, 160, 100, 180 ]


	FONT [ dejavusans,, 9 ]

	MCELLAT [   2, 161 ], [ 25,0,0,,,,,,,,,, 9, M ]   #{washStatusId} gereinigt
	MCELLAT [  27, 161 ], [ 25,0,0,,,,,,,,,, 9, M ]   #{labelStatusId} beschriftet
	MCELLAT [  52, 161 ], [ 25,0,0,,,,,,,,,, 9, M ]   #{restoreStatusId} restauriert
	MCELLAT [  77, 161 ], [ 25,0,0,,,,,,,,,, 9, M ]   #{photographStatusId} fotografiert

	MCELLAT [   2, 171 ], [ 25,0,0,,,,,,,,,, 9, M ]   #{drawStatusId} gezeichnet
	MCELLAT [  27, 171 ], [ 25,0,0,,,,,,,,,, 9, M ]   #{layoutStatusId} gesetzt
	MCELLAT [  52, 171 ], [ 25,0,0,,,,,,,,,, 9, M ]   #{scientificStatusId} datiert
	MCELLAT [  77, 171 ], [ 25,0,0,,,,,,,,,, 9, M ]   #{publishStatusId} publiziert

	FONT [ helvetica ]


}



