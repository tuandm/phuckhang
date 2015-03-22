<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Author: Storm
 */

?>


<form method="post" action="" enctype="multipart/form-data" />
    <label>Project Name :</label>
    <input type="text" placeholder="Project Name">
    <label>Upload file :</label>
    <input type="file" id="myFile" name="myFile"/>
    <input type="hidden" id="action" name="act" value="addProduct"><br>
    <input type="submit" value="Upload">
</form>
