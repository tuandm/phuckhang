<div class="feed">
    <?php echo $this->view('/homepage/post_box') ?>
    <?php echo $this->view('/layout/partial/comments', array('postId' => $post->ID)) ?>
</div>
