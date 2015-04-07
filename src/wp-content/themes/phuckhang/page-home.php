<?php
get_header();
$hotPost = LandBook_Posts::getInstance()->getHottestPost();
?>
<div id="content" class="content">

    <div id="main-slider" class="carousel slide" data-ride="carousel">

        <ol class="carousel-indicators">
            <li data-target="#main-slider" data-slide-to="0" class="active"></li>
            <li data-target="#main-slider" data-slide-to="1"></li>
            <li data-target="#main-slider" data-slide-to="2"></li>
        </ol>

        <div class="carousel-inner">
            <div class="item active">
                <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/slider/bg1.jpg" height="430" width="1260" alt="">
                <div class="carousel-caption">
                </div>
            </div>

            <div class="item">
                <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/slider/bg2.jpg" height="430" width="1260" alt="">
                <div class="carousel-caption">
                </div>
            </div>

            <div class="item">
                <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/slider/bg3.jpg" height="430" width="1260" alt="">
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
                    <img src="<?php echo LandBook_Posts::getInstance()->get_avatar_url(get_avatar($hotPost['post_author'], 66)) ?>" height="66" width="66" alt="Linh Nguyen" class="img-circle"  style="float: left;">
                    <p>
                        <span class="author"><?php echo $hotPost['user_nicename'] ?></span> <br />
                        <a href="<?php echo get_permalink($hotPost['ID']) ?>">
                            <?php echo $hotPost['post_title'] ?>
                        </a>
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>


<?php get_footer(); ?>
