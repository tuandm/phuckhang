<?php
$url = new Permalink_Util;
?>
<div class="feed feed-lv0 feed-status-lv0">
	<?php if (is_page_template('page-landbook.php')) : ?>
		<div class="media user-feed-media">
			<div class="media-left">
				<a href="<?php echo $url->buildUserProfileUrl($userId) ?>"><?php echo get_simple_local_avatar($userId, 100) ?></a>
			</div>
			<div class="media-body">
				<p>
					<?php echo $statusContent ?>
					<!--<a href="#">See More</a>-->
				</p>

				<div>
					<?php if (get_current_user_id()) : ?>
						<?php echo $this->view('/homepage/user_like', [
							'referenceType' => $referenceType,
							'postId' => $statusId,
							'numLike' => $numLike,
						]); ?>
					<?php endif ?>
				</div>
			</div>
		</div>
		<?php echo $this->view('/layout/partial/comments', array('postId' => $statusId)) ?>
	<?php else : ?>
		<?php echo $this->view('/layout/partial/comments', array('postId' => $status['status_id'])) ?>
	<?php endif ?>
</div>