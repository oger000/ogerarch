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
class SkeletonAgeType12 extends DbRecFake {


	const ID_PRAENATAL = 'ID_PRAENATAL';
	const ID_NEONATUS = 'ID_NEONATUS';
	const ID_INFANT1 = 'ID_INFANT1';
	const ID_INFANT2 = 'ID_INFANT2';
	const ID_JUVENIL = 'ID_JUVENIL';
	const ID_SUBADULT = 'ID_SUBADULT';
	const ID_ADULT = 'ID_ADULT';
	const ID_MATURE = 'ID_MATURE';
	const ID_SENIL = 'ID_SENIL';
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
			static::ID_PRAENATAL =>
				array('id' => static::ID_PRAENATAL,
							'name' => Oger::_('Pränatal'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_NEONATUS =>
				array('id' => static::ID_NEONATUS,
							'name' => Oger::_('Neonatus'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_INFANT1 =>
				array('id' => static::ID_INFANT1,
							'name' => Oger::_('Infans I'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_INFANT2 =>
				array('id' => static::ID_INFANT2,
							'name' => Oger::_('Infans II'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_JUVENIL =>
				array('id' => static::ID_JUVENIL,
							'name' => Oger::_('Juvenil'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_SUBADULT =>
				array('id' => static::ID_SUBADULT,
							'name' => Oger::_('Subadult'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_ADULT =>
				array('id' => static::ID_ADULT,
							'name' => Oger::_('Adult'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_MATURE =>
				array('id' => static::ID_MATURE,
							'name' => Oger::_('Matur'),
							'code' => '',
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_SENIL =>
				array('id' => static::ID_SENIL,
							'name' => Oger::_('Senil'),
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
