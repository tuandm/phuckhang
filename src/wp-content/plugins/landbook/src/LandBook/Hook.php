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
            array('users', LandBook_Users::getInstance()),
        );
        add_menu_page( 'Landbook', 'Landbook', 'manage_options', 'landbook', array(LandBook::getInstance(), 'settings') );
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
     * Handle ajax request
     */
    public function projectProducts()
    {
        $ajaxHandler = LandBook_Ajax::getInstance();
        $ajaxHandler->projectProducts();
    }

    /**
     * Handle all actions need to be hooked after post is posted
     * @param int $postId The post ID.
     * @param WP_Post $post
     * @param bool $update
     */
    public function processAfterSavingPost($postId, $post, $update)
    {
        // For now, we just add to feed when new post is posted.
        if (get_post_status($postId) == 'publish' && get_post_type($postId) == 'post') {
            $userId = get_current_user_id();
            $feedModel = new LandBook_Model_Feed();
            $feedModel->insertFeedAfterPublishPost($userId, $postId);
        }
    }

    /**
     * Redirect to User Profile after login
     *
     */
    public function redirectUserProfile($redirect_to, $request, $user)
    {
        global $user;
        $redirect_to = home_url('/wp-login');
        if ( isset( $user->roles ) && is_array( $user->roles ) ) {
            if ( in_array( 'administrator', $user->roles ) ) {
                // redirect them to the default place
                return $redirect_to;
            } else {
                return home_url();
            }
        } else {
            return $redirect_to;
        }
    }

    /** Create sc_group taxonomy
     *
     */
    function createScGroupTaxonomy()
    {
        $labels = array(
            'name'              => _x('Sc_Groups', 'taxonomy general name'),
            'singular_name'     => _x('Sc_Group', 'taxonomy singular name'),
            'search_items'      => __('Search Sc_Group'),
            'all_items'         => __('All Sc_Group'),
            'parent_item'       => __('Parent Sc_Group'),
            'parent_item_colon' => __('Parent Sc_Group:'),
            'edit_item'         => __('Edit Sc_Group'),
            'update_item'       => __('Update Sc_Group'),
            'add_new_item'      => __('Add New Sc_Group'),
            'new_item_name'     => __('New Sc_Group Name'),
            'menu_name'         => __('Sc_Group'),
        );
        // Now register the taxonomy
        register_taxonomy('sc_group', array('post'), array(
            'labels'            => $labels,
            'show_in_menu'      => false,
            'hierarchical'      => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
        ));
    }

    /**
     * Update group for user
     */
    function updateUserGroups()
    {
        $groupModel = new LandBook_Model_Group();
        $groupModel->updateUserGroups();
    }

    /**
     * Display check box to choose group for user
     * @param $user
     */
    public function selectGroup($user)
    {
        $selectGroupView = new LandBook_View_Group();
        $selectGroupView->selectUserGroup($user);
    }

    public function profileRedirect()
    {
        $postUserGroups = filter_input(INPUT_POST, 'group', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        if ($postUserGroups) {
            wp_redirect(home_url('/wp-admin/admin.php?page=landbook-users'));
            exit;
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
     * Handle all actions need to be hooked after an activity is created
     *
     * @param int $activityId
     */
    public function processAfterSavingActivity($activityId)
    {
        $notificationModel = new LandBook_Model_Notification();
        $notificationModel->createNotificationsOfActivity($activityId);
    }

}
