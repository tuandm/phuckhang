<?php
/**
 * Homepage Controller for social network
 * @author Tuan Duong <duongthaso@gmail.com>
 * @package LandBook
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Base extends CI_Controller
{

    /**
     * @var User_Profile_Model
     */
    public $userProfileModel;

    /**
     * @var Permalink_Util
     */
    public $permalinkUtil;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('userprofile/User_Profile_Model', 'userProfileModel');
        $this->load->library('permalink_util', '', 'permalinkUtil');
    }

    /**
     * Render view file and return renderred content
     *
     * @param string $view file path
     * @param array $data
     * @return string
     */
    public function render($view, array $data = array())
    {

        ob_start();
        $this->load->view($view, $data);
        return ob_get_clean();
    }

    /**
     * Load View for View Controller
     *
     * @param string $view file path
     * @param array $data
     * @param bool $renderFullView
     * @return string
     */
    public function renderSocialView($view, $data = array(), $renderFullView = false)
    {
        /** @var array $content */
        $content = [];

        if ($renderFullView) {

            $data = $this->bindUserSocialData($data);

            $content['left'] = $this->render('layout/partial/left_content', $data);
            $content['main'] = $this->render($view, $data);
            $content['right'] = $this->render('layout/partial/social_sidebar');
        }

        if (!empty($content)) {
            $this->load->view('layout/layout', array(
                'content' => $content
            ));
        } else {
            die('Can not load this page');
        }
    }

    /**
     * Handle ajax request
     *
     * @return mixed
     */
    public function ajax()
    {
        if (!$this->input->is_ajax_request()) {
            die('Ajax request required!');
        }

        $callback = $this->input->get_post('callback');
        if ($callback === false) {
            die('Invalid callback');
        }

        $handle = 'handle' . ucfirst($callback);
        if (!method_exists($this, $handle)) {
            die('Invalid handle');
        }
        echo json_encode($this->$handle());
    }

    /**
     * Set data needed to render common parts of user social page
     * @param $data
     * @return array
     */
    protected function bindUserSocialData($data)
    {
        $userId = get_current_user_id();
        if ($userId == 0) {
            return $data;
        }
        $data['currentUserId'] = $userId;

        $groups = $this->userProfileModel->getAllUserGroups($userId);
        foreach ($groups as $group) {
            $groupId = $group->group_id;
            $group->group_name = get_term($groupId, 'sc_group', ARRAY_A)['name'];
            $group->group_url = $this->permalinkUtil->buildGroupProfileUrl($groupId);
        }
        $data['groups'] = $groups;

        return $data;
    }

    /**
     * Return status block
     *
     * @param int $statusId
     * @param string $view
     * @return string
     */
    protected function renderUserStatus($view, $statusId)
    {
        $status = $this->statusModel->findById($statusId);
        $isLiked = $this->likeModel->isLiked(get_current_user_id(), $status['status_id']);
        $numUsersLike = $this->likeModel->getNumUsersLikeByLikeId($status['status_id']);
        $likeImage = $isLiked ? 'down' : 'up';
        $state  = $isLiked ? 'Unlike' : 'Like';
        $numLike = $this->likeModel->countLike($status['status_id']);
        if ($status !== false && is_array($status)) {
            return $this->render($view, array(
                'isLiked'       => $isLiked,
                'numLike'       => $numLike,
                'likeImage'     => $likeImage,
                'numUsersLike'  => $numUsersLike,
                'state'         => $state,
                'postDate'      => $status['created_time'],
                'status'        => $status,
                'referenceType' => Feed_Model::REFERENCE_TYPE_USER_STATUS,
                'allowComment'  => true
            ));
        } else {
            return '';
        }

    }

}
