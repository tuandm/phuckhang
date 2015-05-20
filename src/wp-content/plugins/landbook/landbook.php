<?php
/**
 * Plugin Name: LandBook
 * Description: LandBook plugin
 * Author: Duc Duong
 * Version: 0.0.1
 */

define('CI_ADMIN_FOLDER', "admin");

define('SRC_FOLDER', "src");

define('NUM_NOTIFICATIONS', 20);
define('USER_NOTIFICATION_AVATAR_SIZE', 50);

spl_autoload_register('LandBook::autoload');

/**
 * @author PN
 *
 */
class LandBook
{

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
            // AJAX action is handled by wp-admin/admin-ajax.php
            $this->loader->addAction('wp_ajax_project_products', $this->hook, 'projectProducts');
        } else {
            // Register shortcode handler
            $this->loader->addShortcode('landbook', $this->hook, 'handleShortcode');
            // Register redirect page after login
            $this->register_js();
        }
        $this->register_css();
        // Hooking
        add_filter('redirect_post_location', array($this, 'redirectPage'), 10, 3);
        add_filter('login_redirect', array($this, 'loginRedirectHandle'), 10, 3);
        add_filter('redirect_post_location', array($this, 'redirectPage'), 10, 3);
        $this->registerHooks();
    }

    /**
     * @param $redirect_to
     * @param $request
     * @param $user
     * @return string|void
     */
    public function loginRedirectHandle($redirect_to, $request, $user)
    {
        global $user;
        $userId = $user->ID;
        if ($redirect_to == 'social' && $userId != 0) {
            return site_url('phuc-khang-net');
        } else {
            return $redirect_to;
        }
    }

    /**
     *
     */
    public function registerHooks()
    {
        $this->loader->addAction('init', $this->hook, 'createScGroupTaxonomy');
        $this->loader->addAction('save_post', $this->hook, 'processAfterSavingPost', 10, 3);
        $this->loader->addAction('show_user_profile', $this->hook, 'selectGroup');
        $this->loader->addAction('edit_user_profile', $this->hook, 'selectGroup');
        $this->loader->addAction('profile_update', $this->hook, 'profileRedirect');
        $this->loader->addAction('edit_user_profile_update', $this->hook, 'updateUserGroups');

        // Hook action for user activities and user notifications.
        $this->loader->addAction('save_activity', $this->hook, 'processAfterSavingActivity', 10, 1);
        $this->loader->addAction('save_comment', $this->hook, 'processAfterSavingUserStatusComment', 10, 1);
        $this->loader->addAction('save_user_status', $this->hook, 'processAfterSavingUserStatus', 10, 1);
        $this->loader->addAction('request_add_user_friend', $this->hook, 'processReqAddUserFriend', 10, 1);
        $this->loader->addAction('save_group_status', $this->hook, 'processAfterSavingGroupStatus', 10, 1);
        $this->loader->addAction('save_user_like_status', $this->hook, 'processAfterSavingUserLikeStatus', 10, 1);
        $this->loader->addAction('save_user_photo', $this->hook, 'processAfterSavingUserPhoto', 10, 1);
        $this->loader->addAction('save_user_like_post', $this->hook, 'processAfterSavingUserLikePost', 10, 1);
        $this->loader->addAction('personal_options_update', $this->hook, 'updateUserGroups');
        $this->loader->addAction('save_activity', $this->hook, 'processAfterSavingActivity');
        $this->loader->run();
    }

    /**
     *
     */
    public function register_css()
    {
        wp_register_style('lbstyle', plugins_url('/css/lbstyle.css', __FILE__), array(), '20120208', 'all');
        wp_enqueue_style('lbstyle');
    }

    public function register_js()
    {
        wp_enqueue_script('social-script', get_template_directory_uri() . '/js/social.js', array(), '1.0.0', true);
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
     * @param  string $className The name of the class
     * @return null    Return early if the class name does not start with the
     *                 correct prefix
     */
    public static function autoload($className)
    {
        if (__CLASS__ !== mb_substr($className, 0, strlen(__CLASS__))) {
            return;
        }
        $className = ltrim($className, '\\');
        $fileName = '';
        if ($lastNsPos = strrpos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace);
            $fileName .= DIRECTORY_SEPARATOR;
        }
        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className);
        $fileName .= '.php';

        require SRC_FOLDER . DIRECTORY_SEPARATOR . $fileName;
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
        if (filter_input(INPUT_POST, 'publish') || filter_input(INPUT_POST, 'save')) {
            if (preg_match('/post=([0-9]*)/', $location, $match) && $post->ID == $match[1]) {
                if (is_object_in_term($post->ID, 'sc_group') && ($post->post_status == 'publish') && $pl) {
                    $location = home_url('/wp-admin/admin.php?page=landbook-posts');
                }
            }
        } else {
            $location = $pl;
        }
        return $location;
    }

}

add_action('plugins_loaded', array('LandBook', 'getInstance'));
