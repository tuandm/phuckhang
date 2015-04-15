<?php
    $url = new Permalink_Util;
?>
<div class="feed">

    <div class="row">
        <div class="person col-lg-3 col-xs-3">
                <a href="<?php echo $url->buildUserProfileUrl($status['user_id']) ?>" ><?php echo get_simple_local_avatar($status['user_id'], 100) ?></a>
        </div>

        <div class="feed-content col-lg-9 col-xs-9">
            <p>
                <?php echo $status['status']?>
                <!--<a href="#">See More</a>-->
            </p>

            <div>
                <?php if (get_current_user_id()) : ?>
                    <?php echo $this->view('/homepage/user_like', [
                        'referenceType'     => $referenceType,
                        'postId'            => $status['status_id'],
                        'numLike'           => $numLike
                    ]) ?>
                <?php endif ?>
            </div>
        </div>
    </div>
    <?php echo $this->view('/layout/partial/comments', array('postId' => $status['status_id'])) ?>
</div>
