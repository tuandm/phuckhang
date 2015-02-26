<?php
    /**
    * User: Duc Duong
    */

if ( !defined('BASEPATH')) exit('No direct script access allowed');

class Post extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('sc_post_manage');
        $this->load->model('admin/Posts','postModel');
        $this->load->library('form_validation');
    }
    
    public function index()
    {
        $posts = $this->postModel->getAllPosts();
        $this->load->view('admin/post/view_all', array('posts' => $posts));
    }
    
    public function edit()
    {
        if(!is_admin()) {
        	die('You dont have permission to edit');
        };
        $postId = (int)$this->input->get('post');
        if($postId <= 0)
        {
            echo "Invalid Post ID";
            return;
        }
        $result = $this->postModel->getPostById($postId);
        $this->load->view('admin/post/edit', array(
            'post' => $result->posts[0]
        ));
    }
    
    public function updatePost()
    {
        $this->form_validation->set_rules('post-title', 'Title', 'required');
        $this->form_validation->set_rules('post-content', 'Content', 'required');
        if($this->form_validation->run()==FALSE) {
            return $this->edit();
        } else {
            $title = $this->input->post('post-title');
            $content = $this->input->post('post-content');
            $id = $this->input->post('post-id');
            $args = array(
                'ID' => $id,
                'post_title' => $title,
                'post_content' => $content
            );
            wp_update_post($args);
            $this->index();
        }
    }
    public function filterAction()
    {
        $posts = $this->postModel->getAllPosts();
        $this->load->view('admin/post/view_all', array('posts' => $posts));
    }
    public function delete()
    {
        if(!is_admin()) {
            die('You dont have permission to delete');
        };
        $postId = (int)$this->input->get('post');
        if($postId <= 0)
        {
            echo "Invalid Post ID";
            return;
        }
        wp_delete_post($postId);
        $this->index();
    }
}