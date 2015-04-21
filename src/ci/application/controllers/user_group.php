<?php
/**
 * Created by PhpStorm.
 * User: Storm
 * Date: 3/26/15
 * Time: 8:42 PM
 */
include_once('base.php');
Class User_Group extends Base
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
        $groupId = $this->input->get('groupID');
        $group = $this->userModel->getGroupByGroupId($groupId);
        $usersInGroup = $this->userModel->getUsersInGroupByGroupID($groupId);
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