<h3><?php _e('Edit Group');?></h3>
<form name="edit-group" id="edit-group" method="post" action="<?php echo get_option('siteurl'); ?>/wp-admin/admin.php?page=landbook-users&amp;noheader=true" class="validate">
    <table class="form-table">
        <tr>
            <th><label for="group"><?php _e('Select Group'); ?></label></th>
            <td><?php if (!empty($terms)) : ?>
                    <?php foreach ($terms as $term) :?>
                    <?php $checkValue = in_array($term->term_id, $results)? 1 : 0 ; ?>
                    <input type="checkbox" name="group[]" id="group-<?php echo $term->name; ?>"
                    value="<?php echo $term->name; ?>"
                    <?php checked($checkValue, 1); ?> />
                    <label for="group-<?php echo esc_attr($term->name); ?>">
                        <?php echo $term->name ?>
                    </label> <br />
                    <?php endforeach;?>
        <!--    If there are no groups terms, display a message.   -->
                <?php else :?>
                    _e('There are no groups available.);
                }
                <?php endif;?>
            </td>
        </tr>
    </table>
    <input type="hidden" id="user_id" name="user_id" value="<?php echo $userId; ?>"><br>
    <input type="hidden" id="action" name="act" value="updateUserGroups"><br>
    <p class="submit"><input name="update-user-goups" id="submit" class="button button-primary" value="Update User Groups" type="submit"></p>
</form>