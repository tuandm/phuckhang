<?php
    /**
    * User: Duc Duong
    */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Post extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
        $this->load->library('sc_post_manage');
        $post = new CI_SC_Post_Manage();
        $post->prepare_items();
        $this->load->view('admin/post/view_all', array('post' => $post));
    }
}