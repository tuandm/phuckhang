<?php
/**
 * User: Duc Duong
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project extends CI_Controller {

    public function viewAll()
    {
        $this->load->view('admin/project/view_all');
    }

}