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
        <div>
            <?php if (get_current_user_id()) : ?>
                <?php echo $this->view('/homepage/user_like', [
                    'referenceType' => $referenceType,
                    'postId'        => $post->ID,
                    'numLike'       => $numLike
                ]) ?>
            <?php endif ?>
        </div>
    </div>
    <!-- /.feed-content -->
</div>