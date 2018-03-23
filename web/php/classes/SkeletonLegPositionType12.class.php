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
* Skeleton leg position type master
*
* Values are hardcoded without database.
*/
class SkeletonLegPositionType12 extends DbRecFake {


	const ID_1 = 'ID_1';
	const ID_2 = 'ID_2';
	const ID_3 = 'ID_3';
	const ID_4 = 'ID_4';
	const ID_5 = 'ID_5';
	const ID_6 = 'ID_6';
	const ID_7 = 'ID_7';
	const ID_8 = 'ID_8';
	const ID_9 = 'ID_9';
	const ID_10 = 'ID_10';


	static $records = array();




	/**
	* Create record list
	*/
	public static function createRecords() {

		if (static::$records) {
			return;
		}

		static::$records = array(
			static::ID_1 =>
				array('id' => static::ID_1,
							'name' => Oger::_('1) R/B Gestreckt'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_2 =>
				array('id' => static::ID_2,
							'name' => Oger::_('2) R/B Leicht gespreizt'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_3 =>
				array('id' => static::ID_3,
							'name' => Oger::_('3) R/B "O-Beine"'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_4 =>
				array('id' => static::ID_4,
							'name' => Oger::_('4) R/B Knie nach rechts'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_5 =>
				array('id' => static::ID_5,
							'name' => Oger::_('5) R/B Knie nach links'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_6 =>
				array('id' => static::ID_6,
							'name' => Oger::_('6) SL Gestreckt'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_7 =>
				array('id' => static::ID_7,
							'name' => Oger::_('7) SL Leicht gewinkelt (< 90 Grad)'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_8 =>
				array('id' => static::ID_8,
							'name' => Oger::_('8) SL etwa 90 Grad'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_9 =>
				array('id' => static::ID_9,
							'name' => Oger::_('9) SL Stark gewinkelt (> 90 Grad)'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_10 =>
				array('id' => static::ID_10,
							'name' => Oger::_('10) SL Sehr stark angewinkelt'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
		);

	}  // eo create records






}  // end of class

?>
