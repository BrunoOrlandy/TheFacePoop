<?php
include("includes/header.php");

if (isset($_POST['cancel'])) {
	header("Location: settings.php");
}

if (isset($_POST['close_account'])) {
	$close_query = pg_query($con, "UPDATE users SET is_active=false WHERE login='$loggedUserLogin'");
	session_destroy();
	header("Location: register.php");
}

?>

<div class="main_column column">

	<h4>Hibernar conta</h4>

	Tem certeza que deseja colocar sua conta em hibernação?<br><br>
	Seu perfil e suas atividades na conta serão escondidos dos outros usuários.<br><br>
	Você reabrir sua conta a qualquer momento realizando o login.<br><br>

	<form action="close_account.php" method="POST">
		<input type="submit" name="close_account" id="close_account" value="Sim, a mimir!" class="danger settings_submit">
		<input type="submit" name="cancel" id="update_details" value="Não, senhor!" class="info settings_submit">
	</form>

</div>