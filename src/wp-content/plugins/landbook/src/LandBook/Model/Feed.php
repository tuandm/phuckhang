<?php
/**
 * Feed Model for admin
 * @author Tuan Duong <duongthaso@gmail.com>
 * @package LandBook
 */
 

class LandBook_Model_Feed extends LandBook_Model
{
    const REFERENCE_TYPE_POST    = 'post';
    const REFERENCE_TYPE_STATUS  = 'status';
    const REFERENCE_TYPE_COMMENT = 'comment';

    /**
     * Insert to feed table when new post is posted
     *
     * @param $userId
     * @param $postId
     * @return false|int
     */
    public function insertFeedAfterPublishPost($userId, $postId)
    {
        return $this->getWpdb()->insert(
            'pk_sc_user_feed',
            array(
                'user_id'           => $userId,
                'reference_id'      => $postId,
                'reference_type'    => static::REFERENCE_TYPE_POST,
                'created_date'      => LandBook_Util::now()
            )
        );
    }
}
