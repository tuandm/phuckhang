<?php foreach ($feeds as $feed) : ?>
    <?php if (isset($feed['html'])): ?>
        <?php echo $feed['html']; ?>
    <?php endif; ?>
<?php endforeach; ?>

<div class="feed-pagination">
	<span class="pagination-link current-page" href="javascript:void(0);">1</span>
	<a class="pagination-link" href="javascript:void(0);">2</a>
	<a class="pagination-link" href="javascript:void(0);">3</a>
	<a class="pagination-link" href="javascript:void(0);">4</a>
	<a class="pagination-link" href="javascript:void(0);">5</a>
	<a class="pagination-link" href="javascript:void(0);">6</a>
	<a class="pagination-link" href="javascript:void(0);">7</a>
	<a class="pagination-link" href="javascript:void(0);">...</a>
</div>
