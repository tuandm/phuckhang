<?php
/**
 * Created by PhpStorm.
 * User: Storm
 * Date: 3/24/15
 * Time: 11:19 PM
 */
class Permalink_Util
{
    public function getUrl($postTitle, $action, $userId)
    {
        global $wpdb;
        $permalink = $wpdb->get_results( "SELECT guid FROM pk_posts WHERE post_title = '$postTitle' AND post_type = 'page'", OBJECT);
        $link = $permalink[0]->guid . '/?act=' . $action . '&userId=' . $userId;
        return $link;
    }
}