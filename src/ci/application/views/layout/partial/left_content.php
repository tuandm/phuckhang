<?php
/**
 * Created by PhpStorm.
 * User: PN
 * Date: 3/26/2015
 * Time: 11:58 PM
 */


if (is_page_template('page-landbook.php')) {
    $leftContentHtmlClasses = 'col-xs-12 col-sm-12 col-md-3 col-lg-3';
} else {
    $leftContentHtmlClasses = 'col-lg-2 col-lg-offset-0 col-md-offset-1 col-md-3 col-sm-offset-1 col-sm-3 col-xs-11 col-xs-offset-1';
}
?>
<div class="<?php echo $leftContentHtmlClasses;?>">
    <?php if (isset($userId)): ?>
    <div class="news-nav news-nav_feed text-uppercase">
        <span>Nhóm</span>
        <ul class="category-menu">
            <?php if (isset($groups) && !empty($groups)) : ?>
                <?php foreach ($groups as $group) : ?>
                    <li class="group-item"><a href="<?php echo $group->group_url; ?>"><?php echo $group->group_name; ?></a></li>
                <?php endforeach ?>
            <?php else : ?>
                <li>Bạn không trong nhóm nào</li>
            <?php endif ?>
        </ul>
    </div>
    <?php endif; ?>
</div>
