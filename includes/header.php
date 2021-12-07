<?php

require 'config/config.php';
include("includes/models/User.php");
include("includes/models/Post.php");
include("includes/models/Reaction.php");
include("includes/models/Search.php");
include("includes/models/Friendship.php");
include("includes/models/DAOs/UserDAO.php");
include("includes/models/DAOs/PostDAO.php");
include("includes/models/DAOs/ReactionDAO.php");
include("includes/models/DAOs/SearchDAO.php");
include("includes/models/DAOs/FriendshipDAO.php");


if (isset($_SESSION['login']) && isset($_SESSION['user_id'])) {

	$loggedUserLogin = $_SESSION['login'];
	$loggedUserID = $_SESSION['user_id'];

	$loggedUser = new User($loggedUserID);
} else {
	header("Location: register.php");
}

?>

<html>

<head>
	<title>Bem-vindo ao FacePoop!</title>

	<link rel="stylesheet" type="text/css" href="assets/css/fontsawesome.css">
	<link rel="stylesheet" type="text/css" href="assets/css/all.css">
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="assets/css/jquery.Jcrop.css" />

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

	<script src="assets/js/popper.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/bootbox.min.js"></script>
	<script src="assets/js/bootbox.locales.min.js"></script>

	<script src="assets/js/facepoop.js"></script>
	<script src="assets/js/jquery.jcrop.js"></script>
	<script src="assets/js/jcrop_bits.js"></script>

</head>

<body>

	<div class="top_bar">

		<div class="logo">

			<a href="index.php">
				<h2>FacePoop</h2>
			</a>

		</div>

		<nav>
			<a href="profile.php?profileUserID=<?php echo $loggedUser->getId(); ?>">
				<img src='<?php echo $loggedUser->getProfilePhoto(); ?>' class='small_profile_pic_header'/>
				<?php echo $loggedUser->getFirstName(); ?>
			</a>

			<a href="index.php">
				<i class="fas fa-home"></i>
			</a>

			<a href="search.php">
				<i class="fas fa-search"></i>
			</a>

			<a href="requests.php">
				<i class="fas fa-users"></i>
			</a>

			<a href="settings.php">
				<i class="fas fa-cog"></i>
			</a>

			<a href="includes/handlers/logout.php">
				<i class="fa fa-sign-out-alt"></i>
			</a>

		</nav>

		<div class="dropdown_data_window" style="height:0px; border:none;"></div>
		<input type="hidden" id="dropdown_data_type" value="">

	</div>

	<div class="wrapper">