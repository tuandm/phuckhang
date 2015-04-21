<?php
/**
 * Created by PhpStorm.
 * User: PN
 * Date: 4/9/2015
 * Time: 9:09 PM
 */

/**
 * Class LandBook_Model_Group
 */
class LandBook_Model_Group extends LandBook_Model {

    /**
     * Get sc_group name and sc_group id by $userId
     * @param $userId
     * @return array|bool
     */
    public function getScGroupByUserId($userId)
    {
        $results = $this->getWpdb()->get_results(
            "SELECT group_id, pk_terms.name FROM pk_sc_user_groups
            INNER JOIN pk_terms ON pk_sc_user_groups.group_id = pk_terms.term_id
            WHERE pk_sc_user_groups.user_id = $userId",
            ARRAY_A
        );
        return $results;
    }

    /**
     * Delete a group by $data
     * @param array $data
     * @return false|int
     */
    public function deleteGroup(array $data)
    {
        $result = $this->getWpdb()->delete('pk_sc_user_groups', $data);
        return $result;
    }

    /**
     * Insert groups into database
     * @param array $data
     * @return false|int
     */
    public function insertGroup(array $data)
    {
        $result = $this->getWpdb()->insert('pk_sc_user_groups', $data);
        return $result;
    }

    /**
     * Update group for user
     * @param array $updateData
     * @param int $userId
     * @return false|int
     */
    public function updateGroup(array $updateData, $userId)
    {
        $result = $this->getWpdb()->update('pk_users', $updateData, $userId);
        return $result;
    }

    /**
     * Get groupId by Name
     * @param $postUserGroup
     * @return int|bool
     */
    public function getGroupIdByName($postUserGroup)
    {
        $groupId = $this->getWpdb()->get_col("SELECT term_id FROM pk_terms WHERE pk_terms.name = '$postUserGroup'")[0];
        return $groupId;
    }

    /**
     * Get group id By User Id
     * @param $user
     * @return array
     */
    public function getGroupIdByUserId($user)
    {
        $groupId = $this->getWpdb()->get_col("SELECT group_id FROM pk_sc_user_groups WHERE user_id = $user->ID");
        return $groupId;
    }

    /**
     * Update User Groups
     */
    function updateUserGroups()
    {
        $updateData = filter_input_array(INPUT_POST);
        $userId = filter_input(INPUT_POST, 'user_id');
        $postUserGroups = filter_input(INPUT_POST, 'group', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        if ($postUserGroups == null) {
            return ;
        }
        $results = $this->getScGroupByUserId($userId);
        $currentUserGroups = wp_list_pluck($results, 'name', 'group_id');
        if (!is_admin()) {
            die ('You do not have permission to edit this user');
        }

        if ($postUserGroups == null) {
            $deleteData = array('user_id' =>  $userId);
            $this->deleteGroup($deleteData);
        }

        $this->updateGroup($updateData, $userId);
        foreach ($postUserGroups as $postUserGroup) {
            $checkGroup = in_array($postUserGroup, $currentUserGroups) ? 1 : 0;
            if ($checkGroup == 0) {
                $groupId = $this->getGroupIdByName($postUserGroup);
                $insertData = array(
                    'user_id'   => $userId,
                    'group_id'  => $groupId
                );
                $this->insertGroup($insertData);
            }
        }

        foreach ($currentUserGroups as $groupId => $currentUserGroup) {
            $checkGroup = in_array($currentUserGroup, $postUserGroups) ? 1 : 0;
            if ($checkGroup == 0) {
                $deleteDataWithGroupId = array(
                    'group_id'  => $groupId,
                    'user_id'   => $userId
                );
                $this->deleteGroup($deleteDataWithGroupId);
            }
        }
    }

}
