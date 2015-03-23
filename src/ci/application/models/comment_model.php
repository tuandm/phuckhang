<?php
/**
 * Created by PhpStorm.
 * User: Storm
 * Date: 1/31/15
 * Time: 1:24 PM
 */
require_once('land_book_model.php');
class Comment_Model extends Land_Book_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function getListComments($search_term='default')
    {
        $this->db
            ->select('pk_comments.comment_ID, pk_comments.comment_author, pk_comments.comment_content, pk_posts.post_title')
            ->from('pk_comments')
            ->like('comment_author', $search_term)
            ->or_like('post_title', $search_term)
            ->or_like('comment_content', $search_term)
            ->join('pk_posts', 'pk_comments.comment_post_ID = pk_posts.ID', 'left')
            ->order_by('pk_comments.comment_date', 'DESC');
        $comments = $this->db->get()->result_array();
        return $comments;
    }

    public function deleteComment($commentId)
    {
        $this->db->where('pk_comments.comment_ID', $commentId);
        $this->db->delete('pk_comments');
    }

    public function countComments()
    {
        $rows = $this->db->count_all('pk_comments');
        return $rows;
    }
}