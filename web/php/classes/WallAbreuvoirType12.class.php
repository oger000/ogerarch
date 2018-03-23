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
* Wall abreuvoir type master
*
* Values are hardcoded without database.
*/
class WallAbreuvoirType12 extends DbRecFake {


	const ID_SMEARED = 'ID_SMEARED';
	const ID_OVERFLOW = 'ID_OVERFLOW';
	const ID_TROWEL = 'ID_TROWEL';
	const ID_OTHER = 'ID_OTHER';


	static $records = array();



	/**
	* Create record list
	*/
	public static function createRecords() {

		if (static::$records) {
			return;
		}

		static::$records = array(
			static::ID_SMEARED =>
				array('id' => static::ID_SMEARED,
							'name' => Oger::_('Verstrichen'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_OVERFLOW =>
				array('id' => static::ID_OVERFLOW,
							'name' => Oger::_('Herausgequollen'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_TROWEL =>
				array('id' => static::ID_TROWEL,
							'name' => Oger::_('Kellenstrich'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_OTHER =>
				array('id' => static::ID_OTHER,
							'name' => Oger::_('Sonstiges'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
		);

	}  // eo create records







}  // end of class



?>
