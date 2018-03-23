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
* Skeleton bone quality type master
*
* Values are hardcoded without database.
*/
class SkeletonBoneQualityType12 extends DbRecFake {


	const ID_1 = 'ID_1';
	const ID_2 = 'ID_2';
	const ID_3 = 'ID_3';
	const ID_4 = 'ID_4';
	const ID_5 = 'ID_5';


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
							'name' => Oger::_('1 Sehr gut'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_2 =>
				array('id' => static::ID_2,
							'name' => Oger::_('2 Gut'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_3 =>
				array('id' => static::ID_3,
							'name' => Oger::_('3 Durchschnittlich'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_4 =>
				array('id' => static::ID_4,
							'name' => Oger::_('4 Schlecht'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_5 =>
				array('id' => static::ID_5,
							'name' => Oger::_('5 Sehr schlecht'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
		);

	}  // eo create records





}  // end of class

?>
