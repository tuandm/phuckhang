<?php
/**
 * Created by PhpStorm.
 * User: PN
 * Date: 3/26/2015
 * Time: 11:58 PM
 */
?>
<div class="col-lg-2 col-lg-offset-0 col-md-offset-1 col-md-3 col-sm-offset-1 col-sm-3 col-xs-11 col-xs-offset-1">
<div class="avatar">
    <?php echo (get_simple_local_avatar($userId, 150)); ?>
</div>
<div class="group-wrap">
    <h4>GROUP</h4>
    <ul class="group-links">
        <?php if (isset($groupNames) && !empty($groupNames)) : ?>
            <?php foreach ($groupNames as $group) : ?>
                <li class="group-item"><a href="#"><i class="fa fa-users"></i><span> <?php echo $group; ?></span></a></li>
            <?php endforeach ?>
        <?php else : ?>
            <?php echo 'There is no group'; ?>
        <?php endif ?>
    </ul>
</div>

</div>
