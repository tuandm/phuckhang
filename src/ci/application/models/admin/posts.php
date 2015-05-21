<?php
/**
 * 
 * @author Phat Nguyen
 *
 */
class Posts extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('sc_post_management');
    }

    /**
     * Get Category by Id
     * 
     * @param int $id The Id of post
     * @return category name
     */
    public function getCatByPostId($id)
    {
        $categories = get_the_category($id);
        foreach ($categories as $category) {
            $catName = $category->cat_name;
        }
        return $catName;
    }

    /**
     * Search for Posts
     * @param $orderBy
     * @param $order
     * @param $cat
     * @param $postTitle
     * @return Array of post objects
     */
    public function getAllPosts($orderBy, $order, $cat, $postTitle)
    {
        $posts = new Sc_Post_Management();
        $posts->prepare_items($orderBy, $order, $cat, $postTitle);
        return $posts;
    }

    /**
     * Get Post by Id
     * 
     * @param int $postId
     * @return post instance
     */
    public function getPostById($postId)
    {
        $args = array('ID' => $postId);
        $post = new WP_Query("p=$postId");
        return $post;
    }

}
