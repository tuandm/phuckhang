<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Author: Storm
 */
$this->load->helper('url');
$user = wp_get_current_user();
?>
<div class="photo-header">
    <div class="row">
        <div class="col-xs-4 col-sm-5">
            <h4 class="text-primary">Hình ảnh</h4>
        </div>
        <?php if (isset($user->ID) && ($user->ID == $photos[1]['user_id'])) : ?>
            <form method="post" action="" enctype="multipart/form-data" />
            <div class="fileUpload btn btn-primary">
                <span>Up hình ảnh mới</span>
                <input id="uploadBtn" type="file" class="upload" name="myImages"/>
            </div>
            <div class="col-xs-4 col-sm-4">
                <input type="text" name="txtDescription" id="uploadFile" class="form-control" required>
            </div>
                <input type="submit" placeholder="Upload" value="Upload">
                <input type="hidden" id="action" name="act" value="addImages">
            </form>
            <?php endif;?>
    </div>
</div>
<div class="photo-wrap">
    <div class="row">
        <?php foreach ($photos as $photo): ?>
            <div class="col-md-3 col-sm-4 col-xs-6 photo-item">
                <image src="<?php echo base_url().'ci/'.$photo['path'].$photo['name']; ?>" class="img-responsive" style="width: 200px;height: 200px;"></image>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<script>
    document.getElementById("uploadBtn").onchange = function () {
        document.getElementById("uploadFile").value = this.value;
    };
</script>