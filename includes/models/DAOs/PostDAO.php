<?php
class PostDAO
{
	private $logged_user_obj;
	private $con;

	public function __construct($con, $user_id)
	{
		$this->con = $con;
		$this->logged_user_obj = new UserDAO($con, $user_id);
	}

	public function submitPost($post_text_body)
	{
		$post_text_body = strip_tags($post_text_body);
		$check_empty = preg_replace('/\s+/', '', $post_text_body);

		if ($check_empty != "") {

			$inclusion_date = date("Y-m-d H:i:s");

			$logged_user_id = $this->logged_user_obj->getID();

			pg_query($this->con, "INSERT INTO posts VALUES(default, default, '$logged_user_id', default, '$post_text_body', '$inclusion_date', false)");
		}
	}

	public function loadPostsFriends($data, $limit)
	{
		$page = $data['page'];

		$logged_user_id = $this->logged_user_obj->getID();

		if ($page == 1)
			$start = 0;
		else
			$start = ($page - 1) * $limit;

		$str = "";

		$data_query = pg_query($this->con, "SELECT * FROM posts WHERE is_deleted=false ORDER BY post_id DESC");

		if (pg_num_rows($data_query) > 0) {
			$num_iterations = 0;
			$count = 1;

			while ($row = pg_fetch_array($data_query)) {
				$id = $row['post_id'];
				$user_id = $row['user_id'];
				$text_body = $row['text'];
				$date_time = $row['inclusion_date'];
				$added_by_obj = new UserDAO($this->con, $user_id);
				$user_login = $added_by_obj->getLogin();

				if ($added_by_obj->isAccountClosed()) {
					continue;
				}

				if ($this->logged_user_obj->isFriendOf($user_id)) {

					if ($num_iterations++ < $start)
						continue;
					if ($count > $limit) {
						break;
					} else {
						$count++;
					}

					if ($logged_user_id == $user_id)
						$delete_button = "<button class='delete_button btn-danger' id='post$id'>Excluir</button>";
					else
						$delete_button = "";

					$user_details_query = pg_query($this->con, "SELECT first_name, last_name FROM users WHERE user_id='$user_id'");

					$user_row = pg_fetch_array($user_details_query);

					$first_name = $user_row['first_name'];
					$last_name = $user_row['last_name'];
					$profile_pic = $added_by_obj->getProfilePic();

					$date_time_now = date("Y-m-d H:i:s");
					$start_date = new DateTime($date_time);
					$end_date = new DateTime($date_time_now);
					$interval = (object)$start_date->diff($end_date);

					if ($interval->y >= 1) {
						if ($interval == 1)
							$time_message = "Há $interval->y ano";
						else
							$time_message = "Há $interval->y anos";
					} else if ($interval->m >= 1) {
						if ($interval->d == 0) {
							$days = "";
						} else if ($interval->d == 1) {
							$days = "e $interval->d dia";
						} else {
							$days = "e $interval->d dias";
						}
						if ($interval->m == 1) {
							$time_message = "Há $interval->m mês $days";
						} else {
							$time_message = "Há $interval->m meses $days";
						}
					} else if ($interval->d >= 1) {
						if ($interval->d == 1) {
							$time_message = "Ontem";
						} else {
							$time_message = "Há $interval->d dias";
						}
					} else if ($interval->h >= 1) {
						if ($interval->h == 1) {
							$time_message = "Há $interval->h hora";
						} else {
							$time_message = "Há $interval->h horas";
						}
					} else if ($interval->i >= 1) {
						if ($interval->i == 1) {
							$time_message = "Há $interval->i minuto";
						} else {
							$time_message = "Há $interval->i minutos";
						}
					} else {
						if ($interval->s < 30) {
							$time_message = "Agora";
						} else {
							$time_message = "Há $interval->s segundos";
						}
					}

					$str .= "<div class='status_post' onClick='javascript:toggle$id()'>
								<div class='post_profile_pic'>
									<img src='$profile_pic' width='50'>
								</div>

								<div class = 'post_main_frame' style='margin-left: 8px;'>

									<div class='posted_by' style='color:#ACACAC;'>
										<a href='$user_login'> $first_name $last_name </a> &nbsp;&nbsp;&nbsp;&nbsp; $time_message
										$delete_button
									</div>
									<div id='post_body'>
										<p style='font-size: 27px; line-height: 30px; margin-top: 10px;'>$text_body<p>
										<br>
										<br>
										<br>
									</div>
								</div>

								<div class='newsfeedPostOptions'>
									<iframe src='like.php?post_id=$id' scrolling='no'></iframe>
								</div>
								

							</div>
							<hr>";
				}

?>
				<script>
					$(document).ready(function() {
						$('#post<?php echo $id; ?>').on('click', function() {
							bootbox.confirm("Tem certeza que deseja excluir esta postagem?", function(result) {
								$.post("includes/form_handlers/delete_post.php?post_id=<?php echo $id; ?>", {
									result: result
								});

								if (result)
									location.reload();
							});
						});


					});
				</script>



			<?php

			} // End loop

			if ($count > $limit)
				$str .= "<input type='hidden' class='nextPage' value='" . ($page + 1) . "'>
							<input type='hidden' class='noMorePosts' value='false'>";
			else
				$str .= "<input type='hidden' class='noMorePosts' value='true'><p style='text-align: centre;'> Não existem mais postagens! </p>";
		}

		echo $str;
	}


