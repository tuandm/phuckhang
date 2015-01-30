<?php
/*
Plugin Name: Social-Network
Plugin URI: http://wordpress.org/plugins/user-social-network/
Description: This is a plugin will be use for landbook project
Author: Phat Nguyen chicken
Version: 0.0
Author URI: http://starting-point/
*/
spl_autoload_register('SocialNetwork::autoload');
class SocialNetwork
{
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
     * Initializes the plugin by setting localization, filters, and
     * administration functions.
     */
    private function __construct()
    {
        add_action('parent_file', array($this, 'sc_category_menu_correction'), 999);
        add_action('admin_menu', array($this, 'user_social_network_menu'), 999);
    }


    public function sc_category_menu_correction($parent_file) {
        global $current_screen;
        $taxonomy = $current_screen->taxonomy;
        if ($taxonomy == 'scgroup')
            $parent_file = 'user-social-network';
        return $parent_file;
    }

    public function user_social_network_menu()
    {
        add_menu_page( 'User Social Network', 'Social Network', 'manage_options', 'user-social-network', array($this, 'user_social_network_options') );
        $subTitleArray = array( 'posts', 'users', 'comments','groups');
        foreach ( $subTitleArray as &$title ) {
            add_submenu_page( 'user-social-network', 'User Social Network', ucfirst( $title ),
                'manage_options', 'user-social-network-'.$title, array($this,$title.'_function'));
        }
    }

    public function user_social_network_options() {
        if ( !current_user_can( 'manage_options' ) )  {
            wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        }
        echo '<div class="wrap">';
        echo '<p>Here is Top Menu Social Network.</p>';
        echo '</div>';
        return;
    }
    public function posts_function() {
        if ( !current_user_can( 'manage_options' ) )  {
            wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        }
        echo '<div class="wrap">';
        echo '<p>Here is Posts function.</p>';
        echo '</div>';
        return;
    }
    public function groups_function() {
        if ( !current_user_can( 'manage_options' ) )  {
            wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        }
        global $wpdb;
        $user_groups = $wpdb->prefix.'sc_user_groups';
        $term_taxonomy = $wpdb->prefix.'term_taxonomy';
        $users = $wpdb->prefix.'users';
        $groups = $wpdb->get_results("SELECT *,(SELECT COUNT(*) FROM $users LEFT JOIN $user_groups AS u2 ON (u2.user_id =$users.ID) WHERE u2.group_id = u1.group_id) as user_count FROM $user_groups u1 LEFT JOIN $term_taxonomy t1 ON (t1.term_taxonomy_id = u1.group_id)  WHERE 1=1 GROUP BY (u1.group_id) ORDER BY u1.sc_user_groups_id ASC");
        echo SocialNetwork_View::render('groups',array('groups'=>$groups));
    }
    public function users_function() {
        if ( !current_user_can( 'manage_options' ) )  {
            wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        }
        echo '<div class="wrap">';
        echo '<p>Here is Users function.</p>';
        echo '</div>';
        return ;
    }
    public function comments_function() {
        if ( !current_user_can( 'manage_options' ) )  {
            wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        }
        echo '<div class="wrap">';
        echo '<p>Here is Comments funtion.</p>';
        echo '</div>';
        return ;
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
        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, 'src_'.$className);
        $fileName .='.php';

        require $fileName;
    }
}

add_action('plugins_loaded', array('SocialNetwork', 'getInstance'));
