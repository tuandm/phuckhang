<?php
/**
 * Created by PhpStorm.
 * User: PN
 * Date: 3/28/2015
 * Time: 12:35 AM
 */
?>
<div class="row user-info user-info-header">
    <div class="col-md-3">
        <span class="user-span-control"><?php echo $name ?></span>
        </br>
        <span><?php echo $title; ?></span>
    </div>
    <div class="col-md-3">
        <span class="user-span-control">FRIENDS</span>
        </br>
        <span><?php echo $numFriends; ?></span>
    </div>
    <div class="col-md-3">
        <span class="user-span-control">GROUPS</span>
        </br>
        <span><?php  echo $numGroups ?></span>
    </div>
</div>
