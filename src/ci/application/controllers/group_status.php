<?php
/**
 * Created by PhpStorm.
 * User: Storm
 * Date: 3/26/15
 * Time: 8:42 PM
 */
include_once('base.php');
Class Group_Status extends Base
{
    /**
     * @var Feed_Model
     */
    public $feedModel;

    /**
     * @var User_Model
     */
    public $userModel;

    /**
     * @var Status_Model
     */
    public $statusModel;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_Model', 'userModel');
        $this->load->model('Status_Model', 'userModel');
        $this->load->model('Feed_Model', 'feedModel');
    }

    /**
     * Default action handle Group Page controller
     */
    public function index()
    {
        $groupId = $this->input->get('groupId');
        $group = $this->userModel->getGroupByGroupId($groupId);
        $usersInGroup = $this->userModel->getUsersInGroupByGroupID($groupId);
        $feeds = $this->feedModel->getNewGroupFeeds($groupId);

        foreach ($feeds as $key => &$feed) {
            switch ($feed['reference_type']) {
                case Feed_Model::REFERENCE_TYPE_GROUP_STATUS:
                    $feed['html'] = $this->renderGroupStatus($feed['status_id']);
                    break;
                default;
                    $feed['html'] = '';
                    break;
            }
        }

        $this->renderSocialView('user/group/view', array(
            'feeds'         => $feeds,
            'group'         => $group,
            'groupId'       => $groupId,
            'usersInGroup'  => $usersInGroup
        ), true);
    }

    public function handlePostGroupStatus()
    {
        $groupStatus = trim($this->input->post('txtGroupStatus'));
        $userId = get_current_user_id();
        $groupId = $this->input->post('groupId');
        $response = array(
            'success'   => false,
            'result'    => ''
        );
        if ($userId === 0) {
            $response['result'] = 'Vui lòng đăng nhập trước';
        }

        if (empty($groupStatus)) {
            $response['result'] = 'Vui lòng nhập thông báo cho group';
        }

        if (empty($response['result'])) {
            $groupStatusId = $this->userModel->addGroupStatus($userId, $groupStatus, $groupId);
            if ($groupStatusId!== false) {
                $response['success'] = true;
                $response['result'] = $this->renderGroupStatus($groupStatusId);
                do_action('save_group_status', $groupStatusId);
            } else {
                $response['result'] = 'Can not post status. Please try again.';
            }
        }
        return $response;
    }

    /**
     * Render A Group Status
     *
     * @param int $groupStatusId
     * @return string
     */
    private function renderGroupStatus($groupStatusId)
    {
        $groupStatus = $this->userModel->findById($groupStatusId);
        if ($groupStatus !== false && is_array($groupStatus)) {
            return $this->render('/user/group/group_status', array(
                'groupStatus'   => $groupStatus,
                'referenceType' => Feed_Model::REFERENCE_TYPE_GROUP_STATUS,
                'allowComment'  => true
            ));
        } else {
            return '';
        }

    }

}
