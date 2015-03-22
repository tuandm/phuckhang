<?php
/**
 * Author: Duc Duong
 */

class LandBook_Controller {

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
     * Forward the current request to the front controller of CI
     * @param $params
     * @param $output
     * @return string
     */
    public function forwardRequestToCI($params, $output = true)
    {
        extract($params);
        if (!isset($controller) || !isset($action)) {
            wp_die('Invalid request parameters');
        }

        $_GET['d'] = $this->getControllerDirectory();
        $_GET['c'] = $controller;
        $_GET['m'] = $action;

        $ciPath = $this->getCIPath();
        $ci_front_controller = 'index.php';
        if (!file_exists($ciPath . DIRECTORY_SEPARATOR . $ci_front_controller)) {
            return 'Couldn\'t locate CodeIgniter native index.php file.';
        }

        $cwd = getcwd();
        chdir($ciPath);
        ob_start();
        require_once($ci_front_controller);
        $CI_OUTPUT = ob_get_contents();
        ob_end_clean();
        chdir($cwd);

        if ($output) {
            echo $CI_OUTPUT;
        } else {
            return $CI_OUTPUT;
        }
    }

    protected function getControllerDirectory()
    {
        return '';
    }

    protected function getCIPath()
    {
        return "ci";
    }

}