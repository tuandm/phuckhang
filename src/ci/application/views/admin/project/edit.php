<?php
    $this->load->helper('form');
?>
<h2>EDIT PROJECT</h2>
<form name="edit-proj" id="edit-proj" method="post" action="<?php echo get_option('siteurl'); ?>/wp-admin/admin.php?page=landbook-projects&amp;noheader=true" class="validate" >
    <table class="form-table">
        <tbody>
            <tr class="form-field form-required term-name-wrap">
                <th scope="row"><label for="proj-name">Name<span style="color: #ff0000">(*)</span></label></th>
                <td><input name="proj-name" id="proj-name" value="<?php echo $proj->name; ?>" size="40" aria-required="true" type="text" required>
                <span id="validation" style="color:red"><?php echo form_error('proj-name'); ?></span>
            </tr>
            <tr class="form-field term-slug-wrap">
                <th scope="row"><label for="post-content">Status<span style="color: #ff0000">(*)</span></label></th>
                <td><?php echo form_dropdown('status', $statusNames ,$proj->status); ?></td>
            </tr>
        </tbody>
    </table>
    <input name="proj-id" id="proj-id" value="<?php echo $proj->lb_project_id; ?>" size="40" aria-required="true" type="hidden">
    <input type="hidden" id="action" name="act" value="Update"><br>
    <p class="submit"><input name="update" id="submit" class="button button-primary" value="Update" type="submit"></p>
</form>