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

    public function __construct()
    {
        parent::__construct();
        $this->load->model('userprofile/User_Profile_Model', 'userProfileModel');
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
    public function renderSocialView($view, array $data = array(), $renderFullView = false)
    {
        /** @var array $content */
        $content = [];
        if ($renderFullView) {
            $userId = get_current_user_id();
            $data['userId'] = $userId;
            $groups = $this->userProfileModel->getAllUserGroups($userId);
            foreach ($groups as $group) {
                $group->group_name = get_term($group->group_id, 'sc_group', ARRAY_A)['name'];
            }
            $content['left'] = $this->render('layout/partial/left_content', array('groups' => $groups));
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
}
