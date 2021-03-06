<?php
/**
 * LandBook general constant
 * Created by PhpStorm.
 * @author: PN
 * Date: 5/5/2015
 * Time: 12:23 AM
 */
class LandBook_Constant
{
    /**
     * These are the constants for Activity model
     */
    const TYPE_ADD_STATUS_COMMENT = 'add_status_comment';
    const TYPE_ADD_USER_PHOTO = 'add_user_photo';
    const TYPE_ADD_USER_STATUS = 'add_user_status';
    const TYPE_ADD_GROUP_STATUS = 'add_group_status';
    const TYPE_LIKE_COMMENT = 'like_comment';
    const TYPE_LIKE_PHOTO = 'like_photo';
    const TYPE_LIKE_POST = 'like_post';
    const TYPE_LIKE_STATUS = 'like_status';
    const TYPE_COMMENT = 'comment';

    /**
     * These are the constants for Notification model
     */
    const TYPE_STATUS_COMMENT = 'status_comment';
    const TYPE_USER_PHOTO = 'user_photo';
    const TYPE_USER_STATUS = 'user_status';
    const TYPE_GROUP_STATUS = 'add_group_status';

    const STATUS_UNREAD = 0;
    const STATUS_READ = 1;

}
