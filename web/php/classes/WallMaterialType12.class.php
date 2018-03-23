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
* Wall material type master
*
* Values are hardcoded without database.
*/
class WallMaterialType12 extends DbRecFake {


	const ID_STONE = 'ID_STONE';
	const ID_BRICK = 'ID_BRICK';
	const ID_MIXED = 'ID_MIXED';
	const ID_MUDBRICK = 'ID_MUDBRICK';


	static $records = array();


	/**
	* Create record list
	*/
	public static function createRecords() {

		if (static::$records) {
			return;
		}

		static::$records = array(
			static::ID_STONE =>
				array('id' => static::ID_STONE,
							'name' => Oger::_('Stein'),
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
			static::ID_MUDBRICK =>
				array('id' => static::ID_MUDBRICK,
							'name' => Oger::_('Lehmziegel'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
		);

	}  // eo create records





}  // end of class

?>
