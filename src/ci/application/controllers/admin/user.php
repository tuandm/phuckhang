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

    /**
     * @var Users_Model
     */
    public $userModel;

    /**
     * @var CI_Loader
     */
    public $load;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('sc_user_management');
        $this->load->model('admin/Users_Model', 'userModel');
        $this->load->library('form_validation');
        $this->load->database();
        $this->load->helper('url');

        $this->userTable = new Sc_User_Management();

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

    /**
     * Delete group
     */
    public function deleteGroup()
    {
        global $wpdb;
        if (!is_admin()) {
            die('You don\'t have permission to delete');
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

    /**
     * Delete user
     */
    public function deleteUser()
    {
        global $wpdb;
        if (!is_admin()) {
            die('You don\'t have permission to delete');
        }
        $userId = $wpdb->get('userId');
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

    /**
     * Filter group
     */
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

    /**
     * Edit Group User
     */
    public function editGroup()
    {
        global $wpdb;
        $userId = $this->input->get('userId');
        $tax = get_taxonomy('sc_group');
        $results = $wpdb->get_col("SELECT group_id FROM pk_sc_user_groups WHERE user_id = '$userId'");
        $roles = $wpdb->get_results('SELECT group_id, role FROM pk_sc_user_groups WHERE user_id =' . $userId, ARRAY_A);
        $roleNames = array();
        foreach ($roles as $role) {
            $roleNames[$role['group_id']] = $role['role'];
        }
        // Make sure the user can assign terms of the profession taxonomy before proceeding.
        if (!current_user_can($tax->cap->assign_terms))
            return;
        // Get the terms of the 'sc_group' taxonomy.
        $terms = get_terms('sc_group', array('hide_empty' => false));
        foreach ($terms as &$term) {
            if (in_array($term->term_id, $results)) {
                $term->checked = 1;
                $term->role = $roleNames[$term->term_id];
            } else {
                $term->checked = 0;
                $term->role = 'No Role';
            }
        }

        $this->load->view('admin/user/edit_group', [
            'terms'     => $terms,
            'results'   => $results,
            'userId'    => $userId,
            'role'      => $roles
        ]);
    }
    /**
     *  Update user group
     *
     */
    function updateUserGroups()
    {
        global $wpdb;
        $postUserGroups = array_keys(filter_input(INPUT_POST, 'group', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY));
        $roles = filter_input(INPUT_POST, 'role', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $insertResult = true;
        $deleteResult = true;
        $userId = (int) filter_input(INPUT_POST, 'user_id');
        $results = $this->userModel->getGroupNameByUserId($userId);
        $currentUserGroups = wp_list_pluck($results, 'group_id', '');
        if (!is_admin()) {
            die ('You do not have permission to edit this user');
        }
        if ($postUserGroups == null) {
            $wpdb->delete('pk_sc_user_groups', array('user_id' => $userId));
        }
        foreach ($postUserGroups as $postUserGroup) {
            $checkGroup = in_array($postUserGroup, $currentUserGroups) ? 1 : 0;
            if ($checkGroup == 0) {
                $data = array(
                        'user_id'   => $userId,
                        'group_id'  => $postUserGroup,
                        'role'      => $roles["$postUserGroup"]
                    );
                $insertResult = $wpdb->insert('pk_sc_user_groups', $data);
            } else {
                $data = array(
                    'role' => $roles["$postUserGroup"],
                );
                $where = array(
                    'user_id'   => $userId,
                    'group_id'  => $postUserGroup
                );
                $insertResult = $wpdb->update('pk_sc_user_groups', $data, $where);
            }
        }

        foreach ($currentUserGroups as $currentUserGroup) {
            $checkGroup = in_array($currentUserGroup, $postUserGroups) ? 1 : 0;
            if ($checkGroup == 0) {
                $deleteResult = $wpdb->delete('pk_sc_user_groups', array(
                                    'group_id'  => $currentUserGroup,
                                    'user_id'   => $userId,
                                ));
            }
        }

        if ($insertResult || $deleteResult) {
            redirect(get_option('siteurl') . '/wp-admin/admin.php?page=landbook-users', 'refresh');
        } else {
            die('Update group is not successful');
        }
    }

}