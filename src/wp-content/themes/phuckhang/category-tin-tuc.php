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
        get_template_part( 'content', 'category');
      endwhile;

      // Previous/next page navigation.
      //wp_pagenavi();

      $args = array(
        'base'               => '%_%',
        'format'             => '?page=%#%',
        'total'              => 1,
        'current'            => 0,
        'show_all'           => False,
        'end_size'           => 1,
        'mid_size'           => 2,
        'prev_next'          => True,
        'prev_text'          => __('« Previous'),
        'next_text'          => __('Next »'),
        'type'               => 'plain',
        'add_args'           => False,
        'add_fragment'       => '',
        'before_page_number' => '',
        'after_page_number'  => ''
      );
      echo paginate_links( $args );

    // If no content, include the "No posts found" template.
    else :
      get_template_part( 'content', 'none' );
    endif;
    ?>

  </div><!-- .content -->

</div>
<?php get_footer(); ?>
