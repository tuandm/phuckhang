<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Author: Phat Nguyen
 */
?>
<h2>PRODUCTS MANAGEMENT</h2>
<div class="alignleft actions">
<form id="filter" class="filter" action='' method="post">
    <input type="hidden" id="action" name="act" value="filterAction"><br>
    <?php
    if ($this->input->post('status') != 0) {
        $statusVal = $this->input->post('status');
    } else {
        $statusVal = 0;
    }
    echo form_dropdown('status', $statusNames, $statusVal);?>
    <input class="button" type="submit" name="filter_action" value="Filter"/>
<?php
    echo '<input type="hidden" name="act" value="filterAction"><br>';
    $productTable->search_box('search', 'search_id');
?>
</form>
</div>
<?php
$productTable->display();

?>
<form method="post" action="" enctype="multipart/form-data" />
    <label>Project Name :</label>
    <input type="text" placeholder="Project Name">
    <label>Upload file :</label>
    <input type="file" id="myFile" name="myFile"/>
    <input type="hidden" id="action" name="act" value="addProduct"><br>
    <input type="submit" value="Upload">
</form>
