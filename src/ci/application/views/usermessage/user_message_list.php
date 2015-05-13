<?php
echo $this->view('/userprofilepage/user_login_info',
    [
        'name'          => $loginUser['name'],
        'title'         => $loginUser['title'],
        'numFriends'    => $loginUser['numFriends'],
        'numGroups'     => $loginUser['numGroups'],
    ]);
?>
<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <strong class="pull-left">Tin Nhắn</strong>
        <div class="pull-right">
            <a href="#" class="btn btn-default btn-sm">Nhắn tin mới</a>
            <a href="#">(Chưa Đọc) <span class="badge" style="background-color: #0291F9;">2</span></a>
        </div>
    </div>

    <div class="panel-body">
        <ul class="list-group">

            <li class="list-group-item not-read" onclick="location.href='#';" style="cursor: pointer;">
                <div class="row noti-item">
                    <div class="col-sm-2 col-xs-3 noti-avatar">
                        <a href="#"><img src="images/avatar.png" height="50" width="50" alt=""></a>
                    </div>
                    <div class="col-sm-10 col-xs-9">
                        <strong><a href="#">Phát Trí Nguyễn</a></strong>
                        </br>
                        Hôm nay trời nắng quá, làm ly bia đi.
                        <span class="noti-datetime">10 phút trước</span>
                    </div>
                </div>
            </li>

            <li class="list-group-item not-read" onclick="location.href='#';" style="cursor: pointer;">
                <div class="row noti-item">
                    <div class="col-sm-2 col-xs-3 noti-avatar">
                        <a href="#"><img src="images/avatar.png" height="50" width="50" alt=""></a>
                    </div>
                    <div class="col-sm-10 col-xs-9">
                        <strong><a href="#">Phát Trí Nguyễn</a></strong>
                        </br>
                        Hôm nay trời nắng quá, làm ly bia đi.
                        <span class="noti-datetime">10 phút trước</span>
                    </div>
                </div>
            </li>

            <li class="list-group-item" onclick="location.href='#';" style="cursor: pointer;">
                <div class="row noti-item">
                    <div class="col-sm-2 col-xs-3 noti-avatar">
                        <a href="#"><img src="images/avatar.png" height="50" width="50" alt=""></a>
                    </div>
                    <div class="col-sm-10 col-xs-9">
                        <strong><a href="#">Phát Trí Nguyễn</a></strong>
                        </br>
                        Hôm nay trời nắng quá, làm ly bia đi.
                        <span class="noti-datetime">10 phút trước</span>
                    </div>
                </div>
            </li>

            <li class="list-group-item" onclick="location.href='#';" style="cursor: pointer;">
                <div class="row noti-item">
                    <div class="col-sm-2 col-xs-3 noti-avatar">
                        <a href="#"><img src="images/avatar.png" height="50" width="50" alt=""></a>
                    </div>
                    <div class="col-sm-10 col-xs-9">
                        <strong><a href="#">Phát Trí Nguyễn</a></strong>
                        </br>
                        Hôm nay trời nắng quá, làm ly bia đi.
                        <span class="noti-datetime">10 phút trước</span>
                    </div>
                </div>
            </li>

        </ul>

        <div class="refresh">
            <i class="fa fa-3x fa-refresh fa-spin"></i>
        </div>

    </div>
</div>
