<?php
/**
 * Created by PhpStorm.
 * User: Storm
 * Date: 3/24/15
 * Time: 10:46 AM
 */
$currentUserId = get_current_user_id();
$this->load->library('permalink_util');
$url = new Permalink_Util;
?>

<div class="newpost-wrap txtGroup" id="<?php echo $groupId ?>">
    <span class="user-span-control"><?php echo $group->name; ?></span></br>
    <span>member: <?php echo count($usersInGroup); ?></span>

    <?php foreach($usersInGroup as $user): ?>
        <?php $userInGroupIds[] = $user['user_id']?>
        <a href="<?php echo $url->buildUserProfileUrl($user['user_id']); ?>"> <?php echo get_avatar($user['user_id'], 20); ?></a>
    <?php endforeach; ?>

    <?php if(in_array($currentUserId, $userInGroupIds)) : ?>
        <?php echo $this->view('/user/group/add_group_status', array('groupId' => $groupId)) ?>
    <?php endif; ?>

<div class="clearfix" id="user_status_separate"></div>
    <?php echo $this->view('/user/group/group_feed') ?>
</div>
