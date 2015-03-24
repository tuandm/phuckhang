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

/**
 * @author PN
 *
 */
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
            add_action('admin_menu', array($this, 'createMenuItems'), 999);

            // a filter hook to redirect post location after it is edited
            add_filter('redirect_post_location', array($this, 'redirectPage'), 10, 3);

            //hook into the init action and call createScGroupTaxonomy when it fires
            add_action('init', array($this, 'createScGroupTaxonomy'), 0);

            // AJAX action is handled by wp-admin/admin-ajax.php
            $ajaxHandler = LandBook_Ajax::getInstance();
            // Hook to user edit a custom field select box
            add_action('show_user_profile', array($this, 'selectGroup'));
            add_action('edit_user_profile', array($this, 'selectGroup'));

            add_action('profile_update', array($this, 'profileRedirect'));

            add_action('edit_user_profile_update', array($this, 'updateUserGroups'));

            // sample ajax action binding
            add_action('wp_ajax_project_products', array($ajaxHandler, 'projectProducts'));

            $this->loader->addAction('admin_menu', $this->hook, 'createMenuItems', 999);
            $this->register_css();

            // AJAX action is handled by wp-admin/admin-ajax.php
            $this->loader->addAction('wp_ajax_project_products', $this->hook, 'projectProducts');
        } else {
            // Register shortcode handler
            $this->loader->addShortcode('landbook', $this->hook, 'handleShortcode');
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
                if (is_object_in_term($post->ID, 'sc_group') && ($post->post_status == 'publish') && $pl) {
                    $location = home_url('/wp-admin/admin.php?page=landbook-posts');
                }
            }
        } else {
            $location = $pl;
        }
        return $location;
    }

    /**
    * 
    * @param unknown $userId
     */
    function updateUserGroups($userId)
    {
        global $wpdb;
        $updateData = filter_input_array(INPUT_POST);
        $terms = get_terms('sc_group', array('hide_empty' => false));
        $userId = filter_input(INPUT_POST, 'user_id');
        $postUserGroups = filter_input(INPUT_POST, 'group', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $numPostUserGroups = count($postUserGroups);
        $results = $wpdb->get_results("SELECT group_id, pk_terms.name FROM pk_sc_user_groups 
            INNER JOIN pk_terms ON pk_sc_user_groups.group_id = pk_terms.term_id WHERE pk_sc_user_groups.user_id = $userId", ARRAY_A);
        $currentUserGroups = wp_list_pluck($results, 'name', 'group_id');
        $numCurrentUserGroups = count($currentUserGroups);
        $termArray = wp_list_pluck($terms, 'name', 'term_id');
        if (!is_admin()) {
            die ('You do not have permission to edit this user');
        }
        if ($postUserGroups == null) {
            $result = $wpdb->delete('pk_sc_user_groups', array('user_id' => $userId));
        }
        $updateResults = $wpdb->update('pk_users', $updateData, $userId);
        foreach ($postUserGroups as $postUserGroup) {
            $checkGroup = in_array($postUserGroup, $currentUserGroups) ? 1 : 0;
            if ($checkGroup == 0) {
                $groupId = $wpdb->get_col("SELECT term_id FROM pk_terms WHERE pk_terms.name = '$postUserGroup'")[0];
                $data = array(
                    'user_id'   => $userId,
                    'group_id'  => $groupId
                );
                $insertResult = $wpdb->insert('pk_sc_user_groups', $data);
            }
        }
        foreach ($currentUserGroups as $groupId => $currentUserGroup) {
            $checkGroup = in_array($currentUserGroup, $postUserGroups) ? 1 : 0;
            if ($checkGroup == 0) {
                $wpdb->delete('pk_sc_user_groups', array(
                    'group_id'  => $groupId,
                    'user_id'   => $userId
                ));
            }
        }
    }

    /**
     * 
     * @param unknown $user
     */
    public function selectGroup($user)
    {
        global $wpdb;
        $tax = get_taxonomy('sc_group');
        $results = $wpdb->get_col("SELECT group_id FROM pk_sc_user_groups WHERE user_id = $user->ID");
        /* Make sure the user can assign terms of the profession taxonomy before proceeding. */
        if (!current_user_can($tax->cap->assign_terms))
            return;
        /* Get the terms of the 'profession' taxonomy. */
        $terms = get_terms('sc_group', array('hide_empty' => false));
    /* If there are any profession terms, loop through them and display checkboxes. */
    ?>
<h3><?php _e('Group');?></h3>
<table class="form-table">
    <tr>
        <th><label for="group"><?php _e('Select Group'); ?></label></th>
        <td><?php if (!empty($terms)) :?>
                <?php foreach ($terms as $term) : ?>
                <?php $checkValue = in_array($term->term_id, $results)? 1 : 0; ?>
                <input type="checkbox" name="group[]"
            id="group-<?php echo $term->name;?>"
            value="<?php echo $term->name; ?>" <?php checked($checkValue, 1); ?> />
            <label for="group-<?php echo esc_attr($term->name); ?>">
                    <?php echo $term->name; ?>
                </label> <br />
                <?php endforeach;?>
    <!--    If there are no groups terms, display a message.   -->
            <?php else :?>
                _e('There are no groups available.');
            }
            <?php endif;?>
        </td>
    </tr>
</table>
<?php }

    public function profileRedirect()
    {
        wp_redirect(home_url('/wp-admin/admin.php?page=landbook-users'));
        exit;
    }

    public function handleShortcode(array $attributes) {
        // Get optional attributes and assign default values if not present
        $page = isset($attributes['page']) ? $attributes['page'] : 'home';
        $action = isset($_REQUEST['act']) ? $_REQUEST['act'] : 'index';
        $landBookContent = LandBook_Controller::getInstance()->forwardRequestToCI([
            'controller' => $page,
            'action' => $action
        ], false);
        return $landBookContent;
        // Hooking
        $this->registerHooks();
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
