<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Author: Duc Duong
 */
?>

<h2>GROUP MANAGEMENT</h2>
<div>
    </br>
    <br/>
    <div></div>
    <table border="1">
        <thead>
        <tr>
            <th><?php _e('Group Name');?></th>
            <th><?php _e('Decriptions');?></th>
            <th><?php _e('Slug');?></th>
            <th><?php _e('Users In Group');?></th>
            <th colspan="2"><?php _e('Manager Group');?></th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th><?php _e('SC User Group ID');?></th>
            <th><?php _e('Decriptions');?></th>
            <th><?php _e('Slug');?></th>
            <th><?php _e('Users In Group');?></th>
            <th colspan="2"><?php _e('Manager Group');?></th>
        </tr>
        </tfoot>
        <tbody>
        <?php
        foreach( $groups as $gr ):
            ?>
            <tr>
                <td><?php echo $gr['name'];?></td>
                <td><?php echo $gr['description'];?></td>
                <td><?php echo $gr['slug'];?></td>
                <td><?php echo $gr['count'];?></td>
                <td>
                    <a href="?page=landbook-groups&act=edit&termid=<?php echo $gr['term_id'];?>">Edit</a>
                </td>
                <td>
                    <a href="?page=landbook-groups&act=delete&termid=<?php echo $gr['term_id'];?>">Delete</a>
                </td>
            </tr>
        <?php
        endforeach;
        ?>
        </tbody>
    </table>
</div>

<h2>Add New Group</h2>
<div>
    <form id="frmAddGroup" action="" method="POST">
        <div class="inputs">
            <input type="text" placeholder="Name Group" id="name" name="txtName" value=""><br>
            <input type="text" placeholder="Slug Group" id="slug" name="txtSlug" value=""><br>
            <textarea name="txtDescription"></textarea>
            <input type="hidden" id="action" name="act" value="addNewGroup"><br>
            <input id='submit' type="submit" value="Add New Group" name="btnAddGroup">
        </div>
    </form>
</div>
​
