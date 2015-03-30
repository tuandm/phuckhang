<?php
/**
 * Created by PhpStorm.
 * User: Storm
 * Date: 3/23/15
 * Time: 9:53 PM
 */
require_once('land_book_model.php');
Class User_Model extends Land_Book_Model
{
    public function addUserPhotos($dataPhotos)
    {
        return $this->create('pk_sc_user_photos', $dataPhotos);
    }

    public function getAllPhotos()
    {
        $this->db
            ->select('pk_sc_user_photos.user_id, pk_sc_user_photos.name, pk_sc_user_photos.path, pk_sc_user_photos.description, pk_users.user_login')
            ->from('pk_sc_user_photos')
            ->join('pk_users', 'pk_sc_user_photos.user_id = pk_users.ID', 'left')
            ->order_by('pk_sc_user_photos.sc_user_photo_id', 'ASC');
        $photos = $this->db->get()->result_array();
        return $photos;
    }

    public function getAllFriends()
    {
        $this->db
            ->select('*')
            ->from('pk_sc_user_friends')
            ->join('pk_users', 'pk_sc_user_friends.friend_id = pk_users.ID', 'left')
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
}