<?php
/**
 * Created by PhpStorm.
 * User: Storm
 * Date: 3/24/15
 * Time: 10:44 AM
 */
Class User_Friends extends CI_Controller
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
        $friends = $this->userModel->getAllFriends();
        $this->load->view('layout/layout', array(
            'content' => $this->render('user/friend/view', array(
                'friends' => $friends
            )),
        ));
    }

    public function removeFriend()
    {
        $userId = (int) $this->input->get('userId');
        $friendId = (int) $this->input->get('friendId');
        $this->userModel->removeFriend($userId, $friendId);
        $this->index();
    }

}