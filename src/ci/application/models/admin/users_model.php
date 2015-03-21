<?php
/**
 * User: Phat Nguyen
 * 
 */
require_once(dirname(dirname(__FILE__)) . "/land_book_model.php");
class Users_Model extends Land_Book_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getAllUsers($order, $orderBy)
    {
        $this->db
            ->distinct()
            ->select('*')
            ->group_by('pk_users.ID')
            ->from('pk_users')
            ->join('pk_sc_user_groups', 'pk_users.id = pk_sc_user_groups.user_id')
            ->order_by($orderBy, $order);
        $users = $this->db->get()->result_array();
        return $users;
    }

    public function getGroupsByUserId($userId)
    {
        $this->db
        ->select('pk_sc_user_groups.group_id')
        ->from('pk_sc_user_groups')
        ->where('pk_sc_user_groups.user_id', $userId);
        $groupIds = $this->db->get()->result_array();
        return $groupIds;
    }

    public function countAllUsers()
    {
        $results = $this->db
                    ->distinct()
                    ->select('*')
                    ->group_by('pk_users.ID')
                    ->from('pk_users')
                    ->join('pk_sc_user_groups', 'pk_users.id = pk_sc_user_groups.user_id')
                    ->get()->result_array();
        return count($results);
    }

    public function filterUser($name, $groupId, $orderBy, $order)
    {
        if ($groupId == 0) {
            $results = $this->db
                        ->distinct()
                        ->select('user_id, pk_users.*')
                        ->from('pk_users')
                        ->join('pk_sc_user_groups', 'pk_users.id = pk_sc_user_groups.user_id')
                        ->like('pk_users.user_nicename', $name)
                        ->order_by($orderBy, $order)
                        ->get()
                        ->result_array();
        } else {
            $results = $this->db->select('user_id, pk_users.*')
                    ->distinct()
                    ->from('pk_users')
                    ->join('pk_sc_user_groups', 'pk_users.id = pk_sc_user_groups.user_id')
                    ->where('group_id', $groupId)
                    ->like('pk_users.user_nicename', $name)
                    ->order_by($orderBy, $order)
                    ->get()
                    ->result_array();
        }
        return $results;
    }

    public function countFilterUsers($name, $groupId)
    {
        if ($groupId == 0) {
            $results = $this->db->select('user_id, pk_users.*')
                        ->distinct()
                        ->from('pk_users')
                        ->join('pk_sc_user_groups', 'pk_users.id =  pk_sc_user_groups.user_id')
                        ->like('pk_users.user_nicename', $name)
                        ->get()
                        ->result_array();
        } else {
            $results = $this->db->select('user_id, pk_users.*')
                    ->distinct()
                    ->from('pk_users')
                    ->join('pk_sc_user_groups', 'pk_users.id = pk_sc_user_groups.user_id')
                    ->where('group_id', $groupId)
                    ->like('pk_users.user_nicename', $name)
                    ->get()
                    ->result_array();
        }
        return count($results);
    }

}
