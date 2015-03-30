<?php
/**
 * Created by PhpStorm.
 * User: Storm
 * Date: 3/26/15
 * Time: 8:42 PM
 */
Class User_Group extends CI_Controller
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
        //$groupId =
        $group = $this->userModel->getGroupByGroupId(3);
        $usersInGroup = $this->userModel->getUsersInGroupByGroupID(3);
        //var_dump($usersInGroup);die;
        $this->load->view('layout/layout', array(
            'content' => $this->render('user/group/view', array(
                'group' => $group,
                'usersInGroup' => $usersInGroup
            )),
        ));
    }

    public function post()
    {
        echo 'aaaa';
        $this->index();
    }
}