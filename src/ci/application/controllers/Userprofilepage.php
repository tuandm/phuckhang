<?php
/**
 * UserProfilepage Controller for social network
 * @author Phat Nguyen
 * @package LandBook
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Userprofilepage extends CI_Controller
{
    /**
     * @var Feed_Model
     */
    public $feedModel;

    public function __construct()
    {
        parent::__construct();
//         $this->load->model('Feed_Model', 'feedModel');
    }

    public function index()
    {
//         $feeds = $this->feedModel->getNewFeeds();
        $this->load->view('layout/layout', array(
            "content" => $this->render('userprofilepage/index')
        ));
    }
}
