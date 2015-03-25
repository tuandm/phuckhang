<?php
global $user;
var_dump(get_current_user_id());
//    echo '<br>';
//    echo 'Title: ' . $title;
//    echo '<br>';
//    echo 'Phone: ' . $phone;
//    echo '<br>';
//    echo 'Name: ' . $info['user_nicename'];
//    echo '<br>';
//    echo 'Email: ' . $info['user_email'];
//    echo '<br>';
//    echo 'Group: ' . $numGroups;
//    echo '<br>';
//    echo 'Friend: ' . $friends['numFriend'];
//    echo '<br>';
//    echo 'Friend List: ';
//    $listFriends = $friends['friendId'];
//        foreach ($listFriends as $friend) {
//            var_dump($friend);
//            echo (get_simple_local_avatar($friend));
//        }
//    echo '<br>';
//
//    echo '<a href="?act=index"> Back</a>';
?>
<div id="user-profile" class="content social-cotent">
    <div class="row">
        <div class="col-lg-2 col-lg-offset-0 col-md-offset-1 col-md-3 col-sm-offset-1 col-sm-3 col-xs-11 col-xs-offset-1">
            <?php if ($userId == get_current_user_id()): ?>

                <div class="avatar">
                    <?php echo (get_simple_local_avatar($userId, 150)); ?>
                </div>


                <div class="group-wrap">
                    <h4>GROUP</h4>
                    <ul class="group-links">
                        <li class="group-item"><a href="#"><i class="fa fa-users"></i><span> Lorem ipsum dolor sit amet</span></a></li>
                        <li class="group-item"><a href="#"><i class="fa fa-users"></i><span> Consectetaur adipisicing elit</span></a></li>
                        <li class="group-item"><a href="#"><i class="fa fa-users"></i><span> Excepteur sint occaecat cupid</span></a></li>
                        <li class="group-item"><a href="#"><i class="fa fa-users"></i><span> Onsectetaur adipisicing elit</span></a></li>
                        <li class="group-item"><a href="#"><i class="fa fa-users"></i><span> Excepteur sint occaecat cupid</span></a></li>
                        <li class="group-item"><a href="#"><i class="fa fa-users"></i><span> Sunt in culpa qui offi</span></a></li>
                    </ul>
                </div>
            <?php endif ?>

        </div>

        <div class="col-lg-6 col-lg-offset-0 col-md-7 col-md-offset-0 col-sm-7 col-sm-offset-0 col-xs-10 col-xs-offset-1">

            <div class="row user-info">
                <?php if ($userId == get_current_user_id()): ?>
                <div class="col-md-3">
                    <span class="user-span-control"><?php echo $info['user_nicename']; ?></span>
                    </br>
                    <span><?php echo $title; ?></span>
                </div>
                <div class="col-md-3">
                    <span class="user-span-control">FRIENDS</span>
                    </br>
                    <span><?php echo $friends['numFriend']; ?></span>
                </div>
                <div class="col-md-3">
                    <span class="user-span-control">GROUPS</span>
                    </br>
                    <span><?php  echo $numGroups; ?></span>
                </div>
                <?php endif ?>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading"><strong>Thông Tin <?php echo $info['user_nicename']; ?></strong></div>
                <div class="panel-body">
                    <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
                        <li class="active">Thông tin chung </li>
                    </ul>
                    <div class="row">
                        <div class="col-sm-3">
                            <?php echo (get_simple_local_avatar($userId, 150)); ?>
                        </div>
                        <div class="col-lg-6">
                            <div class="tab-content">
                                <div class="tab-pane active" id="profile-category-1">
                                    <form class="form-horizontal" role="form">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Họ Tên</label>
                                            <div class="col-sm-9">
                                                <p class="form-control-static"><?php echo $info['user_nicename']; ?></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Chức Vụ</label>
                                            <div class="col-sm-9">
                                                <p class="form-control-static"><?php echo $title; ?></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Số Điện Thoại</label>
                                            <div class="col-sm-9">
                                                <p class="form-control-static"><?php echo $phone; ?></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Email</label>
                                            <div class="col-sm-9">
                                                <p class="form-control-static"><?php echo $info['user_email']; ?></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Sinh Nhật</label>
                                            <div class="col-sm-9">
                                                <p class="form-control-static"><?php echo $dob; ?></p>
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
                        <?php $listFriends = $friends['friendId']; ?>
                        <?php foreach ($listFriends as $friend): ?>
                            <div class="col-sm-1">
                                <a href="?act=view&userId=<?php echo $friend; ?>"><?php echo (get_simple_local_avatar($friend, 50)); ?></a>
                            </div>
                        <?php endforeach ?>
                        <div class="col-sm-3 pull-right" >
                            <a href="#">Xem Thêm...</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="hidden-xs hidden-sm hidden-md col-lg-4">

            <div class="social-sidebar">

                <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
                    <li class=""><a href="#red" data-toggle="tab"><i class="fa fa-2x fa-user"></i> </a></li>
                    <li class="active"><a href="#orange" data-toggle="tab"><i class="fa fa-2x fa-comments"></i></a></li>
                    <li><a href="#yellow" data-toggle="tab"><i class="fa fa-2x fa-globe"></i></a></li>
                </ul>

                <div class="tab-content">
                    <textarea class="message" rows="5"></textarea>
                </div>


            </div>


        </div>


    </div>

</div>

<div class="clearfix"></div>

<div class="horizontal-footer"></div>