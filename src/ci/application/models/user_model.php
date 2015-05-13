<?php
/**
 * Created by PhpStorm.
 * User: Storm
 * Date: 3/23/15
 * Time: 9:53 PM
 */
require_once('land_book_model.php');
require_once('feed_model.php');
Class User_Model extends Land_Book_Model
{
    public function addUserPhotos($dataPhotos)
    {
        return $this->create('pk_sc_user_photos', $dataPhotos);
    }

    public function getAllPhotos($userId)
    {
        $this->db
            ->select('pk_sc_user_photos.user_id, pk_sc_user_photos.name, pk_sc_user_photos.path, pk_sc_user_photos.description, pk_users.user_login')
            ->from('pk_sc_user_photos')
            ->join('pk_users', 'pk_sc_user_photos.user_id = pk_users.ID', 'left')
            ->where('pk_sc_user_photos.user_id', $userId)
            ->order_by('pk_sc_user_photos.sc_user_photo_id', 'ASC');
        $photos = $this->db->get()->result_array();
        return $photos;
    }

    public function getAllFriends($userId, $search='default')
    {
        $this->db
            ->select('*')
            ->from('pk_sc_user_friends')
            ->join('pk_users', 'pk_sc_user_friends.friend_id = pk_users.ID', 'left')
            ->like('display_name', $search)
            ->where('pk_sc_user_friends.user_id', $userId)
            ->order_by('pk_sc_user_friends.created_date', 'DES');
        $friends = $this->db->get()->result_array();
        return $friends;
    }

    public function  removeFriend($userId, $friendId)
    {
        return $this->db->delete('pk_sc_user_friends', array('user_id' => $userId, 'friend_id' => $friendId));
    }

    public function getUsersInGroupByGroupID($groupId)
    {
        $this->db
            ->select('pk_sc_user_groups.user_id')
            ->from('pk_sc_user_groups')
            ->where('pk_sc_user_groups.group_id', $groupId);
        $users = $this->db->get()->result_array();
        return $users;
    }

    public function getGroupByGroupId($groupId)
    {
        $this->db
            ->select('pk_terms.name, pk_terms.slug, pk_term_taxonomy.description, pk_term_taxonomy.term_id')
            ->from('pk_term_taxonomy')
            ->join('pk_terms', 'pk_terms.term_id = pk_term_taxonomy.term_id AND pk_terms.term_id = ' .$groupId, 'left')
            ->where('pk_term_taxonomy.taxonomy', 'sc_group')
            ->where('pk_term_taxonomy.term_id', $groupId);
        $group = $this->db->get()->row();
        return $group;
    }

    public function getRoleByUserId($userId,$groupId)
    {
        $this->db
            ->select('pk_sc_user_groups.role')
            ->from('pk_sc_user_groups')
            ->where('pk_sc_user_groups.group_id', $groupId)
            ->where('pk_sc_user_groups.user_id', $userId);
        $role = $this->db->get()->row();
        return $role;
    }

    /**
     * Add a Group Status into pk_sc_user_status
     *
     * @param int $groupId
     * @param int $userId
     * @param string $groupStatus
     * @return int|false
     */
    public function addGroupStatus($userId, $groupStatus, $groupId)
    {
        $now = date('Y-m-d H:i:s');
        $result = $this->db->insert('pk_sc_user_status', array(
            'status'        => $groupStatus,
            'user_id'       => $userId,
            'reference_id'  => $groupId,
            'status_type'   => Feed_Model::REFERENCE_TYPE_GROUP_STATUS,
            'created_time'  => $now,
        ));

        if ($result) {
            $groupStatusId = $this->db->insert_id();
            $feedModel = new Feed_Model();
            $feedResult = $feedModel->insert($userId, $groupStatusId, Feed_Model::REFERENCE_TYPE_GROUP_STATUS);
            if ($feedResult == false) {
                return false;
            }
        }
        return $groupStatusId;
    }

    public function findById($groupStatusId)
    {
        $rows = $this->db->select()
            ->from('pk_sc_user_status')
            ->where('status_id', $groupStatusId)
            ->get()
            ->result_array();
        if (empty($rows)) {
            return false;
        } else {
            return $rows[0];
        }
    }
}
