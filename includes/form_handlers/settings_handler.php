<?php
if (isset($_POST['update_details'])) {

	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$email = $_POST['email'];

	$email_check = pg_query($con, "SELECT * FROM users WHERE email='$email'");
	$row = pg_fetch_array($email_check);
	$matched_user = $row['login'];

	if ($matched_user == "" || $matched_user == $loggedUserLogin) {
		$message = "Informações atualizadas!<br><br>";

		$query = pg_query($con, "UPDATE users SET first_name='$first_name', last_name='$last_name', email='$email' WHERE login='$loggedUserLogin'");
	} else
		$message = "Este email já está sendo usado!<br><br>";
} else
	$message = "";

if (isset($_POST['update_password'])) {
	$old_password = strip_tags($_POST['old_password']);
	$new_password_1 = strip_tags($_POST['new_password_1']);
	$new_password_2 = strip_tags($_POST['new_password_2']);

	$password_query = pg_query($con, "SELECT email, password FROM users WHERE login='$loggedUserLogin'");
	$row = pg_fetch_array($password_query);
	$db_password = $row['password'];
	$db_email = $row['email'];

	if (md5($db_email . $old_password) == $db_password) {
		if ($new_password_1 == $new_password_2) {
			if (strlen($new_password_1) <= 4) {
				$password_message = "A senha precisa ter mais que 4 caracteres!<br><br>";
			} else {
				$new_password_md5 = md5($db_email . $new_password_1);
				$password_query = pg_query($con, "UPDATE users SET password='$new_password_md5' WHERE login='$loggedUserLogin'");
				$password_message = "Senha alterada!<br><br>";
			}
		} else {
			$password_message = "As senhas não coincidem!<br><br>";
		}
	} else {
		$password_message = "A senha atual está incorreta! <br><br>";
	}
} else {
	$password_message = "";
}


if (isset($_POST['close_account'])) {
	header("Location: close_account.php");
}
