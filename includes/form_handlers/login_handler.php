<?php  

// dispara quando clicado no login 

if(isset($_POST['login_button'])) {

	$email = filter_var($_POST['log_email'], FILTER_SANITIZE_EMAIL); 

	$_SESSION['log_email'] = $email; 

	$password = md5($email.$_POST['log_password']); 

	// Query para validar email e senha do login

	$check_database_query = pg_query($con, "SELECT * FROM users WHERE email='$email' AND password='$password'");

	//$check_login_query = pg_num_rows($check_database_query);

	if($check_database_query) {

		$row = pg_fetch_array($check_database_query);
		$login = $row['login'];

		// Update user_closed='yes' for successfull logging in

		$user_closed_query = pg_query($con, "SELECT * FROM users WHERE email='$email' AND is_active=false");
		if(pg_num_rows($user_closed_query) == 1) {

			$reopen_account = pg_query($con, "UPDATE users SET is_active=true WHERE email='$email'");
		}

		$_SESSION['login'] = $login; 
		header("Location: index.php"); 
		exit();
	}
	else {
		array_push($error_array, "Login ou senha incorretos<br>");
	}
}
