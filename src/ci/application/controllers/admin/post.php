<?php
    /**
     * @author Phat Nguyen
     *
     */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Post extends CI_Controller
{

    /**
     * @var Input_Util
     */
    public $inputUtil;

    /**
     * @var Posts
     */
    public $postModel;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/Posts', 'postModel');
        $this->load->library('sc_post_management');
        $this->load->library('form_validation');
        $this->load->library('input_util', '', 'inputUtil');
    }

    /**
     * Show All Posts
     */
    public function index()
    {
        $orderBy = $this->inputUtil->getInputValue($this->input, 'orderby', 'col_post_id');
        $order = $this->inputUtil->getInputValue($this->input, 'order', 'ASC');
        $cat = $this->inputUtil->getInputValue($this->input, 'cat', 0);
        $postTitle = $this->inputUtil->getInputValue($this->input, 's', false);

        $posts = $this->postModel->getAllPosts($orderBy, $order, $cat, $postTitle);
        $this->load->view('admin/post/view_all', array('posts' => $posts));
    }

    /**
     * Edit A Post
     *
     */
    public function edit()
    {
        if (is_admin()) {
            $postId = (int) $this->input->get('post');
            if($postId > 0) {
                $result = $this->postModel->getPostById($postId);
                $this->load->view('admin/post/edit', array('post' => $result->posts[0]));
            } else {
                echo 'Invalid Post ID';
                return;
            }
        } else {
            die('You dont have permission to edit');
        }
    }

    public function update()
    {
        $this->form_validation->set_rules('post-title', 'Title', 'required');
        $this->form_validation->set_rules('post-content', 'Content', 'required');
        if ($this->form_validation->run() == TRUE) {
            $title = $this->input->post('post-title');
            $content = $this->input->post('post-content');
            $id = $this->input->post('post-id');
            $args = array(
                            'ID'            => $id,
                            'post_title'    => $title,
                            'post_content'  => $content
            );
            wp_update_post($args);
            $this->index();
        } else {
            return $this->edit();
        }
    }

    public function filter()
    {
        $posts = $this->postModel->getAllPosts();
        $this->load->view('admin/post/view_all', array('posts' => $posts));
    }

    public function delete()
    {
        if (!is_admin()) {
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
