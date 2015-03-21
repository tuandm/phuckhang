<?php
    /**
     * @author Phat Nguyen
     *
     */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Post extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('ScPostManage');
        $this->load->model('admin/Posts', 'postModel');
        $this->load->library('form_validation');
    }

    /**
     * Show All Posts
     */
    public function index()
    {
        $posts = $this->postModel->getAllPosts();
        $this->load->view('admin/post/view_all', array('posts' => $posts));
    }

    public function filter()
    {
        $posts = $this->postModel->getAllPosts();
        $this->load->view('admin/post/view_all', array('posts' => $posts));
    }

    public function delete()
    {
        if (is_admin()) {
            $postId = (int) $this->input->get('post');
            if ($postId > 0) {
                wp_delete_post($postId);
                $this->index();
            } else {
                echo 'Invalid Post ID';
                return;
            }
        } else {
            die('You dont have permission to delete');
        }
    }

}
