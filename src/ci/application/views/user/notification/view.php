

<div class="col-sm-10 col-md-10 col-no-padding">
    <div class="panel panel-default">
        <div class="panel-heading"><strong>Notifications</strong></div>

        <div class="panel-body">

            <?php foreach ($timeToNotificationMap as $dateLabel => $notifications):?>
            <div class="date-wrap">
                <strong><?php echo $dateLabel; ?></strong>
            </div>

            <?php foreach ($notifications as $notification): ?>
            <div class="row noti-item">
                <div class="col-sm-2 col-xs-3 noti-avatar">
                    <a href="<?php echo $notification->fromUserProfileUrl; ?>"><?php echo $notification->fromUserAvatarHtml; ?></a>
                </div>
                <div class="col-sm-10 col-xs-9">
                    <?php echo $notification->notification_text; ?>
                    <span class="noti-datetime"><?php echo $notification->timeLabel; ?></span>
                </div>
            </div>
            <?php endforeach; ?><!-- End foreach of $notifications -->

            <div class="clearfix"></div>
            <?php endforeach; ?><!-- End foreach of $timeToNotificationMap -->

        </div>
    </div>
</div>