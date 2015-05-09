<?php if (isset($loginUser)):
echo $this->view('/userprofilepage/user_login_info',
    [
        'name'          => $loginUser['name'],
        'title'         => $loginUser['title'],
        'numFriends'    => $loginUser['numFriends'],
        'numGroups'     => $loginUser['numGroups'],
    ]);
endif;

echo $this->view('/userprofilepage/user_viewed_info',
    [
        'userId'        => $viewedUser['userId'],
        'title'         => $viewedUser['title'],
        'phone'         => $viewedUser['phone'],
        'name'          => $viewedUser['name'],
        'email'         => $viewedUser['email'],
        'dob'           => $viewedUser['dob'],
        'friendIds'     => $viewedUser['friendIds'],
        'numFriends'    => $viewedUser['numFriends']
    ]);




