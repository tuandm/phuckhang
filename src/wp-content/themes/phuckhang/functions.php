<?php

/**
 * PhucKhang functions and definitions
 */

if ( ! function_exists( 'phuckhang_setup' ) ) :

function phuckhang_setup() {

  /*
   * Make theme available for translation.
   * Translations can be filed in the /languages/ directory.
   */
  load_theme_textdomain( 'phuckhang', get_template_directory() . '/languages' );
  // Add default posts and comments RSS feed links to head.
  add_theme_support( 'automatic-feed-links' );
  /* Let WordPress manage the document title.*/
  add_theme_support( 'title-tag' );
  /*
   * Enable support for Post Thumbnails on posts and pages.
   *
   * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
   */
  //add_theme_support( 'post-thumbnails' );
  //set_post_thumbnail_size( 825, 510, true );

  // This theme uses wp_nav_menu() in two locations.
  register_nav_menus( array(
    'primary' => __( 'Primary Menu',      'phuckhang' ),
    'social'  => __( 'Social Links Menu', 'phuckhang' ),
  ) );

  /*
   * Switch default core markup for search form, comment form, and comments
   * to output valid HTML5.
   */
  add_theme_support( 'html5', array(
    'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
  ) );

  /*
   * Enable support for Post Formats.
   *
   * See: https://codex.wordpress.org/Post_Formats
   */
  add_theme_support( 'post-formats', array(
    'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
  ) );

}
endif;

add_action( 'after_setup_theme', 'phuckhang_setup' );


/**
 * Enqueue scripts and styles.
 *
 */
function phuckhang_scripts() {

  // Add custom fonts, used in the main stylesheet.
  wp_enqueue_style( 'phuckhang-fonts', "http://fonts.googleapis.com/css?family=Roboto+Condensed:300italic,400italic,400,300,700&subset=latin,vietnamese", array(), null );

  // Bootstrap
  wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '3.3.4' );
  wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), '4.3.0' );

  // Load our main stylesheet.
  wp_enqueue_style( 'phuckhang-style', get_stylesheet_uri() );

  wp_enqueue_script( 'phuckhang-jquery', get_template_directory_uri() . '/js/jquery.min.js', array(), false, false );
  wp_enqueue_script( 'phuckhang-bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array(), false, true );

}

add_action( 'wp_enqueue_scripts', 'phuckhang_scripts' );


?>
