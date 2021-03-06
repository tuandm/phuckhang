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

          <div class="col-lg-6 col-lg-offset-0 col-md-7 col-md-offset-0 col-sm-7 col-sm-offset-0 col-xs-10 col-xs-offset-1">

            <div class="row user-info">
              <div class="col-md-3">
                <span class="user-span-control">NGUYỄN VĂN A</span>
              </br>
              <span>project manager</span>
            </div>
            <div class="col-md-3">
              <span class="user-span-control">FRIENDS</span>
            </br>
            <span>20</span>
          </div>
          <div class="col-md-3">
            <span class="user-span-control">GROUPS</span>
          </br>
          <span>2</span>
        </div>
      </div>

      <div class="panel panel-default">
          <div class="panel-heading clearfix">
            <strong class="pull-left">Tin Nhắn</strong>
           <div class="pull-right">
            <a href="#" class="btn btn-default btn-sm">Nhắn tin mới</a>
            <a href="#">(Chưa Đọc) <span class="badge" style="background-color: #0291F9;">2</span></a>
          </div>
          </div>
          
            <div class="panel panel-default">
          <div class="panel-heading"><strong>Phát Trí Nguyễn</strong></div>
            <div class="panel-body">

                    <div class="row noti-item">
                      <div class="col-sm-2 col-xs-3 noti-avatar">
                        <a href="#"><img src="images/avatar.png" height="50" width="50" alt=""></a>
                      </div>
                      <div class="col-sm-10 col-xs-9">
                        <strong><a href="#">Phát Trí Nguyễn</a></strong> 
                      </br>
                      <p>Hôm nay trời nắng quá, làm ly bia đi.</p>
                      <p>Hôm nay trời nắng quá, làm ly bia đi.</p>
                      <p>Hôm nay trời nắng quá, làm ly bia đi.</p>
                      <p>Hôm nay trời nắng quá, làm ly bia đi.</p>
                      <p>Hôm nay trời nắng quá, làm ly bia đi.</p>
                      <p>Hôm nay trời nắng quá, làm ly bia đi.</p>
                      </div>
                    </div> 
                    <div class="row noti-item">
                      <div class="col-sm-2 col-xs-3 noti-avatar">
                        <a href="#"><img src="images/avatar.png" height="50" width="50" alt=""></a>
                      </div>
                      <div class="col-sm-10 col-xs-9">
                        <strong><a href="#">Anh Tũn</a></strong> 
                      </br>
                        <p>Chơi lun</p>
                        <p>ở đâu?</p>
                        <p>Mấy giờ?</p>
                      </div>
                    </div>

                    <div class="newpost-wrap">
                      <form>
                        <div class="form-group">
                          <textarea class="form-control" rows="3"></textarea>
                        </div>
                        <div class="form-group pull-right">
                          <button class="btn btn-primary" type="submit">Gởi</button>
                        </div>
                      </form>
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

<?php get_footer(); ?>
