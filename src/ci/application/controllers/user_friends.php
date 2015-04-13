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
        $friends = $this->userModel->getAllFriends($search);
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
        $friends = $this->userModel->getAllFriends($search);
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