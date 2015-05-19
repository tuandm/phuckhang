<?php

/**
 * Notification Model for admin
 * @author Duc Duong <duongthienduc@gmail.com>
 * @package LandBook
 */
class LandBook_Model_Notification extends LandBook_Model
{
    /**
     * @var User_Model
     */
    public $userModel;
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
            case LandBook_Constant::TYPE_ADD_STATUS_COMMENT:
                $result = $this->createAddStatusCommentNotifications($userId, $objectId);
                break;

            case LandBook_Constant::TYPE_ADD_USER_PHOTO:
                $result = $this->createAddPhotoNotifications($userId, $objectId);
                break;

            case LandBook_Constant::TYPE_ADD_USER_STATUS:
                $result = $this->createAddUserStatusNotifications($userId, $objectId);
                break;

            case LandBook_Constant::TYPE_ADD_GROUP_STATUS:
                $result = $this->createAddGroupStatusNotifications($userId, $objectId);
                break;

            case LandBook_Constant::TYPE_LIKE_STATUS:
                $result = $this->createAddUserLikeStatusNotifications($userId, $objectId);
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
            'SELECT scus.user_id, scus.status_id FROM pk_sc_user_status scus INNER JOIN pk_comments com ON scus.status_id = com.comment_post_ID WHERE comment_ID = %d', $objectId);
        if ($status == null) {
            die('Invalid status');
        }
        $listUserIds = array();
        $commentedUserIds = $this->getResults('SELECT DISTINCT user_id FROM pk_comments WHERE comment_post_ID = %d AND comment_type = %s', [$status->status_id, 'user_status']);
        if ($commentedUserIds == null) {
            $listUserIds[] = $status->user_id;
        }

        foreach ($commentedUserIds as $commentedUserId) {
            if ($commentedUserId->user_id == get_current_user_id()) {
                continue;
            }
            $listUserIds[] = $commentedUserId->user_id;
        }

        if (!in_array($status->user_id, $listUserIds)) {
            $listUserIds = array_merge($listUserIds, array($status->user_id));
        }

        $currentUserName = get_the_author_meta('display_name', $userId);
        $userProfileUrl = $this->buildNotiUserProfileUrl($status->user_id, LandBook_Constant::TYPE_STATUS_COMMENT, array('comment_id' => $objectId));
        foreach ($listUserIds as $listUserId) {
            if ($listUserId == $status->user_id) {
                $notiText = sprintf('<a href="%s"><span class="author">%s</span> bình luận về trạng thái của bạn.</a>', $userProfileUrl, $currentUserName);
            } else {
                $notiText = sprintf('<a href="%s"><span class="author">%s</span> bình luận về trạng thái mà bạn được đánh dấu.</a>', $userProfileUrl, $currentUserName);
            }
            $this->createNotification(
            $userId,
                array(
                    'user_id'               => $listUserId,
                    'notification_type'     => LandBook_Constant::TYPE_USER_PHOTO,
                    'reference_id'          => $objectId,
                    'notification_text'     => $notiText,
                )
            );
        }

        return true;
    }

    /**
     * Create notifications of the activity that user add a photo
     *
     * @param int $objectId
     * @param int $userId
     * @return bool
     */
    protected function createAddPhotoNotifications($userId, $objectId)
    {
        $photo = $this->getRow('SELECT * FROM pk_sc_user_photos WHERE sc_user_photo_id = %d', $objectId);
        if ($photo == null) {
            die('Invalid photo');
        }

        $currentUserName = get_the_author_meta('display_name', $userId);
        $userPhotoUrl = $this->buildNotiUserPhotoUrl($photo->user_id, LandBook_Constant::TYPE_USER_PHOTO, array('photo_id' => $objectId));
        $notiText = sprintf('<a href="%s"><span class="author">%s</span> thêm một ảnh mới</a>', $userPhotoUrl, $currentUserName);

        $friendListIds = $this->getFriendListByUserId($userId);
        if (empty($friends)) {
            return false;
        }

        foreach ($friendListIds as $friendListId) {
            $this->createNotification(
                $photo->user_id,
                array(
                    'user_id'               => $friendListId,
                    'notification_type'     => LandBook_Constant::TYPE_USER_PHOTO,
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
     * @return bool
     */
    protected function createAddUserStatusNotifications($userId, $objectId)
    {
        $status = $this->getRow('SELECT * FROM pk_sc_user_status WHERE status_id = %d', $objectId);

        if ($status == null) {
            wp_die('Invalid Status');
        }

        // Skip the creation if user is not the status's author
        if ($status->user_id != $userId) {
            return;
        }
        $friendListIds = $this->getFriendListByUserId($userId);
        if (!$friendListIds) {
            return false;
        }
        $currentUserName = get_the_author_meta('display_name', $userId);
        $statusUrl = $this->buildNotiUserWallUrl($status->status_id, LandBook_Constant::TYPE_USER_STATUS, array('status_id' => $objectId));
        $notiText = sprintf('<a href="%s"><span class="author">%s</span> đã đăng trên dòng thời gian</a>', $statusUrl, $currentUserName);
        foreach ($friendListIds as $friendListId) {
            $this->createNotification(
                $userId,
                array(
                    'user_id' => $friendListId,
                    'notification_type' => LandBook_Constant::TYPE_USER_STATUS,
                    'reference_id' => $objectId,
                    'notification_text' => $notiText,
                )
            );
        }
        return true;
    }

    /**
     * Create notifications of the activity that user likes status of another user
     *
     * @param int $userId
     * @param int $objectId
     * @return int|false
     */
    protected function createAddUserLikeStatusNotifications($userId, $objectId)
    {
        $like = $this->getRow('SELECT * FROM pk_sc_user_status psus INNER JOIN pk_sc_user_like psul ON psus.status_id=psul.reference_id WHERE psul.reference_id = %d AND psul.reference_type = %s', [$objectId, 'status']);

        if ($like == null) {
            wp_die('Die Invalid like');
        }
        $currentUserName = get_the_author_meta('display_name', $userId);
        $userLikeStatusUrl = $this->buildNotiUserLikeStatusUrl($like->user_id, LandBook_Constant::TYPE_LIKE_STATUS, array('reference_id' => $like->status_id));

        $notiText = sprintf('<a href="%s"><span class="author">%s</span> thích trạng thái của bạn</a>', $userLikeStatusUrl, $currentUserName);
        return $this->createNotification(
            $userId,
            array(
                'user_id'               => $like->user_id,
                'notification_type'     => LandBook_Constant::TYPE_LIKE_STATUS,
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
        $userInGroups= $this->getResults('SELECT sug.user_id FROM pk_sc_user_groups sug WHERE group_id = %d', $status->reference_id);
        if ($status == null) {
            wp_die('Invalid Status');
        }
        foreach ($userInGroups as $userIdInGroup) {
            $currentUserName = get_the_author_meta('display_name', $userId);
            $groupUrl = $this->buildNotiGroupUrl($status->reference_id, LandBook_Constant::TYPE_GROUP_STATUS, array('status_id' => $objectId));

            $notiText = sprintf('<a href="%s"><span class="author">%s</span> đã đăng trên dòng thời gian</a>', $groupUrl, $currentUserName);
            $notificationId = $this->createNotification(
                $userId,
                array(
                    'user_id'               => $userIdInGroup->user_id,
                    'notification_type'     => LandBook_Constant::TYPE_GROUP_STATUS,
                    'reference_id'          => $objectId,
                    'notification_text'     => $notiText,
                )
            );
            if (!$notificationId) {
                return;
            }
        }
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
        $data['notification_status'] = LandBook_Constant::STATUS_UNREAD;
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
     * Build the user's wall URL that the notification points to
     * @param int $userId
     * @param string $notiType
     * @param array|null $additionalParams
     * @return string
     */
    protected function buildNotiUserWallUrl($userId, $notiType, $additionalParams = null)
    {
        $params = array(
            'ref'       => 'noti',
            'noti_t'    => $notiType
        );

        if (!empty($additionalParams)) {
            $params = array_merge($params, $additionalParams);
        }

        return LandBook_Util_Url::buildUserWallUrl($userId, $params);
    }

    /**
     * Build User photo URL that notification points to
     *
     * @param int $userId
     * @param string $notiType
     * @param array|null $additionalParams
     * @return string
     */
    protected function buildNotiUserPhotoUrl($userId, $notiType, $additionalParams = null)
    {
        $params = array(
            'ref'       => 'noti',
            'noti_t'    => $notiType
        );

        if (!empty($additionalParams)) {
            $params = array_merge($params, $additionalParams);
        }

        return LandBook_Util_Url::buildUserPhotoUrl($userId, $params);
    }

    /**
     * Build the user's status URL that the notification points to
     *
     * @param int $statusId
     * @param string $notiType
     * @param array|null $additionalParams
     * @return string
     */
    protected function buildNotiUserStatusUrl($statusId, $notiType, $additionalParams = null)
    {
        $params = array(
            'ref'       => 'noti',
            'noti_t'    => $notiType
        );

        if (!empty($additionalParams)) {
            $params = array_merge($params, $additionalParams);
        }

        return LandBook_Util_Url::buildUserStatusUrl($statusId, $params);
    }

    /**
     * Build url for user likes status notification.
     *
     * @param $statusId int
     * @param $notiType string
     * @param array|null $additionParams
     * @return string
     */
    protected function buildNotiUserLikeStatusUrl($statusId, $notiType, $additionParams = null)
    {
        $params = array(
            'ref'   => 'noti',
            'noti_t'    => $notiType
        );
        if (!empty($additionParams)) {
            $params = array_merge($params, $additionParams);
        }
        return LandBook_Util_Url::buildUserWallUrl($statusId, $params);
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

    /**
     * Get all user 's friend list.
     *
     * @param int $userId
     * @return array|false
     */
    protected function getFriendListByUserId($userId)
    {
        $friendListIds = array();
        $results = $this->getResults('SELECT * FROM pk_sc_user_friends WHERE user_id = %d OR friend_id = %d', [$userId, $userId]);
        if (is_null($results)) {
            return false;
        }
        foreach ($results as $result) {
            if ($result->user_id == $userId) {
                $friendListIds[] = $result->friend_id;
            } else {
                $friendListIds[] = $result->user_id;
            }
        }
        $friendListIds = array_unique($friendListIds);
        return $friendListIds;
    }
    
}
