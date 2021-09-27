<?php  

include("../../config/config.php");
include("../models/DAOs/UserDAO.php");
include("../models/Post.php");

$limit_pagination = 10;

$posts = new Post($con, $_REQUEST['userID']);
$posts->loadPostsFriends($_REQUEST, $limit_pagination);

?>