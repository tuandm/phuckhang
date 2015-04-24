<?php
/**
 * Created by PhpStorm.
 * User: Storm
 * Date: 3/24/15
 * Time: 10:46 AM
 */
$current_userId = wp_get_current_user()->ID;
$this->load->library('permalink_util');
$url = new Permalink_Util;
?>

<div class="newpost-wrap">
    <span class="user-span-control"><?php echo $group->name; ?></span></br>
    <span>member: <?php echo count($usersInGroup); ?></span>
    <?php foreach($usersInGroup as $user): ?>
        <?php $group_ids[] = $user['user_id']?>
        <a href="<?php echo $url->buildUserProfileUrl($user['user_id']); ?>"><?php echo get_avatar($user['user_id'], 20); ?></a>
    <?php endforeach; ?>
    <?php if(in_array(strval($current_userId), $group_ids)) : ?>
        <?php echo $this->view('/user/group/group_notice') ?>
    <?php endif; ?>
    <div class="clearfix"></div>
</div>

<div class="clearfix" id="user_notice_separate">
    <?php echo $this->view('/user/group/notice_content') ?>
</div>
