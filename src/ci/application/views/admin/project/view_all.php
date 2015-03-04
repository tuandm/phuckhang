<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Author: Duc Duong
 */
?>
<div class="alignleft actions">
<form id="category-select" class="category-select" action='' method="post">
<?php

?>
    <input type="hidden" id="action" name="act" value="filterAction"><br>
    <input class="button" type="submit" name="filter_action" value="Filter" />
<?php
    echo '<input type="hidden" name="act" value="filterAction"><br>';
    $projTable->search_box('search', 'search_id');
?>
    </form>
</div>
<?php
$projTable->display();