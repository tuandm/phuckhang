<?php
/**
 * Message Model
 * Created by PhpStorm.
 * @author  PN
 * @package LandBook
 * Date: 4/20/2015
 * Time: 11:33 PM
 */

require_once('land_book_model.php');
class Message_Model extends Land_Book_Model
{

    /**
     * @var string
     */
    protected $tableName = 'pk_sc_user_messages';

    /**
     * Get newest messages for displaying to the message list page
     *
     * @return array|bool
     */
    public function getNewMessages()
    {
        $messages= $this->db
            ->select()
            ->from($this->tableName)
            ->order_by('create_date', 'DESC')
            ->limit(10)
            ->get()
            ->result_array();
        return $messages;
    }

    /**
     * Insert to message table when new message is sent
     *
     * @param array $data
     * @return false|int
     */
    public function insert($data)
    {
        return $this->db->insert(
            $this->tableName,
            array(
                'sender_id'             => $data['sender_id'],
                'sender_name'           => $data['sender_name'],
                'receiver_id'           => $data['receiver_id'],
                'receiver_name'         => $data['receiver_name'],
                'message'               => $data['message'],
                'is_deleted'            => 0,
                'status'                => 0,
                'created_date'          => LandBook_Util::now()
           ));
    }
}
