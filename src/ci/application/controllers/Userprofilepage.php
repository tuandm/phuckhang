<?php
/**
 * UserProfilepage Controller for social network
 * @author Phat Nguyen
 * @package LandBook
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Userprofilepage extends CI_Controller
{
    /**
     * @var User_Profile_Model
     */
    public $userProfileModel;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('userprofile/User_Profile_Model', 'userProfileModel');
    }

    public function index()
    {
        $this->load->view('layout/layout', array(
            'content' => $this->render('userprofilepage/index')
        ));
    }

    public function view()
    {
        global $wpdb;
        $userId = $this->input->get('userId');
        $phoneNumber = $this->userProfileModel->getPhoneNumberById($userId);
        $title = $this->userProfileModel->getTitleByUserId($userId);
        $info = $this->userProfileModel->getUserNameById($userId);
        $groups = $this->userProfileModel->getAllUserGroups($userId);
        foreach ($groups['group'] as $group) {
            $groupName = get_term($group['group_id'], 'sc_group');
            var_dump($groupName->name);
            var_dump($group['group_id']);
            var_dump($groupName);
        }
        $friends = $this->userProfileModel->getFriendsByUserId($userId);
        $dob = $this->userProfileModel->getDOBByUserId($userId);
        $dob = date("d-m-Y");
        var_dump($dob);
        $data = array(
                'userId'    => $userId,
                'title'     => $title,
                'phone'     => $phoneNumber,
                'info'      => $info,
                'numGroups' => $numGroups,
                'friends'   => $friends,
                'dob'       => $dob
        );
        $this->load->view('layout/layout', array(
                        'content'   => $this->render('userprofilepage/view_profile', $data
            )));
    }
}
