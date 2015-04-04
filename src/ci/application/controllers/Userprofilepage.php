<?php
/**
 * UserProfilepage Controller for social network
 * @author Phat Nguyen
 * @package LandBook
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once('base.php');

class Userprofilepage extends Base
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
        // Information for the viewed user profile
        $viewedUserId = ($this->input->get('userId')) ? $this->input->get('userId') : get_current_user_id();
        $viewedPhoneNumber = $this->userProfileModel->getPhoneNumberById($viewedUserId);
        $viewedTitle = $this->userProfileModel->getTitleByUserId($viewedUserId);
        $viewedName = $this->userProfileModel->getUserInfoById($viewedUserId)['user_nicename'];
        $viewedEmail = $this->userProfileModel->getUserInfoById($viewedUserId)['user_email'];
        $viewedDob = empty($this->userProfileModel->getDOBByUserId($viewedUserId)) ? '' : date("d-m-Y", strtotime($this->userProfileModel->getDOBByUserId($viewedUserId)));
        $viewedUser = array(
            'userId'    => $viewedUserId,
            'title'     => $viewedTitle,
            'phone'     => $viewedPhoneNumber,
            'name'      => $viewedName,
            'email'     => $viewedEmail,
            'dob'       => $viewedDob
        );

        // Information for login user profile
        $loginUserId = get_current_user_id();
        $loginName = $this->userProfileModel->getUserInfoById($loginUserId)['user_nicename'];
        $loginTitle = $this->userProfileModel->getTitleByUserId($loginUserId);
        $loginFriends = $this->userProfileModel->getFriendsByUserId($loginUserId);
        $loginGroups = $this->userProfileModel->getAllUserGroups($loginUserId);

        if ($loginGroups['numGroups'] === 0) {
            $loginGroupNames = '';
        }
        foreach ($loginGroups['group'] as $group) {
            $loginGroupNames[] = get_term($group['group_id'], 'sc_group', ARRAY_A)['name'];
        }
        $loginUser = array(
            'userId'        => $loginUserId,
            'title'         => $loginTitle,
            'name'          => $loginName,
            'numGroups'     => $loginGroups['numGroups'],
            'groupNames'    => $loginGroupNames,
            'numFriends'    => $loginFriends['numFriend'],
            'friendIds'     => $loginFriends['friendId'],
        );
        $this->load->view('layout/layout', array(
            'content' => $this->render('userprofilepage/index', array(
                'viewedUser' => $viewedUser,
                'loginUser' => $loginUser
            ))
        ));
    }

}
