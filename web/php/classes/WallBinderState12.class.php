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
* Wall binder state master
*
* Values are hardcoded without database.
*/
class WallBinderState12 extends DbRecFake {


	const ID_MOIST = 'ID_MOIST';
	const ID_DRY = 'ID_DRY';


	static $records = array();



	/**
	* Create record list
	*/
	public static function createRecords() {

		if (static::$records) {
			return;
		}

		static::$records = array(
			static::ID_MOIST =>
				array('id' => static::ID_MOIST,
							'name' => Oger::_('Feucht'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_DRY =>
				array('id' => static::ID_DRY,
							'name' => Oger::_('Trocken'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
		);

	}  // eo create records





}  // end of class

?>
