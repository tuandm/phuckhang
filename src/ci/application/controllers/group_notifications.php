<?php
/**
 * Created by PhpStorm.
 * User: Storm
 * Date: 3/26/15
 * Time: 8:42 PM
 */
include_once('base.php');
Class Group_Notifications extends Base
{
    /**
     * @var User_Model
     */
    public $userModel;

    /**
     * @var Feed_Model
     */
    public $feedModel;

    public $statusModel;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_Model', 'userModel');
        $this->load->model('Feed_Model', 'feedModel');
    }

    public function index()
    {
        $feeds = $this->feedModel->getNewFeeds();
        foreach ($feeds as $key => &$feed) {
            switch ($feed['reference_type']) {
                case Feed_Model::REFERENCE_TYPE_NOTIFICATION:
                    $notification = $this->userModel->findById($feed['reference_id']);
                    $feed['html'] = $this->renderGroupNotification($feed['reference_id']);
                    $feed['html'] = $this->render('/user/group/group_notification', array(
                        'notification' => $notification,
                        'postDate' => $notification['created_time'],
                        'referenceType' => Feed_Model::REFERENCE_TYPE_NOTIFICATION,
                        'allowComment' => true
                    ));
                    break;
            }
        }

        $groupId = $this->input->get('groupId');
        $group = $this->userModel->getGroupByGroupId($groupId);
        $usersInGroup = $this->userModel->getUsersInGroupByGroupID($groupId);
        $this->renderSocialView('user/group/view', array(
            'feeds' => $feeds,
            'group' => $group,
            'usersInGroup' => $usersInGroup
        ), true);
    }

    public function handlePostGroupNotification()
    {
        $notification = trim($this->input->post('txtGroupNotification'));
        $userId = get_current_user_id();
        $response = array(
            'success'   => false,
            'result'    => ''
        );
        if ($userId === 0) {
            $response['result'] = 'Please login first';
        }

        if (empty($notification)) {
            $response['result'] = 'Please input notification';
        }

        if (empty($response['result'])) {
            $notificationId = $this->userModel->addGroupNotification($userId, $notification);
            if ($notificationId !== false) {
                $response['success'] = true;
                $response['result'] = $this->renderGroupNotification($notificationId);
            } else {
                $response['result'] = 'Can not post status. Please try again.';
            }
        }
        return $response;
    }

    private function renderGroupNotification($notificationId)
    {
        $notification = $this->userModel->findById($notificationId);
        if ($notification !== false && is_array($notification)) {
            return $this->render('/user/group/group_notification', array(
                'notification'        => $notification,
                'postDate'      => $notification['created_time'],
                'referenceType' => Feed_Model::REFERENCE_TYPE_NOTIFICATION,
                'allowComment'  => true
            ));
        } else {
            return '';
        }

    }
}