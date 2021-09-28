<?php

if (isset($_POST['login_button'])) {

	$email = filter_var($_POST['log_email'], FILTER_SANITIZE_EMAIL);

	$_SESSION['log_email'] = $email;

	$password = md5($email . $_POST['log_password']);

	$check_database_query = pg_query($con, "SELECT * FROM users WHERE email='$email' AND password='$password'");
	$check_login_query = pg_num_rows($check_database_query);

	if ($check_login_query == 1) {

		$row = pg_fetch_array($check_database_query);
		$login = $row['login'];
		$user_id = $row['user_id'];

		$user_closed_query = pg_query($con, "SELECT * FROM users WHERE email='$email' AND is_active=false");
		if (pg_num_rows($user_closed_query) == 1) {
			$reopen_account = pg_query($con, "UPDATE users SET is_active=true WHERE email='$email'");
		}

		$_SESSION['login'] = $login;
		$_SESSION['user_id'] = $user_id;
		header("Location: index.php");
		exit();
	} else {
		array_push($error_array, "Login ou senha incorretos<br>");
	}
}
