/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/



EXCAVMETHODID_STRATUM = 'STRATUM';
EXCAVMETHODID_PLANUM = 'PLANUM';


STRATUMCATEGORYID_DEPOSIT = 'DEPOSIT';
STRATUMCATEGORYID_SKELETON = 'SKELETON';
STRATUMCATEGORYID_WALL = 'WALL';
STRATUMCATEGORYID_TIMBER = 'TIMBER';
STRATUMCATEGORYID_INTERFACE = 'INTERFACE';
STRATUMCATEGORYID_COMPLEX = 'COMPLEX';


// do not start with numbers, because number only is a maindata id
// pipe (|) is reserved
TYPENAME_REGEX = /^[^\s\d\+\-][^\|]*[^\s]$/;

MSG_DEFER = 1500;  // 1000 / 1500
CHKCHANGE_DEFER = 1000;   // 500 / 1000 / 3000



SUBID_DELIM = '/';


