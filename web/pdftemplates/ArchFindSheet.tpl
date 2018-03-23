{ init
	INIT [ L, mm, A4]
	FONT [helvetica, , 7]
}

{ offsets
	SHEETSPERPAGE: 4
	SHEET: 0,  10,  7
	SHEET: 1,  10,104
	SHEET: 2, 150,  7
	SHEET: 3, 150,104
}


{ body

	// overall
	RECT        [  0,   1, 135, 95], [0.1]

	//main info
	RECT        [  1,   2, 74, 7], [0.1]
	CLIPCELLAT  [  1,   3], [73, 6], [,B,11]         #{excavName}
	CLIPCELLAT  [ 76,   1], [20, 4], [,,7]           #MASSNAHME:
	CLIPCELLAT  [ 76,   5], [21, 4, 1], [,B,7]       #{officialId}
	CLIPCELLAT  [ 98,   1], [15, 4, 0, 0, C], [,,7]  #DATUM:
	CLIPCELLAT  [ 98,   5], [15, 4, 1, 0, C], [,B,7] #{date datetime:d.m.Y}

	RECT        [115,   2,   18,12], [0.5]
	CLIPCELLAT  [115,   3], [18, 4, 0, 0, C], [,B,9]  #FUND-NR:
	//CLIPCELLAT  [115,   5], [18,10, 0, 0, C], [,B,15] #{archFindId}
	CLIPCELLAT  [115,   5], [20,10, 0, 0, C], [,B,13] #{archFindId}

	RECT        [115,  17,   18,12], [0.1]
	CLIPCELLAT  [115,  17], [18, 4, 0, 0, C], [,B,7] #STRATUM:
	MULTICELLAT [115,  21], [18, 10, 0, C], [,B,9]   #{stratumIdList}

	// cadastralcommunity,
	CLIPCELLAT  [  1,  10], [74, 4, 1], [,,7]       #{cadastralCommunityName}
	CLIPCELLAT  [ 76,  10], [37, 4, 1], [,,7]       #{companyShortName}

	//location info
	CLIPCELLAT [  1,  15], [15, 4], [,,7]      #SCHNITT:
	CLIPCELLAT [ 18,  15], [20, 4 , 1], [,B,7] #{section}
	CLIPCELLAT [ 42,  15], [15, 4], [,,7]      #FLÄCHE:
	CLIPCELLAT [ 55,  15], [20, 4 , 1], [,B,7] #{area}
	CLIPCELLAT [ 79,  15], [15, 4], [,,7]      #PROFIL:
	CLIPCELLAT [ 93,  15], [20, 4 , 1], [,B,7] #{profile}

	CLIPCELLAT [  1,  20], [15, 4], [,,7]      #INTERFACE:
	CLIPCELLAT [ 18,  20], [20, 4 , 1], [,B,7] #{interfaceIdList}
	CLIPCELLAT [ 42,  20], [15, 4], [,,7]      #OBJEKT:
	CLIPCELLAT [ 55,  20], [20, 4 , 1], [,B,7] #{archObjectIdList}
	CLIPCELLAT [ 79,  20], [15, 4], [,,7]      #OBJ.GRP:
	CLIPCELLAT [ 93,  20], [20, 4 , 1], [,B,7] #{archObjGroupIdList}

	CLIPCELLAT [  1,  25], [22, 4], [,,7]      #PLANNAME:
	CLIPCELLAT [ 18,  25], [37, 4 , 1], [,B,7] #{planName}
	CLIPCELLAT [ 57,  25], [15, 4], [,,7]            #A:
	CLIPCELLAT [ 61,  25], [ 5, 4 , 1, 0, C], [,B,7] #{atStepLowering}
	CLIPCELLAT [ 67,  25], [ 5, 4], [,,7]            #GP:
	CLIPCELLAT [ 73,  25], [ 5, 4 , 1, 0, C], [,B,7] #{atStepCleaningRaw}
	CLIPCELLAT [ 79,  25], [ 5, 4], [,,7]            #FP:
	CLIPCELLAT [ 85,  25], [ 5, 4 , 1, 0, C], [,B,7] #{atStepCleaningFine}
	CLIPCELLAT [ 91,  25], [ 5, 4], [,,7]            #SO:
	CLIPCELLAT [ 97,  25], [ 5, 4 , 1, 0, C], [,B,7] #{atStepOther}
	CLIPCELLAT [103,  25], [ 5, 4], [,,7]            #Str
	CLIPCELLAT [108,  25], [ 5, 4 , 1, 0, C], [,B,7] #{isStrayFind}


	// interpretation
	CLIPCELLAT [  1,  30], [20, 4], [,,7]      #BEZ/INTERPR:
	CLIPCELLAT [ 22,  30],[111, 4 , 1], [,B,7] #{interpretation}

	// extra find note
	CLIPCELLAT [  1,  35], [20, 4], [,,7]      #SONDERFUND:
	CLIPCELLAT [ 22,  35],[111, 4 , 1], [,B,7] #{specialArchFind}

	// arch find details (ceramics)
	CLIPCELLAT [= 12+ 0, = 40+ 0], [8, 4], [,,7]           #KER
	CLIPCELLAT [= 22+ 0, = 40+ 0], [6, 4, 1, 0, C], [,B,7] #{ceramicsCountId1}
	CLIPCELLAT [= 22+ 6, = 40+ 0], [6, 4, 1, 0, C], [,B,7] #{ceramicsCountId2}
	CLIPCELLAT [= 22+12, = 40+ 0], [6, 4, 1, 0, C], [,B,7] #{ceramicsCountId3}
	// arch find details (ferrous)
	CLIPCELLAT [= 12+30, = 40+ 0], [8, 4], [,,7]           #FE
	CLIPCELLAT [= 52+ 0, = 40+ 0], [6, 4, 1, 0, C], [,B,7] #{ferrousCountId1}
	CLIPCELLAT [= 52+ 6, = 40+ 0], [6, 4, 1, 0, C], [,B,7] #{ferrousCountId2}
	CLIPCELLAT [= 52+12, = 40+ 0], [6, 4, 1, 0, C], [,B,7] #{ferrousCountId3}
	// arch find details (architectural ceramics)
	CLIPCELLAT [= 12+60, = 40+ 0], [8, 4], [,,7]           #BAUK
	CLIPCELLAT [= 82+ 0, = 40+ 0], [6, 4, 1, 0, C], [,B,7] #{architecturalCeramicsCountId1}
	CLIPCELLAT [= 82+ 6, = 40+ 0], [6, 4, 1, 0, C], [,B,7] #{architecturalCeramicsCountId2}
	CLIPCELLAT [= 82+12, = 40+ 0], [6, 4, 1, 0, C], [,B,7] #{architecturalCeramicsCountId3}
	// arch find details (silex)
	CLIPCELLAT [= 12+90, = 40+ 0], [8, 4], [,,7]           #SIL
	CLIPCELLAT [=112+ 0, = 40+ 0], [6, 4, 1, 0, C], [,B,7] #{silexCountId1}
	CLIPCELLAT [=112+ 6, = 40+ 0], [6, 4, 1, 0, C], [,B,7] #{silexCountId2}
	CLIPCELLAT [=112+12, = 40+ 0], [6, 4, 1, 0, C], [,B,7] #{silexCountId3}
	// arch find details (animal bones)
	CLIPCELLAT [= 12+ 0, = 40+ 4], [8, 4], [,,7]           #TKN
	CLIPCELLAT [= 22+ 0, = 40+ 4], [6, 4, 1, 0, C], [,B,7] #{animalBoneCountId1}
	CLIPCELLAT [= 22+ 6, = 40+ 4], [6, 4, 1, 0, C], [,B,7] #{animalBoneCountId2}
	CLIPCELLAT [= 22+12, = 40+ 4], [6, 4, 1, 0, C], [,B,7] #{animalBoneCountId3}
	// arch find details (ferrous)
	CLIPCELLAT [= 12+30, = 40+ 4], [8, 4], [,,7]           #BMET
	CLIPCELLAT [= 52+ 0, = 40+ 4], [6, 4, 1, 0, C], [,B,7] #{nonFerrousMetalCountId1}
	CLIPCELLAT [= 52+ 6, = 40+ 4], [6, 4, 1, 0, C], [,B,7] #{nonFerrousMetalCountId2}
	CLIPCELLAT [= 52+12, = 40+ 4], [6, 4, 1, 0, C], [,B,7] #{nonFerrousMetalCountId3}
	// arch find details (daub)
	CLIPCELLAT [= 12+60, = 40+ 4], [8, 4], [,,7]           #HL
	CLIPCELLAT [= 82+ 0, = 40+ 4], [6, 4, 1, 0, C], [,B,7] #{daubCountId1}
	CLIPCELLAT [= 82+ 6, = 40+ 4], [6, 4, 1, 0, C], [,B,7] #{daubCountId2}
	CLIPCELLAT [= 82+12, = 40+ 4], [6, 4, 1, 0, C], [,B,7] #{daubCountId3}
	// arch find details (mortar)
	CLIPCELLAT [= 12+90, = 40+ 4], [8, 4], [,,7]           #MÖR
	CLIPCELLAT [=112+ 0, = 40+ 4], [6, 4, 1, 0, C], [,B,7] #{mortarCountId1}
	CLIPCELLAT [=112+ 6, = 40+ 4], [6, 4, 1, 0, C], [,B,7] #{mortarCountId2}
	CLIPCELLAT [=112+12, = 40+ 4], [6, 4, 1, 0, C], [,B,7] #{mortarCountId3}
	// arch find details (human bones)
	CLIPCELLAT [= 12+ 0, = 40+ 8], [8, 4], [,,7]           #HOMO
	CLIPCELLAT [= 22+ 0, = 40+ 8], [6, 4, 1, 0, C], [,B,7] #{humanBoneCountId1}
	CLIPCELLAT [= 22+ 6, = 40+ 8], [6, 4, 1, 0, C], [,B,7] #{humanBoneCountId2}
	CLIPCELLAT [= 22+12, = 40+ 8], [6, 4, 1, 0, C], [,B,7] #{humanBoneCountId3}
	// arch find details (glass)
	CLIPCELLAT [= 12+30, = 40+ 8], [8, 4], [,,7]           #GLAS
	CLIPCELLAT [= 52+ 0, = 40+ 8], [6, 4, 1, 0, C], [,B,7] #{glassCountId1}
	CLIPCELLAT [= 52+ 6, = 40+ 8], [6, 4, 1, 0, C], [,B,7] #{glassCountId2}
	CLIPCELLAT [= 52+12, = 40+ 8], [6, 4, 1, 0, C], [,B,7] #{glassCountId3}
	// arch find details (stone)
	CLIPCELLAT [= 12+60, = 40+ 8], [8, 4], [,,7]           #ST
	CLIPCELLAT [= 82+ 0, = 40+ 8], [6, 4, 1, 0, C], [,B,7] #{stoneCountId1}
	CLIPCELLAT [= 82+ 6, = 40+ 8], [6, 4, 1, 0, C], [,B,7] #{stoneCountId2}
	CLIPCELLAT [= 82+12, = 40+ 8], [6, 4, 1, 0, C], [,B,7] #{stoneCountId3}
	// arch find details (timber)
	CLIPCELLAT [= 12+90, = 40+ 8], [8, 4], [,,7]           #HOLZ
	CLIPCELLAT [=112+ 0, = 40+ 8], [6, 4, 1, 0, C], [,B,7] #{timberCountId1}
	CLIPCELLAT [=112+ 6, = 40+ 8], [6, 4, 1, 0, C], [,B,7] #{timberCountId2}
	CLIPCELLAT [=112+12, = 40+ 8], [6, 4, 1, 0, C], [,B,7] #{timberCountId3}

	// organic
	CLIPCELLAT [  1,  53], [20, 4], [,,7]      #ORGANISCH:
	CLIPCELLAT [ 22,  53],[111, 4 , 1], [,B,7] #{organic}
	// find note
	CLIPCELLAT [  1,  58], [20, 4], [,,7]      #Sonstiger Fund:
	CLIPCELLAT [ 22,  58],[111, 4 , 1], [,B,7] #{archFindOther}

	// samples
	CLIPCELLAT [  1,  63], [18, 4], [,,7] #PROBEN:
	// samples (slurry)
	CLIPCELLAT [ 21,  63], [15, 4], [,,7]            #SEDIMENT
	CLIPCELLAT [ 36,  63], [ 4, 4 , 1, 0, C], [,B,7] #{sedimentSampleCountId}
	// samples (sediment)
	CLIPCELLAT [ 42,  63], [22, 4], [,,7]            #SCHLÄMMPROBE
	CLIPCELLAT [ 65,  63], [ 4, 4 , 1, 0, C], [,B,7] #{slurrySampleCountId}
	// samples (charcoal)
	CLIPCELLAT [ 71,  63], [20, 4], [,,7]            #HOLZKOHLE
	CLIPCELLAT [ 88,  63], [ 4, 4 , 1, 0, C], [,B,7] #{charcoalSampleCountId}
	// samples (mortar)
	CLIPCELLAT [ 94,  63], [12, 4], [,,7]            #MÖRTEL
	CLIPCELLAT [107,  63], [ 4, 4 , 1, 0, C], [,B,7] #{mortarSampleCountId}
	// samples (slag)
	CLIPCELLAT [113,  63], [15, 4], [,,7]            #SCHLACKE
	CLIPCELLAT [129,  63], [ 4, 4 , 1, 0, C], [,B,7] #{slagSampleCountId}
	// samples (other)
	CLIPCELLAT [  1,  68], [20, 4], [,,7]      #Sonstige Probe:
	CLIPCELLAT [ 22,  68],[111, 4 , 1], [,B,7] #{sampleOther}

	// comment
	MULTICELLAT [ 2,  73],[109,22,1,,,,,,,,,,25], [,,7] #{comment}
	// comment (without qr-code)
	//MULTICELLAT [ 2,  73],[131,22,1,,,,,,,,,,25], [,,7] #{comment}

}


