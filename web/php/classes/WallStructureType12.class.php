<?PHP
/*
#LICENSE BEGIN
**********************************************************************
* OgerArch - Archaeological Database is released under the GNU General Public License (GPL) <http://www.gnu.org/licenses>
* Copyright (C) Gerhard Öttl <gerhard.oettl@ogersoft.at>
**********************************************************************
#LICENSE END
*/


/**
* Wall structure type master
*
* Values are hardcoded without database.
*/
class WallStructureType12 extends DbRecFake {


	const ID_LAYER = 'ID_LAYER';
	const ID_COMPARTMENT = 'ID_COMPARTMENT';
	const ID_PENDENTIVE = 'ID_PENDENTIVE';
	const ID_PENDENTIVEFILLED = 'ID_PENDENTIVEFILLED';
	const ID_MESH = 'ID_MESH';
	const ID_NONE = 'ID_NONE';
	const ID_UNRECOGNIZABLE = 'ID_UNRECOGNIZABLE';


	static $records = array();




	/**
	* Create record list
	*/
	public static function createRecords() {

		if (static::$records) {
			return;
		}

		static::$records = array(
			static::ID_LAYER =>
				array('id' => static::ID_LAYER,
							'name' => Oger::_('Lagen'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_COMPARTMENT =>
				array('id' => static::ID_COMPARTMENT,
							'name' => Oger::_('Kompartimente'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_PENDENTIVEFILLED =>
				array('id' => static::ID_PENDENTIVEFILLED,
							'name' => Oger::_('Ausgezwickelt'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_PENDENTIVE =>
				array('id' => static::ID_PENDENTIVE,
							'name' => Oger::_('Zwickel'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_MESH =>
				array('id' => static::ID_MESH,
							'name' => Oger::_('Netz'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_NONE =>
				array('id' => static::ID_NONE,
							'name' => Oger::_('Keine Struktur'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
				static::ID_UNRECOGNIZABLE =>
				array('id' => static::ID_UNRECOGNIZABLE,
							'name' => Oger::_('Nicht erkennbar'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
	);

	}  // eo create records







}  // end of class

?>
