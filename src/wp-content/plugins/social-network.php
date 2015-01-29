<?php

    /*
    Plugin Name: Social Network
    Plugin URI: http://wordpress.org/plugins/user-social-network/
    Description: This is a plugin will be use for landbook project
    Author: Phat Nguyen chicken
    Version: 0.0
    Author URI: http://starting-point/
    */
    /** Step 2 (from text above). */
    add_action( 'admin_menu', 'user_social_network_menu' );
    /** Step 1. */
    function user_social_network_menu()
    {
        add_menu_page( 'User Social Network', 'Social Network', 'manage_options', 'user-social-network', 'user_social_network_options' );
        $subTitleArray = array( 'groups', 'users', 'comments');
        foreach ( $subTitleArray as &$title ) {
            add_submenu_page( 'user-social-network', 'User Social Network', ucfirst( $title ),
                            'manage_options', 'user-social-network-'.$title, $title.'_function');
        }
        add_submenu_page('user-social-network','Posts','Posts','manage_options','user-social-network-posts','sc_posts_show');
//         add_submenu_page('user-social-network','Categories','Categories','manage_options','edit-tags.php?taxonomy=sc_group&post_type=sc_post');

    }
    
    function sc_posts_show()
    {
    	//Our class extends the WP_List_Table class, so we need to make sure that it's there
    	if ( !class_exists('WP_List_Table') ) {
    		require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
    	};
    	require_once( ABSPATH . 'wp-content/plugins/sc-post-table.php' );
    	//Prepare Table of elements
    	$wp_list_table = new Sc_Post_Table();
    	$wp_list_table->prepare_items();
    	$wp_list_table->display();
    }
  /*   function sc_category_menu_correction($parent_file) {
        global $current_screen;
        $taxonomy = $current_screen->taxonomy;
        if ($taxonomy == 'sc_group')
            $parent_file = 'user-social-network';
        return $parent_file;
    }
    add_action('parent_file', 'sc_category_menu_correction');
 */

    /** Step 3. */
    function user_social_network_options() {
        if ( !current_user_can( 'manage_options' ) )  {
            wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        }
        echo '<div class="wrap">';
        echo '<p>Here is Top Menu Social Network.</p>';
        echo '</div>';
        return;
    }
    function groups_function() {
        if ( !current_user_can( 'manage_options' ) )  {
            wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        }
        echo '<div class="wrap">';
        echo '<p>Here is Groups function.</p>';
        echo '</div>';
        return;
    }
    function users_function() {
        if ( !current_user_can( 'manage_options' ) )  {
            wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        }
        echo '<div class="wrap">';
        echo '<p>Here is Users function.</p>';
        echo '</div>';
        return ;
    }
    function comments_function() {
        if ( !current_user_can( 'manage_options' ) )  {
            wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        }
        echo '<div class="wrap">';
        echo '<p>Here is Comments funtion.</p>';
        echo '</div>';
        return ;
    }


    if (!function_exists('landbook_sc_init')) {
        /**
         * Register a product post type.
         *
         * @link http://codex.wordpress.org/Function_Reference/register_post_type
         */
        function landbook_sc_post_init()
        {
            $labels = array(
                'name' => _x('Posts', 'post type general name', _NP_TEXT_DOMAIN),
                'singular_name' => _x('Post', 'post type singular name', _NP_TEXT_DOMAIN),
                'menu_name' => _x('Posts', 'admin menu', _NP_TEXT_DOMAIN),
                'name_admin_bar' => _x('Posts', 'add new on admin bar', _NP_TEXT_DOMAIN),
                'add_new' => _x('Add New', 'Posts', _NP_TEXT_DOMAIN),
                'add_new_item' => __('Add New Posts', _NP_TEXT_DOMAIN),
                'new_item' => __('New Posts', _NP_TEXT_DOMAIN),
                'edit_item' => __('Edit Posts', _NP_TEXT_DOMAIN),
                'view_item' => __('View Posts', _NP_TEXT_DOMAIN),
                'all_items' => __('All Posts', _NP_TEXT_DOMAIN),
                'search_items' => __('Search Posts', _NP_TEXT_DOMAIN),
                'parent_item_colon' => __('Parent Posts:', _NP_TEXT_DOMAIN),
                'not_found' => __('No Posts.', _NP_TEXT_DOMAIN),
                'not_found_in_trash' => __('No Posts found in Trash.', _NP_TEXT_DOMAIN)
            );

            $args = array(
                'labels' => $labels,
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'query_var' => true,
                'rewrite' => array('slug' => 'sc-post'),
                'capability_type' => 'post',
                'has_archive' => true,
                'hierarchical' => false,
                'show_in_menu' => false ,
                'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt'),
                'taxonomies' => array ('categories'),
            );

            register_post_type('sc_post', $args);
        }
    }
    add_action( 'init', 'landbook_sc_post_init' );

    function landbook_sc_group() {

        register_taxonomy('sc_group', 'sc_post', array(
            // Hierarchical taxonomy (like categories)
            'hierarchical' => true,
            // This array of options controls the labels displayed in the WordPress Admin UI
            'labels' => array(
                'name' => _x( 'Categories', 'taxonomy general name' ),
                'singular_name' => _x( 'Categories', 'taxonomy singular name' ),
                'search_items' =>  __( 'Search Categories' ),
                'all_items' => __( 'All Categories' ),
                'parent_item' => __( 'Parent Categories' ),
                'parent_item_colon' => __( 'Parent Categories:' ),
                'edit_item' => __( 'Edit Categories' ),
                'update_item' => __( 'Update Categories' ),
                'add_new_item' => __( 'Add New Categories' ),
                'new_item_name' => __( 'New Categories Name' ),
                'menu_name' => __( 'Categories' ),

            ),
              // Control the slugs used for this taxonomy
            'rewrite' => array(
                'slug' => 'sc-group', // This controls the base slug that will display before each term
                'with_front' => false, // Don't display the category base before "/locations/"
                'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
            ),
        ));
    }
    add_action( 'init', 'landbook_sc_group', 0 );


?>