<div class="row">
    <div class="person col-lg-3 col-xs-3">
        <a href="/social-userprofilepage/?index&userId=<?php echo $post->post_author ?>" ><?php echo get_simple_local_avatar($post->post_author, 100) ?></a>
    </div>
    <div class="feed-content col-lg-9 col-xs-9">
        <a href="/social-userprofilepage/?index&userId=<?php echo $post->post_author ?>" ><?php echo get_the_author_meta('display_name', $post->post_author) ?></a> shared<br /><br />

        <p><a href="<?php echo get_permalink($post->ID) ?> ">"<?php echo $post->post_title ?>"</a> <br /><br />
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
                    'numLike'       => $numLike,
                    'postDate'      => $post->post_date
                ])
                ?>
            <?php endif ?>
        </div>
    </div>
    <!-- /.feed-content -->
</div>
