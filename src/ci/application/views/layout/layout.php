<?php
    get_header();
?>

<?php if (isset($content)) : ?>
    <div id="user-profile" class="content social-cotent">
        <div class="row">
                <?php echo $content['left']; ?>
            <div class="col-lg-6 col-lg-offset-0 col-md-7 col-md-offset-0 col-sm-7 col-sm-offset-0 col-xs-10 col-xs-offset-1">
                <?php echo $content['main']; ?>
            </div>
            <div class="hidden-xs hidden-sm hidden-md col-lg-4">
                <?php echo $content['right']; ?>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="horizontal-footer"></div>
<?php endif ?>
<?php
    get_footer();
?>
