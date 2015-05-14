<?php
echo $this->view('/userprofilepage/user_login_info',
    [
        'name'          => $data['name'],
        'title'         => $data['title'],
        'numFriends'    => $data['friend'],
        'numGroups'     => $data['group'],
    ]);
$this->load->library('permalink_util');
$url = new Permalink_Util();
?>
<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <strong class="pull-left">Tin Nhắn</strong>
        <div class="pull-right">
            <span class="badge" style="background-color: #0291F9;"><?php echo $data['unreadMessages'] ?></span> (Chưa Đọc)
        </div>
    </div>

    <div class="panel-body">
        <?php foreach ($data['messages'] as $message) : ?>
            <div class="row noti-item">
                <!--                --><?php //endif ?>
                <div class="col-sm-2 col-xs-3 noti-avatar">
                    <a href="<?php echo $url->buildUserProfileUrl($message['sender_id']) ?>"><?php echo get_simple_local_avatar($message['sender_id'], 50) ?></a>
                </div>
                <div class="col-sm-10 col-xs-9">
                    <strong><a href="<?php echo $url->buildUserProfileUrl($message['sender_id']) ?>"><?php echo $message['sender_name'] ?></a></strong>
                    </br>
                    <p>
                        <?php echo nl2br($message['message']) ?>
                    </p>
                </div>
            </div>
        <?php endforeach ?>
        <?php $this->view('/message/user_message', array('senderId' => $senderId)) ?>
    </div>
</div>
