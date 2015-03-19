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
        $this->load->library('ScPostManage');
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
     * Get All Posts
     * 
     * @return post object
     */
    public function getAllPosts()
    {
        $posts = new MY_SCPostManage();
        $posts->prepare_items();
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
        $post = new WP_Query("p = $postId");
        return $post;
    }

}
