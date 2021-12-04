<?php

include("../../config/config.php");
include("../models/User.php");
include("../models/Post.php");
include("../models/Reaction.php");
include("../models/Search.php");
include("../models/Friendship.php");
include("../models/DAOs/UserDAO.php");
include("../models/DAOs/PostDAO.php");
include("../models/DAOs/ReactionDAO.php");
include("../models/DAOs/SearchDAO.php");
include("../models/DAOs/FriendshipDAO.php");

if (isset($_POST['post_body'])) {
	$loggedUser = new User($_POST['logged_user']);
	$loggedUser->submitPost($_POST['post_body']);
}
?>
