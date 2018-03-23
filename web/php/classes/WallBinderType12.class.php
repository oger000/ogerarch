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
* Wall binder type master
*
* Values are hardcoded without database.
*/
class WallBinderType12 extends DbRecFake {


	const ID_MORTAR = 'ID_MORTAR';
	const ID_CLAY = 'ID_CLAY';
	const ID_NONE = 'ID_NONE';


	static $records = array();



	/**
	* Create record list
	*/
	public static function createRecords() {

		if (static::$records) {
			return;
		}

		static::$records = array(
			static::ID_MORTAR =>
				array('id' => static::ID_MORTAR,
							'name' => Oger::_('Mörtel'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_CLAY =>
				array('id' => static::ID_CLAY,
							'name' => Oger::_('Lehm'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_NONE =>
				array('id' => static::ID_NONE,
							'name' => Oger::_('Keine Bindung'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
		);

	}  // eo create records





}  // end of class

?>
