<?php
/**
 * Created by PhpStorm.
 * User: PN
 * Date: 4/8/2015
 * Time: 12:44 AM
 */

class LandBook_Model_HottestPost extends LandBook_Model
{
    /**
     * Return a hottest Post
     * @return array|bool
     */
    public function getHottestPost()
    {
        $sql = "SELECT p.post_author, p.post_title, count_like, p.ID, pk_users.user_nicename
                FROM pk_posts p
                JOIN
                  (SELECT reference_id, user_id,COUNT(user_id) as count_like
                    FROM pk_sc_user_like WHERE reference_type = 'post'
                    GROUP BY reference_id) ul
                ON ul.reference_id = p.ID
                JOIN pk_users ON pk_users.ID = p.post_author
                ORDER BY count_like DESC LIMIT 1";
        $hotPost = $this->getWpdb()->get_results($sql, ARRAY_A)[0];
        return $hotPost;
    }

}
