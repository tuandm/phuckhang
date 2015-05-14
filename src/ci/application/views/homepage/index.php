<div id="social-home" class="content social-cotent col-sm-10 col-md-10">
	<?php if (get_current_user_id()) : ?>
		<?php echo $this->view('/layout/partial/user_status') ?>
	<?php endif ?>
	<!-- User status -->
	<div class="clearfix" id="user_status_separate"></div>
	<?php echo $this->view('/homepage/user_feed') ?>
</div>
