<?php
/**
 * Homepage Controller for social network
 * @author Tuan Duong <duongthaso@gmail.com>
 * @package LandBook
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once('base.php');
class Homepage extends Base
{
    /**
     * @var Feed_Model
     */
    public $feedModel;

    /**
     * @var Status_Model
     */
    public $statusModel;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Feed_Model', 'feedModel');
        $this->load->model('Status_Model', 'statusModel');
    }

    public function index()
    {
        $feeds = $this->feedModel->getNewFeeds();
        foreach ($feeds as $key => &$feed) {
            switch ($feed['reference_type']) {
                case Feed_Model::REFERENCE_TYPE_STATUS:
                    $feed['html'] = $this->renderUserStatus($feed['reference_id']);
                    break;
                case Feed_Model::REFERENCE_TYPE_POST:
                    $post = get_post($feed['reference_id']);
                    $comments = get_comments('number=5&order=ASC&orderBy=comment_date&status=approve&post_id=' . $post->ID);
                    $feed['html'] = $this->render('/homepage/feed_post', array(
                        'post'      => $post,
                        'comments'  => $comments,
                        'allowComment'  => true,
                    ));
                    break;
                default;
                    break;
            }
        }
        $this->load->view('layout/layout', array(
            'content' => $this->render('homepage/index', array('feeds' => $feeds)),
        ));
    }

    /**
     * Return status block
     *
     * @param $statusId
     * @return string
     */
    private function renderUserStatus($statusId)
    {
        $status = $this->statusModel->findById($statusId);
        if ($status !== false && is_array($status)) {
            return $this->render('/homepage/feed_status', array('status' => $status));
        } else {
            return '';
        }

    }
    
    /**
     * Handle status posting
     */
    public function handlePostStatus()
    {
        $status = trim($this->input->post('txtUserStatus'));
        $userId = get_current_user_id();
        $response = array(
            'success'   => false,
            'result'    => ''
        );
        if ($userId === 0) {
            $response['result'] = 'Please login first';
        }

        if (empty($status)) {
            $response['result'] = 'Please input status';
        }

        if (empty($response['result'])) {
            $statusId = $this->statusModel->addUserStatus($userId, $status);
            if ($statusId !== false) {
                $response['success'] = true;
                $response['result'] = $this->render('/homepage/feed_status', array('status' => $this->statusModel->findById($statusId)));
            } else {
                $response['result'] = 'Can not post status. Please try again.';
            }
        }
        return $response;
    }

    public function handlePostComment()
    {
        $comment = trim($this->input->post('txtUserComment'));
        $postId = (int) $this->input->post('postId');
        $userId = get_current_user_id();
        $response = array(
            'success'   => false,
            'result'    => ''
        );
        if ($userId === 0) {
            $response['result'] = 'Please login first';
        }

        if (empty($comment)) {
            $response['result'] = 'Please input comment';
        }

        if (empty($postId)) {
            $response['result'] = 'Invalid post';
        }

        if (empty($response['result'])) {
            $currentUser = wp_get_current_user();
            $commentData = array(
                'comment_post_ID'       => $postId,
                'comment_author'        => $currentUser->display_name,
                'comment_author_email'  => $currentUser->user_email,
                'comment_content' => $comment,
                'comment_type' => '',
                'comment_parent' => 0,
                'user_id' => $currentUser->ID,
                'comment_author_IP' => $this->input->ip_address(),
                'comment_agent' => $this->input->user_agent(),
                'comment_date' => date('Y-m-d H:i:s'),
                'comment_approved' => 1,
            );
            $newCommentId = wp_insert_comment($commentData);
            if ($newCommentId !== false) {
                $response['success'] = true;
                $response['result'] = $this->render('/layout/partial/comment', array('comment' => get_comment($newCommentId)));
            } else {
                $response['result'] = 'Can not post comment. Please try again.';
            }
        }
        return $response;
    }
}
