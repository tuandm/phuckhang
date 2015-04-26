<?php
$this->load->library('permalink_util');
$url = new Permalink_Util;
?>

<div class="panel panel-default">
    <div class="panel-body">
        <div class="panel-heading"><strong>Thông Báo</strong></div>
        <div class="feed">
            <div class="row">
                <div class="person col-lg-3 col-xs-3">
                    <a href="<?php echo $url->buildUserProfileUrl($notification['user_id']) ?>" ><?php echo get_simple_local_avatar($notification['user_id'], 100) ?></a>
                </div>
                <div class="feed-content col-lg-9 col-xs-9">
                    <p>
                        <?php echo $notification['status']?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
