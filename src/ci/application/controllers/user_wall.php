<?php
/**
 * User Wall Controller for social network
 * Created by PhpStorm.
 * @author: Phat Nguyen
 * @package LandBook
 * Date: 5/18/2015
 * Time: 9:48 PM
 */

define("LOGO_SRC", "/wp-content/themes/phuckhang/images/logo.png");
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once('base.php');
class User_Wall extends Base
{

    /**
     * @var Like_Model
     */
    public $likeModel;

    /**
     * @var User_Model
     */
    public $userModel;

    /**
     * @var Status_Model
     */
    public $statusModel;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('date');
        $this->load->model('Status_Model', 'statusModel');
        $this->load->model('Like_Model', 'likeModel');
        $this->load->model('User_Model', 'userModel');
    }

    /**
     * Default action handler of User Wall controller
     */
    public function index()
    {
        $userId = $this->input->get('userId');
        $userId = ($userId) ? $userId : get_current_user_id();
        $allStatus =  $this->statusModel->getAllStatusByUserId($userId);
        //TODO add condition to verify whether current user is friend or not.
        if ($allStatus == null) {
                return $this->renderSocialView('/user/wall/index', array('allStatus' => ''), true);
        } else {
            foreach ($allStatus as $key => &$userStatus) {
                $numLike = $this->likeModel->countLike($userStatus['status_id']);
                $numUsersLike = $this->likeModel->getNumUsersLikeByLikeId($userStatus['status_id']);
                $isLiked = $this->likeModel->isLiked(get_current_user_id(), $userStatus['status_id']);
                $likeImage = $isLiked ? 'down' : 'up';
                $state  = $isLiked ? 'Unlike' : 'Like';
                $comments = get_comments('type=status&number=5&order=DESC&orderBy=comment_date&status=approve&post_id=' . $userStatus['status_id']);
                $userStatus['html'] = $this->render('/user/wall/status', array(
                    'statusContent' => $userStatus['status'],
                    'userId'        => $userStatus['user_id'],
                    'statusId'      => $userStatus['status_id'],
                    'comments'      => $comments,
                    'numLike'       => $numLike,
                    'numUsersLike'  => $numUsersLike,
                    'likeImage'     => $likeImage,
                    'state'         => $state,
                    'postDate'      => $userStatus['created_time'],
                    'referenceType' => Feed_Model::REFERENCE_TYPE_USER_STATUS,
                    'allowComment'  => true
                ));
            }
        }
        $this->renderSocialView('/user/wall/index', array('allStatus' => $allStatus), true);
    }

}
