<?php
get_header();

function get_avatar_url($get_avatar){
    preg_match("/src='(.*?)'/i", $get_avatar, $matches);
    return $matches[1];
}

global $wpdb;
$sql = "SELECT p.post_author, p.post_title, count_like, p.ID, pk_users.user_nicename
        FROM pk_posts p
        JOIN
          (SELECT reference_id, user_id,COUNT(user_id) as count_like
            FROM pk_sc_user_like WHERE reference_type = 'post'
            GROUP BY reference_id) ul
        ON ul.reference_id = p.ID
        JOIN pk_users ON pk_users.ID = p.post_author
        ORDER BY count_like DESC LIMIT 1";
$hotPost = $wpdb->get_results($sql, ARRAY_A)[0];
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
                    <img src="<?php echo get_avatar_url(get_avatar($hotPost['post_author'], 66)) ?>" height="66" width="66" alt="Linh Nguyen" class="img-circle"  style="float: left;">
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
