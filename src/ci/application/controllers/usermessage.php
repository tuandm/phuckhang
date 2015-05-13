<?php
/**
 * User Message Controller for social network
 * @author Phat Nguyen
 * @package LandBook
 * Created by PhpStorm.
 * Date: 4/18/2015
 * Time: 11:19 PM
 */
define("LOGO_SRC", "/wp-content/themes/phuckhang/images/logo.png");
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once('base.php');
class Usermessage extends Base
{

    /**
     * @var Message_Model
     */
    public $messageModel;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('date');
        $this->load->model('Message_Model', 'messageModel');
        $this->load->model('userprofile/User_Profile_Model', 'userProfileModel');
    }

    /**
     *
     */
    public function index()
    {
        $this->renderSocialView('usermessage/user_message_list', array('data' => ''), true);
    }

    /**
     * Handle send message
     * @return array
     */
    public function handleSendMessage()
    {
        $message = trim($this->input->post('txtUserMessage'));
        $sendMessageUserId = get_current_user_id();
        $receivedMessageUserId = (int) $this->input->post('receiverId');
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
            $response['result'] = 'Please input comment';
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
                $response['result'] = $this->render('/layout/partial/social_sidebar', array('data' => ''));
            } else {
                $response['result'] = 'Can not send. Please try again.';
            }
        }
        return $response;
    }
    /**
     * Handle like
     * @return array
     */
    public function handleLikeComment()
    {
        $postId = (int) $this->input->post('postId');
        $type = $this->input->post('type');
        $userId = get_current_user_id();
        $response = array(
            'success'   => false,
            'result'    => ''
        );
        if ($userId === 0) {
            $response['result'] = 'Please login first';
        }

        if (empty($postId)) {
            $response['result'] = 'Invalid post';
        }

        if (empty($response['result'])) {
            $likeData = array(
                'referenceId'      => $postId,
                'referenceType'    => $type,
                'userId'           => $userId,
            );
            $newLikeId = $this->likeModel->like($likeData);
            $numLike = $this->likeModel->countLike($postId);
            $isLiked = $this->likeModel->isLiked($userId, $postId);
            if ($type == 'post') {
                $postDate = get_post($postId)->post_date;
                $sharedImage = $this->getSharedImage($postId);
            } else {
                $sharedImage = '';
                $status = $this->statusModel->findById($postId);
                $postDate = $status['created_time'];
            }
            $numUsersLike = $this->likeModel->getNumUsersLikeByLikeId($postId);
            $likeImage = $isLiked ? 'down' : 'up';
            $state  = $isLiked ? 'Unlike' : 'Like';
            if ($newLikeId !== false) {
                $response['success'] = true;
                $response['result'] = $this->render('homepage/user_like', array(
                    'postId'           => $postId,
                    'sharedImage'      => $sharedImage,
                    'referenceType'    => $type,
                    'userId'           => $userId,
                    'numLike'          => $numLike,
                    'numUsersLike'     => $numUsersLike,
                    'likeImage'        => $likeImage,
                    'state'            => $state,
                    'postDate'         => $postDate
                ));
            } else {
                $response['result'] = "Can not like $type. Please try again.";
            }
        }
        return $response;
    }

    /**
     * @param $postId
     * @return string
     */
    public function getSharedImage($postId)
    {
        $image = array();
        if (get_post($postId)->post_type == 'post') {
            $content = get_post($postId)->post_content;
            $count = substr_count($content, '<img');
            $start = 0;
            for($i=1 ; $i <= $count ; $i++) {
                $imgBeg = strpos($content, '<img', $start);
                $post = substr($content, $imgBeg);
                $imgEnd = strpos($post, '>');
                $postOutput = substr($post, 0, $imgEnd);
                $postOutput = preg_replace('/width="([0-9]*)" height="([0-9]*)"/', '', $postOutput);

                $image[$i] = $postOutput;
                $start=$imgEnd+1;
            }
            if (empty($image)) {
                return $sharedImage = '<img src=' . LOGO_SRC . '></img>';
            } else {
                if (stristr($image[1], '<img')) {
                    return $sharedImage = $image[1];
                }
            }
        } else {
            return;
        }
    }

}
