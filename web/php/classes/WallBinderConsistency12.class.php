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
* Wall binder consistency master
*
* Values are hardcoded without database.
*/
class WallBinderConsistency12 extends DbRecFake {


	const ID_VERY_COMPACT = 'ID_VERY_COMPACT';
	const ID_COMPACT = 'ID_COMPACT';
	const ID_LOOSELY = 'ID_LOOSELY';
	const ID_VERY_LOOSELY = 'ID_VERY_LOOSELY';
	const ID_CRUMBLY = 'ID_CRUMBLY';


	static $records = array();




	/**
	* Create record list
	*/
	public static function createRecords() {

		if (static::$records) {
			return;
		}

		static::$records = array(
			static::ID_VERY_COMPACT =>
				array('id' => static::ID_VERY_COMPACT,
							'name' => Oger::_('Sehr fest'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_COMPACT =>
				array('id' => static::ID_COMPACT,
							'name' => Oger::_('Fest'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_LOOSELY =>
				array('id' => static::ID_LOOSELY,
							'name' => Oger::_('Locker'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_VERY_LOOSELY =>
				array('id' => static::ID_VERY_LOOSELY,
							'name' => Oger::_('Sehr locker'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_CRUMBLY =>
				array('id' => static::ID_CRUMBLY,
							'name' => Oger::_('Bröselig'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
		);

	}  // eo create records






}  // end of class

?>
