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
* Skeleton age type master
*
* Values are hardcoded without database.
*/
class SkeletonBodyPositionType12 extends DbRecFake {


	const ID_BACK = 'ID_BACK';
	const ID_LEFT = 'ID_LEFT';
	const ID_RIGHT = 'ID_RIGHT';
	const ID_BELLY = 'ID_BELLY';
	//const ID_DESTROYED = 'ID_DESTROYED';
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
			static::ID_BACK =>
				array('id' => static::ID_BACK,
							'name' => Oger::_('Gestreckte Rückenlage'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_LEFT =>
				array('id' => static::ID_LEFT,
							'name' => Oger::_('Hockerlage Links'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_RIGHT =>
				array('id' => static::ID_RIGHT,
							'name' => Oger::_('Hockerlage Rechts'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_BELLY =>
				array('id' => static::ID_BELLY,
							'name' => Oger::_('Gestreckte Bauchlage'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			/*
			static::ID_DESTROYED =>
				array('id' => static::ID_DESTROYED,
							'name' => Oger::_('Irritiert/Gestört'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			*/
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
