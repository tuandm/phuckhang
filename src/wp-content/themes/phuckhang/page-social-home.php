<?php
  get_header();
?>

  <div id="social-home" class="content social-cotent">

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

        <div class="newpost-wrap">
          <form>
            <div class="form-group">
              <textarea class="form-control" rows="3"></textarea>
            </div>
            <div class="form-group pull-right">
              <button class="btn btn-primary" type="submit">Post</button>
            </div>
          </form>
        </div>

        <div class="clearfix"></div>

        <div class="new-feed-wrap">

          <div class="feed">
            <div class="row">
              <div class="person col-lg-3 col-xs-3">
                <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/avatar.png" height="100" width="100" alt="">
              </div>
              <div class="feed-content col-lg-9 col-xs-9">
                <p>
                  Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                  tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                  quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                  consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                  cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                  proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </p>
              </div>
            </div>
          </div>

          <div class="feed">
            <div class="row">
              <div class="person col-lg-3 col-xs-3">
                <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/avatar.png" height="100" width="100" alt="">
              </div>
              <div class="feed-content col-lg-9 col-xs-9">
                <p>
                  Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                  tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                  quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                  consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                  cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                  proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </p>
              </div>
            </div>
          </div>

          <div class="feed">
            <div class="row">
              <div class="person col-lg-3 col-xs-3">
                <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/avatar.png" height="100" width="100" alt="">
              </div>
              <div class="feed-content col-lg-9 col-xs-9">
                <p>
                  Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                  tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                  quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                  consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                  cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                  proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </p>
              </div>
            </div>
          </div>

          <div class="refresh">
            <i class="fa fa-3x fa-refresh fa-spin"></i>
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
