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

<div class="main_column column">

	<form class="search_form" action="search.php" method="GET" name="search_form">
		<textarea name="search_string" id="search_string" placeholder="Pesquisar..." autocomplete="off"></textarea>
		<button type="submit" name="post" id="post_button" class="btn btn-primary search_button">
			<i class="fas fa-search"></i>
		</button>
		<hr>
	</form>

	<?php

	if ($search_string == "")
		echo "Digite um termo para buscar!";
	else {
		$search = new Search();
		$queryResult = $search->searchFor($search_string, $type);

		if (count($queryResult) == 0)
			echo "Não há resultados para: " . $search_string . "<br> <br>";
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
						$button = "<button type='submit' name='" . $currentUserId . "' class='btn btn-danger'><i class='fa fa-user-times'></i></button>";
					else if ($value->didReceiveRequest($loggedUser->getId()))
						$button = "<input type='submit' name='" . $currentUserId . "' class='default' value='Responder solicitação'>";
					else if ($loggedUser->didSendRequest($currentUserId))
						$button = "<input type='submit' class='default' value='Solicitação enviada'>";
					else
						$button = "<button type='submit' name='" . $currentUserId . "' class='btn btn-success'><i class='fa fa-user-plus'></i></button>";

					$mutual_friends = $loggedUser->getMutualFriends($currentUserId) . " amigo(s) em comum";

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