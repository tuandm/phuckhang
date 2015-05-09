<?php
/**
 * Homepage Controller for social network
 * @author Tuan Duong <duongthaso@gmail.com>
 * @package LandBook
 */
define("LOGO_SRC", "/wp-content/themes/phuckhang/images/logo.png");
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once('base.php');
class Homepage extends Base
{
    /**
     * @var Feed_Model
     */
    public $feedModel;

    /**
     * @var Like_Model
     */
    public $likeModel;

    /**
     * @var Status_Model
     */
    public $statusModel;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('date');
        $this->load->library('permalink_util');
        $this->load->model('Feed_Model', 'feedModel');
        $this->load->model('Status_Model', 'statusModel');
        $this->load->model('Like_Model', 'likeModel');
    }

    /**
     *
     */
    public function index()
    {
        $feeds = $this->feedModel->getNewFeeds();
        foreach ($feeds as $key => &$feed) {
            switch ($feed['reference_type']) {
                case Feed_Model::REFERENCE_TYPE_STATUS:
                    $status = $this->statusModel->findById($feed['reference_id']);
                    $feed['html'] = $this->renderUserStatus($feed['reference_id']);
                    $numLike = $this->likeModel->countLike($status['status_id']);
                    $numUsersLike = $this->likeModel->getNumUsersLikeByLikeId($status['status_id']);
                    $isLiked = $this->likeModel->isLiked(get_current_user_id(), $status['status_id']);
                    $likeImage = $isLiked ? 'down' : 'up';
                    $state  = $isLiked ? 'Unlike' : 'Like';
                    $comments = get_comments('type=status&number=5&order=DESC&orderBy=comment_date&status=approve&post_id=' . $status['status_id']);
                    $feed['html'] = $this->render('/homepage/feed_status', array(
                        'status'        => $status,
                        'comments'      => $comments,
                        'numLike'       => $numLike,
                        'numUsersLike'  => $numUsersLike,
                        'likeImage'     => $likeImage,
                        'state'         => $state,
                        'postDate'      => $status['created_time'],
                        'referenceType' => Feed_Model::REFERENCE_TYPE_STATUS,
                        'allowComment'  => true
                    ));
                    break;
                case Feed_Model::REFERENCE_TYPE_POST:
                    $post = get_post($feed['reference_id']);
                    $sharedImage = $this->getSharedImage($post->ID);
                    $numLike = $this->likeModel->countLike($post->ID);
                    $numUsersLike = $this->likeModel->getNumUsersLikeByLikeId($post->ID);
                    $isLiked = $this->likeModel->isLiked(get_current_user_id(), $post->ID);
                    $likeImage = $isLiked ? 'down' : 'up';
                    $state  = $isLiked ? 'Unlike' : 'Like';
                    $comments = get_comments('type=post&number=5&order=ASC&orderBy=comment_date&status=approve&post_id=' . $post->ID);
                    $feed['html'] = $this->render('/homepage/feed_post', array(
                        'sharedImage'   => $sharedImage,
                        'post'          => $post,
                        'comments'      => $comments,
                        'likeImage'     => $likeImage,
                        'state'         => $state,
                        'postDate'      => $post->post_date,
                        'numUsersLike'  => $numUsersLike,
                        'numLike'       => $numLike,
                        'referenceType' => Feed_Model::REFERENCE_TYPE_POST,
                        'allowComment'  => true
                    ));
                    break;
                default;
                    break;
            }
        }
        $this->renderSocialView('homepage/index', array('feeds' => $feeds), true);
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
        $isLiked = $this->likeModel->isLiked(get_current_user_id(), $status['status_id']);
        $numUsersLike = $this->likeModel->getNumUsersLikeByLikeId($status['status_id']);
        $likeImage = $isLiked ? 'down' : 'up';
        $state  = $isLiked ? 'Unlike' : 'Like';
        $numLike = $this->likeModel->countLike($status['status_id']);
        if ($status !== false && is_array($status)) {
            return $this->render('/homepage/feed_status', array(
                'isLiked'       => $isLiked,
                'numLike'       => $numLike,
                'likeImage'     => $likeImage,
                'numUsersLike'  => $numUsersLike,
                'state'         => $state,
                'postDate'      => $status['created_time'],
                'status'        => $status,
                'referenceType' => Feed_Model::REFERENCE_TYPE_STATUS,
                'allowComment'  => true
            ));
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
                $response['result'] = $this->renderUserStatus($statusId);
                /**
                 * Fires once a user status has been saved.
                 * //TODO if need further parameter
                 */
                do_action('save_user_status', $statusId);
            } else {
                $response['result'] = 'Can not post status. Please try again.';
            }
        }
        return $response;
    }

    /**
     * Handle status posting
     * @return array
     */
    public function handlePostComment()
    {
        $comment = trim($this->input->post('txtUserComment'));
        $postId = (int) $this->input->post('postId');
        $type = $this->input->post('type');
        $userId = get_current_user_id();
        $response = array(
            'success'   => false,
            'result'    => ''
        );
        if (!in_array($type, [Feed_Model::REFERENCE_TYPE_POST, Feed_Model::REFERENCE_TYPE_STATUS])) {
            $response['result'] = 'Invalid Type';
        }

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
                'comment_content'       => $comment,
                'comment_type'          => $type,
                'comment_parent'        => 0,
                'user_id'               => $currentUser->ID,
                'comment_author_IP'     => $this->input->ip_address(),
                'comment_agent'         => $this->input->user_agent(),
                'comment_date'          => date('Y-m-d H:i:s'),
                'comment_approved'      => 1
            );
            $newCommentId = wp_insert_comment($commentData);
            if ($newCommentId !== false) {
                $response['success'] = true;
                $response['result'] = $this->render('/layout/partial/comment', array('comment' => get_comment($newCommentId)));
            /**
             * Fires once a comment has been saved.
             * //TODO if need further parameter
             */
                do_action('save_comment', $newCommentId);
            } else {
                $response['result'] = 'Can not post comment. Please try again.';
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
                /**
                 * Fires once a user likes post/status has been saved.
                 * //TODO if need further parameter
                 */
                do_action('save_user_like_' . $type, $newLikeId);
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
