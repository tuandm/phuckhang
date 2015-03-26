<?php
/**
 * Created by PhpStorm.
 * User: Storm
 * Date: 3/24/15
 * Time: 10:46 AM
 */
$currentUser = wp_get_current_user();
$this->load->library('permalink_util');
$url = new Permalink_Util();
?>
<?php foreach ( $friends as $friend ): ?>
    <a href="<?php echo $url->getUrl('Social User Photo', 'user', $friend['friend_id']); ?>"><?php echo get_avatar( $friend['friend_id'], 100 ); ?></a>
    <?php echo $friend['display_name']; ?>
    <?php $user = new WP_User( $friend['friend_id'] ); ?>
    <?php echo $user->roles[0]; ?>
    <?php if (isset($currentUser->ID) && ($currentUser->ID == $friend['user_id'])) : ?>
        <a href="?act=removeFriend&userId=<?php echo $friend['user_id']; ?>&friendId=<?php echo $friend['friend_id']; ?>">Remove</a>
    <?php endif; ?>
<?php endforeach; ?>