<?php
/**
 * Author: Duc Duong
 */
class LandBook_Ajax {

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

    public function projectProducts() {
        echo "Project's products from AJAX";
        wp_die();
    }

}