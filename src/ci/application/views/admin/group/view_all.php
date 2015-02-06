<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Author: Storm
 */
?>

<h2>GROUP MANAGEMENT</h2>
<table class="wp-list-table widefat fixed tags">
    <thead>
        <tr>
            <th class="manage-column column-name sortable desc"><?php _e('Group Name'); ?></th>
            <th class="manage-column column-description sortable desc"><?php _e('Decriptions'); ?></th>
            <th class="manage-column column-slug sortable desc"><?php _e('Slug'); ?></th>
            <th><?php _e('Users In Group'); ?></th>
            <th colspan="2"><?php _e('Manager Group'); ?></th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th class="manage-column column-name sortable desc"><?php _e('Group Name'); ?></th>
            <th class="manage-column column-description sortable desc"><?php _e('Decriptions'); ?></th>
            <th class="manage-column column-slug sortable desc"><?php _e('Slug'); ?></th>
            <th><?php _e('Users In Group'); ?></th>
            <th colspan="2"><?php _e('Manager Group'); ?></th>
        </tr>
    </tfoot>
    <tbody id="the-list">
        <?php foreach($groups as $group): ?>
            <tr>
                <td><?php echo $group['name']; ?></td>
                <td><?php echo $group['description']; ?></td>
                <td><?php echo $group['slug']; ?></td>
                <td><?php echo $group['count_users_in_group']; ?></td>
                <td><a href="?page=landbook-groups&act=edit&termId=<?php echo $group['term_id']; ?>">Edit</a></td>
                <td><a href="?page=landbook-groups&act=delete&termId=<?php echo $group['term_id']; ?>">Delete</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<h2>Add New Group</h2>
<form id="frmAddGroup" class="validate" action="" method="POST">
    <input type="text" placeholder="Name Group" id="name" name="txtName" value="">
    <span style="color: red; font-style: italic; "><?php echo form_error('txtName'); ?></span>
    <input type="text" placeholder="Slug Group" id="slug" name="txtSlug" value="">
    <span style="color: red; font-style: italic; "><?php echo form_error('txtSlug'); ?></span>
    <textarea name="txtDescription"></textarea>
    <span style="color: red; font-style: italic; "><?php echo form_error('txtDescription'); ?></span>
    <input type="hidden" id="action" name="act" value="addNewGroup">
    <input id='submit' type="submit" value="Add New Group" name="btnAddGroup">
</form>
​