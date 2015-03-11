<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
    /**
    * Author: Phat Nguyen
    */
?>
<div class="alignleft actions">
    <form id="category-select" class="category-select" action='' method="post">
<?php
    global $cat;
    $args = array(
                    'show_option_all'   => __('All categories'),
                    'hide_empty'        => 0,
                    'hierarchical'      => 1,
                    'show_count'        => 1,
                    'orderby'           => 'name',
                    'selected'          => $cat,
                    'taxonomy'          =>'sc_group'
                );
    wp_dropdown_categories($args); 
?>
    <input type="hidden" id="action" name="act" value="filter"><br>
    <input class="button" type="submit" name="filter_action" value="Filter" />
<?php
    echo '<input type="hidden" name="act" value="filter"><br>';
    $posts->search_box('search', 'search_id');
?>
    </form>
</div>
<?php
    $posts->display();
