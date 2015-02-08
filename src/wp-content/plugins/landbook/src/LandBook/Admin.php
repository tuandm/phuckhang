<?php
/**
 * Author: Duc Duong
 */
abstract class LandBook_Admin {

    protected abstract function getInstanceName();

    public function handleRequest() {
        $act = isset($_REQUEST['act']) ? $_REQUEST['act'] : 'index';
        $this->forwardRequestToCI($this->getInstanceName(), $act);
    }

    protected function forwardRequestToCI($controller = '', $action = '')
    {
        $_GET['d'] = CI_ADMIN_FOLDER;
        $_GET['c'] = $controller;
        $_GET['m'] = $action;

        $ci_front_controller = CODEIGNITER_PATH . DIRECTORY_SEPARATOR . '/index.php';
        if (!file_exists($ci_front_controller)) {
            return 'Couldn\'t locate CodeIgniter native index.php file.';
        }

        $cwd = getcwd();
        chdir(CODEIGNITER_PATH);
        ob_start();
        require_once($ci_front_controller);
        $CI_OUTPUT = ob_get_contents();
        ob_end_clean();
        chdir($cwd);

        echo $CI_OUTPUT;
    }

}