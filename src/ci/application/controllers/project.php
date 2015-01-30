<?php
/**
 * Author: Duc Duong
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project extends CI_Controller {

    public function products()
    {
        $this->load->view('project/products');
    }

}