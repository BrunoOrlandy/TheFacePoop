<?php  

// dispara quando clicado no login 

if(isset($_POST['login_button'])) {

	$email = filter_var($_POST['log_email'], FILTER_SANITIZE_EMAIL); 

	$_SESSION['log_email'] = $email; 

	$password = md5($_POST['log_password']); 

	// Query para validar email e senha do login

	$check_database_query = pg_query($con, "SELECT * FROM usuario WHERE email='$email' AND senha='$password'");

	$check_login_query = pg_num_rows($check_database_query);

	if($check_login_query == 1) {

		$row = pg_fetch_array($check_database_query);
		$username = $row['username'];

		// Update user_closed='yes' for successfull logging in

		$user_closed_query = pg_query($con, "SELECT * FROM usuario WHERE email='$email' AND user_closed='yes'");
		if(pg_num_rows($user_closed_query) == 1) {

			$reopen_account = pg_query($con, "UPDATE usuario SET user_closed='no' WHERE email='$email'");
		}

		$_SESSION['username'] = $username; 
		header("Location: index.php"); 
		exit();
	}
	else {
		array_push($error_array, "Login ou senha incorretos<br>");
	}


}

?>