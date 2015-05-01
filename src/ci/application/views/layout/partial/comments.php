<?php
if (is_page_template('page-landbook.php')) {
	?>

	<div class="comment-item_wrapper row">
		<?php if (isset($comments) && is_array($comments)) : ?>
			<?php
			$comment_count = 0;
			foreach ($comments as $comment) : ?>
				<?php echo $this->view('/layout/partial/comment', ['comment' => $comment]); ?>
				<?php
				$comment_count++;
			endforeach; ?>
		<?php endif ?>

		<?php if (isset($allowComment) && $allowComment && get_current_user_id()) : ?>
			<div class="comment-item comment-form">
				<div class="col-sm-12">
					<div class="media user-feed-media comment-text comment-post-<?php echo $postId; ?>">

						<div class="media-left">
							<div class="" style="width: 100px;text-align: right;">
								<?php echo get_simple_local_avatar(get_current_user_id(), 50) ?>
							</div>

						</div>

						<div class="media-body">
							<form>
								<textarea class="form-control userCommentPost type-<?php echo $referenceType ?>" rows="1" placeholder="Viết comment" id="comment_<?php echo $postId ?>"></textarea>

								<div class="userCommentError" style="display: none;"></div>
							</form>
						</div>
					</div>
				</div>
			</div>
		<?php endif ?>
	</div>

<?php } else {
	?>

	<div class="row">
		<?php if (isset($comments) && is_array($comments)) : ?>
			<?php foreach ($comments as $comment) : ?>
				<?php echo $this->view('/layout/partial/comment', ['comment' => $comment]); ?>
			<?php endforeach; ?>
		<?php endif ?>

		<!-- comment-item -->
		<?php if (isset($allowComment) && $allowComment && get_current_user_id()) : ?>
			<div class="comment-item col-lg-12 comment-text comment-post-<?php echo $postId; ?>">
				<div class="row">

					<div class="col-md-2 col-sm-2 col-xs-2 text-right">
						<?php echo get_simple_local_avatar(get_current_user_id(), 50) ?>
					</div>

					<div class="comment col-md-10 col-sm-10 col-xs-10">
						<form>
							<textarea class="form-control userCommentPost type-<?php echo $referenceType ?>" rows="1" placeholder="Viết comment" id="comment_<?php echo $postId ?>"></textarea>

							<div class="userCommentError" style="display: none;"></div>
						</form>
					</div>

				</div>
			</div>
		<?php endif ?>
	</div>
	<!-- .row -->

<?php } ?>

