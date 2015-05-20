

<div class="col-sm-10 col-md-10 col-no-padding">
    <div class="panel panel-default">
        <div class="panel-heading"><strong>Notifications</strong></div>

        <div class="panel-body">

            <?php foreach ($timeToNotificationMap as $dateLabel => $notifications):?>
            <div class="date-wrap">
                <strong><?php echo $dateLabel; ?></strong>
            </div>

            <?php foreach ($notifications as $notification): ?>
                <?php if ($notification->notification_status == 0) : ?>
                    <div class="row noti-item not-read">
                <?php else : ?>
                    <div class="row noti-item ">
                <?php endif ?>
                    <div class="col-sm-2 col-xs-3 noti-avatar">
                        <a href="<?php echo $notification->fromUserProfileUrl; ?>"><?php echo $notification->fromUserAvatarHtml; ?></a>
                    </div>
                    <div class="col-sm-10 col-xs-9 notification_link" id="<?php echo $notification->notification_id ?>">
                        <?php echo $notification->notification_text; ?>
                        <span class="noti-datetime"><?php echo $notification->timeLabel; ?></span>
                        <?php if ($notification->notification_type === LandBook_Constant::TYPE_ADD_FRIEND) : ?>
                        <a href="#" class="acceptRequestFriend_<?php echo $notification->notification_id ?>" ><?php echo 'Accept' ?></a>
                            |
                        <a href="#" class="rejectRequestFriend_<?php echo $notification->notification_id ?>" ><?php echo 'Reject' ?></a>
                        <?php endif ?>
                    </div>
                </div>
                        <div class="updateStatusError" style="display: none;"></div>
                <?php endforeach; ?><!-- End foreach of $notifications -->

                <div class="clearfix"></div>
                <?php endforeach; ?><!-- End foreach of $timeToNotificationMap -->

            </div>
        </div>
    </div>