<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Author: Storm
 */
$this->load->model('Group_Model', 'groupModel');
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
        <?php foreach($groups as $gr): ?>
            <tr>
                <td><?php echo $gr['name']; ?></td>
                <td><?php echo $gr['description']; ?></td>
                <td><?php echo $gr['slug']; ?></td>
                <td><?php echo $this->groupModel->countUsersInGroup($gr['term_taxonomy_id']); ?></td>
                <td><a href="?page=landbook-groups&act=edit&termId=<?php echo $gr['term_id']; ?>">Edit</a></td>
                <td><a href="?page=landbook-groups&act=delete&termId=<?php echo $gr['term_id']; ?>">Delete</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2>Add New Group</h2>
<form id="frmAddGroup" class="validate" action="" method="POST">
    <input type="text" placeholder="Name Group" id="name" name="txtName" value="">
    <input type="text" placeholder="Slug Group" id="slug" name="txtSlug" value="">
    <textarea name="txtDescription"></textarea>
    <input type="hidden" id="action" name="act" value="addNewGroup">
    <input id='submit' type="submit" value="Add New Group" name="btnAddGroup">
</form>
​