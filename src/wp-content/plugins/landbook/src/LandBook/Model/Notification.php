<?php

/**
 * Notification Model for admin
 * @author Duc Duong <duongthienduc@gmail.com>
 * @package LandBook
 */
class LandBook_Model_Notification extends LandBook_Model
{
    const TYPE_STATUS_COMMENT = 'status_comment';
    const TYPE_USER_PHOTO = 'user_photo';
    const TYPE_USER_STATUS = 'user_status';
    const TYPE_GROUP_STATUS = 'add_group_status';
    const TYPE_LIKE_COMMENT = 'like_comment';
    const TYPE_LIKE_PHOTO = 'like_photo';
    const TYPE_LIKE_POST = 'like_post';
    const TYPE_LIKE_STATUS = 'like_status';
    const TYPE_COMMENT = 'comment';

    const STATUS_UNREAD = 0;
    const STATUS_READ = 1;

    /**
     * Create corresponding notifications of an activity
     *
     * @param int $activityId
     * @return int|false
     */
    public function createNotificationsOfActivity($activityId)
    {
        $activity = $this->getRow("SELECT * FROM pk_sc_user_activities WHERE sc_user_activity_id = %d", $activityId);
        $objectId = $activity->object_id;
        $userId = $activity->user_id;

        switch ($activity->type) {
            case LandBook_Model_Activity::TYPE_ADD_STATUS_COMMENT:
                $result = $this->createAddStatusCommentNotifications($userId, $objectId);
                break;

            case LandBook_Model_Activity::TYPE_ADD_USER_PHOTO:
                $result = $this->createAddPhotoNotifications($userId, $objectId);
                break;

            case LandBook_Model_Activity::TYPE_ADD_USER_STATUS:
                $result = $this->createAddUserStatusNotifications($userId, $objectId);
                break;

            case LandBook_Model_Activity::TYPE_ADD_GROUP_STATUS:
                $result = $this->createAddUserStatusNotifications($userId, $objectId);
                break;

            case LandBook_Model_Activity::TYPE_LIKE_COMMENT:
                $result = $this->createAddUserStatusNotifications($userId, $objectId);
                break;

            default:
                $result = false;
        }

        return $result;
    }

    /**
     * Create notifications of the activity that user adds comment to a status
     *
     * @param int $userId
     * @param int $objectId
     * @return int|false
     */
    protected function createAddStatusCommentNotifications($userId, $objectId)
    {
        $status = $this->getRow(
            'SELECT scus.user_id FROM pk_sc_user_status scus INNER JOIN pk_comments WHERE comment_ID = %d', $objectId);
        if ($status == null) {
            die('Invalid status');
        }

        $currentUserName = get_the_author_meta('display_name', $userId);
        $userProfileUrl = $this->buildNotiUserProfileUrl($status->user_id, self::TYPE_STATUS_COMMENT, array('status_id' => $objectId));
        $notiText = sprintf('<a href="%s"><span class="author">%s</span> bình luận về trạng thái của bạn</a>', $userProfileUrl, $currentUserName);
        return $this->createNotification(
            $userId,
            array(
                'user_id'               => $status->user_id,
                'notification_type'     => self::TYPE_STATUS_COMMENT,
                'reference_id'          => $objectId,
                'notification_text'     => $notiText,
            )
        );
    }

    /**
     * Create notifications of the activity that user add a photo
     *
     * @param int $userId
     * @param int $objectId
     * @return int|false
     */
    protected function createAddPhotoNotifications($userId, $objectId)
    {
        $photo = $this->getRow('SELECT * FROM pk_sc_user_photos WHERE sc_user_photo_id = %d', $objectId);
        if ($photo == null) {
            die('Invalid photo');
        }
        $currentUserName = get_the_author_meta('display_name', $userId);
        $userProfileUrl = $this->buildNotiUserProfileUrl($userId, self::TYPE_USER_PHOTO, array('photo_id' => $objectId));
        $notiText = sprintf('<a href="%s"><span class="author">%s</span> thêm một ảnh mới</a>', $userProfileUrl, $currentUserName);

        $friends = $this->getResults(
            'SELECT user_id, friend_id FROM pk_sc_user_friends WHERE user_id = %d OR friend_id = %d',
            [$objectId, $objectId]);
        if (empty($friends)) {
            return false;
        }

        foreach ($friends as $friend) {
            $friendId = ($friend->user_id == $userId) ? $friend->friend_id : $friend->user_id;
            $this->createNotification(
                $userId,
                array(
                    'user_id'               => $friendId,
                    'notification_type'     => self::TYPE_USER_PHOTO,
                    'reference_id'          => $objectId,
                    'notification_text'     => $notiText,
                )
            );
        }

        return true;
    }

