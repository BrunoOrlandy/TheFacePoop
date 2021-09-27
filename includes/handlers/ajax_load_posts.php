<?php  

if (isset($_REQUEST['userLoggedIn']) && isset($_SESSION['userID'])) {  
    
    $limit_pagination = 10;
    
    $posts = new Post($con, $_REQUEST['userID']);
    $posts->loadPostsFriends($_REQUEST, $limit_pagination);
}
