<?php
class LandBook_View_Group
{
    public function selectUserGroup($user)
    {
        $groupModel = new LandBook_Model_Group();
        $tax = get_taxonomy('sc_group');
        $results = $groupModel->getGroupIdByUserId($user);
        // Make sure the user can assign terms of the sc_group taxonomy before proceeding.
        if (!current_user_can($tax->cap->assign_terms))
            return;
        // Get the terms of the 'sc_group' taxonomy
        $terms = get_terms('sc_group', array('hide_empty' => false));
        // If there are any profession terms, loop through them and display checkboxes.?>
        <h3><?php _e('Group');?></h3>
        <table class="form-table">
            <tr>
                <th><label for="group"><?php _e('Select Group'); ?></label></th>
                <td><?php if (!empty($terms)) :?>
                        <?php foreach ($terms as $term) : ?>
                            <?php $checkValue = in_array($term->term_id, $results)? 1 : 0; ?>
                            <input type="checkbox" name="group[]"
                                   id="group-<?php echo $term->name;?>"
                                   value="<?php echo $term->name; ?>" <?php checked($checkValue, 1); ?> />
                            <label for="group-<?php echo esc_attr($term->name); ?>">
                                <?php echo $term->name; ?>
                            </label> <br />
                        <?php endforeach;?>
                        <!--    If there are no groups terms, display a message.   -->
                    <?php else :?>
                        _e('There are no groups available.');
                        }
                    <?php endif;?>
                </td>
            </tr>
        </table>
<?php
    }

}

