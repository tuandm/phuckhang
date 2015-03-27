<div id="user-profile" class="content social-cotent">
    <div class="row">
        <?php echo $this->view('/userprofilepage/left_content', ['userId' => $loginUser['userId'], 'userGroupNames' => $loginUser['groupNames']]) ?>

        <div class="col-lg-6 col-lg-offset-0 col-md-7 col-md-offset-0 col-sm-7 col-sm-offset-0 col-xs-10 col-xs-offset-1">
            <?php echo $this->view('/userprofilepage/user_login_info',
                [
                    'name'          => $loginUser['name'],
                    'title'         => $loginUser['title'],
                    'numFriends'    => $loginUser['numFriends'],
                    'numGroups'     => $loginUser['numGroups'],
                ])
            ?>

            <?php echo $this->view('/userprofilepage/user_viewed_info',
                [
                    'userId'        => $viewedUser['userId'],
                    'title'         => $viewedUser['title'],
                    'phone'         => $viewedUser['phone'],
                    'name'          => $viewedUser['name'],
                    'email'         => $viewedUser['email'],
                    'dob'           => $viewedUser['dob'],
                    'numFriends'    => $loginUser['numFriends'],
                    'friendIds'     => $loginUser['friendIds']
                ])
            ?>
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