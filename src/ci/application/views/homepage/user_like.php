<div class="social-tools-wrap social-user-like_<?php echo $postId ?>">
    <div class="social-tools">
        <i class="fa fa-thumbs-o-<?php echo $likeImage ?>" id="like"> </i>
        <a href="#" class="user-like like-type-<?php echo $referenceType?>" id="like_<?php echo $postId ?>"> <?php echo $state ?> </a> ·
        <i class="fa fa-comment"></i><a class="user-comment" href="#" id="comment-post-<?php echo $postId ?>"> Comment </a> ·
        <i class="fa fa-facebook"></i> <a href="#">Share</a>
    </div>
    <div class="social-like-count">
        <?php if ($numLike > 0) : ?>
            <a class="num-like" href="#"><?php echo $numLike ?></a> people like this.
        <?php else : ?>
            Làm người đầu tiên thích bài này.
        <?php endif ?>
    </div>
    <div id="likeError" style="display: none;"></div>
</div>