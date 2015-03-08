<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Author: Duc Duong
 */
?>
<h2>PROJECTS MANAGEMENT</h2>
<div class="alignleft actions">
<form id="filter" class="filter" action='' method="post">
    <input type="hidden" id="action" name="act" value="filterAction"><br>
    <?php
    if ($this->input->post('status') != 0) {
        $statusVal = $this->input->post('status');
    } else {
        $statusVal = 0;
    }
    echo form_dropdown('status', $statusNames , $statusVal);?>
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
<?php
if (isset($msg) && !empty($msg)) {
    echo '<script language="javascript">';
    echo "alert(\"$msg\")";
    echo '</script>';
}
$projTable->display();
