<?php
    get_header();
?>

    <div class="content">
        <div class="row">
          <div class="col-lg-10 col-md-10 col-md-10 col-xs-12 col-lg-offset-1 col-md-offset-1 col-sm-offset-1">

            <?php
                // Start the loop.
                while ( have_posts() ) : the_post();
                    // Include the page content template.
                    get_template_part( 'content', 'page' );
                // End the loop.
                endwhile;
            ?>
            </div>
        </div>
    </div><!-- .content-area -->

<?php get_footer(); ?>
