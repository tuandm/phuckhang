<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Author: Phat Nguyen
 */
?>
<h2>PROJECTS MANAGEMENT</h2>
<div class="alignleft actions">
    <form id="filter" class="filter" action='' method="get">
        <input type="hidden" id="action" name="page" value="landbook-projects"><br>
        <input type="hidden" id="action" name="act" value="filterAction"><br>
        <?php if ($this->input->get('status') != 0) :?>
        <?php   $statusVal = $this->input->get('status');?>
        <?php else :?>
        <?php   $statusVal = 0; ?>
        <?php endif?>
        <?php  echo form_dropdown('status', $statusNames, $statusVal);?>
        <input class="button" type="submit" name="filter_action" value="Filter"/>
        <?php
            echo '<input type="hidden" name="act" value="filterAction"><br>';
            $projTable->search_box('search', 'search_id');
        ?>
    </form>
    <form id="add-proj" class="add-project" action='' method="post">
        <?php
            submit_button('Add Project');
            echo '<input type="hidden" id="action" name="act" value="addProject"><br>';
        ?>
    </form>
</div>
<?php $projTable->display();
