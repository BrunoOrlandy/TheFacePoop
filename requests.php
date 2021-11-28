<?php
include("includes/header.php");
?>

<div class="main_column column" id="main_column">

	<h2> Solicitações de amizade </h2>

	<hr>
	</hr>

	<?php

	$friendship = new Friendship($loggedUserID);
	$users = $friendship->getFriendRequests();

	if (count($users) == 0)
		echo "Você não tem novos pedidos de amizade!";
	else {
		foreach ($users as &$user) {
			echo '&nbsp' . $user->getFullName() . " enviou uma solicitação de amizade!";

			if (isset($_POST['accept_request' . $user->getId()])) {

				$friendship->acceptFriendRequest($user->getId());

				echo "Agora vocês são amigos!";

				header("Location: requests.php");
			}

			if (isset($_POST['reject_request' . $user->getId()])) {

				$friendship->rejectFriendRequest($user->getId());

				echo "Você recusou a solicitação de amizade!";

				header("Location: requests.php");
			}

	?>
			<form action="requests.php" method="POST">

				<button type="submit" name="accept_request<?php echo $user->getId(); ?>" class="btn btn-sucess" id="accept_button"><i class="fa fa-check"></i></button>
				<button type="submit" name="reject_request<?php echo $user->getId(); ?>" class="btn btn-danger" id="reject_button"><i class="fa fa-times"></i></button>
				<hr>
				</hr>

			</form>

	<?php
		}
	}

	?>
</div>