<?php
/**
 * User: Phat Nguyen
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller 
{
    private $userTable;
    private $users;
    private $order;
    private $orderBy;
    private $checkHeader; 

    public function __construct()
    {
        parent::__construct();
        $this->load->library('ScUserManage');
        $this->load->model('admin/Users_Model', 'userModel');
        $this->load->library('form_validation');
        $this->load->database();
        $this->load->helper('url');

        $this->userTable = new MY_SCUserManage();

        $this->orderBy = !empty($this->input->get('orderby')) ? $this->input->get('orderby') : 'ID';
        $this->order = !empty($this->input->get('order')) ? $this->input->get('order') : 'ASC';
        $this->checkHeader = $this->input->get('noheader');
        if (isset($this->checkHeader)) {
            require_once(ABSPATH . 'wp-admin/admin-header.php');
        }
    }

    /**
     * Show All Users
     */
    public function index()
    {
        $this->users = $this->userModel->getAllUsers($this->order, $this->orderBy);
        foreach ($this->users as &$user) {
            $user['group_ids'] = $this->userModel->getGroupsByUserId($user['ID']);
        }
        $numUser = $this->userModel->countAllUsers();
        $this->userTable->prepare_items($this->users, $numUser);
        $this->load->view('admin/user/view_all', array('userTable' => $this->userTable));
    }

    public function deleteGroup()
    {
        global $wpdb;
        if (!is_admin()) {
            die('You dont have permission to delete');
        }
        $groupId = $this->input->get('group');
        $userId = $this->input->get('userId');
        $result = $wpdb->delete('pk_sc_user_groups', array(
                        'group_id'  => $groupId,
                        'user_id'   => $userId
                    ));
        if ($result) {
            redirect(get_option('siteurl') . '/wp-admin/admin.php?page=landbook-users', 'refresh');
        } else {
            die('Server is busy');
        }
    }

    public function deleteUser()
    {
        global $wpdb;
        if (!is_admin()) {
            die('You dont have permission to delete');
        }
        $userId = $this->input->get('userId');
        $resultGroup = $wpdb->delete('pk_sc_user_groups', array(
                        'user_id'   => $userId
                    ));
        $resultUser = $wpdb->delete('pk_users', array(
                        'ID'   => $userId
        ));
        if ($resultGroup && $resultUser) {
            redirect(get_option('siteurl') . '/wp-admin/admin.php?page=landbook-users', 'refresh');
        } else {
            die('Server is busy');
        }
    }

    public function filter()
    {
        $s = $this->input->get('s');
        $groupId = $this->input->get('cat');
        $this->users = $this->userModel->filterUser($s, $groupId, $this->orderBy, $this->order);
        $numUsers = $this->userModel->countFilterUsers($s, $groupId);
        foreach ($this->users as &$user) {
            $user['group_ids'] = $this->userModel->getGroupsByUserId($user['ID']);
        }
        $this->userTable->prepare_items($this->users, $numUsers);
        $this->load->view('admin/user/view_all', array(
                        'userTable'     => $this->userTable,
        ));
    }

}
