<?php
/**
 * LandBook_Hook class contains all "hooking" actions that integrate with WordPress
 * @author Tuan Duong <duongthaso@gmail.com>
 * @package LandBook
 */
 

class LandBook_Hook
{
    /**
     * Handle shortcode of landbook plugin
     * @param array $attributes
     * @return string
     */
    public function handleShortcode(array $attributes) {
        // Get optional attributes and assign default values if not present
        $page = isset($attributes['page']) ? $attributes['page'] : 'home';
        $action = isset($_REQUEST['act']) ? $_REQUEST['act'] : 'index';
        $landBookContent = LandBook_Controller::getInstance()->forwardRequestToCI([
            'controller' => $page,
            'action' => $action
        ], false);

        return $landBookContent;
    }

    /**
     * Create admin menu for landbook plugin
     */
    public function createMenuItems()
    {
        $subMenus = array(
            array('projects', LandBook_Projects::getInstance()),
            array('products', LandBook_Products::getInstance()),
            array('groups', LandBook_Groups::getInstance()),
            array('posts', LandBook_Posts::getInstance()),
        );
        add_menu_page( 'Landbook', 'Landbook', 'manage_options', 'landbook', array($this, 'settings') );
        foreach ($subMenus as $subMenu) {
            $menuName = $subMenu[0];
            $menuHandler = $subMenu[1];
            $menuTitle = ucwords($menuName);
            add_submenu_page( 'landbook', 'Landbook - ' . $menuTitle, $menuTitle, 'manage_options', 'landbook-' . $menuName, array(
                $menuHandler, 'handleRequest'
            ) );
        }
    }

    /**
     *
     */
    public function projectProducts()
    {
        $ajaxHandler = LandBook_Ajax::getInstance();
        $ajaxHandler->projectProducts();
    }
}
