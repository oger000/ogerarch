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
* Wall plaster surface type master
*
* Values are hardcoded without database.
*/
class WallPlasterSurface12 extends DbRecFake {


	const ID_TROWELED = 'ID_TROWELED';
	const ID_RUBBED = 'ID_RUBBED';
	const ID_TRICKLE = 'ID_TRICKLE';
	const ID_MUDDLED = 'ID_MUDDLED';
	const ID_PAINT = 'ID_PAINT';


	static $records = array();



	/**
	* Create record list
	*/
	public static function createRecords() {

		if (static::$records) {
			return;
		}

		static::$records = array(
			static::ID_TROWELED =>
				array('id' => static::ID_TROWELED,
							'name' => Oger::_('Geglättet (Kelle)'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_RUBBED =>
				array('id' => static::ID_RUBBED,
							'name' => Oger::_('Überrieben'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_TRICKLE =>
				array('id' => static::ID_TRICKLE,
							'name' => Oger::_('Riesel'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_MUDDLED =>
				array('id' => static::ID_MUDDLED,
							'name' => Oger::_('Geschlämmt'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_PAINT =>
				array('id' => static::ID_PAINT,
							'name' => Oger::_('Farbe'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
		);

	}  // eo create records







}  // end of class

?>
