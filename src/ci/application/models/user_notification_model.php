<?php
/**
 * Model class that helps manage notifications
 *
 * @author Duc Duong <duongthienduc@gmail.com>
 * @package Landbook
 */

require_once('land_book_model.php');

class User_Notification_Model extends Land_Book_Model
{

    /**
     * @var string
     */
    protected $tableName = 'pk_sc_user_notification';

    /**
     * Find latest notifications of a user.
     *
     * @param int $userId
     * @param int $page
     * @param int $numItems
     * @return array
     */
    public function findUserNotifications($userId, $page = 1, $numItems)
    {
        if (!isset($page) || $page < 1) {
            $page = 1;
        }
        $notifications = $this->db
            ->where(array('user_id' => $userId))
            ->order_by('created_date', 'DESC')
            ->limit($numItems, ($page - 1) * $numItems)
            ->get($this->tableName)
            ->result();
        return $notifications;
    }

    /**
     * Count the number of notifications of a user.
     *
     * @param int $userId
     * @return int
     */
    public function countUserNotifications($userId)
    {
        return $this->db
            ->from($this->tableName)
            ->where(array('user_id' => $userId))
            ->count_all_results();
    }

}
