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
     * @var LandBook_Loader
     */
    private $loader;

    /**
     * @var LandBook_Hook
     */
    private $hook;

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
        $this->loader = new LandBook_Loader();
        $this->hook = new LandBook_Hook();
        if (is_admin()) {

            $this->loader->addAction('admin_menu', $this->hook, 'createMenuItems', 999);
            $this->register_css();
            $this->loader->addAction('init', $this->hook, 'createScGroupTaxonomy');
            // AJAX action is handled by wp-admin/admin-ajax.php
            $this->loader->addAction('wp_ajax_project_products', $this->hook, 'projectProducts');
        } else {
            // Register shortcode handler
            $this->loader->addAction('init', $this->hook, 'createScGroupTaxonomy');
            $this->loader->addShortcode('landbook', $this->hook, 'handleShortcode');
            // Register redirect page after login
//            $this->loader->addFilter('login_redirect', $this->hook, 'redirectUserProfile');

            add_filter('login_redirect', array($this, 'redirectUserProfile'), 10, 3);
        }

        // Hooking
        $this->registerHooks();
    }

    /**
     * @param $redirect_to
     * @param $request
     * @param $user
     * @return string|void
     */
    public function redirectUserProfile($redirect_to, $request, $user)
    {
        global $user;
        $redirect_to = home_url('/wp-login');
        if ( isset( $user->roles ) && is_array( $user->roles ) ) {
            if (in_array('administrator', $user->roles)) {
                // redirect them to the default place
                return home_url('/wp-admin/');
            } else {
                return home_url("/social-userprofilepage/?act=index&userId=$user->ID");
            }
        } else {
            return $redirect_to;
        }
    }

    public function registerHooks()
    {
        $this->loader->addAction('publish_post', $this->hook, 'postPublishPost');
        $this->loader->run();
    }

    public function register_css() {
        wp_register_style('lbstyle', plugins_url('/css/lbstyle.css',__FILE__ ), array(), '20120208', 'all');
        wp_enqueue_style('lbstyle');
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
     * @param  string  $className  The name of the class
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