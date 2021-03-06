<?php
/**
 * Created by PhpStorm.
 * User: Storm
 * Date: 3/24/15
 * Time: 10:44 AM
 */
include_once('base.php');
Class User_Friends extends Base
{
    /**
     * @var User_Model
     */
    public $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('User_Model', 'userModel');
    }

    public function index()
    {
        $search = '';
        $uId = $this->input->get('userId');
        $userId = ($uId) ? $uId : get_current_user_id();
        $friends = $this->userModel->getAllFriends($userId, $search);

        $this->renderSocialView('user/friend/view', array(
                'friends' => $friends,
                'userId'    => $userId
        ), true);
    }

    public function handleSearch()
    {
        $response = array(
            'success'   => false,
            'result'    => ''
        );
        $search = $this->input->post('search');
        $uId = $this->input->get('userId');
        $userId = ($uId) ? $uId : get_current_user_id();
        $friends = $this->userModel->getAllFriends($userId, $search);

        if (!empty($friends)) {
            $response['success'] = true;
            $response['result'] = $this->render('/user/friend/friend', array(
                'friends' => $friends,
                'userId'    => $userId
            ));
        } else {
            $response['success'] = false;
        }
        return $response;
    }

    public function removeFriend()
    {
        $userId = (int) $this->input->get('userId');
        $friendId = (int) $this->input->get('friendId');
        $this->userModel->removeFriend($userId, $friendId);
        redirect(get_option('siteurl') . '/social-user-friends/', 'refresh');
    }

}