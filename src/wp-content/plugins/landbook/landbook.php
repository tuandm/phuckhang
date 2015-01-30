<?php
/**
 * Plugin Name: LandBook
 * Description: LandBook plugin
 * Author: Duc Duong
 * Version: 0.0.1
 */

define('CODEIGNITER_PATH', "../ci");
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
            add_action('admin_menu', array($this, 'createMenuTtems'), 999);

            // AJAX action is handled by wp-admin/admin-ajax.php
            $ajaxHandler = LandBook_Ajax::getInstance();

            // sample ajax action binding
            add_action( 'wp_ajax_project_products', array($ajaxHandler, 'projectProducts'));
        } else {
            add_shortcode('landbook', array($this, 'process'));
        }
    }

    public function createMenuTtems()
    {
        add_menu_page( 'Landbook', 'Landbook', 'manage_options', 'landbook', array($this, 'settings') );
        add_submenu_page( 'landbook', 'Landbook - Projects', 'Projects', 'manage_options', 'landbook-projects', array(
            LandBook_Projects::getInstance(), 'viewAll'
        ) );
        add_submenu_page( 'landbook', 'Landbook - Products', 'Products', 'manage_options', 'landbook-products', array(
            LandBook_Products::getInstance(), 'viewAll'
        ) );
        add_submenu_page( 'landbook', 'Landbook - Posts', 'Posts', 'manage_options', 'landbook-posts', array(
            LandBook_Posts::getInstance(), 'viewAll'
        ) );
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
        $namespace = '';
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