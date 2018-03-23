{ init
	INIT [ L, mm, A4]
	FONT [helvetica, , 12]
	MARGINS [ 20, 50, 20 ]
	AUTOPAGEBREAK [ 1, 30 ]
}

{ header
	CELLAT   [ 20,20 ], [], [,B,16] #Befundliste {excavName}
	NEWLINE
	CELL     [ FIT ], [,,10]  :: 1 #Massnahme: {excavOfficialId}  BL: {excavRegionName}  Bez: {excavDistrictName}
	 Gem: {excavCommuneName}  KG: {excavCadastralCommunityName}  Flur: {excavFieldName}  Grst: {excavPlotName}

	NEWLINE
	NEWLINE

	CELL [ 20 ]  [ ,B,10 ]   #
	CELL [ 30 ]  [ ,B,10 ]   #Bezeichnung
	CELL [ 20 ]  [ ,B,10 ]   #Datum
	CELL [150 ]  [ ,B,10 ]   #
	CELL [ 20 ]  [ ,B,10 ]   #Älter als
	CELL [ 20 ]  [ ,B,10 ]   #Ident mit
	NEWLINE
	CELL [ 20 ]  [ ,B,10 ]   #Stratum
	CELL [ 30 ]  [ ,B,10 ]   #Interpretation
	CELL [ 20 ]  [ ,B,10 ]   #Datierung
	CELL [150 ]  [ ,B,10 ]   #Beschreibung
	CELL [ 20 ]  [ ,B,10 ]   #Jünger als
	CELL [ 20 ]  [ ,B,10 ]   #Zeitgleich

	NEWLINE
	LINE  [ 20, 46, 278, 46 ]
	NEWLINE

}

{ body_end

	CELL [ 20,0,0,0,C ] , [ ,,10 ]   #{stratumId}
	CLIPCELL [ 30 ]  [ ,,10 ]        #{typeName}
	CELL [ 20 ]  [ ,,10 ]            #{date datetime:d.m.Y}
	STORE [ POS_X, POS_Y ], [ shortSummaryText ]
	CELL [150 ]  [ ,,10 ]            #
	CELL [ 20,0,0,0,C ]  [ ,,10 ]    #{earlierThanIdList}
	CELL [ 20,0,0,0,C ]  [ ,,10 ]    #{equalToIdList}
	NEWLINE
	CLIPCELL [ 20,0,0,0,C ], [ ,,10 ]  #{categoryName}
	CLIPCELL [ 30 ]  [ ,,10 ]          #{interpretation}
	CLIPCELL [ 20 ]  [ ,,10 ]       #{datingSpec}
	CELL [150 ]  [ ,,10 ]           #
	CELL [ 20,0,0,0,C ]  [ ,,10 ]   #{reverseEarlierThanIdList}
	CELL [ 20,0,0,0,C ]  [ ,,10 ]   #{contempWithIdList}

	RESTORE [ POS_X, POS_Y ], [ shortSummaryText ]
	MCELLAT [ ], [150,,,,,1 ]  [ ,,10 ]    #{shortSummaryText}

	// the following line is only a workaround - otherwise after the
	// line there are as many newlines inserted as the comment has lines
	// if we use newline at all
	CELLAT [ 60 ] [ FIT ] [ ,B ]       #
	NEWLINE
	LINE  [ 20, CURRENT, 278, CURRENT ]
}


{ body_end_OBSOLETE

	HTMLCELL [ ,,20,,,1 ] :: ...EOHTMLCELL #
		<table border="0">
		<tr>
			<td width="2cm" align="center">{stratumId}</td>
			<td width="3cm"><nobr>{typeName}</nobr></td>
			<td width="2cm">{date datetime:d.m.Y}</td>
			<td width="15cm" rowspan="2">{shortSummaryText}</td>
			<td width="2cm" align="center">{earlierThanIdList}</td>
			<td width="2cm" align="center">{equalToIdList}</td>
		</tr>
		<tr>
			<td></td>
			<td>{interpretation}</td>
			<td>{datingSpec}</td>
			<td align="center">{reverseEarlierThanIdList}</td>
			<td>{contempWithIdList}</td>
		</tr>
		</table>
	...EOHTMLCELL

	LINE  [ 20, CURRENT, 278, CURRENT ]

}

{ footer
	LINE  [ 20, 185, 278, 185 ]
	CELLAT   [ 20,190 ], [ 0,0,0,0, L ], [,,10] #{companyShortName}
	//CELLAT   [ 20,190 ], [ 0,0,0,0, C ], [,,10] #{__TIME__ datetime:d.m.Y}
	//CELLAT   [ 20,190 ], [ 0,0,0,0, R ], [,,10] #Seite {__PAGENO__} von {__NBPAGES__}
	CELLAT   [ 20,190 ], [ 0,0,0,0, R ], [,,10] #Seite {__PAGENO__}
}
