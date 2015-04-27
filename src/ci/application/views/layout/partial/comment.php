<?php
    $url = new Permalink_Util();
?>
<div class="comment-item col-lg-12">
    <div class="row">

        <div class="col-md-2 col-sm-2 col-xs-2 text-right">
            <a href="<?php echo $url->buildUserProfileUrl($comment->user_id) ?>" ><?php echo get_simple_local_avatar($comment->user_id, 50) ?></a>
        </div>

        <div class="comment col-md-10 col-sm-10 col-xs-10">
            <p>
                <?php echo nl2br($comment->comment_content); ?>
            </p>
        </div>

    </div>
</div>