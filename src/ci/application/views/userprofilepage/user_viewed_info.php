<?php
/**
 * Created by PhpStorm.
 * User: PN
 * Date: 3/28/2015
 * Time: 12:44 AM
 */
?>
<div class="panel panel-default">
    <div class="panel-heading"><strong>Thông Tin <?php echo $name ?></strong></div>
    <div class="panel-body">
        <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
            <li class="active">Thông tin chung </li>
        </ul>
        <div class="row">
            <div class="col-sm-3">
                <?php echo (get_simple_local_avatar($userId, 150)) ?>
            </div>
            <div class="col-sm-9">
                <div class="tab-content">
                    <div class="tab-pane active" id="profile-category-1">
                        <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <label class="col-md-6 control-label">Họ Tên</label>
                                <div class="col-sm-6">
                                    <p class="form-control-static"><?php echo $name ?></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-6 control-label">Chức Vụ</label>
                                <div class="col-sm-6">
                                    <p class="form-control-static"><?php echo $title ?></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-6 control-label">Số Điện Thoại</label>
                                <div class="col-sm-6">
                                    <p class="form-control-static"><?php echo $phone ?></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-6 control-label">Email</label>
                                <div class="col-sm-6">
                                    <p class="form-control-static"><?php echo $email ?></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-6 control-label">Sinh Nhật</label>
                                <div class="col-sm-6">
                                    <p class="form-control-static"><?php echo $dob ?></p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
            <li class="active">Bạn Bè</li>
        </ul>
        <div class="row">
            <?php if ($numFriends === 0) : ?>
            <div class="col-sm-9">
                <?php echo 'Người dùng này hiện không có bạn bè.'; ?>
            </div>
            <?php else : ?>
                <div class="col-sm-9 info-friend">
                <?php foreach ($friendIds as $friend) : ?>
                        <a href="?act=index&userId=<?php echo $friend; ?>"><?php echo (get_simple_local_avatar($friend, 50)); ?></a>
                <?php endforeach ?>
                </div>
                <div class="col-sm-3 pull-right">
                    <a href="#">Xem Thêm...</a>
                </div>
            <?php endif ?>
        </div>

    </div>
</div>
