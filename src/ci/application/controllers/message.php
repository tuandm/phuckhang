<?php
/**
 * User Message Controller for social network
 * @author Phat Nguyen
 * @package LandBook
 * Created by PhpStorm.
 * Date: 4/18/2015
 * Time: 11:19 PM
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once('base.php');
class Message extends Base
{

    /**
     * @var Message_Model
     */
    public $messageModel;

    /**
     * @var User_Profile_Model
     */
    public $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('date');
        $this->load->model('Message_Model', 'messageModel');
        $this->load->model('userprofile/User_Profile_Model', 'userModel');
    }

    /**
     * Index page of Social User Message Page
     */
    public function index()
    {
        $userId = get_current_user_id();
        $messages = array();
        $data['userId'] = $userId;
        $data['unreadMessages'] = $this->messageModel->getUnreadMessages($userId);
        $receivedArrays = $this->messageModel->getSenderIds($userId);
        foreach ($receivedArrays as $key => $receivedArray) {
            $senderIds[$key] = $receivedArray['sender_id'];
        }

        $data['title'] = $this->userModel->getTitleByUserId($userId);
        $data['group'] = $this->userModel->getAllUserGroups($userId)['numGroups'];
        $data['friend'] = $this->userModel->getFriendsByUserId($userId)['numFriend'];
        $data['name']   = get_user_by('id', $userId)->user_nicename;
        foreach ($senderIds as $senderId) {
            $messages[] = $this->messageModel->getNewMessages($userId, $senderId)[0];
        }

        rsort($messages);
        $data['messages'] = $messages;
        $this->renderSocialView('message/user_message_list', array(
            'data' => $data
        ), true);
    }

    /**
     * List User Message Details
     */
    public function messageDetail()
    {
        $messageId = intval($this->input->get('messageId'));
        $message = $this->messageModel->getMessageById($messageId);
        $userId = get_current_user_id();
        $receiveMessages = $this->messageModel->getMessageBySenderId($message['sender_id'], $userId);
        $messages = $this->messageModel->getAllSendAndReplyMessage($message['sender_id'], $userId);

        $data['title'] = $this->userModel->getTitleByUserId($userId);
        $data['group'] = $this->userModel->getAllUserGroups($userId)['numGroups'];
        $data['friend'] = $this->userModel->getFriendsByUserId($userId)['numFriend'];
        $data['name']   = get_user_by('id', $userId)->user_nicename;
        $data['messages'] = $messages;
        foreach ($receiveMessages as $receiveMessage) {
            if ($receiveMessage['status'] == 0) {
                $this->messageModel->updateMessageStatus($receiveMessage['message_id'], 1);
            }
        }

        $data['unreadMessages'] = $this->messageModel->getUnreadMessages($userId);
        $data['userId'] = $userId;
        $this->renderSocialView('message/user_message_detail', array(
            'data'      => $data,
            'senderId'  => $message['sender_id']
        ), true);
    }

    /**
     * Handle send message
     * @return array
     */
    public function handleSendMessage()
    {
        $message = trim($this->input->post('txtUserMessage'));
        $sendMessageUserId = get_current_user_id();
        $receivedMessageUserId = intval($this->input->post('receiverId'));
        $response = array(
            'success'   => false,
            'result'    => ''
        );
        if ($sendMessageUserId === 0) {
            $response['result'] = 'Please login first';
        }

        if ($sendMessageUserId === $receivedMessageUserId) {
            $response['result'] = 'Can\'t send message for yourself' ;
        }

        if ($receivedMessageUserId === 0) {
            $response['result'] = 'Please go to user\'s profile page that you want to send message';
        }

        if (empty($message)) {
            $response['result'] = 'Please input the message';
        }

        if (empty($response['result'])) {
            $sendUser = wp_get_current_user();
            $receivedUser = get_user_by('id', $receivedMessageUserId);
            $messageData = array(
                'sender_id'             => $sendMessageUserId,
                'sender_name'           => $sendUser->display_name,
                'receiver_id'           => $receivedMessageUserId,
                'receiver_name'         => $receivedUser->user_nicename,
                'message'               => $message,
                'is_deleted'            => 0,
                'status'                => 0,
                'create_date'           => date('Y-m-d H:i:s'),
            );
            $newMessageId = $this->messageModel->insert($messageData);
            if ($newMessageId !== false) {
                $response['success'] = true;
                $response['result'] = 'Send successfully';
            } else {
                $response['result'] = 'Can not send. Please try again.';
            }
        }
        return $response;
    }

}
