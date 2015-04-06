<?php
  get_header();
?>

  <div id="primary" class="content">

    <main id="main" class="site-main" role="main">

      <?php
      // Start the Loop.
      while ( have_posts() ) : the_post();
        get_template_part( 'content', 'search' );
      // End the loop.
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

    </main><!-- .site-main -->
  </div><!-- .content -->

<?php get_footer(); ?>
