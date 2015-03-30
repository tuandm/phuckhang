<?php
/**
 * Created by PhpStorm.
 * User: Storm
 * Date: 3/24/15
 * Time: 10:46 AM
 */
$current_user = wp_get_current_user();
$this->load->library('permalink_util');
$url = new Permalink_Util();
?>
<?php echo get_avatar($current_user->ID)?>
<?php echo $group->name; ?><br>
Member(<?php echo count($usersInGroup); ?>)
<?php foreach($usersInGroup as $user): ?>
<a href="<?php echo $url->getUrl('Social User Photo', 'user', $user['user_id']); ?>"><?php echo get_avatar($user['user_id'], 20); ?></a>
<?php endforeach; ?>
<form id="addtag" class="validate" action="" method="POST">
    <table class="form-table">
        <tbody>
        <tr class="form-field form-required term-name-wrap">
            <td><textarea name="txtPost" style="height: 100px; width: 450px;"></textarea></td>
        </tr>
    </table>
    <input type="hidden" id="action" name="act" value="post">
    <p class="submit"><input id='submit' type="submit" value="Post" name="btnPost"></p>
</form>