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

if (isset($_GET['post_id']) && isset($_GET['user_id'])) {
	$userId = $_GET['user_id'];
	$postId = $_GET['post_id'];
}

if (isset($_POST['result'])) {
	if ($_POST['result'] == 'true') {
		$loggedUser = new User($userId);
		$loggedUser->deletePost($postId);
	}
}
