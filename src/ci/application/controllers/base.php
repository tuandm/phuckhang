<?php
/**
 * Homepage Controller for social network
 * @author Tuan Duong <duongthaso@gmail.com>
 * @package LandBook
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Base extends CI_Controller
{

    /**
     * Render view file and return renderred content
     *
     * @param string $view file path
     * @param array $data
     * @return string
     */
    public function render($view, array $data = array())
    {
        ob_start();
        $this->load->view($view, $data);
        return ob_get_clean();
    }

    /**
     * Handle ajax request
     *
     * @return mixed
     */
    public function ajax()
    {
        if (!$this->input->is_ajax_request()) {
            die('Ajax request required!');
        }

        $callback = $this->input->get_post('callback');
        if ($callback === false) {
            die('Invalid callback');
        }

        $handle = 'handle' . ucfirst($callback);
        if (!method_exists($this, $handle)) {
            die('Invalid handle');
        }
        echo json_encode($this->$handle());
    }
}
