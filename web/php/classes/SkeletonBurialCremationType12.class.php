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
* Burial cremation types
*
* Values are hardcoded without database.
*/
class SkeletonBurialCremationType12 extends DbRecFake {


	const ID_IN_CONTAINER = 'ID_IN_CONTAINER';
	const ID_LUMP_NO_CONTAINER = 'ID_LUMP_NO_CONTAINER';
	const ID_SCATTER_ON_BASE = 'ID_SCATTER_ON_BASE';
	const ID_SCATTER_ABOVE_BASE = 'ID_SCATTER_ABOVE_BASE';
	const ID_OTHER = 'OTHER';


	static $records = array();



	/**
	* Create record list
	*/
	public static function createRecords() {

		if (static::$records) {
			return;
		}

		static::$records = array(
			static::ID_IN_CONTAINER =>
				array('id' => static::ID_IN_CONTAINER,
							'name' => Oger::_('In Gefäss'),
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_LUMP_NO_CONTAINER =>
				array('id' => static::ID_LUMP_NO_CONTAINER,
							'name' => Oger::_('Konzentration ohne Gefäss'),
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_SCATTER_ON_BASE =>
				array('id' => static::ID_SCATTER_ON_BASE,
							'name' => Oger::_('Streuung an Sohle'),
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_SCATTER_ABOVE_BASE =>
				array('id' => static::ID_SCATTER_ABOVE_BASE,
							'name' => Oger::_('Streuung über Sohle'),
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_OTHER =>
				array('id' => static::ID_OTHER,
							'name' => Oger::_('Sonstiges'),
							'beginDate' => '',
							'endDate' => '',
						 ),
		);

	}  // eo create records







}  // end of class

?>
