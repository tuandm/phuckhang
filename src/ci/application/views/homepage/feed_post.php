<div class="feed feed-lv0">
    <?php echo $this->view('/homepage/post_box') ?>
    <?php echo $this->view('/layout/partial/comments', array('postId' => $post->ID)) ?>
</div>
