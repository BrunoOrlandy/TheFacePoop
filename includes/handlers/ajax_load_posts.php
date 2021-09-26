<?php  

include("../../config/config.php");
include("../models/DAOs/UserDAO.php");
include("../models/DAOs/PostDAO.php");

$limit = 10; // paginacao

$posts = new PostDAO($con, $_REQUEST['userID']);
$posts->loadPostsFriends($_REQUEST, $limit);

?>