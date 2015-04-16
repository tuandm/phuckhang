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
        $this->load->model('User_Model', 'userModel');
    }

    public function index()
    {
        $search = '';
        $userId = $this->input->get('userId');

        if($userId === false) {
            $userId = wp_get_current_user()->ID;
            $friends = $this->userModel->getAllFriends($userId, $search);
        } else {
            $friends = $this->userModel->getAllFriends($userId, $search);
        }

        $this->load->view('layout/layout', array(
            'content' => $this->render('user/friend/view', array(
                'friends' => $friends
            )),
        ));
    }

    public function handleSearch()
    {
        $response = array(
            'success'   => false,
            'result'    => ''
        );
        $search = $this->input->post('search');

        $userId = $this->input->get('userId');

        if($userId === false) {
            $userId = wp_get_current_user()->ID;
            $friends = $this->userModel->getAllFriends($userId, $search);
        } else {
            $friends = $this->userModel->getAllFriends($userId, $search);
        }

        if (!empty($friends)) {
            $response['success'] = true;
            $response['result'] = $this->render('/user/friend/friend', array(
                'friends' => $friends
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
        $this->index();
    }

}