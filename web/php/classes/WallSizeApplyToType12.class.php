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
* Wall size apply to types (is reused for timber sizes too)
*
* Values are hardcoded without database.
*/
class WallSizeApplyToType12 extends DbRecFake {


	const ID_CONSERVED = 'ID_CONSERVED';
	const ID_ORIGINAL = 'ID_ORIGINAL';
	const ID_VISIBLE = 'ID_VISIBLE';


	static $records = array();



	/**
	* Create record list
	*/
	public static function createRecords() {

		if (static::$records) {
			return;
		}

		static::$records = array(
			static::ID_CONSERVED =>
				array('id' => static::ID_CONSERVED,
							'name' => Oger::_('Erhalten'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_ORIGINAL =>
				array('id' => static::ID_ORIGINAL,
							'name' => Oger::_('Original'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_VISIBLE =>
				array('id' => static::ID_VISIBLE,
							'name' => Oger::_('Sichtbar'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
		);

	}  // eo create records







}  // end of class

?>
