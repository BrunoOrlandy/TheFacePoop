<?php
include("includes/header.php");
include("includes/form_handlers/settings_handler.php");
?>

<div class="main_column column">

	<h4>Configurações da conta</h4>
	<img src='<?php echo $loggedUser->getProfilePhoto(); ?>' class='small_profile_pic'>
	<br>
	<a href="upload.php">Atualizar foto de perfil</a> <br><br><br>

	Altere os valores e clique em 'Atualizar Informações'

	<br /> <br />

	<form action="settings.php" method="POST">
		Nome: <input type="text" name="first_name" value="<?php echo $loggedUser->getFirstName(); ?>" id="settings_input"><br>
		Sobrenome: <input type="text" name="last_name" value="<?php echo $loggedUser->getLastName(); ?>" id="settings_input"><br>
		Email: <input type="text" name="email" value="<?php echo $loggedUser->getEmail(); ?>" id="settings_input"><br>

		<?php echo $message; ?>

		<input type="submit" name="update_details" id="save_details" value="Atualizar Informações" class="btn btn-primary settings_submit"><br>
	</form>

	<h4>Alterar senha</h4>
	<form action="settings.php" method="POST">
		Senha atual: <input type="password" name="old_password" id="settings_input"><br>
		Nova senha: <input type="password" name="new_password_1" id="settings_input"><br>
		Confirmar nova senha: <input type="password" name="new_password_2" id="settings_input"><br>

		<?php echo $password_message; ?>

		<input type="submit" name="update_password" id="save_details" value="Atualizar Senha" class="btn btn-primary settings_submit"><br>
	</form>

	<h4>Hibernar Conta</h4>
	<form action="settings.php" method="POST">
		<input type="submit" name="close_account" id="close_account" value="Hibernar Conta" class="btn btn-danger settings_submit">
	</form>


</div>