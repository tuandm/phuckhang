<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width">
  <link rel="profile" href="http://gmpg.org/xfn/11">
  <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
  <link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" />

  <script>(function(){document.documentElement.className='js'})();</script>

  <?php wp_head(); ?>

  <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/main.js"></script>

  <!--[if lt IE 9]>
    <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
    <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/respond.min.js"></script>
  <![endif]-->

</head>

<body <?php body_class(); ?>>

   <header id="header">
        <nav class="navbar" role="banner">
            <div class="container-fluid">
                <div class="row">
                    <div class="navbar-header col-xs-12 col-sm-12 col-md-12 col-lg-3">
                        <div class="row">
                          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                              <span class="sr-only">Toggle navigation</span>
                              <i class="fa fa-bars fa-1x"></i>
                          </button>

                          <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">

                              <h1 class="site-title">
                                <img id="logo" src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/logo.png" alt="<?php bloginfo( 'name' ); ?>" class="img-responsive" alt="<?php bloginfo( 'name' ); ?>">
                              </h1>

                              <?php
                                $description = get_bloginfo( 'description', 'display' );
                                if ( $description || is_customize_preview() ) : ?>
                                    <p class="site-description"><?php echo $description; ?></p>
                                  <?php
                                endif;
                              ?>
                          </a>
                        </div>
                    </div>

                    <?php
                      if ( has_nav_menu( 'primary' ) || has_nav_menu( 'social' ) || is_active_sidebar( 'sidebar-1' )  ) : ?>

                      <div class="collapse navbar-collapse col-xs-12 col-sm-12 col-md-12 col-lg-9">

                        <?php if ( has_nav_menu( 'primary' ) ) : ?>

                            <?php
                              // Primary navigation menu.
                              wp_nav_menu( array(
                                'menu_class'     => 'nav navbar-nav',
                                'theme_location' => 'primary',
                              ) );
                            ?>
                          </div>
                        <?php endif; ?>

                        <?php if ( has_nav_menu( 'social' ) ) : ?>
                          <nav id="social-navigation" class="social-navigation" role="navigation">
                            <?php
                              // Social links navigation menu.
                              wp_nav_menu( array(
                                'theme_location' => 'social',
                                'depth'          => 1,
                                'link_before'    => '<span class="screen-reader-text">',
                                'link_after'     => '</span>',
                              ) );
                            ?>
                          </nav><!-- .social-navigation -->
                        <?php endif; ?>
                        <!-- <li><a href="#"><i class="fa fa-search"></i></a></li>
                        <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li> -->

                      </div>
                    <?php endif; ?>

                </div>
            </div><!--/.container-->
        </nav><!--/nav-->
    </header><!--/header-->
