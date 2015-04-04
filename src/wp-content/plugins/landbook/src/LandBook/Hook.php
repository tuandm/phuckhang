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
        if (!$update && (get_post_status($postId) == 'inherit')) {
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
            var_dump(filter_input_array(INPUT_POST));
            die();
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

    /**
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
