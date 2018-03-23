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
* Skeleton tomb demage form type master
*
* Values are hardcoded without database.
*/
class SkeletonTombDemageFormType12 extends DbRecFake {


	const ID_CIRCLE = 'ID_CIRCLE';
	const ID_OVAL = 'ID_OVAL';
	const ID_RECTANGLE = 'ID_RECTANGLE';
	const ID_SQUARE = 'ID_SQUARE';
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
			static::ID_CIRCLE =>
				array('id' => static::ID_CIRCLE,
							'name' => Oger::_('Rund'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_OVAL =>
				array('id' => static::ID_OVAL,
							'name' => Oger::_('Oval'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_RECTANGLE =>
				array('id' => static::ID_RECTANGLE,
							'name' => Oger::_('Rechteckig'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_SQUARE =>
				array('id' => static::ID_SQUARE,
							'name' => Oger::_('Quadratisch'),
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
