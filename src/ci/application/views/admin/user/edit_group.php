<h3><?php _e('Edit Group');?></h3>
<form name="edit-group" id="edit-group" method="post" action="<?php echo get_option('siteurl'); ?>/wp-admin/admin.php?page=landbook-users&amp;noheader=true" class="validate">
    <table class="form-table">
        <tr>
            <th><label for="group"><?php _e('Select Group'); ?></label></th>
            <td><?php if (!empty($terms)) : ?>
                    <?php $options = array('No Role', 'Admin', 'Member'); ?>
                    <?php foreach ($terms as $term) :?>
                        <?php if ($term->checked) : ?>
                            <input checked="checked" type="checkbox" name="group[]" id="group-<?php echo $term->name; ?>"
                        <?php else : ?>
                            <input type="checkbox" name="group[]" id="group-<?php echo $term->name; ?>"
                        <?php endif; ?>
                        <label for="group-<?php echo esc_attr($term->name); ?>">
                            <?php echo $term->name; ?>
                        </label>
                        <select name = "<?php echo $term->term_id; ?>">
                            <?php foreach($options as $option) : ?>
                                <?php if ($term->role == $option) : ?>
                                    <option value="<?php echo $option; ?>" selected="selected"><?php echo $option; ?></option>
                                <? else : ?>
                                    <option value="<?php echo $option; ?>"><?php echo $option; ?></option>
                                <? endif; ?>
                            <?php endforeach; ?>
                        </select><br/>
                        <?php endforeach; ?>
                        <br/>
        <!--    If there are no groups terms, display a message.   -->
                <?php else :?>
            <?php if (!empty($terms)) : ?>
                    <?php $options = array('No Role', 'Admin', 'Member'); ?>
                    <?php foreach ($terms as $term) : ?>
                    <tr>
                        <td>
                        <?php if ($term->checked) : ?>
                            <input checked="checked" type="checkbox" name="group[<?php echo $term->term_id; ?>]" id="group-<?php echo $term->name; ?>"
                        <?php else : ?>
                            <input type="checkbox" name="group[<?php echo $term->term_id; ?>]" id="group-<?php echo $term->name; ?>"
                        <?php endif; ?>
                        <label for="group-<?php echo esc_attr($term->name); ?>">
                            <?php echo $term->name; ?>
                        </label>
                        </td>
                        <td>
                        <select name ="role[<?php echo $term->term_id; ?>]" value="">
                            <?php foreach($options as $option) : ?>
                                <?php if ($term->role == $option) : ?>
                                    <option value="<?php echo $option; ?>" selected="selected"><?php echo $option; ?></option>
                                <?php else : ?>
                                    <option value="<?php echo $option; ?>"><?php echo $option; ?></option>
                                <?php endif ?>
                            <?php endforeach ?>
                        </select>
                        <td>
                    </tr>
                    <?php endforeach ?>
                    <!--    If there are no groups terms, display a message.   -->
                <?php else : ?>
                    _e('There are no groups available.);
                    }
                <?php endif;?>
        </tr>
    </table>
    <input type="hidden" id="user_id" name="user_id" value="<?php echo $userId; ?>"><br>
    <input type="hidden" id="action" name="act" value="updateUserGroups"><br>
    <p class="submit"><input name="update-user-goups" id="submit" class="button button-primary" value="Update User Groups" type="submit"></p>
</form>