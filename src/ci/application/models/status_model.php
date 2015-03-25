<?php
/**
 * Created by PhpStorm.
 * @author Tuan Duong <duongthaso@gmail.com>
 * @package
 */
 

class Status_Model extends Land_Book_Model
{
    /**
     * Add user status and push to feed
     *
     * @param int $userId
     * @param string $status
     * @return bool
     */
    public function addUserStatus($userId, $status)
    {
        $now = date('Y-m-d H:i:s');
        $this->startTransaction();
        $result = $this->db->insert('user_status', array(
            'status'        => $status,
            'user_id'       => $userId,
            'created_time'  => $now,
            'updated_time'  => $now,
        ));

        if ($result) {
            $feedModel = new Feed_Model();
            $feedResult = $feedModel->insert($userId, $this->db->insert_id(), Feed_Model::REFERENCE_TYPE_STATUS);
            if ($feedResult == false) {
                $this->rollbackTransaction();
                return false;
            }
        }
        $this->commitTransaction();
        return true;
    }
}