	public function loadProfilePosts($data, $limit)
	{
		$page = $data['page'];
		$logged_user_id = $this->logged_user_obj->getID();

		if ($page == 1)
			$start = 0;
		else
			$start = ($page - 1) * $limit;


		$str = "";
		$data_query = pg_query($this->con, "SELECT * FROM posts WHERE is_deleted=false AND user_id='$logged_user_id' ORDER BY post_id DESC");

		if (pg_num_rows($data_query) > 0) {
			$num_iterations = 0;
			$count = 1;

			while ($row = pg_fetch_array($data_query)) {
				$id = $row['post_id'];
				$user_id = $row['user_id'];
				$text_body = $row['text'];
				$date_time = $row['inclusion_date'];

				if ($num_iterations++ < $start)
					continue;

				if ($count > $limit) {
					break;
				} else {
					$count++;
				}

				if ($logged_user_id == $user_id)
					$delete_button = "<button class='delete_button btn-danger' id='post$id'>Excluir</button>";
				else
					$delete_button = "";

				$user_details_query = pg_query($this->con, "SELECT first_name, last_name FROM users WHERE user_id='$logged_user_id'");
				$user_row = pg_fetch_array($user_details_query);
				$first_name = $user_row['first_name'];
				$last_name = $user_row['last_name'];

				$added_by_obj = new UserDAO($this->con, $user_id);
				$profile_pic = $added_by_obj->getProfilePic();
				$user_login = $added_by_obj->getLogin();

				$date_time_now = date("Y-m-d H:i:s");
				$start_date = new DateTime($date_time);
				$end_date = new DateTime($date_time_now);
				$interval = (object)$start_date->diff($end_date);

				if ($interval->y >= 1) {
					if ($interval == 1)
						$time_message = "Há $interval->y ano";
					else
						$time_message = "Há $interval->y anos";
				} else if ($interval->m >= 1) {
					if ($interval->d == 0) {
						$days = "";
					} else if ($interval->d == 1) {
						$days = "e $interval->d dia";
					} else {
						$days = "e $interval->d dias";
					}
					if ($interval->m == 1) {
						$time_message = "Há $interval->m mês $days";
					} else {
						$time_message = "Há $interval->m meses $days";
					}
				} else if ($interval->d >= 1) {
					if ($interval->d == 1) {
						$time_message = "Ontem";
					} else {
						$time_message = "Há $interval->d dias";
					}
				} else if ($interval->h >= 1) {
					if ($interval->h == 1) {
						$time_message = "Há $interval->h hora";
					} else {
						$time_message = "Há $interval->h horas";
					}
				} else if ($interval->i >= 1) {
					if ($interval->i == 1) {
						$time_message = "Há $interval->i minuto";
					} else {
						$time_message = "Há $interval->i minutos";
					}
				} else {
					if ($interval->s < 30) {
						$time_message = "Agora";
					} else {
						$time_message = "Há $interval->s segundos";
					}
				}

				$str .= "<div class='status_post' onClick='javascript:toggle$id()'>
								<div class='post_profile_pic'>
									<img src='$profile_pic' width='50'>
								</div>

								<div class='posted_by' style='color:#ACACAC;'>
									<a href='$user_login'> $first_name $last_name </a> &nbsp;&nbsp;&nbsp;&nbsp;$time_message
									$delete_button
								</div>
								<div id='post_body'>
									<p style='font-size: 27px; line-height: 30px; margin-top: 10px;'>$text_body<p>
									<br>
									<br>
									<br>
								</div>

								<div class='newsfeedPostOptions'>
									<iframe src='like.php?post_id=$id' scrolling='no'></iframe>
								</div>

							</div>
							<hr>";

			?>
				<script>
					$(document).ready(function() {
						$('#post<?php echo $id; ?>').on('click', function() {
							bootbox.confirm("Tem certeza que deseja excluir esta postagem?", function(result) {
								$.post("includes/form_handlers/delete_post.php?post_id=<?php echo $id; ?>", {
									result: result
								});

								if (result)
									location.reload();
							});
						});
					});
				</script>
<?php

			}

			if ($count > $limit)
				$str .= "<input type='hidden' class='nextPage' value='" . ($page + 1) . "'>
							<input type='hidden' class='noMorePosts' value='false'>";
			else
				$str .= "<input type='hidden' class='noMorePosts' value='true'><p style='text-align: centre;'> Não existem mais postagens! </p>";
		}

		echo $str;
	}
}

?>