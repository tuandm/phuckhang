<?php
get_header();
?>
<div id="user-profile" class="content social-cotent">
  <div class="row">

    <div class="col-lg-2 col-lg-offset-0 col-md-offset-1 col-md-3 col-sm-offset-1 col-sm-3 col-xs-11 col-xs-offset-1">
      <div class="avatar">
        <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/avatar.png" height="150" width="150" alt="">
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
    </div>
    <!-- end left sidebar -->
    <div class="col-lg-6 col-lg-offset-0 col-md-7 col-md-offset-0 col-sm-7 col-sm-offset-0 col-xs-10 col-xs-offset-1">

      <div class="row user-info">
        <div class="col-md-4 col-sm-4 col-xs-12">
          <span class="user-span-control">NGUYỄN VĂN A</span><br />
          <span>project manager</span>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12">
          <span class="user-span-control">FRIENDS</span><br />
          <span>20</span>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12">
          <span class="user-span-control">GROUPS</span><br />
          <span>6</span>
        </div>
      </div>
      <!-- end row user-info -->
      <div class="panel panel-default">
        <div class="panel-heading"><strong>Notification</strong></div>
        <div class="panel-body">

          <div class="date-wrap">
            <strong>Hôm Nay</strong>
          </div>

          <div class="row noti-item">
            <div class="col-sm-2 col-xs-3 noti-avatar">
              <a href="#"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/avatar.png" height="50" width="50" alt=""></a>
            </div>
            <div class="col-sm-10 col-xs-9">
              <strong><a href="#">Phát Trí Nguyễn</a></strong> và <strong><a href="#">Anh Tũn</a></strong> vừa thích một <a href="#">hình ảnh</a> của bạn.
              <span class="noti-datetime">10 phút trước</span>
            </div>
          </div>

          <div class="row noti-item">
            <div class="col-sm-2 col-xs-3 noti-avatar">
              <a href="#"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/avatar.png" height="50" width="50" alt=""></a>
            </div>
            <div class="col-sm-10 col-xs-9">
              <strong><a href="#">Phát Trí Nguyễn</a></strong> vừa bình luận <a href="#">trạng thái</a> của bạn.
              <span class="noti-datetime">20 phút trước</span>
            </div>
          </div>

          <div class="clearfix"></div>

          <div class="date-wrap">
            <strong>25.03.2015</strong>
          </div>

          <div class="row noti-item">
            <div class="col-sm-2 col-xs-3 noti-avatar">
              <a href="#"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/avatar.png" height="50" width="50" alt=""></a>
            </div>
            <div class="col-sm-10 col-xs-9">
              <strong><a href="#">Phát Trí Nguyễn</a></strong> và <strong><a href="#">Anh Tũn</a></strong> vừa thích một <a href="#">hình ảnh</a> của bạn.
              <span class="noti-datetime">15h 25.03.2015</span>
            </div>
          </div>

          <div class="row noti-item">
            <div class="col-sm-2 col-xs-3 noti-avatar">
              <a href="#"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/avatar.png" height="50" width="50" alt=""></a>
            </div>
            <div class="col-sm-10 col-xs-9">
              <strong><a href="#">Phát Trí Nguyễn</a></strong> vừa bình luận <a href="#">trạng thái</a> của bạn.
              <span class="noti-datetime">15h 25.03.2015</span>
            </div>
          </div>

          <div class="row noti-item">
            <div class="col-sm-2 col-xs-3 noti-avatar">
              <a href="#"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/avatar.png" height="50" width="50" alt=""></a>
            </div>
            <div class="col-sm-10 col-xs-9">
              <strong><a href="#">Phát Trí Nguyễn</a></strong> và <strong><a href="#">Anh Tũn</a></strong> vừa thích một <a href="#">hình ảnh</a> của bạn.
              <span class="noti-datetime">15h 25.03.2015</span>
            </div>
          </div>

          <div class="row noti-item">
            <div class="col-sm-2 col-xs-3 noti-avatar">
              <a href="#"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/avatar.png" height="50" width="50" alt=""></a>
            </div>
            <div class="col-sm-10 col-xs-9">
              <strong><a href="#">Phát Trí Nguyễn</a></strong> vừa bình luận <a href="#">trạng thái</a> của bạn.
              <span class="noti-datetime">15h 25.03.2015</span>
            </div>
          </div>

        </div>
      </div>
    </div>
    <!-- end middle cotent -->
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
    <!-- end right sidebar -->
  </div>
</div>
<div class="clearfix"></div>
<div class="horizontal-footer"></div>
<?php get_footer(); ?>