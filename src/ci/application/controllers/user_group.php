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

    public $statusModel;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_Model', 'userModel');
    }

    public function index()
    {
        $groupId = $this->input->get('groupId');
        $group = $this->userModel->getGroupByGroupId($groupId);
        $usersInGroup = $this->userModel->getUsersInGroupByGroupID($groupId);
        $this->renderSocialView('user/group/view', array(
            'group' => $group,
            'usersInGroup' => $usersInGroup
        ), true);
    }

    public function handlePostNotice()
    {
        $notice = trim($this->input->post('txtGroupNotice'));
        $userId = get_current_user_id();
        $response = array(
            'success'   => false,
            'result'    => ''
        );
        if ($userId === 0) {
            $response['result'] = 'Please login first';
        }

        if (empty($notice)) {
            $response['result'] = 'Please input notice';
        }

        if (empty($response['result'])) {
            $noticeId = $this->userModel->addGroupNotice($userId, $notice);
            if ($noticeId !== false) {
                $response['success'] = true;
                $response['result'] = $this->renderGroupNotice($noticeId);
            } else {
                $response['result'] = 'Can not post status. Please try again.';
            }
        }
        return $response;
    }

    private function renderGroupNotice($noticeId)
    {
        $notice = $this->userModel->findById($noticeId);
        if ($notice !== false && is_array($notice)) {
            return $this->render('/group/notice_content', array(
                'postDate'      => $notice['created_time'],
                'notice'        => $notice,
                'referenceType' => Feed_Model::REFERENCE_TYPE_NOTICE,
                'allowComment'  => true
            ));
        } else {
            return '';
        }

    }
}