<?php

?>
<form name="edit-tag" id="edit-tag" method="post" action="" class="validate" >
    <table class="form-table">
        <tbody>
            <tr class="form-field form-required term-name-wrap">
                <th scope="row"><label for="post-title">Title<span style="color: #ff0000">(*)</span></label></th>
                <td><input name="post-title" id="post-title" value="<?php echo $post->post_title; ?>" size="40" aria-required="true" type="text" required>
                <span id="validation"><?php echo form_error('post-title'); ?></span>
            </tr>
            <tr class="form-field term-slug-wrap">
                <th scope="row"><label for="post-content">Content<span style="color: #ff0000">(*)</span></label></th>
                <td><input name="post-content" id="post-content" value="<?php echo $post->post_content; ?>" size="40" type="text" required>
                <span id="validation"><?php echo form_error('post-content'); ?></span>
            </tr>
        </tbody>
    </table>
    <input name="post-id" id="post-id" value="<?php echo $post->ID; ?>" size="40" aria-required="true" type="hidden">
    <input type="hidden" id="action" name="act" value="updatePost"><br>
    <p class="submit"><input name="update" id="submit" class="button button-primary" value="Update" type="submit"></p>
</form>