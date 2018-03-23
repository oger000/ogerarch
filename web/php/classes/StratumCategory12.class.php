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
* Stratum category master
*
* Values are hardcoded without database.
*/
class StratumCategory12 extends DbRecFake {


	const ID_INTERFACE = 'INTERFACE';
	const ID_DEPOSIT = 'DEPOSIT';
	const ID_SKELETON = 'SKELETON';
	const ID_WALL = 'WALL';
	const ID_TIMBER = 'TIMBER';
	// const ID_COFFIN = 'COFFIN';   // sarg not used for now

	const ID_COMPLEX = 'COMPLEX';

	static $records = array();
	static $strucInfo = array();



	/**
	* Create record list
	*/
	public static function createRecords() {

		if (static::$records) {
			return;
		}

		static::$records = array(
			static::ID_INTERFACE =>
				array('id' => static::ID_INTERFACE,
							'name' => Oger::_('Interface'),
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_DEPOSIT =>
				array('id' => static::ID_DEPOSIT,
							'name' => Oger::_('Schicht'),
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_SKELETON =>
				array('id' => static::ID_SKELETON,
							'name' => Oger::_('Skelett'),
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_WALL =>
				array('id' => static::ID_WALL,
							'name' => Oger::_('Mauer'),
							'beginDate' => '',
							'endDate' => '',
						 ),
			static::ID_TIMBER =>
				array('id' => static::ID_TIMBER,
							'name' => Oger::_('Holz'),
							'beginDate' => '',
							'endDate' => '',
						 ),
			/*
			 * deactivate complex, because we have to code
			static::ID_COMPLEX =>
				array('id' => static::ID_COMPLEX,
							'name' => Oger::_('Komplex'),
							'beginDate' => '',
							'endDate' => '',
						 ),
			*/
		);

	}  // eo create records



	/**
	* Create info
	*/
	public static function createStrucInfo() {

		if (static::$strucInfo) {
			return;
		}

		static::$strucInfo = array(
			static::ID_DEPOSIT =>
				array('id' => static::ID_DEPOSIT,
							'className' => 'StratumDeposit',
						 ),
			static::ID_INTERFACE =>
				array('id' => static::ID_INTERFACE,
							'className' => 'StratumInterface',
						 ),
			static::ID_WALL =>
				array('id' => static::ID_WALL,
							'className' => 'StratumWall',
						 ),
			static::ID_SKELETON =>
				array('id' => static::ID_SKELETON,
							'className' => 'StratumSkeleton',
						 ),
			/*
			 * Complex is handled direct from Stratum class WITHOUT subclass object
			 * only with some static methods from StratumComplex (like Matrix)
			 * But we need the name of the table - for example for renaming the stratum id.
			 */
			static::ID_COMPLEX =>
				array('id' => static::ID_COMPLEX,
							'className' => 'StratumComplex',
						 ),
			static::ID_TIMBER =>
				array('id' => static::ID_TIMBER,
							'className' => 'StratumTimber',
						 ),
		);

	}  // eo create strucInfo


	/**
	* Get structure info
	* If id is given than for a single category otherwise return full list.
	*/
	public static function getStrucInfo($id) {
		static::createStrucInfo();
		if ($id) {
			return static::$strucInfo[$id];
		}
		else {
			return static::$strucInfo;
		}
	}  // eo get structure info



}  // end of class



?>
