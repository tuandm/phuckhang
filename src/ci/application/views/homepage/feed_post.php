<div class="feed">
    <div class="row">
        <div class="person col-lg-3 col-xs-3">
            <img class="medium-avatar" src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/profile/phuc_nguyen.jpg" height="100" width="100" alt="">
        </div>
        <div class="feed-content col-lg-9 col-xs-9">
            <a href="#"><?php echo get_the_author_meta('display_name', $post->post_author) ?> </a> shared<br /><br />

            <p>"<?php echo $post->post_title ?>" <br /><br />
                <?php
                    $striptagFromContent = strip_tags($post->post_content);
                    echo $content = wp_trim_words($striptagFromContent, 100, null);
                ?>
            </p>

            <div class="social-tools-wrap">
                <div class="social-tools">
                    <i class="fa fa-thumbs-o-up"> </i> <a href="#">Like</a> ·  <i class="fa fa-comment"></i> <a href="#">Comment</a> · <i class="fa fa-facebook"></i> <a href="#">Share</a>
                </div>

                <div class="social-like-count">
                    <a href="#">49</a> people like this.
                </div>
            </div>
        </div>
        <!-- /.feed-content -->
    </div>
    <?php echo $this->view('/layout/partial/comments', array('postId' => $post->ID)) ?>
</div>