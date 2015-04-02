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

    public function getAllFriends($search='default')
    {
        $this->db
            ->select('*')
            ->from('pk_sc_user_friends')
            ->join('pk_users', 'pk_sc_user_friends.friend_id = pk_users.ID', 'left')
            ->like('display_name', $search)
            ->order_by('pk_sc_user_friends.created_date', 'DES');
        $friends = $this->db->get()->result_array();
        return $friends;
    }

    public function  removeFriend($userId, $friendId)
    {
        return $this->db->delete('pk_sc_user_friends', array('user_id' => $userId, 'friend_id' => $friendId));
    }

}