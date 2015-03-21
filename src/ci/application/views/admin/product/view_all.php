<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Author: Phat Nguyen
 */
?>
<h2>PRODUCTS MANAGEMENT</h2>
<div class="alignleft actions">
<form id="filter" class="filter" action='' method="get">
    <input type="hidden" id="action" name="page" value="landbook-products"><br>
    <input type="hidden" id="action" name="act" value="filterAction"><br>
    <?php   if ($this->input->get('status') != 0) :?>
    <?php       $statusVal = $this->input->get('status');?>
    <?php   else :?>
    <?php       $statusVal = 0;?>
    <?php   endif?>
    <?php echo form_dropdown('status', $statusNames, $statusVal);?>
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
