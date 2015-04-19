<?php
get_header();
?>

<?php if (isset($content)) : ?>
    <div id="user-profile" class="content social-cotent">
        <div class="row">
            <?php if (isset($content['left'])): ?>
                <?php echo $content['left']; ?>
            <?php endif; ?>
            <div class="col-lg-6 col-lg-offset-0 col-md-7 col-md-offset-0 col-sm-7 col-sm-offset-0 col-xs-10 col-xs-offset-1">
                <?php if (isset($content['main'])): ?>
                    <?php echo $content['main']; ?>
                <?php endif; ?>
            </div>
            <div class="hidden-xs hidden-sm hidden-md col-lg-4">
                <?php if (isset($content['right'])): ?>
                    <?php echo $content['right']; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="horizontal-footer"></div>
<?php endif ?>
<?php
get_footer();
?>
