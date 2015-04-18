<?php
/**
 * Used for Category post type
 * @Author Tony
 * 2015-04-18
 */
?>

<article id="post-<?php the_ID(); ?>" class="col-lg-6 category-post <?php post_class(); ?>">
  <?php
    // Post thumbnail.
    if ( has_post_thumbnail() ) {
      the_post_thumbnail();
    }
  ?>

  <header class="entry-header">
    <?php
      if ( is_single() ) :
        the_title( '<h1 class="entry-title">', '</h1>' );
      else :
        the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
      endif;
    ?>
  </header><!-- .entry-header -->

  <div class="entry-content">
    <?php
      /* translators: %s: Name of current post */
      // the_content( sprintf(
      //   __( 'Continue reading %s', 'phuckhang' ),
      //   the_title( '<span class="screen-reader-text">', '</span>', true )
      // ) );

      the_excerpt();



      wp_link_pages( array(
        'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'phuckhang' ) . '</span>',
        'after'       => '</div>',
        'link_before' => '<span>',
        'link_after'  => '</span>',
        'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'phuckhang' ) . ' </span>%',
        'separator'   => '<span class="screen-reader-text">, </span>',
      ) );
    ?>
  </div><!-- .entry-content -->

  <?php
    // Author bio.
    if ( is_single() && get_the_author_meta( 'description' ) ) :
      get_template_part( 'author-bio' );
    endif;
  ?>

  <footer class="entry-footer">
    <?php phuckhang_entry_meta(); ?>
    <?php edit_post_link( __( 'Edit', 'phuckhang' ), '<span class="edit-link">', '</span>' ); ?>
  </footer><!-- .entry-footer -->

</article><!-- #post-## -->
