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
	$fname = strip_tags($_POST['reg_fname']);
	$fname = str_replace(' ', '', $fname);
	$fname = ucfirst(strtolower($fname));
	$_SESSION['reg_fname'] = $fname;

	$lname = strip_tags($_POST['reg_lname']);
	$lname = str_replace(' ', '', $lname);
	$lname = ucfirst(strtolower($lname));
	$_SESSION['reg_lname'] = $lname;

	$em = strip_tags($_POST['reg_email']);
	$em = str_replace(' ', '', $em);
	$_SESSION['reg_email'] = $em;

	$em2 = strip_tags($_POST['reg_email2']);
	$em2 = str_replace(' ', '', $em2);
	$_SESSION['reg_email2'] = $em2;

	$password = strip_tags($_POST['reg_password']);
	$password2 = strip_tags($_POST['reg_password2']);

	$date = date("Y-m-d");

	if ($em == $em2) {
		if (filter_var($em, FILTER_VALIDATE_EMAIL)) {

			$em = filter_var($em, FILTER_VALIDATE_EMAIL);

			$e_check = pg_query($con, "SELECT email FROM users WHERE email='$em'");

			$num_rows = pg_num_rows($e_check);

			if ($num_rows > 0) {
				array_push($error_array, "Email already in use</br>");
			}
		} else {
			array_push($error_array, "Invalid email format</br>");
		}
	} else {
		array_push($error_array, "Emails doesn't match</br>");
	}

	if (strlen($fname) > 25 || strlen($fname) < 2) {

		array_push($error_array, "Your First Name should be in between 2-25 characters</br>");
	}

	if (strlen($lname) > 25 || strlen($lname) < 2) {
		array_push($error_array,  "Your Last Name should be in between 2-25 characters</br>");
	}

	if ($password != $password2) {

		array_push($error_array,  "Passwords doesn't match</br>");
	} else {
		if (preg_match('/[^A-Za-z0-9]/', $password)) {

			array_push($error_array, "Your password should contain only letters and numbers</br>");
		}
	}

	if (strlen($password > 30 || strlen($password) < 5)) {

		array_push($error_array, "Your Password should be in between 5-30 characters</br>");
	}

	if (empty($error_array)) {
		$encripted_password = md5($em . $password);

		$login = strtolower($fname . "_" . $lname);
		$check_login_query = pg_query($con, "SELECT login FROM users WHERE login='$login'");

		$i = 0;
		while (pg_num_rows($check_login_query) != 0) {
			$i++;
			$login = $login . "_" . $i;
			$check_login_query = pg_query($con, "SELECT login FROM users WHERE login='$login'");
		}

		$rand = rand(1, 2);

		if ($rand == 1)
			$profile_pic = "assets/images/profile_pics/defaults/head_green_sea.png";
		else if ($rand == 2)
			$profile_pic = "assets/images/profile_pics/defaults/head_wet_asphalt.png";

		$query = pg_query($con, "INSERT INTO users VALUES (default, '$login', '$fname', '$lname', '$em', '$encripted_password', default, default, '$date')");

		array_push($error_array, "<span style='color: #14C800;'>You're all set! Go ahead and login!</span><br>");

		$_SESSION['reg_fname'] = "";
		$_SESSION['reg_lname'] = "";
		$_SESSION['reg_email'] = "";
		$_SESSION['reg_email2'] = "";
	}
}
