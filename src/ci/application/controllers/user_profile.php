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
    /**
     * @var User_Model
     */
    public $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_Model', 'userModel');
    }

    /**
     * Default page of user when login
     */
    public function index()
    {
        // Information for the viewed user profile
        $userId = $this->input->get('userId');
        $viewedUserId = $userId ? $userId : get_current_user_id();
        $viewedPhoneNumber = $this->userProfileModel->getPhoneNumberById($viewedUserId);
        $viewedTitle = $this->userProfileModel->getTitleByUserId($viewedUserId);
        $viewedName = $this->userProfileModel->getUserInfoById($viewedUserId)['user_nicename'];
        $viewedEmail = $this->userProfileModel->getUserInfoById($viewedUserId)['user_email'];
        $viewedFriends = $this->userProfileModel->getFriendsByUserId($viewedUserId);

        $userDob = $this->userProfileModel->getDOBByUserId($viewedUserId);
        $viewedDob = !empty($viewedUserId) ? date("d-m-Y", strtotime($userDob)) : '';

        //Handle add friend
        $currentUserId = get_current_user_id();
        $isFriend = $this->userModel->isFriend($currentUserId, $userId);
        if($isFriend) {
            $btnSubmit = ((int)$isFriend[0]['status'] === 0 ) ? "Remove" : "Pending";
        } else {
            $btnSubmit = "Add";
        }

        $viewedUser = array(
            'userId'        => $viewedUserId,
            'title'         => $viewedTitle,
            'phone'         => $viewedPhoneNumber,
            'name'          => $viewedName,
            'email'         => $viewedEmail,
            'dob'           => $viewedDob,
            'friendIds'     => $viewedFriends['friendId'],
            'numFriends'    => $viewedFriends['numFriend'],
            'submitValue'   => $btnSubmit,
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

    public function handleAddFriend()
    {
        $friendId = $this->input->post('friendId');
        $userId = get_current_user_id();
        $response = array(
            'success'   => false,
            'result'    => ''
        );

        if (empty($response['result'])) {
            $userFriendId = $this->userModel->addFriend($userId, $friendId);
            if ($userFriendId!== false) {
                do_action('save_user_friend', $userFriendId);
                $response['success'] = true;
                $response['result'] = $userFriendId;
            } else {
                $response['result'] = 'Can not add friend. Please try again.';
            }
        }
        return $response;
    }

    public function handleRemoveFriend()
    {
        $friendId = (int)$this->input->post('friendId');
        $userId = get_current_user_id();
        $response = array(
            'success'   => false,
            'result'    => ''
        );

        if (empty($response['result'])) {
            $this->userModel->removeFriend($userId, $friendId);
                $response['success'] = true;
        }
        return $response;
    }
}
