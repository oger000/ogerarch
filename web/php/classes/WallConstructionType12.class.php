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
* Wall construction type master
*
* Values are hardcoded without database.
*/
class WallConstructionType12 extends DbRecFake {


	const ID_THROUGH = 'ID_THROUGH';
	const ID_SHELL = 'ID_SHELL';
	const ID_CAST = 'ID_CAST';
	//const ID_UNDEFINED = 'ID_UNDEFINED';   // OBSOLETED BY ID_UNRECOGNIZABLE
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
			static::ID_SHELL =>
				array('id' => static::ID_SHELL,
							'name' => Oger::_('Schalenmauer'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_THROUGH =>
				array('id' => static::ID_THROUGH,
							'name' => Oger::_('Durchgemauert'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_CAST =>
				array('id' => static::ID_CAST,
							'name' => Oger::_('Gussmauerwerk'),
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
