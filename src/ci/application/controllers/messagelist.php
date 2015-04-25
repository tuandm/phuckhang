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
class Messagelist extends Base
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
     *
     */
    public function index()
    {
        $userId = get_current_user_id();
        $data['userId'] = $userId;
        $data['unreadMessages'] = $this->messageModel->getUnreadMessages($userId);
        $data['title'] = $this->userModel->getTitleByUserId($userId);
        $data['group'] = $this->userModel->getAllUserGroups($userId)['numGroups'];
        $data['friend'] = $this->userModel->getFriendsByUserId($userId)['numFriend'];
        $data['name']   = get_user_by('id', $userId)->user_nicename;
        $data['messages'] = $this->messageModel->getNewMessages($userId);
        $this->renderSocialView('message/user_message_list', array(
            'data' => $data
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
