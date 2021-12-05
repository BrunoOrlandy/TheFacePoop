<?php

require 'config/config.php';
require 'includes/form_handlers/register_handler.php';
require 'includes/form_handlers/login_handler.php';

?>


<!DOCTYPE html>
<html>

<head>
	<title>FacePoop</title>
	<link rel="stylesheet" type="text/css" href="assets/css/register_style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="assets/js/register.js"></script>
</head>

<body>

	<?php

	if (isset($_POST['register_button'])) {

		echo '
		<script>

		$(document).ready(function() {
			$("#first").hide();
			$("#second").show();
		});

		</script>

		';
	}

	?>

	<div class="wrapper">

		<div class="login_box">

			<div class="login_header">
				<h1>Bem-vindo!</h1>
				<p> Faça login ou inscreva-se abaixo! </p>
			</div>

			</br>

			<div id="first">

				<form action="register.php" method="POST">

					<input type="email" name="log_email" placeholder="Endereço de email" value="<?php
																								if (isset($_SESSION['log_email'])) {
																									echo $_SESSION['log_email'];
																								}
																								?>" required>
					<br>

					<input type="password" name="log_password" placeholder="Senha">
					<br>

					<?php if (in_array("Login ou senha incorretos<br>", $error_array)) echo  "Login ou senha incorretos<br>"; ?>

					<input type="submit" name="login_button" value="Login">
					<br>

					<a href="#" id="signup" class="signup">Não tem uma conta? Registre-se aqui!</a>

				</form>

			</div>

			<div id="second">

				<form action="register.php" method="POST">

					<input type="text" name="reg_fname" placeholder="Primeiro nome" value="<?php
																							if (isset($_SESSION['reg_fname'])) {
																								echo $_SESSION['reg_fname'];
																							}
																							?>" required>

					<input type="text" name="reg_lname" placeholder="Sobrenome" value="<?php
																						if (isset($_SESSION['reg_lname'])) {
																							echo $_SESSION['reg_lname'];
																						}
																						?>" required>
					<br>

					<?php if (in_array("O nome deve ter entre 2 e 25 caracteres</br>", $error_array)) echo "O nome deve ter entre 2 e 25 caracteres</br>"; ?>
					<?php if (in_array("O sobrenome deve ter entre 2 e 25 caracteres</br>", $error_array)) echo "O sobrenome deve ter entre 2 e 25 caracteres</br>"; ?>

					<input type="email" name="reg_email" placeholder="Email" value="<?php
																					if (isset($_SESSION['reg_email'])) {
																						echo $_SESSION['reg_email'];
																					}
																					?>" required>

					<input type="email" name="reg_email2" placeholder="Confirmar Email" value="<?php
																								if (isset($_SESSION['reg_email2'])) {
																									echo $_SESSION['reg_email2'];
																								}
																								?>" required>
					<br>

					<?php if (in_array("Email já esta sendo usado</br>", $error_array)) echo "Email já esta sendo usado</br>"; ?>
					<?php if (in_array("Formato invalido de email</br>", $error_array)) echo "Formato invalido de email</br>"; ?>
					<?php if (in_array("Emails informados não coincidem</br>", $error_array)) echo "Emails informados não coincidem</br>"; ?>

					<input type="password" name="reg_password" placeholder="Senha" required>

					<input type="password" name="reg_password2" placeholder="Confirmar senha" required>
					<br>

					<?php if (in_array("As senhas não coincidem</br>", $error_array)) echo "As senhas não coincidem</br>"; ?>
					<?php if (in_array("A senha deve conter apenas letras e números</br>", $error_array)) echo "A senha deve conter apenas letras e números</br>"; ?>
					<?php if (in_array("A senha deve ter entre 5 e 30 caracteres</br>", $error_array)) echo "A senha deve ter entre 5 e 30 caracteres</br>"; ?>

					<input type="submit" name="register_button" value="Registrar">
					<br>

					<?php if (in_array("<span style='color: #14C800;'>Tudo pronto! Vá em frente e faça login!</span><br>", $error_array)) echo "<span style='color: #14C800; margin-left: -80px;'>Tudo pronto! Vá em frente e faça login!</span><br>"; ?>

					<a href="#" id="signin" class="signin">Já tem uma conta? Faça login aqui!</a>

				</form>

			</div>

		</div>

	</div>

</body>

</html>