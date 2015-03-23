<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Author: Storm
 */
?>

<h2>COMMENTS MANAGEMENT</h2>
<form method="post" action="">
    <input type="text" name="keyword" placeholder="Input keyword" value="<?php echo $keyword;?>">
    <button type="submit" name="btnSearch" >Search</button>
    <input type="hidden" id="action" name="act" value="index"><br>
</form>
<table class="wp-list-table widefat fixed tags">
    <thead>
    <tr>
        <th class="manage-column column-name sortable desc"><?php _e('Author'); ?></th>
        <th class="manage-column column-description sortable desc"><?php _e('Comment'); ?></th>
        <th class="manage-column column-slug sortable desc"><?php _e('In Response To'); ?></th>
        <th colspan="2"><?php _e('Manager Comment'); ?></th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <th class="manage-column column-name sortable desc"><?php _e('Author'); ?></th>
        <th class="manage-column column-description sortable desc"><?php _e('Comment'); ?></th>
        <th class="manage-column column-slug sortable desc"><?php _e('In Response To'); ?></th>
        <th colspan="2"><?php _e('Manager Comment'); ?></th>
    </tr>
    </tfoot>
    <tbody id="the-list">
    <?php foreach($comments as $comment): ?>
        <tr>
            <td><?php echo $comment['comment_author']; ?></td>
            <td><?php echo $comment['comment_content']; ?></td>
            <td><?php echo $comment['post_title']; ?></td>
            <td><a href="?page=landbook-comments&act=delete&commentId=<?php echo $comment['comment_ID']; ?>">Delete</a></td>
        </tr>
    <?php endforeach; ?>
    <?php echo $pageLink;?>
    </tbody>
</table>
