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
                    $feed['html'] = $this->renderUserStatus($feed['reference_id']);
                    break;
                case Feed_Model::REFERENCE_TYPE_POST:
                    $post = get_post($feed['reference_id']);
                    $comments = get_comments('status=approve&post_id=$id');
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
                $response['success'] = $this->render('/homepage/feed_status', array('status' => $this->statusModel->findById($statusId)));
            } else {
                $response['result'] = 'Can not post status. Please try again.';
            }
        }
        return $response;
    }
}
