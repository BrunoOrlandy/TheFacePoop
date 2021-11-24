<?php

include("includes/header.php");

if (isset($_GET['search_string'])) {
	$search_string = $_GET['search_string'];
} else {
	$search_string = "";
}

if (isset($_GET['type'])) {
	$type = $_GET['type'];
} else {
	$type = "default";
}
?>

<div class="main_column column" id="main_column">

	<form action="search.php" method="GET" name="search_form">

		<input type="text" onkeyup="" name="search_string" placeholder="Pesquisar..." autocomplete="off" id="search_text_input">

		<div class="button_holder">
			<i class="fas fa-search"></i>
		</div>

	</form>

	<?php

	if ($search_string == "")
		echo "Digite um termo para buscar!";
	else {
		$search = new Search();
		$queryResult = $search->searchFor($search_string, $type);

		if (count($queryResult) == 0)
			echo "Não há resultados para" . $search_string;
		else
			echo count($queryResult) . " resultados encontrados: <br> <br>";

		echo "<p id='grey'>Filtrar por:</p>";
		echo "<a href='search.php?search_string=" . $search_string . "&type=users'>Usuários</a> <br> <br>";
		echo "<a href='search.php?search_string=" . $search_string . "&type=posts'>Postagens</a ><br> <br>";
		echo "<a href='search.php?search_string=" . $search_string . "&type=comments'>Comentários</a> <br> <br>";

		foreach ($queryResult as &$value) {
			if ($value instanceof User) {
				$button = "";
				$mutual_friends = "";

				$currentUserId = $value->getId();

				if ($loggedUser->getId() != $currentUserId) {
					if ($loggedUser->isFriendOf($currentUserId))
						$button = "<input type='submit' name='" . $currentUserId . "' class='danger' value='Excluir amigo'>";
					else if ($value->didReceiveRequest($loggedUser->getId()))
						$button = "<input type='submit' name='" . $currentUserId . "' class='warning' value='Responder solicitação'>";
					else if ($loggedUser->didSendRequest($currentUserId))
						$button = "<input type='submit' class='default' value='Solicitação enviada'>";
					else
						$button = "<input type='submit' name='" . $currentUserId . "' class='success' value='Adicionar amigo'>";

					$mutual_friends = $loggedUser->getMutualFriends($currentUserId) . " amigos em comum";

					if (isset($_POST[$currentUserId])) {
						if ($loggedUser->isFriendOf($currentUserId)) {
							$loggedUser->removeFriend($currentUserId);
							header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
						} else if ($loggedUser->didReceiveRequest($currentUserId)) {
							header("Location: requests.php");
						} else if ($loggedUser->didSendRequest($currentUserId)) {
						} else {
							$loggedUser->sendRequest($currentUserId);
							header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
						}
					}
				}

				echo "<div class='search_result'>
							<div class='searchPageFriendButtons'>
								<form action='' method='POST'>
									" . $button . "
									<br>
								</form>
							</div>
							<div class='result_profile_pic'>
								<a href='" . $currentUserId . "'><img src='" . $value->getProfilePhoto() . "' style='height: 100px;'></a>
							</div>
								<a href='" . $value->getLogin() . "'> " . $value->getFirstName() . " " . $value->getLastName() . "
								<p id='grey'> " . $value->getLogin() . "</p>
								</a>
								<br>
								" . $mutual_friends . "<br>
						</div>
						<hr id='search_hr'>";
			}

			if ($value instanceof Post) {
				echo "É USUÁRIO PORCO";
			}

			if ($value instanceof Comment) {
				echo "É USUÁRIO PORCO";
			}
		}
	}


	?>



</div>