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
* Skeleton sex type master
*
* Values are hardcoded without database.
*/
class SkeletonSexType12 extends DbRecFake {


	const ID_CHILD = 'ID_CHILD';
	const ID_MALE = 'ID_MALE';
	const ID_FEMALE = 'ID_FEMALE';
	const ID_INDETERMINABLE = 'ID_INDETERMINABLE';


	static $records = array();



	/**
	* Create record list
	*/
	public static function createRecords() {

		if (static::$records) {
			return;
		}

		static::$records = array(
			static::ID_CHILD =>
				array('id' => static::ID_CHILD,
							'name' => Oger::_('Kind'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_MALE =>
				array('id' => static::ID_MALE,
							'name' => Oger::_('Männlich'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_FEMALE =>
				array('id' => static::ID_FEMALE,
							'name' => Oger::_('Weiblich'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_INDETERMINABLE =>
				array('id' => static::ID_INDETERMINABLE,
							'name' => Oger::_('Nicht erkennbar'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
		);

	}  // eo create records







}  // end of class



?>
