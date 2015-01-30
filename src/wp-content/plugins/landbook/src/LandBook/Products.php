<?php
/**
 * Author: Duc Duong
 */
class LandBook_Products extends LandBook_Admin {

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

    public function viewAll() {
        $this->forwardRequestToCI('product', 'viewAll');
    }

}