{ init
	INIT [ L, mm, A4]
	FONT [helvetica, , 12]
	MARGINS [ 20, 45, 20 ]
	AUTOPAGEBREAK [ 1, 30 ]
}

{ header
	CELLAT   [ 20,20 ], [], [,B,16] #Fundliste {excavName}
	NEWLINE
	CELL     [ FIT ], [,,10]  :: 1 #Massnahme: {excavOfficialId}  BL: {excavRegionName}  Bez: {excavDistrictName}
	 Gem: {excavCommuneName}  KG: {excavCadastralCommunityName}  Flur: {excavFieldName}  Grst: {excavPlotName}
	NEWLINE
	NEWLINE

	CELL [ 20 ]  [ ,B,10 ]   #Fund
	CELL [ 20 ]  [ ,B,10 ]   #Stratum
	CELL [ 25 ]  [ ,B,10 ]   #Datum

	CELL [ 9,0,0,0,C ]  [ ,B,10 ]   #KE
	CELL [ 9,0,0,0,C ]  [ ,B,10 ]   #TK
	CELL [ 9,0,0,0,C ]  [ ,B,10 ]   #MK
	CELL [ 9,0,0,0,C ]  [ ,B,10 ]   #FE
	CELL [ 9,0,0,0,C ]  [ ,B,10 ]   #BM
	CELL [ 9,0,0,0,C ]  [ ,B,10 ]   #GL
	CELL [ 9,0,0,0,C ]  [ ,B,10 ]   #BK
	CELL [ 9,0,0,0,C ]  [ ,B,10 ]   #HL
	CELL [ 9,0,0,0,C ]  [ ,B,10 ]   #ST
	CELL [ 9,0,0,0,C ]  [ ,B,10 ]   #SI
	CELL [ 9,0,0,0,C ]  [ ,B,10 ]   #MÖ
	CELL [ 9,0,0,0,C ]  [ ,B,10 ]   #HO

	CELL [ 9,0,0,0,C ]  [ ,B,10 ]   #OR
	CELL [ 9,0,0,0,C ]  [ ,B,10 ]   #SF

	CELL [ 9,0,0,0,C ]  [ ,B,10 ]   #se
	CELL [ 9,0,0,0,C ]  [ ,B,10 ]   #sc
	CELL [ 9,0,0,0,C ]  [ ,B,10 ]   #hk
	CELL [ 9,0,0,0,C ]  [ ,B,10 ]   #mp
	CELL [ 9,0,0,0,C ]  [ ,B,10 ]   #sl
	CELL [ 9,0,0,0,C ]  [ ,B,10 ]   #sp

	NEWLINE
	LINE  [ 20, 41, 278, 41 ]
	NEWLINE

}

{ body

	CELL [ 20,0,0,0,C ]  [ ,,10 ]            #{archFindId}
	CELL [ 20 ]  [ ,,10 ]            #{stratumIdList}
	CELL [ 25 ]  [ ,,10 ]            #{date datetime:d.m.Y}

	CELL [ 9,0,0,0,C ]              #{ceramicsCountAbbrev}
	CELL [ 9,0,0,0,C ]              #{animalBoneCountAbbrev}
	CELL [ 9,0,0,0,C ]              #{humanBoneCountAbbrev}
	CELL [ 9,0,0,0,C ]              #{ferrousCountAbbrev}
	CELL [ 9,0,0,0,C ]              #{nonFerrousMetalCountAbbrev}
	CELL [ 9,0,0,0,C ]              #{glassCountAbbrev}
	CELL [ 9,0,0,0,C ]              #{architecturalCeramicsCountAbbrev}
	CELL [ 9,0,0,0,C ]              #{daubCountAbbrev}
	CELL [ 9,0,0,0,C ]              #{stoneCountAbbrev}
	CELL [ 9,0,0,0,C ]              #{silexCountAbbrev}
	CELL [ 9,0,0,0,C ]              #{mortarCountAbbrev}
	CELL [ 9,0,0,0,C ]              #{timberCountAbbrev}

	CELL [ 9,0,0,0,C ]              #{organicAbbrev}
	CELL [ 9,0,0,0,C ]              #{archFindOtherAbbrev}

	CELL [ 9,0,0,0,C ]              #{sedimentSampleCountAbbrev}
	CELL [ 9,0,0,0,C ]              #{slurrySampleCountAbbrev}
	CELL [ 9,0,0,0,C ]              #{charcoalSampleCountAbbrev}
	CELL [ 9,0,0,0,C ]              #{mortarSampleCountAbbrev}
	CELL [ 9,0,0,0,C ]              #{slagSampleCountAbbrev}
	CELL [ 9,0,0,0,C ]              #{sampleOtherAbbrev}
	NEWLINE

	IF # {specialArchFind}
		CELLAT [ 60 ] [ FIT ] [  ]       #Sonderfund:
		CELL                             # {specialArchFind}
		NEWLINE
	ENDIF

	IF # {interpretation}
		CELLAT [ 60 ] [ FIT ] [  ]       #Interpretation:
		CELL                             # {interpretation}
		NEWLINE
	ENDIF

	IF # {comment}
		CELLAT [ 60 ] [ FIT ] [  ]               #Bemerkungen:
		MCELL  [ 0,0,0,,,1, [ 60, [CURRENT,2] ] ]   #{comment}
	ENDIF

	LINE  [ 20, CURRENT, 278, CURRENT ]
	// the following line is only a workaround - otherwise after the
	// line there are as many newlines inserted as the comment has lines
	// if we use newline at all
	//CELLAT [ 60 ] [ FIT ] [ ,B ]       #
	//NEWLINE

}

{ footer
	LINE  [ 20, 185, 278, 185 ]
	CELLAT   [ 20,190 ], [ 0,0,0,0, L ], [,,10] #{companyShortName}
	//CELLAT   [ 20,190 ], [ 0,0,0,0, C ], [,,10] #{__TIME__ datetime:d.m.Y}
	//CELLAT   [ 20,190 ], [ 0,0,0,0, R ], [,,10] #Seite {__PAGENO__} von {__NBPAGES__}
	CELLAT   [ 20,190 ], [ 0,0,0,0, R ], [,,10] #Seite {__PAGENO__}
}



{ abbrev
		HTMLCELL  [ 0,0,20,,,1 ] :: 21  #
		<B>Liste der Abkürzungen für Material und Proben</B><br>
		KE: Keramik<br>
		TK: Tierknochen<br>
		MK: Menschenknochen<br>
		FE: Eisen<br>
		BM: Buntmetall<br>
		GL: Glas<br>
		BK: Baukeramik<br>
		HL: Hüttenlehm<br>
		ST: Stein<br>
		SI: Silex<br>
		MÖ: Mörtel<br>
		HO: Holz<br>
		OR: Organisch<br>
		SF: Sonstiger Fund<br>
		se: Sedimentprobe<br>
		sc: Schlämmprobe<br>
		hk: Holzkohle<br>
		mp: Mörtelprobe<br>
		sl: Schlackenprobe<br>
		sp: Sonstige Probe<br>
}
