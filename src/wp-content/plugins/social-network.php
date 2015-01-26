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
	$subTitleArray = array( 'groups', 'users', 'posts', 'comments' );
	foreach ( $subTitleArray as &$title ) {
// 		var_dump("$title".'_function');
// 		die();
		add_submenu_page( 'user-social-network', 'User Social Network', ucfirst( $title ), 
						'manage_options', 'user-social-network-'.$title, $title.'_function');
	}
}

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
function posts_function() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	echo '<div class="wrap">';
	echo '<p>Here is Posts funtion.</p>';
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

?>