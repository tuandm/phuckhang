<?php
    $this->load->helper('form');
?>

<form name="add-proj" id="add-proj" method="post" action="<?php echo get_option('siteurl'); ?>/wp-admin/admin.php?page=landbook-projects&amp;noheader=true" class="validate" >
    <table class="form-table">
        <tbody>
            <tr class="form-field form-required term-name-wrap">
                <th scope="row"><label for="proj-name">Name<span style="color: #ff0000">(*)</span></label></th>
                <td><input name="proj-name" id="proj-name" value="" size="40" aria-required="true" type="text" required>
                <span id="validation"><?php echo form_error('proj-name'); ?></span>
            </tr>
            <tr class="form-field term-slug-wrap">
                <th scope="row"><label for="post-content">Status<span style="color: #ff0000">(*)</span></label></th>
                <td><?php echo form_dropdown('status', $statusNames ,$statusNames[1]); ?></td>
            </tr>
        </tbody>
    </table>
    <input type="hidden" id="action" name="act" value="createProject"><br>
    <p class="submit"><input name="create-project" id="submit" class="button button-primary" value="createProject" type="submit"></p>
</form>
