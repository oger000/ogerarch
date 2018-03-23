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
* Wall base type master
*
* Values are hardcoded without database.
*/
class WallBaseType12 extends DbRecFake {


	const ID_BRICK = 'ID_BRICK';
	const ID_RUBBLE = 'ID_RUBBLE';
	const ID_ASHLAR = 'ID_ASHLAR';
	const ID_MIXED = 'ID_MIXED';
	const ID_CAST = 'ID_CAST';
	const ID_COBBLE = 'ID_COBBLE';


	static $records = array();



	/**
	* Create record list
	*/
	public static function createRecords() {

		if (static::$records) {
			return;
		}

		static::$records = array(
			static::ID_ASHLAR =>
				array('id' => static::ID_ASHLAR,
							'name' => Oger::_('Quader'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_RUBBLE =>
				array('id' => static::ID_RUBBLE,
							'name' => Oger::_('Bruchstein'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_COBBLE =>
				array('id' => static::ID_COBBLE,
							'name' => Oger::_('Rollstein'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_BRICK =>
				array('id' => static::ID_BRICK,
							'name' => Oger::_('Ziegel'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_MIXED =>
				array('id' => static::ID_MIXED,
							'name' => Oger::_('Mischmauer'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			/*
			static::ID_CAST =>
				array('id' => static::ID_CAST,
							'name' => Oger::_('Guss'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			*/
		);

	}  // eo create records


}  // end of class

?>
