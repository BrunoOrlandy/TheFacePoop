<?php  

include("../../config/config.php");
include("../models/DAOs/UserDAO.php");
include("../models/DAOs/PostDAO.php");


if(isset($_POST['post_body'])) {

	$post = new PostDAO($_POST['logged_user']);

	$post->submitPost($_POST['post_body']);
}
	
?>