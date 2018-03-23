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
*/
class UserToUserGroup extends DbRec {

	public static $tableName = "userToUserGroup";


	// ###################################



	/*
	* Get user group list for given user
	* The group_concat_max_len is 1024 by default. To change use:
	* "SET group_concat_max_len = xxxxx;"
	*/
	public static function getUserGroupIdList($userId) {

		return Dbw::fetchValue1(
						"SELECT GROUP_CONCAT(userGroupId SEPARATOR ', ')" .
						" FROM " . static::$tableName .
						" WHERE userId=:userId" .
						" ORDER BY userGroupId",
						array("userId" => $userId));
	}  // eo get user group list


	/*
	* Get user list for given user group
	* The group_concat_max_len is 1024 by default. To change use:
	* "SET group_concat_max_len = xxxxx;"
	*/
	public static function getUserIdList($userGroupId) {

		return Dbw::fetchValue1(
						"SELECT GROUP_CONCAT(userId SEPARATOR ', ')" .
						" FROM " . static::$tableName .
						" WHERE userGroupId=:userGroupId" .
						" ORDER BY userId",
						array("userGroupId" => $userGroupId));
	}  // eo get user group list





	/*
	* Save user group id list
	*/
	public static function saveUserGroupIdList($userId, $idList, $opts = array()) {

		$tableName = static::$tableName;

		// only admin can assign or remove user groups from user
		if (!(Logon::$logon->user->hasPerm("SUPER"))) {
			throw new Exception(Oger::_("Sie benötigen Administrationsrechte für diesen Vorgang (save-usergroup-idlist)."));
		}
		$oldIds = explode(",", static::getUserGroupIdList($userId));
		$newIds = explode(",", $idList);

		// delete removed user groups
		$delIds = array_diff($oldIds, $newIds);
		if ($delIds && $opts['allowDelete']) {
			$pstmt = Dbw::$conn->prepare("DELETE FROM {$tableName} WHERE userId=:userId AND userGroupId=:userGroupId");
			foreach ($delIds as $id) {
				$pstmt->execute(array("userId" => $userId, "userGroupId" => $id));
			}
		}  // eo delete

		// insert new (not existing) user groups
    $addIds = array_diff($newIds, $oldIds);
    if ($addIds) {
      $pstmt = Dbw::$conn->prepare("INSERT INTO {$tableName} (userId, userGroupId) VALUES (:userId, :userGroupId)");
      foreach ($addIds as $id) {
        //static::store("INSERT", array("userId" => $userId, "userGroupId" => $id));
          $pstmt->execute(array("userId" => $userId, "userGroupId" => $id));
      }
    }  // eo add

	}  // eo save user group id list





}  // eo class



?>
