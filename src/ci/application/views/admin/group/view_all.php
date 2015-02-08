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
                <td><a href="?page=landbook-groups&act=edit&groupId=<?php echo $group['term_id']; ?>">Edit</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<h2>Add New Group</h2>
<form id="addtag" class="validate" action="" method="POST">
    <table class="form-table">
        <tbody>
            <tr class="form-field form-required term-name-wrap">
                <th scope="row"><label for="name">Name <span style="color: #ff0000">(*)</span></label></th>
                <td><input type="text" placeholder="Name Group" id="name" name="txtName" value="" required></td>
                <span style="color: red; font-style: italic; "><?php echo form_error('txtName'); ?></span>
            </tr>
            <tr class="form-field term-slug-wrap">
                <th scope="row"><label for="name">Slug</label></th>
                <td><input type="text" placeholder="Slug Group" id="slug" name="txtSlug" value=""></td>
            </tr>
            <tr class="form-field term-description-wrap">
                <th scope="row"><label for="name">Description <span style="color: #ff0000">(*)</span></label></th>
                <td><textarea name="txtDescription" placeholder="Description Group" required></textarea></td>
                <span style="color: red; font-style: italic; "><?php echo form_error('txtDescription'); ?></span>
        </tbody>
    </table>
    <input type="hidden" id="action" name="act" value="addNewGroup">
    <p class="submit"><input id='submit' type="submit" value="Add New Group" name="btnAddGroup"></p>
</form>
​