// DOKN INFO - not used for now - only to preserve the positions from old find ticket
{ dummy1

	::CLIPCELLAT:: [= 96, = 17], [ 8, 4], [,,7] ::DOKN:
	::CLIPCELLAT:: [=106, = 17], [ 7, 4 , 1], [,B,7] ::

	// DOKN line 3
	::CLIPCELLAT:: [=  1, = 22], [ 8, 4], [,,7] ::XVON:
	::CLIPCELLAT:: [= 11, = 22], [15, 4 , 1], [,B,7] ::

	::CLIPCELLAT:: [= 27, = 22], [ 8, 4], [,,7] ::XBIS:
	::CLIPCELLAT:: [= 36, = 22], [15, 4 , 1], [,B,7] ::

	::CLIPCELLAT:: [= 53, = 22], [15, 4], [,,7] ::PROFIL:
	::CLIPCELLAT:: [= 68, = 22], [45, 4 , 1], [,B,7] ::

	// DOKN line 4
	::CLIPCELLAT:: [=  1, = 26], [ 8, 4], [,,7] ::YVON:
	::CLIPCELLAT:: [= 11, = 26], [15, 4 , 1], [,B,7] ::

	::CLIPCELLAT:: [= 27, = 26], [ 8, 4], [,,7] ::YBIS:
	::CLIPCELLAT:: [= 36, = 26], [15, 4 , 1], [,,7] ::

	// DOKN line 4 and a half
	::CLIPCELLAT:: [= 52, = 28], [ 5, 4], [,,7] ::NN:
	::CLIPCELLAT:: [= 58, = 28], [ 7, 4 , 1], [,B,7] ::

	::CLIPCELLAT:: [= 66, = 28], [ 7, 4], [,,7] ::REL0:
	::CLIPCELLAT:: [= 74, = 28], [ 7, 4 , 1], [,B,7] ::

	::CLIPCELLAT:: [= 81, = 28], [ 7, 4], [,,7] ::GOK:
	::CLIPCELLAT:: [= 89, = 28], [ 7, 4 , 1], [,B,7] ::

	::CLIPCELLAT:: [= 96, = 28], [ 8, 4], [,,7] ::DOKN:
	::CLIPCELLAT:: [=106, = 28], [ 7, 4 , 1], [,B,7] ::

	// DOKN line 5
	::CLIPCELLAT:: [=  1, = 30], [ 8, 4], [,,7] ::ZVON:
	::CLIPCELLAT:: [= 11, = 30], [15, 4 , 1], [,B,7] ::

	::CLIPCELLAT:: [= 27, = 30], [ 8, 4], [,,7] ::ZBIS:
	::CLIPCELLAT:: [= 36, = 30], [15, 4 , 1], [,B,7] ::

	// subject
	::CLIPCELLAT:: [=  1, = 41], [20, 4], [,,7] ::BESCHREIBUNG:
	::CLIPCELLAT:: [= 24, = 41], [89, 4 , 1], [,B,7] ::{subject}
}

