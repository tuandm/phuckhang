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
        if ($renderFullView && get_current_user_id()) {
            /** @var array $groups */
            $groups = $this->userProfileModel->getAllUserGroups(get_current_user_id());

            /** @var array $groupNames */
            if ($groups['numGroups'] === 0) {
                $groupNames = [];
            }
            foreach ($groups['group'] as $group) {
                $groupNames[] = get_term($group['group_id'], 'sc_group', ARRAY_A)['name'];
            }
            /** @var array $groupData */
            $groupData = array(
                'numGroups'     => $groups['numGroups'],
                'userId'        => get_current_user_id(),
                'groupNames'    => $groupNames
            );
                $content['left'] = $this->render('layout/partial/left_content', $groupData);
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
