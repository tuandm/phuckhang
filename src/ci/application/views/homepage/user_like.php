<?php if (is_page_template('page-landbook.php')) : ?>
	<div class="social-user-like_<?php echo $postId ?>">
		<div>
			<?php
			$time = strtotime($postDate);
			echo timespan($time, time()) . ' ago';
			?>
		</div>
		<div class="social-tools">

			<i class="fa fa-thumbs-o-<?php echo $likeImage ?>" id="like"> </i>
			<a href="#" class="user-like like-type-<?php echo $referenceType ?>" id="like_<?php echo $postId ?>"> <?php echo $state ?> </a> ·
			<a class="user-comment" href="#" id="comment-post-<?php echo $postId ?>"> Comment </a>
			<?php if ($referenceType == 'post') : ?>
				<span> &#124; </span>
				<a href="https://www.facebook.com/sharer/sharer.php?s=100&p[title]=<?php echo get_the_title($postId) ?>&p[url]=<?php echo get_the_permalink($postId) ?>&p[images]=<?php echo $sharedImage ?>" title="Share on Facebook.">Share</a>
			<?php endif ?>

		</div>
		<div class="social-like-count">
			<?php if ($numLike > 0) : ?>
				<a class="num-like" title="<?php foreach ($numUsersLike as $userLike) : ?><?php echo $userLike['user_nicename'] ?>&#13;<?php endforeach ?>" href="#"><?php echo $numLike ?></a> people like this.
			<?php else : ?>
				Làm người đầu tiên thích bài này.
			<?php endif ?>
		<div id="likeError" style="display: none;"></div>
		</div>

<?php else : ?>
//TODO
<?php endif ?>