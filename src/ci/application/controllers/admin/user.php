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

    public function editGroup()
    {
        global $wpdb;
        $userId = $this->input->get('userId');
        $tax = get_taxonomy('sc_group');
        $results = $wpdb->get_col("SELECT group_id FROM pk_sc_user_groups WHERE user_id = $userId");
        /* Make sure the user can assign terms of the profession taxonomy before proceeding. */
        if (!current_user_can($tax->cap->assign_terms))
            return;
        /* Get the terms of the 'profession' taxonomy. */
        $terms = get_terms('sc_group', array('hide_empty' => false));
        $this->load->view('admin/user/edit_group', array(
                        'terms'     => $terms,
                        'results'   => $results,
                        'userId'    => $userId
        ));
    }

    /**
     *
     * @param unknown $userId
     */
    function updateUserGroups()
    {
        global $wpdb;
        $insertResult = true;
        $deleteResult = true;
        $updateData = $this->input->post();
        $terms = get_terms('sc_group', array('hide_empty' => false));
        $userId = filter_input(INPUT_POST, 'user_id');
        $postUserGroups = filter_input(INPUT_POST, 'group', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $numPostUserGroups = count($postUserGroups);
        $results = $wpdb->get_results("SELECT group_id, pk_terms.name FROM pk_sc_user_groups
                INNER JOIN pk_terms ON pk_sc_user_groups.group_id = pk_terms.term_id WHERE pk_sc_user_groups.user_id = $userId", ARRAY_A);
        $currentUserGroups = wp_list_pluck($results, 'name', 'group_id');
        $numCurrentUserGroups = count($currentUserGroups);
        $termArray = wp_list_pluck($terms, 'name', 'term_id');
        if (!is_admin()) {
            die ('You do not have permission to edit this user');
        }
        if ($postUserGroups == null) {
            $result = $wpdb->delete('pk_sc_user_groups', array('user_id' => $userId));
        }
        foreach ($postUserGroups as $postUserGroup) {
            $checkGroup = in_array($postUserGroup, $currentUserGroups) ? 1 : 0;
            if ($checkGroup == 0) {
                $groupId = $wpdb->get_col("SELECT term_id FROM pk_terms WHERE pk_terms.name = '$postUserGroup'")[0];
                $data = array(
                        'user_id'   => $userId,
                        'group_id'  => $groupId
                    );
                $insertResult = $wpdb->insert('pk_sc_user_groups', $data);
                }
        }
        foreach ($currentUserGroups as $groupId => $currentUserGroup) {
            $checkGroup = in_array($currentUserGroup, $postUserGroups) ? 1 : 0;
            if ($checkGroup == 0) {
                $deleteResult = $wpdb->delete('pk_sc_user_groups', array(
                                    'group_id'  => $groupId,
                                    'user_id'   => $userId
                                ));
            }
        }
        if ($insertResult && $deleteResult) {
            redirect(get_option('siteurl') . '/wp-admin/admin.php?page=landbook-users', 'refresh');
        } else {
            die('Update group is not successful');
        }
    }

}
