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
            INNER JOIN pk_terms ON pk_sc_user_groups.group_id = pk_terms.term_id
            WHERE pk_sc_user_groups.user_id = $userId", ARRAY_A);
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
}
