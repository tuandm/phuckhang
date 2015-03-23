<?php
/**
 * Feed Model
 * @author Tuan Duong <duongthaso@gmail.com>
 * @package LandBook
 */

require_once('land_book_model.php');
class Feed_Model extends Land_Book_Model
{
    /**
     * Get newest feeds for displaying to the homepage
     * @return array|bool
     */
    public function getNewFeeds()
    {
        $feeds = $this->db
            ->select()
            ->from('user_feed')
            ->limit(10)
            ->get()
            ->result_array();
        return $feeds;
    }
}
