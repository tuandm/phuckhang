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
        $response = array(
            'success'   => false,
            'result'    => ''
        );
        $status = $this->input->post('status');
        $area = '';
        $price = '';
        $projectModel = new LandBook_Model_Project();
        $where = $projectModel->searchKeywork($status,$area,$price);
        $projectModel->getProducts($where);
        if (!empty($status)) {
            $response['success'] = true;
            $response['result'] = $this->render('', array(
                'status' => $status
            ));
        } else {
            $response['success'] = false;
        }
        return $response;
    }

}