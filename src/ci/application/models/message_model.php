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
     * @param int $receiverId
     * @param int $senderId
     * @return array|bool
     */
    public function getNewMessages($receiverId, $senderId)
    {
        $where = array(
            'receiver_id'   => $receiverId,
            'sender_id'     => $senderId
        );
        $messages= $this->db
            ->select()
            ->from($this->tableName)
            ->order_by('created_date', 'DESC')
            ->where($where)
            ->limit(1)
            ->get()
            ->result_array();
        return $messages;
    }

    /**
     * Get message information from message Id
     * @param int $messageId
     * @return array|bool
     */
    public function getMessageById($messageId)
    {
        $where = array('message_id' => $messageId);
        $message = $this->db
            ->select()
            ->from($this->tableName)
            ->where($where)
            ->get()
            ->result_array();
        return $message[0];
    }

    /**
     * Get all senderId by receiverId
     * @param int $receiverId
     * @return array|bool
     */
    public function getSenderIds($receiverId)
    {
        $where = array('receiver_id' => $receiverId);
        $receiveArrays = $this->db
            ->select('sender_id')
            ->from($this->tableName)
            ->where($where)
            ->distinct('sender_id')
            ->get()
            ->result_array();
        return $receiveArrays;
    }

    /**
     * Get all messages from sender Id
     * @param int $senderId
     * @param int $receiverId
     * @return array|bool
     */
    public function getMessageBySenderId($senderId, $receiverId)
    {
        $where = array(
            'sender_id'     => $senderId,
            'receiver_id'   => $receiverId
    );
        $messages = $this->db
            ->select()
            ->from($this->tableName)
            ->where($where)
            ->get()
            ->result_array();
        return $messages;
    }

    /**
     * @param $messageId
     * @param $status
     * @return mixed
     */
    public function updateMessageStatus($messageId, $status)
    {
        $data = array('status' => $status);
        $this->db->where('message_id', $messageId);
        $message = $this->db->update($this->tableName, $data);
        return $message;
    }

    /**
     * Get unread messages for displaying to the count number
     * @param int $userId
     * @return array|bool
     */
    public function getUnreadMessages($userId)
    {
        $where = array(
            'receiver_id' => $userId,
            'status'      => 0
        );
        $messages= $this->db
            ->select()
            ->from($this->tableName)
            ->order_by('created_date', 'DESC')
            ->where($where)
            ->get()
            ->result_array();
        return count($messages);
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

    /**
     * @param $senderId
     * @param $receiverId
     * @return mixed
     */
    public function getAllSendAndReplyMessage($senderId, $receiverId)
    {
        $query = "((sender_id='$senderId' AND receiver_id='$receiverId') OR (sender_id='$receiverId' AND receiver_id='$senderId'))";
        $messages = $this->db
            ->select()
            ->from($this->tableName)
            ->where($query)
            ->order_by('created_date', 'DESC')
            ->get()
            ->result_array();
        return $messages;
    }

}
