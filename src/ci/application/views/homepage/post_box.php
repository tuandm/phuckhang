<?php
$url = new Permalink_Util();
?>

<?php
if (is_page_template('page-landbook.php')) {
	?>

	<div class="media user-feed-media">
		<div class="media-left">
			<a href="<?php echo $url->buildUserProfileUrl($post->post_author) ?> "><?php echo get_simple_local_avatar($post->post_author, 58) ?></a>
		</div>
		<div class="media-body">

			<a href="<?php echo $url->buildUserProfileUrl($post->post_author) ?> ">
				<?php echo get_the_author_meta('display_name', $post->post_author) ?>
			</a>&nbsp;shared

			<a class="feed-title text-uppercase" href="<?php echo get_permalink($post->ID) ?> ">"<?php echo $post->post_title ?>"</a>

			<p>
				<?php
				$striptagFromContent = strip_tags($post->post_content);
				echo $content = wp_trim_words($striptagFromContent, 100, null);
				?>
			</p>

			<div>
				<?php if (get_current_user_id()) : ?>
					<?php echo $this->view('/homepage/user_like', [
						'referenceType' => $referenceType,
						'postId' => $post->ID,
						'numLike' => $numLike,
					])
					?>
				<?php endif ?>
			</div>
		</div>
	</div>

<?php } else { ?>
	<div class="row">
		<div class="person col-lg-3 col-xs-3">
			<a href="<?php echo $url->buildUserProfileUrl($post->post_author) ?> "><?php echo get_simple_local_avatar($post->post_author, 58) ?></a>
		</div>
		<div class="feed-content col-lg-9 col-xs-9">
			<a href="<?php echo $url->buildUserProfileUrl($post->post_author) ?> "><?php echo get_the_author_meta('display_name', $post->post_author) ?></a> shared<br /><br />

			<p><a  href="<?php echo get_permalink($post->ID) ?> ">"<?php echo $post->post_title ?>"</a> <br /><br />
				<?php
				$striptagFromContent = strip_tags($post->post_content);
				echo $content = wp_trim_words($striptagFromContent, 100, null);
				?>
			</p>

			<div>
				<?php if (get_current_user_id()) : ?>
					<?php echo $this->view('/homepage/user_like', [
						'referenceType' => $referenceType,
						'postId' => $post->ID,
						'numLike' => $numLike,
					])
					?>
				<?php endif ?>
			</div>
		</div>
		<!-- /.feed-content -->
	</div>
<?php } ?>