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

  <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:300italic,400italic,400,300,700&subset=latin,vietnamese' rel='stylesheet' type='text/css'>
  <!-- Bootstrap -->
  <link href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/bootstrap.min.css" rel="stylesheet">

  <!-- <link href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/font-awesome.min.css" rel="stylesheet"> -->
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" />

  <!--[if lt IE 9]>
    <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
    <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/respond.min.js"></script>
  <![endif]-->

  <script>(function(){document.documentElement.className='js'})();</script>
  <?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<div id="page" class="hfeed site">
  <!-- <a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'twentyfifteen' ); ?></a> -->

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

                                <?php
                                    if ( is_front_page() && is_home() ) : ?>
                                  <h1 class="site-title">
                                      <img id="logo" src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/logo.png" alt="<?php bloginfo( 'name' ); ?>" class="img-responsive">
                                  </h1>

                                <?php else : ?>
                                  <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
                                <?php endif;

                                //$description = get_bloginfo( 'description', 'display' );
                                if ( $description || is_customize_preview() ) : ?>
                                  <p class="site-description"><?php echo $description; ?></p>
                                <?php endif;
                              ?>
                          </a>
                        </div>
                    </div>

                    <div class="collapse navbar-collapse col-xs-12 col-sm-12 col-md-12 col-lg-9">
                        <ul class="nav navbar-nav">
                            <li class="active"><a href="index.html">GIỚI THIỆU</a></li>
                            <li><a href="du-an.html">DỰ ÁN</a></li>
                            <li><a href="#">THÀNH VIÊN</a></li>
                            <li><a href="#">TIN TỨC</a></li>
                            <li><a href="#">SỰ KIỆN</a></li>
                            <li><a href="#">TUYỂN DỤNG</a></li>
                            <li><a href="#"><i class="fa fa-search"></i></a></li>
                            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div><!--/.container-->
        </nav><!--/nav-->
    </header><!--/header-->

  <div id="content" class="site-content">

          <div id="main-slider" class="carousel slide" data-ride="carousel">

            <ol class="carousel-indicators">
                <li data-target="#main-slider" data-slide-to="0" class="active"></li>
                <li data-target="#main-slider" data-slide-to="1"></li>
                <li data-target="#main-slider" data-slide-to="2"></li>
            </ol>

            <div class="carousel-inner">
              <div class="item active">
                <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/slider/bg1.jpg" height="433" width="1261">
                <div class="carousel-caption">
                </div>
              </div>

              <div class="item">
                <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/slider/bg2.jpg" height="604" width="1366" alt="">
                <div class="carousel-caption">
                </div>
              </div>

              <div class="item">
                <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/slider/bg3.jpg" height="604" width="1366" alt="">
                <div class="carousel-caption">
                </div>
              </div>

            </div><!--/.carousel-inner-->


        <!-- Controls -->
        <a class="left carousel-control" href="#main-slider" role="button" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#main-slider" role="button" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>

       </div><!--/.carousel-->
  </div>

    <div class="clearfix"></div>


  <section id="home-block">
    <div class="container-fluid">
      <div class="row">

        <div class="box box-center box-picture box-first">
          <a href="#" title="Hình ảnh">

            <div class="slide-item">
              <span class="slide-title">Hình ảnh</span>
              <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/camera-icon.png" height="67" width="66">
            </div>

          </a>
        </div>
        <div class="box box-center box-video">
          <a href="#" title="Phim">

            <div class="slide-item">
              <span class="slide-title">Phim</span>
              <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/video-icon.png" height="67" width="66" />
            </div>

          </a>
        </div>
        <div class="box box-center box-contact">
          <a href="#" title="Liên Hệ">
            <div class="slide-item">
              <span class="slide-title">Liên hệ</span>
              <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/contact-icon.png" height="67" width="66">
            </div>
          </a>
        </div>
        <div class="box box-news box-last">

          <div class="vertical-center">
            <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/LinhNguyen.jpg" height="66" width="66" alt="Linh Nguyen" class="img-circle"  style="float: left;">
            <p>
              <span class="author">Linh Nguyen</span> <br />
              <a href="#">
                Cơn sốt căn hộ tại dự án Làng sen mới chỉ bắt đầu?
              </a>
            </p>
          </div>
        </div>

      </div>
    </div>
  </section>

</div>
<?php get_footer(); ?>
