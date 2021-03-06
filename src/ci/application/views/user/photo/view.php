<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Author: Storm
 */
$this->load->helper('url');
$userId = get_current_user_id();
?>
<div class="photo-header">
    <div class="row">
        <div class="col-xs-4 col-sm-5">
            <h4 class="text-primary">Hình ảnh</h4>
        </div>
        <?php if (isset($userId) && ($user == $userId)) : ?>
            <?php echo $this->view('/user/photo/add_photo') ?>
        <?php endif; ?>
    </div>
</div>
<div class="photo-wrap">
<?php echo $this->view('/user/photo/show_photos') ?>
</div>