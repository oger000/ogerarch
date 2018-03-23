{ init
	INIT [ P, mm, A4]
	FONT [helvetica, , 12]
	MARGINS [ 20, 45, 20 ]
	AUTOPAGEBREAK [ 1, 30 ]
}

{ header
	//CELLAT   [ 20,20 ], [], [ ,B,16 ] #Ausfolgeschein {packingListId}
	CELLAT   [ 20,20 ], [], [ ,B,16 ] #Ausfolgeschein
	NEWLINE
	CELL     [], [,B,5] #
	NEWLINE
	CELL     [], [,B,10] #Grabung {excavName}   Massnahme {excavOfficialId}
	NEWLINE
	CELL     [], [,,10] #Ausdruck vom {dateTime}
	NEWLINE
	CELL     [], [,B,5] #
	NEWLINE

	LINE  [ 20, 40, 190, 40 ]
	CLIPCELL   [  25, 5, 0, 0]      [ ,B,9 ]           # Behälter
	CLIPCELL   [ 140, 5, 0, 0]      [ ,B,9 ]           # Fundnummern
	LINE  [ 20, 45, 190, 45 ]

	//NEWLINE

		// vertical lines
	LINE [  20, 40,  20, 265 ]
	LINE [  45, 40,  45, 265 ]
	LINE [ 190, 40, 190, 265 ]

}


{ body
	CLIPCELL   [ 25, 5, 0, 0, C]   [ ,,9 ]         #{locationName}
	MCELL      [ 140,,,,,1 ]  [ ,,10 ]             #{archFindIdList}{contentComment}
	LINE  [ 20, CURRENT, 190, CURRENT ]
}


{ body_end
	//NEWLINE
	CELL     [ 150,5,0,0,C ], [,,10] #*** ENDE ***
	NEWLINE
	LINE  [ 20, CURRENT, 190, CURRENT ]
}

{ sign_block
	NEWLINE
	NEWLINE
	CELL     [ 25,5,0,0 ], [,,10] #Übergabe am
	CELL     [ 25,5,0,0 ], [,,10] #____________
	CELL     [ 150,5 ], [,,10] #          entsprechend §§ 398 bis 400 ABGB und § 10 DMSG
	NEWLINE
	NEWLINE
	CELL     [ 150,5 ], [,,10] #als  o Dauerleihgabe  |  o Überlassung  |  o Schenkung  |  o zeitlich befristet bis: ____________
	NEWLINE
	NEWLINE
	CELL     [ 60,5,0,0 ], [,,10] #
	CELL     [ 55,5,0,0 ], [,,10] #Ausgefolgt von
	CELL     [ 60,5,0,0 ], [,,10] #Übernommen von
	NEWLINE
	NEWLINE
	CELL     [ 50,5,0,0 ], [,,10] #Name in Blockbuchstaben
	CELL     [ 60,5,0,0 ], [,,10] #________________________
	CELL     [ 60,5,0,0 ], [,,10] #________________________
	NEWLINE
	NEWLINE
	CELL     [ 50,5,0,0 ], [,,10] #Unterschrift
	CELL     [ 60,5,0,0 ], [,,10] #________________________
	CELL     [ 60,5,0,0 ], [,,10] #________________________
	NEWLINE
	NEWLINE
	CELL     [ 50,5,0,0 ], [,,10] #Für Organisation
	CELL     [ 60,5,0,0 ], [,,10] #________________________
	CELL     [ 60,5,0,0 ], [,,10] #________________________
}



{ footer
	LINE  [ 20, 270, 190, 270 ]
	CELLAT   [ 20,275 ], [ 0,0,0,0, L ], [,,10] #{companyShortName}
	//CELLAT   [ 20,275 ], [ 0,0,0,0, C ], [,,10] #{__TIME__ datetime:d.m.Y}
	//CELLAT   [ 20,275 ], [ 0,0,0,0, R ], [,,10] #Seite {__PAGENO__} von {__NBPAGES__}
	CELLAT   [ 20,275 ], [ 0,0,0,0, R ], [,,10] #Seite {__PAGENO__}
}
