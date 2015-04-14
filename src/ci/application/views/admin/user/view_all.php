<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Author: Phat Nguyen
 */
?>
<h2>USERS MANAGEMENT</h2>
<div class="alignleft actions">
<form id="filter" class="filter" action='' method="get">
<?php
    global $cat;
    $cat = $this->input->get('cat');
    $args = array(
                    'show_option_all'   => __('All Groups'),
                    'hide_empty'        => 0,
                    'hierarchical'      => 0,
                    'show_count'        => 0,
                    'orderby'           => 'name',
                    'selected'          => $cat,
                    'taxonomy'          =>'sc_group'
                );
    wp_dropdown_categories($args); 
?>
    <?php
            echo '<input type="hidden" name="act" value="filter"><br>';
            $userTable->search_box('search', 'search_id');
    ?>
    <input type="hidden" id="action" name="noheader" value="true">
    <input type="hidden" id="action" name="page" value="landbook-users">
    <input type="hidden" id="action" name="act" value="filter"><br>
    <input class="button" type="submit" name="filter_action" value="Filter"/>
    <div>
    <br>
        <a href="/wp-admin/users.php">
            <input name="Add Groups For User" id="button" class="button button-primary" value="Add Groups For User" type="button">
        </a>
    </div>
</form>

</div>
<?php
    $userTable->display();

