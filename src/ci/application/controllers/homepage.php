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

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Feed_Model', 'feedModel');
    }
    public function index()
    {
        $feeds = $this->feedModel->getNewFeeds();
        $this->load->view('layout/layout', array(
            "content" => $this->render('homepage/index')
        ));
    }
}
