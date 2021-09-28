<?php

$fname = "";
$lname = "";
$em = ""; 
$em2 = "";
$password = ""; 
$password2 = ""; 
$date = "";  
$error_array = array();


if (isset($_POST['register_button'])) {

	// Nome

	$fname = strip_tags($_POST['reg_fname']); 
	$fname = str_replace(' ', '', $fname); 
	$fname = ucfirst(strtolower($fname)); 
	$_SESSION['reg_fname'] = $fname; 

	// Sobre name

	$lname = strip_tags($_POST['reg_lname']); 
	$lname = str_replace(' ', '', $lname); 
	$lname = ucfirst(strtolower($lname)); 
	$_SESSION['reg_lname'] = $lname; 

	// Email

	$em = strip_tags($_POST['reg_email']); 
	$em = str_replace(' ', '', $em); 
	$_SESSION['reg_email'] = $em;

	// Confirmacao Email

	$em2 = strip_tags($_POST['reg_email2']);
	$em2 = str_replace(' ', '', $em2); 
	$_SESSION['reg_email2'] = $em2; 

	// Password

	$password = strip_tags($_POST['reg_password']); 
	$password2 = strip_tags($_POST['reg_password2']);

	$date = date("Y-m-d"); // data ataual

	// Email Validation

	if ($em == $em2) { // Se os dois esmils são iguais

		// verifica se o email esta em um formato invalido

		if (filter_var($em, FILTER_VALIDATE_EMAIL)) {

			$em = filter_var($em, FILTER_VALIDATE_EMAIL);

			// verifica se o email existe passar para DAO

			$e_check = pg_query($con, "SELECT email FROM users WHERE email='$em'");
			$num_rows = pg_num_rows($e_check);

			if ($num_rows > 0) {
				array_push($error_array, "Email já esta sendo usado</br>");
			}
		} else {
			array_push($error_array, "Formato invalido de email</br>");
		}
	} else {
		array_push($error_array, "Emails informados não coincidem</br>");
	}

	// tamanho do primeiro nome

	if (strlen($fname) > 25 || strlen($fname) < 2) {

		array_push($error_array, "O nome deve ter entre 2 e 25 caracteres</br>");
	}

	// Second Name length Validation

	if (strlen($lname) > 25 || strlen($lname) < 2) {
		array_push($error_array,  "O sobrenome deve ter entre 2 e 25 caracteres</br>");
	}

	// Password validation

	if ($password != $password2) {

		array_push($error_array,  "As senhas não coincidem</br>");
	} else {
		if (preg_match('/[^A-Za-z0-9]/', $password)) {

			array_push($error_array, "A senha deve conter apenas letras e números</br>");
		}
	}

	// Password length Validation

	if (strlen($password > 30 || strlen($password) < 5)) {

		array_push($error_array, "A senha deve ter entre 5 e 30 caracteres</br>");
	}

	// Triggers when no errors in $error_array

	if (empty($error_array)) {
		$encripted_password = md5($em.$password); 
		

		$login = strtolower($fname . "_" . $lname);
		$check_login_query = pg_query($con, "SELECT login FROM users WHERE login='$login'");

		$i = 0;
		while (pg_num_rows($check_login_query) != 0) {

			$i++; // Add 1 to i
			$login = $login . "_" . $i;
			$check_login_query = pg_query($con, "SELECT login FROM users WHERE login='$login'");
		}

		// gerar uma foto aleatorio para usuario inserido 

		$rand = rand(1, 2);

		if ($rand == 1)
			$profile_pic = "assets/images/profile_pics/fb_default_green_sea.png";
		else if ($rand == 2)
			$profile_pic = "assets/images/profile_pics/fb_default_wet_asphalt.png";

		$query = pg_query($con, "INSERT INTO users VALUES (default, '$login', '$fname', '$lname', '$em', '$encripted_password', default, default, '$date')");

		array_push($error_array, "<span style='color: #14C800;'>Tudo pronto! Vá em frente e faça login!</span><br>");

		// limpa variaveis session  

		$_SESSION['reg_fname'] = "";
		$_SESSION['reg_lname'] = "";
		$_SESSION['reg_email'] = "";
		$_SESSION['reg_email2'] = "";
	}
}
