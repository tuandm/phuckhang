<?php
$mainContentHtmlClasses = 'col-lg-6 col-lg-offset-0 col-md-7 col-md-offset-0 col-sm-7 col-sm-offset-0 col-xs-10 col-xs-offset-1';
$rightContentHtmlClasses = 'col-lg-4';

if (is_page_template('page-landbook.php')) {
    $mainContentHtmlClasses = 'col-xs-12 col-sm-12 col-md-9 col-lg-9';
    $rightContentHtmlClasses .= ' hidden';
}

get_header();
?>

<?php if (isset($content)) : ?>
    <div id="user-profile" class="content social-cotent">
        <div class="row">
            <?php if (isset($content['left'])): ?>
                <?php echo $content['left']; ?>
            <?php endif; ?>

            <div class="<?php echo $mainContentHtmlClasses; ?>">
                <?php if (isset($currentUserId) && $currentUserId != 0): ?>
                    <?php echo $this->view('/user/statistics'); ?>
                <?php endif; ?>

                <?php if (isset($content['main'])): ?>
                    <?php echo $content['main']; ?>
                <?php endif; ?>
            </div>
            <div class="<?php echo $rightContentHtmlClasses; ?>">
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
