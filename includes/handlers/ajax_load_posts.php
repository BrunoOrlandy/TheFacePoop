<?php  

include("../../config/config.php");
include("../models/DAOs/UserDAO.php");
include("../models/DAOs/PostDAO.php");

$limit = 10;

$posts = new PostDAO($_REQUEST['userID']);
$posts->loadPostsFriends($_REQUEST, $limit);

?>