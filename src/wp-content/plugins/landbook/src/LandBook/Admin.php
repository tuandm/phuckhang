<?php
/**
 * Author: Duc Duong
 */
abstract class LandBook_Admin extends LandBook_Controller {

    protected abstract function getInstanceName();

    public function handleRequest() {
        $act = isset($_REQUEST['act']) ? $_REQUEST['act'] : 'index';
        $this->forwardRequestToCI([
            'controller' => $this->getInstanceName(),
            'action' => $act
        ]);
    }

    protected function getControllerDirectory()
    {
        return CI_ADMIN_FOLDER;
    }

    protected function getCIPath()
    {
        return "../ci";
    }

}