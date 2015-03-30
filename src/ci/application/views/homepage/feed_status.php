<div class="feed">

    <div class="row">
        <div class="person col-lg-3 col-xs-3">
            <img class="medium-avatar" src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/profile/tony_nguyen.jpg" height="100" width="100" alt="">
        </div>

        <div class="feed-content col-lg-9 col-xs-9">
            <p>
                <?php echo $status['status']?>
                <!--<a href="#">See More</a>-->
            </p>


            <div class="social-tools-wrap">
                <div class="social-tools">
                    <i class="fa fa-thumbs-o-up"> </i> <a href="#">Like</a> ·  <i class="fa fa-comment"></i> <a href="#">Comment</a> · <i class="fa fa-facebook"></i> <a href="#">Share</a>
                </div>

                <div class="social-like-count">
                    Làm người đầu tiên thích bài này.
                </div>
            </div>

        </div>
    </div>
        <?php echo $this->view('/layout/partial/comments', array('postId' => $status['status_id'])) ?>
</div>