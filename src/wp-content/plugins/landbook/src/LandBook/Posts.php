<?php
/**
 * Author: Duc Duong
 */
class LandBook_Posts extends LandBook_Admin {

    /** Holds the plugin instance */
    private static $instance = false;

    /**
     * Singleton class
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Get Instance Name
     * @return string
     */
    protected function getInstanceName() {
        return 'post';
    }

    /**
     * Get hottest post
     * @return array|bool
     */
    public function getHottestPost()
    {
        $postModel = new LandBook_Model_HottestPost();
        return $postModel->getHottestPost();
    }

    /**
     * Customize css for get_simple_local_avatar() method
     * @param $get_avatar
     * @return mixed
     */
    public function get_avatar_url($get_avatar){
        preg_match("/src='(.*?)'/i", $get_avatar, $matches);
        return $matches[1];
    }

}