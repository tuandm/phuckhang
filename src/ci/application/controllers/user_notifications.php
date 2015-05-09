<?php
/**
 * Author: Duc Duong
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once('base.php');

class User_Notifications extends Base
{
    /**
     * @var User_Notification_Model
     */
    public $userNotificationModel;

    /**
     * @var Date_Util
     */
    public $dateUtil;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_Notification_Model', 'userNotificationModel');
    }

    /**
     * Default action handler of User Notifications controller
     */
    public function index()
    {
        if (get_current_user_id() == 0) {
            wp_redirect(wp_login_url(get_permalink()));
            exit();
        }
        $this->load->library('date_util', '', 'dateUtil');
        $page = $this->input->get('page');
        $notifications = $this->userNotificationModel->findUserNotifications(get_current_user_id(), $page, NUM_NOTIFICATIONS);
        $timeToNotificationMap = array();
        foreach ($notifications as $notification) {
            $fromUserId = $notification->from_user_id;
            $notification->fromUserProfileUrl = LandBook_Util_Url::buildUserProfileUrl($fromUserId);
            $notification->fromUserAvatarHtml = get_avatar($fromUserId, USER_NOTIFICATION_AVATAR_SIZE);
            $notification->timeLabel = $this->dateUtil->getTimeElapsedString($notification->created_date);

            $dateLabel = $this->dateUtil->getDateAsString($notification->created_date);
            if (!isset($timeToNotificationMap[$dateLabel])) {
                $timeToNotificationMap[$dateLabel] = array();
            }
            $timeToNotificationMap[$dateLabel][] = $notification;
        }

        $numNotifications = $this->userNotificationModel->countUserNotifications(get_current_user_id());
        $numPages = ceil($numNotifications  / NUM_NOTIFICATIONS);

        $this->renderSocialView('user/notification/view', array(
            'timeToNotificationMap' => $timeToNotificationMap,
            'numPages' => $numPages,
            'currentPage' => $page
        ), true);
    }

}
