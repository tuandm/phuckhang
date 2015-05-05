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
    public function createActivity($data)
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
     * Create Activities of the action that user adds comment to a status
     *
     * @param int $objectId
     * @return int|false
     */
    public function createAddCommentStatusActivity($objectId)
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
                'type' => LandBook_Constant::TYPE_ADD_STATUS_COMMENT,
                'object_id' => $objectId,
                'user_id'   => $comment->user_id
            )
        );
    }
}
