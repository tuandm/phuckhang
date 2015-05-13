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

    public function listProducts($projectId)
    {
        $projectModel = new LandBook_Model_Project();
        $products =  $projectModel->getProducts($projectId);

        foreach($products as $pros) {
            $pros->status = $this->getProductStatus($pros->status);
        }

        return $products;
    }

    public function getProductStatus($value)
    {
        switch ($value) {
            case '3' :
                return 'Khuyến Mãi';
                break;
            case '2' :
                return 'Đã Bán';
                break;
            case '1' :
                return 'Còn Hàng';
                break;
            default :
                return 'Còn trống';
        }
    }
}
