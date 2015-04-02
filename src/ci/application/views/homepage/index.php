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
            <!-- User status -->
            <?php if (get_current_user_id()) : ?>
                <?php echo $this->view('/layout/partial/user_status') ?>
            <?php endif ?>
            <!-- User status -->
            <div class="clearfix"></div>
            <?php echo $this->view('/homepage/user_feed'); ?>
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