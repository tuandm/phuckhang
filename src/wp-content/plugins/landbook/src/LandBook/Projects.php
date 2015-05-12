<?php
/**
 * Author: Storm
 */

class LandBook_Projects extends LandBook_Admin {

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
        return 'project';
    }

    public function listProducts($projectId)
    {
        $projectModel = new LandBook_Model_Project();
        return $projectModel->getProducts($projectId);
    }
}
