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
* Wall binder grain size master
*
* Values are hardcoded without database.
*/
class WallBinderGrainSize12 extends DbRecFake {


	const ID_RAW = 'ID_RAW';
	const ID_MIDDLE = 'ID_MIDDLE';
	const ID_FINE = 'ID_FINE';


	static $records = array();



	/**
	* Create record list
	*/
	public static function createRecords() {

		if (static::$records) {
			return;
		}

		static::$records = array(
			static::ID_RAW =>
				array('id' => static::ID_RAW,
							'name' => Oger::_('Grob (über 5 mm)'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_MIDDLE =>
				array('id' => static::ID_MIDDLE,
							'name' => Oger::_('Mittel (bis 5 mm)'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_FINE =>
				array('id' => static::ID_FINE,
							'name' => Oger::_('Fein (unter 3 mm)'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
		);

	}  // eo create records





}  // end of class

?>
