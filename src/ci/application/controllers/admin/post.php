<?php
/**
 * User: Duc Duong
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Post extends CI_Controller {

    public function index()
    {
        $this->load->view('admin/post/view_all');
    }

}