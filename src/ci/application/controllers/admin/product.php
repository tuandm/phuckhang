<?php
/**
 * User: Duc Duong
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends CI_Controller {

    public function viewAll()
    {
        $this->load->view('admin/product/view_all');
    }

}