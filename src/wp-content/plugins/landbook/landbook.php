<?php
/**
 * Plugin Name: LandBook
 * Description: LandBook plugin
 * Author: Duc Duong
 * Version: 0.0.1
 */

define('CI_ADMIN_FOLDER', "admin");

define('SRC_FOLDER', "src");

spl_autoload_register('LandBook::autoload');

class LandBook {

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
     * Constructor.
     * Initializes the plugin by setting localization, filters, and administration functions.
     */
    private function __construct()
    {
        if (is_admin()) {
            add_action('admin_menu', array($this, 'createMenuItems'), 999);
            $this->register_css();
            // AJAX action is handled by wp-admin/admin-ajax.php
            $ajaxHandler = LandBook_Ajax::getInstance();

            // sample ajax action binding
            add_action( 'wp_ajax_project_products', array($ajaxHandler, 'projectProducts'));
        } else {
            // Register shortcode handler
            add_shortcode('landbook', array($this, 'handleShortcode'));
        }
    }

    public function register_css() {
        wp_register_style('lbstyle', plugins_url('/css/lbstyle.css',__FILE__ ), array(), '20120208', 'all');
        wp_enqueue_style('lbstyle');
    }

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

    public function handleShortcode($attributes) {
        // Get optional attributes and assign default values if not present
        $page = isset($attributes['page']) ? $attributes['page'] : 'home';
        $action = isset($_REQUEST['act']) ? $_REQUEST['act'] : 'index';
        $landBookContent = LandBook_Controller::getInstance()->forwardRequestToCI([
            'controller' => $page,
            'action' => $action
        ], false);

        return $landBookContent;
    }

    public function settings()
    {
        echo '<div class="wrap">';
        echo '<p>Landbook settings page.</p>';
        echo '</div>';
        return;
    }

    /**
     * PSR-0 compliant autoloader to load classes as needed.
     *
     * @param  string  $classname  The name of the class
     * @return null    Return early if the class name does not start with the
     *                 correct prefix
     */
    public static function autoload($className)
    {
        if (__CLASS__ !== mb_substr($className, 0, strlen(__CLASS__))) {
            return;
        }
        $className = ltrim($className, '\\');
        $fileName  = '';
        if ($lastNsPos = strrpos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace);
            $fileName .= DIRECTORY_SEPARATOR;
        }
        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className);
        $fileName .='.php';

        require SRC_FOLDER . DIRECTORY_SEPARATOR . $fileName;
    }

}

add_action('plugins_loaded', array('LandBook', 'getInstance'));