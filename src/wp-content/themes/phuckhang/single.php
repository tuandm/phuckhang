<?php
  get_header();
?>

  <div class="row">
  <div class="col-lg-3"></div>


  <div id="primary" class="content-area col-lg-9">
    <main id="main" class="site-main" role="main">
    <?php
    // Start the loop.
    while ( have_posts() ) : the_post();

      get_template_part( 'content', get_post_format() );

      // If comments are open or we have at least one comment, load up the comment template.
      if ( comments_open() || get_comments_number() ) :
        comments_template();
      endif;

      // Previous/next post navigation.
      the_post_navigation( array(
        'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next', 'phuckhang' ) . '</span> ' .
          '<span class="screen-reader-text">' . __( 'Next post:', 'phuckhang' ) . '</span> ' .
          '<span class="post-title">%title</span>',
        'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous', 'phuckhang' ) . '</span> ' .
          '<span class="screen-reader-text">' . __( 'Previous post:', 'phuckhang' ) . '</span> ' .
          '<span class="post-title">%title</span>',
      ) );

    // End the loop.
    endwhile;
    ?>

    </main><!-- .site-main -->
  </div><!-- .content-area -->
</div><!-- .row -->

<?php get_footer(); ?>
