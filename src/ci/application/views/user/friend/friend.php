<?php
/**
 * Created by PhpStorm.
 * User: Storm
 * Date: 3/24/15
 * Time: 10:46 AM
 */
$currentUser = wp_get_current_user();
$this->load->library('permalink_util');
$url = new Permalink_Util;
?>
<div class="photo-wrap">
    <div class="row" id="finalResult">
        <?php foreach ( $friends as $friend ): ?>
            <div class="col-md-3 col-sm-4 col-xs-6 photo-item friend-item">
                <a href="<?php echo $url->buildUserProfileUrl($friend['friend_id']); ?>" class="img-responsive"><?php echo get_avatar( $friend['friend_id'], 150 ); ?></a>
                <a href="<?php echo $url->buildUserProfileUrl($friend['friend_id']); ?>"><span class="friend-name"><?php echo $friend['display_name']; ?></span></a>
                <?php $user = new WP_User( $friend['friend_id'] ); ?>
                <span class="friend-role"><?php echo $user->roles[0]; ?></span>
                <?php if (isset($currentUser->ID) && ($currentUser->ID == $friend['user_id'])) : ?>
                    <a href="?act=removeFriend&userId=<?php echo $friend['user_id']; ?>&friendId=<?php echo $friend['friend_id']; ?>">Xoá</a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>