
<div class="row">
    <?php if (isset($comments) && is_array($comments)) : ?>
        <?php foreach ($comments as $comment) : ?>
            <?php echo $this->view('/layout/partial/comment', ['comment' => $comment]); ?>
        <?php endforeach; ?>
    <?php endif ?>

    <!-- comment-item -->
    <?php if (isset($allowComment) && $allowComment && get_current_user_id()) : ?>
    <div class="comment-item col-lg-12">
        <div class="row">

            <div class="col-md-2 col-sm-2 col-xs-2 text-right">
                <img class="small-avatar" src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/profile/tuan_duong.jpg" height="50" width="50" alt="">
            </div>

            <div class="comment col-md-10 col-sm-10 col-xs-10">
                <form>
                    <textarea class="form-control" rows="1" placeholder="Viết comment"></textarea>
                </form>
            </div>

        </div>
    </div>
    <?php endif ?>
</div>
<!-- .row -->