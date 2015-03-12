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

            add_action('show_user_profile', array($this, 'selectGroup'));
            add_action('edit_user_profile', array($this, 'selectGroup'));
            add_action('user_new_form', array($this, 'selectGroup'));

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
            ['users', LandBook_Users::getInstance()],
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
        if (filter_input(INPUT_POST, 'publish') || filter_input(INPUT_POST, 'save')) {
            if (preg_match('/post=([0-9]*)/', $location, $match) && $post->ID == $match[1]) {
                if (is_object_in_term( $post->ID, 'sc_group') && ($post->post_status == 'publish') && $pl) {
                    $location = home_url('/wp-admin/admin.php?page=landbook-posts');
                }
            }
        } else {
            // Post page as a last resort
            $location = $pl;
        }
        return $location;
    }
//     add_action( 'show_user_profile', 'my_show_extra_profile_fields' );
    
    public function selectGroup($user)
    { 
    $tax = get_taxonomy('sc_group');
    /* Make sure the user can assign terms of the profession taxonomy before proceeding. */
    if (!current_user_can($tax->cap->assign_terms))
        return;
    
    /* Get the terms of the 'profession' taxonomy. */
    $terms = get_terms('sc_group', array( 'hide_empty' => false ) ); 
    ?>
    <h3><?php _e( 'Group' ); ?></h3>
    <table class="form-table">
        <tr>
            <th><label for="group"><?php _e( 'Select Group' ); ?></label></th>
            <td><?php
            /* If there are any profession terms, loop through them and display checkboxes. */
            if (!empty($terms)) {
            foreach ($terms as $term) {?>
                    <input type="checkbox" name="group" id="group-<?php echo $term->slug; ?>" 
                    value="<?php echo $term->slug; ?>" 
                    <?php checked( $term->slug, 1 ); ?> /> 
                    <label for="group-<?php echo esc_attr( $term->slug ); ?>">
                    <?php echo $term->name; ?></label> <br />
                <?php }
            }

            /* If there are no profession terms, display a message. */
            else {
                _e( 'There are no professions available.' );
            }
            ?></td>
        </tr>
    </table>
        <h3>Extra profile information</h3>
    
        <table class="form-table">
    
            <tr>
            <th><label for="twitter">Twitter</label></th>
    
                <td>
                    <input type="text" name="twitter" id="twitter" value="<?php echo esc_attr( get_the_author_meta( 'twitter', $user->ID ) ); ?>" class="regular-text" /><br />
                    <span class="description">Please enter your Twitter username.</span>
                </td>
            </tr>
    
        </table>
    <?php }

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
                                                        'show_ui'           => false,
                                                        'show_admin_column' => true,
                                                        'query_var'         => true,
                        ));
    }
}

add_action('plugins_loaded', array('LandBook', 'getInstance'));
