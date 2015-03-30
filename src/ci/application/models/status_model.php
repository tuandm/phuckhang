<?php
/**
 * Created by PhpStorm.
 * @author Tuan Duong <duongthaso@gmail.com>
 * @package
 */
 

class Status_Model extends Land_Book_Model
{
    /**
     * @var
     */
    protected $tableName = 'pk_sc_user_status';

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
        $result = $this->db->insert($this->tableName, array(
            'status'        => $status,
            'user_id'       => $userId,
            'created_time'  => $now,
            'updated_time'  => $now,
        ));

        if ($result) {
            $statusId = $this->db->insert_id();
            $feedModel = new Feed_Model();
            $feedResult = $feedModel->insert($userId, $statusId, Feed_Model::REFERENCE_TYPE_STATUS);
            if ($feedResult == false) {
                $this->rollbackTransaction();
                return false;
            }
        }
        $this->commitTransaction();
        return $statusId;
    }

    /**
     * Get status by status id
     *
     * @param int $statusId
     * @return array|bool
     */
    public function findById($statusId)
    {
        $rows = $this->db->select()
            ->from($this->tableName)
            ->where('status_id', $statusId)
            ->get()
            ->result_array();
        if (empty($rows)) {
            return false;
        } else {
            return $rows[0];
        }
    }
}
