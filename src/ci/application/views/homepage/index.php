<div id="social-home" class="content social-cotent">

    <div class="row">
        <?php echo $this->view('layout/partial/left_content.php', ['userId' => get_current_user_id(), 'userGroupNames' => $groupNames]) ?>
        <div class="col-lg-6 col-lg-offset-0 col-md-7 col-md-offset-0 col-sm-7 col-sm-offset-0 col-xs-10 col-xs-offset-1">
            <!-- User status -->
            <?php if (get_current_user_id()) : ?>
                <?php echo $this->view('/layout/partial/user_status') ?>
            <?php endif ?>
            <!-- User status -->
            <div class="clearfix" id="user_status_separate"></div>
            <?php echo $this->view('/homepage/user_feed') ?>
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
