<?php
/**
 * Used for Category post type
 * @Author Tony
 * 2015-04-18
 */
?>


<?php
  get_header();
?>

<div class="row">

  <div class="col-lg-3">

    <div class="news-nav">

        <span>CHỌN TIN THEO CHỦ ĐỀ</span>

        <ul class="category-menu">
          <li>
            <a href="#">TIN PHÚC KHANG</a>
          </li>
          <li>
            <a href="#">THÔNG TIN DỰ ÁN</a>
          </li>
          <li>
            <a href="#">TIN THỊ TRƯỜNG</a>
          </li>
        </ul>

    </div>

  </div>

  <div id="primary" class="content col-lg-9">

    <?php if ( have_posts() ) : ?>

      <?php

      while ( have_posts() ) : the_post();
        get_template_part( 'content', 'category' );
      endwhile;

      // Previous/next page navigation.
      the_posts_pagination( array(
        'prev_text'          => __( 'Previous page', 'phuckhang' ),
        'next_text'          => __( 'Next page', 'phuckhang' ),
        'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'phuckhang' ) . ' </span>',
      ) );

    // If no content, include the "No posts found" template.
    else :
      get_template_part( 'content', 'none' );
    endif;
    ?>

  </div><!-- .content -->

</div>
<?php get_footer(); ?>
