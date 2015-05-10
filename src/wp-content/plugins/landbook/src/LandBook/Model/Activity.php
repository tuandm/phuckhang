<?php

/**
 * Active Model for admin
 * @author Duc Duong <duongthienduc@gmail.com>
 * @package LandBook
 */
class LandBook_Model_Activity extends LandBook_Model
{

    /**
     * Create an activity when user issue an action
     *
     * @param array $data
     * @return int|false
     */
    protected function createActivity($data)
    {
        $activityId = 0;
        $data['activity_date'] = LandBook_Util::now();
        $result = $this->insert('pk_sc_user_activities', $data);
        if ($result) {
            $activityId = $this->getWpdb()->insert_id;
        }
        do_action('save_activity', $activityId);
        return $activityId;
    }

    /**
     * Create Activities when user adds comment to a status
     *
     * @param int $objectId
     * @return int|false
     */
    public function createAddStatusCommentActivity($objectId)
    {
        $comment = $this->getRow(
            'SELECT * FROM pk_comments WHERE comment_ID = %d', $objectId);
        $status = $this->getRow(
            'SELECT scus.user_id FROM pk_sc_user_status scus INNER JOIN pk_comments WHERE comment_ID = %d', $objectId);
        if ($status == null) {
            die('invalid status');
        }

        return $this->createActivity(
            array(
                'user_id'   => $comment->user_id,
                'object_id' => $objectId,
                'type'      => LandBook_Constant::TYPE_ADD_STATUS_COMMENT
            )
        );
    }

    /**
     * Create Activities when user adds status
     *
     * @param int $objectId
     * @return false|int
     */
    public function createAddUserStatusActivity($objectId)
    {
        $status = $this->getRow('SELECT * FROM pk_sc_user_status WHERE status_id = %d', $objectId);
        if ($status == null) {
            wp_die('Invalid Status');
        }

        return $this->createActivity(
            array(
                'user_id'            => $status->user_id,
                'object_id'          => $objectId,
                'type'               => LandBook_Constant::TYPE_ADD_USER_STATUS
            )
        );
    }

    /**
     * Create Activities when user adds status of a group
     *
     * @param int $objectId
     * @return false|int
     */
    public function createAddGroupStatusActivity($objectId)
    {
        $status = $this->getRow('SELECT * FROM pk_sc_user_status WHERE status_id = %d', $objectId);
        if ($status == null) {
            wp_die('Invalid Status');
        }

        return $this->createActivity(
            array(
                'user_id'            => $status->user_id,
                'object_id'          => $objectId,
                'type'               => LandBook_Constant::TYPE_ADD_GROUP_STATUS
            )
        );
    }

    /**
     * Create Activities when user likes a status
     *
     * @param int $objectId
     */
    public function createAddUserLikeStatusActivity($objectId)
    {
        //TODO
    }
}
