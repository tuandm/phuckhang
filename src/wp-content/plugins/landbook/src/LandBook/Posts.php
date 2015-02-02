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

    protected function getInstanceName() {
        return 'post';
    }

}