<?php
/**
 * UserProfilepage Controller for social network
 * @author Phat Nguyen
 * @package LandBook
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once('base.php');

class User_Profile extends Base
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Default page of user when login
     */
    public function index()
    {
        // Information for the viewed user profile
        $viewedUserId = ($this->input->get('userId')) ? $this->input->get('userId') : get_current_user_id();
        $viewedPhoneNumber = $this->userProfileModel->getPhoneNumberById($viewedUserId);
        $viewedTitle = $this->userProfileModel->getTitleByUserId($viewedUserId);
        $viewedName = $this->userProfileModel->getUserInfoById($viewedUserId)['user_nicename'];
        $viewedEmail = $this->userProfileModel->getUserInfoById($viewedUserId)['user_email'];
        $viewedFriends = $this->userProfileModel->getFriendsByUserId($viewedUserId);

        $userDob = $this->userProfileModel->getDOBByUserId($viewedUserId);
        $viewedDob = !empty($viewedUserId) ? date("d-m-Y", strtotime($userDob)) : '';
        $viewedUser = array(
            'userId'        => $viewedUserId,
            'title'         => $viewedTitle,
            'phone'         => $viewedPhoneNumber,
            'name'          => $viewedName,
            'email'         => $viewedEmail,
            'dob'           => $viewedDob,
            'friendIds'     => $viewedFriends['friendId'],
            'numFriends'    => $viewedFriends['numFriend']
        );

        $data = array('viewedUser' => $viewedUser);

        $loginUserId = get_current_user_id();
        if ($loginUserId != 0) {
            // Information for login user profile
            $loginName = $this->userProfileModel->getUserInfoById($loginUserId)['user_nicename'];
            $loginTitle = $this->userProfileModel->getTitleByUserId($loginUserId);
            $loginGroups = $this->userProfileModel->getAllUserGroups($loginUserId);
            $loginFriends = $this->userProfileModel->getFriendsByUserId($loginUserId);
            $loginUser = array(
                'userId' => $loginUserId,
                'title' => $loginTitle,
                'name' => $loginName,
                'numGroups' => count($loginGroups),
                'numFriends' => $loginFriends['numFriend']
            );
            $data['loginUser'] = $loginUser;
        }

        $this->renderSocialView('userprofilepage/index', $data, true);
    }

}
