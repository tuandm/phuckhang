<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Author: Storm
 */
$this->load->helper('url');
$user = wp_get_current_user();
?>

<?php if (isset($user->ID) && ($user->ID == $photos[1]['user_id'])) : ?>
<form method="post" action="" enctype="multipart/form-data" />
    <label>Upload images :</label>
    <input type="file" id="myImages" name="myImages"/>
    <input type="hidden" id="action" name="act" value="addImages"><br>
    <label>Descriptions :</label>
    <textarea name="txtDescription" required></textarea>
    <input type="submit" value="Upload">
</form>
<?php endif;?>
<h2>PHOTOS</h2>
<?php foreach ($photos as $photo): ?>
    <image src="<?php echo base_url().'ci/'.$photo['path'].$photo['name']; ?>" style="width: 200px; height: 200px"></image>
<?php endforeach; ?>