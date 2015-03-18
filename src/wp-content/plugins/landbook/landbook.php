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

/**
 * @author PN
 *
 */
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

            // a filter hook to redirect post location after it is edited
            add_filter('redirect_post_location', array($this, 'redirectPage'), 10, 3);

            //hook into the init action and call createScGroupTaxonomy when it fires
            add_action('init', array($this, 'createScGroupTaxonomy'), 0);

            // AJAX action is handled by wp-admin/admin-ajax.php
            $ajaxHandler = LandBook_Ajax::getInstance();

            // sample ajax action binding
            add_action('wp_ajax_project_products', array($ajaxHandler, 'projectProducts'));
        } else {
            add_shortcode('landbook', array($this, 'process'));
        }
    }

    public function createMenuItems()
    {
        $subMenus = [
            ['projects', LandBook_Projects::getInstance()],
            ['products', LandBook_Products::getInstance()],
            ['groups', LandBook_Groups::getInstance()],
            ['posts', LandBook_Posts::getInstance()],
        ];
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
     * Redirect to land-post after edit a post which belongs to sc_group
     * 
     * @param string $location
     * @return string $location
     */
    public function redirectPage($location)
    {
        global $post;
        $pl = get_permalink($post->ID);
        $taxInput = filter_input(INPUT_POST, 'tax_input', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        if (filter_input(INPUT_POST, 'publish') || filter_input(INPUT_POST, 'save')) {
            if (preg_match('/post=([0-9]*)/', $location, $match) && $post->ID == $match[1]) {
                if (is_object_in_term( $post->ID, 'sc_group') && ($post->post_status == 'publish')) {
                    $location = home_url('/wp-admin/admin.php?page=landbook-posts');
                }
            }
            elseif((count($taxInput) > 1) && ($post->post_status == 'publish')) {
                $location = home_url('/wp-admin/admin.php?page=landbook-posts');
            }
        } else {
            // Post page as a last resort
            $location = $pl;
        }
        return $location;
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

    /**
     * Register Taxonomy sc_group
     * 
     */
    function createScGroupTaxonomy() 
    {
        // Now register the taxonomy
        register_taxonomy('sc_group', array('post'), array(
                                                        'hierarchical'      => true,
                                                        'show_ui'           => true,
                                                        'show_admin_column' => true,
                                                        'query_var'         => true,
                        ));
    }
}

add_action('plugins_loaded', array('LandBook', 'getInstance'));
