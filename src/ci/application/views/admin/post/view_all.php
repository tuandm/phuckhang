<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    /**
    * Author: Duc Duong
    */
?>
<form method="post">
<input type="hidden" name="page" value="ttest_list_table">
<?php
    $post->search_box( 'search', 'search_id' );
    $post->display();
    echo '</form></div>';