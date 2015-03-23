<?php
/**
 * User: Storm
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comment extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('Comment_Model', 'commentModel');
        $this->load->library('pagination');
    }

    public function index()
    {
        $keyword = $this->input->post('keyword');
        $comments = $this->commentModel->getListComments($keyword);
        $totalRows = $this->commentModel->countComments();

        $perpage = 10;
        $config['base_url'] = '?page=landbook-comments';
        $config['per_page'] = $perpage;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $totalRows;

        $this->pagination->initialize($config);
        $pageLink =  $this->pagination->create_links();
        $from = $this->input->get('per_page');
        if ($from === false || $from === '') {
            $from = 0;
        }
        $showComments = array_slice($comments,$from,$perpage);

        $this->load->view('admin/comment/view_all', array(
            'comments' => $showComments,
            'pageLink'  => $pageLink,
            'keyword' => $keyword
        ));
    }

    public function delete()
    {
        $commentId = (int) $this->input->get('commentId');
        if($commentId <= 0) {
            echo "Invalid Comment ID";
            return;
        }

        $this->commentModel->deleteComment($commentId);
        $this->index();
    }

}