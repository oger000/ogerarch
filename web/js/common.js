/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/




/**
* Validator for identifier (arch find id, stratum id, ...) input
*/
var xidValid = function(value) {
	//var regex = /^[a-zA-Z0-9_\/\-]+$/;
	// empty values are checked by extjs allowBlank so do not check here
	if (!value) {
		return true;
	}
	//value = value.replace(/^\s+|\s+$/g, '');
	//var regex = /^[1-9_]+[0-9a-zA-Z_]*$/;
	var regex = /^[0-9a-zA-Z_\-]+$/;
	if (!regex.test(value)) {
		return Oger._('Nur Ziffern, Buchstaben A-Z oder "_-" erlaubt.');
	}
	return true;
}  // eo identifier validator



/**
 * Validator for multiple identifier (arch find id, stratum id, ...) input
 * Multiple entries must be separated by ','.
 */
var multiXidValid = function(value) {
	// empty values are checked by extjs allowBlank so do not check here
	if (!value) {
		return true;
	}
	//value = value.replace(/^\s+|\s+$/g, '');
	// split and check every part
	var parts = value.split(',');
	for (var i = 0; i < parts.length; i++) {
		var id = parts[i];
		id = id.replace(/^\s+|\s+$/g, '');  //trim
		// if multiple ids are present than the last id (and only the last id) can be empty
		if (!id && i < parts.length - 1) {
			return false;
		}
		var result = xidValid(id);
		if (result !== true) {
			return Oger._('Nur Ziffern, Buchstaben A-Z oder "_-" erlaubt. Trennung durch Beistrich');
		}
	}
	return true;
}  // eo multi identifier validator



/**
 * Validator for multiple identifier (arch find id, stratum id, ...) input
 * that have subId parts.
 * Multiple entries must be separated by ','.
 */
var multiXidSubIdValid = function(value) {

	// empty values are checked by extjs allowBlank so do not check here
	if (!value) {
		return true;
	}

	// split and check every part
	var parts = value.split(',');
	for (var i = 0; i < parts.length; i++) {

		var id = parts[i];
		id = id.replace(/^\s+|\s+$/g, '');  //trim
		// if multiple ids are present than the last id (and only the last id) can be empty
		if (!id && i < parts.length - 1) {
			return false;
		}

		// split into id and subid and check separate
		var subParts = id.split(SUBID_DELIM);
		if (subParts.length > 2) {
			return Oger._('Es darf nur einen Subnummern-Teil geben.');
		}

		for (var j = 0; j < subParts.length; j++) {
			var subId = subParts[j];
			var result = xidValid(subId);
			if (result !== true) {
				return Oger._('Nur Ziffern, Buchstaben A-Z "_" oder "-" erlaubt. Trennung durch Beistrich. Subnummer getrennt mit "/".');
			}
		}
	}

	return true;
}  // eo multi identifier validator
