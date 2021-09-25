<?php  

include("../../config/config.php");
include("../model/User.php");
include("../model/Post.php");

$limit = 10; // paginacao

$posts = new Post($con, $_REQUEST['userLoggedIn']);
$posts->loadPostsFriends($_REQUEST, $limit);

?>