    /**
     * Create notifications of the activity that user add status to another user
     *
     * @param int $userId
     * @param int $objectId
     * @return int|false
     */
    protected function createAddUserStatusNotifications($userId, $objectId)
    {
        $status = $this->getRow('SELECT * FROM pk_sc_user_status WHERE status_id = %d', $objectId);
        if ($status == null) {
            wp_die('Invalid Status');
        }

        // Skip the creation if user it not the status's author
        if ($status->user_id != $userId) {
            return;
        }

        $currentUserName = get_the_author_meta('display_name', $userId);
        $userProfileUrl = $this->buildNotiUserProfileUrl($userId, self::TYPE_USER_STATUS, array('photo_id' => $objectId));

        $notiText = sprintf('<a href="%s"><span class="author">%s</span> đã đăng trên dòng thời gian</a>', $userProfileUrl, $currentUserName);
        return $this->createNotification(
            $userId,
            array(
                'user_id'               => $status->reference_id,
                'notification_type'     => self::TYPE_USER_STATUS,
                'reference_id'          => $objectId,
                'notification_text'     => $notiText,
            )
        );
    }

    /**
     * Create notifications of the activity that user add status to a group
     *
     * @param int $userId
     * @param int $objectId
     * @return int|false
     */
    protected function createAddGroupStatusNotifications($userId, $objectId)
    {
        $status = $this->getRow('SELECT * FROM pk_sc_user_status WHERE status_id = %d', $objectId);
        if ($status == null) {
            wp_die('Invalid Status');
        }

        $currentUserName = get_the_author_meta('display_name', $userId);
        $userProfileUrl = $this->buildNotiUserProfileUrl($userId, self::TYPE_USER_STATUS, array('photo_id' => $objectId));

        $notiText = sprintf('<a href="%s"><span class="author">%s</span> đã đăng trên dòng thời gian</a>', $userProfileUrl, $currentUserName);
        return $this->createNotification(
            $userId,
            array(
                'user_id'               => $status->reference_id,
                'notification_type'     => self::TYPE_USER_STATUS,
                'reference_id'          => $objectId,
                'notification_text'     => $notiText,
            )
        );
    }

    /**
     * Create the notification in the DB
     *
     * @param int $fromUserId ID of the notification's producer
     * @param array $data Basic data of the notification
     * @return false|int
     */
    protected function createNotification($fromUserId, $data)
    {
        $data['from_user_id'] = $fromUserId;
        $data['notification_status'] = self::STATUS_UNREAD;
        $data['created_date'] = LandBook_Util::now();
        return $this->insert('pk_sc_user_notification', $data);
    }

    /**
     * Build the user's profile URL that the notification points to
     * @param int $userId
     * @param string $notiType
     * @param array|null $additionalParams
     * @return string
     */
    protected function buildNotiUserProfileUrl($userId, $notiType, $additionalParams = null)
    {
        $params = array(
            'ref'       => 'noti',
            'noti_t'    => $notiType
        );

        if (!empty($additionalParams)) {
            $params = array_merge($params, $additionalParams);
        }

        return LandBook_Util_Url::buildUserProfileUrl($userId, $params);
    }

    /**
     * Build the user's profile URL that the notification points to
     * @param int $groupId
     * @param string $notiType
     * @param array|null $additionalParams
     * @return string
     */
    protected function buildNotiGroupUrl($groupId, $notiType, $additionalParams = null)
    {
        $params = array(
            'ref'       => 'noti',
            'noti_t'    => $notiType
        );

        if (!empty($additionalParams)) {
            $params = array_merge($additionalParams);
        }

        return LandBook_Util_Url::buildGroupProfileUrl($groupId, $params);
    }

}
