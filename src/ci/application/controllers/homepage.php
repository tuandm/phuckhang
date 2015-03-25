<?php
/**
 * Homepage Controller for social network
 * @author Tuan Duong <duongthaso@gmail.com>
 * @package LandBook
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Homepage extends CI_Controller
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
                    $feed['html'] = $this->render('/homepage/feed_status');
                    break;
                case Feed_Model::REFERENCE_TYPE_POST:
                    $feed['html'] = $this->render('/homepage/feed_post');
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
        return $this->$handle();
    }

    /**
     * Handle status posting
     */
    public function handlePostStatus()
    {
        $status = $this->input->post('txtUserStatus');
        $userId = get_current_user_id();
        if ($userId === 0) {
            die('Please login first');
        }

        if (empty($status)) {
            die('Please input status');
        }

        $result = $this->statusModel->addUserStatus($userId, $status);
        if ($result) {
            die('OK');
        } else {
            die('Can not post status. Please try again.');
        }
    }
}
