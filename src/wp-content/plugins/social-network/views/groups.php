    <h2>GROUP MANAGEMENT</h2>
    <div>
        </br>
        <br/>
        <div></div>
        <table border="1">
            <thead>
                <tr>
                    <th><?php _e('SC User Group ID');?></th>
                    <th><?php _e('Group ID');?></th>
                    <th><?php _e('Decriptions');?></th>
                    <th><?php _e('Users In Group');?></th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th><?php _e('SC User Group ID');?></th>
                    <th><?php _e('Group ID');?></th>
                    <th><?php _e('Decriptions');?></th>
                    <th><?php _e('Users In Group');?></th>
                </tr>
            </tfoot>
            <tbody>
                <?php
                foreach( $groups as $gr ):
                ?>
                    <tr>
                        <td><?php echo $gr->sc_user_groups_id;?></td>
                        <td><?php echo $gr->group_id;?></td>
                        <td><?php echo $gr->description;?></td>
                        <td><?php echo $gr->user_count;?></td>
                    </tr>
                <?php
                endforeach;
                ?>
            </tbody>
        </table>
    </div>
    
