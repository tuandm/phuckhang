<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Author: Duc Duong
 */
?>
<div class="alignleft actions">
<form id="filter" class="filter" action='' method="post">
    <input type="hidden" id="action" name="act" value="filterAction"><br>
    <?php echo form_dropdown('status', $statusNames ,$statusNames[1]);?>
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
