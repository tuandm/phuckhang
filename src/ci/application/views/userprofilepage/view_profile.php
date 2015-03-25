<?php
    echo (get_simple_local_avatar($userId));
    echo '<br>';
    echo 'Title: ' . $title;
    echo '<br>';
    echo 'Phone: ' . $phone;
    echo '<br>';
    echo 'Name: ' . $info['user_nicename'];
    echo '<br>';
    echo 'Email: ' . $info['user_email'];
    echo '<br>';
    echo 'Group: ' . $numGroups;
    echo '<br>';
    echo 'Friend: ' . $friends['numFriend'];
    echo '<br>';
    echo 'Friend List: ';
    $listFriends = $friends['friendId'];
        foreach ($listFriends as $friend) {
            echo (get_simple_local_avatar($friend));
        }
    echo '<br>';
    
    echo '<a href="?act=index"> Back</a>';