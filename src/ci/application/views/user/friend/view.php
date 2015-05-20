<?php
/**
 * Created by PhpStorm.
 * User: Storm
 * Date: 3/24/15
 * Time: 10:46 AM
 */
get_header();
$currentUser = wp_get_current_user();
$this->load->library('permalink_util');
$url = new Permalink_Util();
echo $this->view('/userprofilepage/user_login_info',
    [
        'name'          => $data['name'],
        'title'         => $data['title'],
        'numFriends'    => $data['friend'],
        'numGroups'     => $data['group'],
    ]);
?>
    <div id ="user-profile" class="content social-cotent">
        <div class="row">
            <!-- end left sidebar -->
                <!-- end row user-info -->
                <div class="photo-header">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <h4 class="text-primary">Bạn bè</h4>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <input type="text" class="form-control" name="searchFriend" id="search" value="" placeholder="Tìm bạn">
                        </div>
                    </div>
                </div>
                <?php echo $this->view('/user/friend/friend'); ?>
            </div>
            <!-- end middle cotent -->
    </div>
    <div class="clearfix"></div>
    <div class="horizontal-footer"></div>
<?php get_footer(); ?>
<script>
    var base_url = "<?=base_url()?>";
</script>
<script>
