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
			$inclusion_date = date("Y-m-d H:i:s");
			$logged_user_id = $this->logged_user_obj->getID();
			pg_query($this->con, "INSERT INTO posts VALUES(default, default, '$logged_user_id', default, '$post_text_body', '$inclusion_date', false)");		
	}

	public function loadPostsFriends($data, $limit_pagination)
	{
		$page = $data['page'];

		$logged_user_id = $this->logged_user_obj->getID();

		if ($page == 1)
			$start = 0;
		else
			$start = ($page - 1) * $limit_pagination;

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

				if ($user_id != $logged_user_id) {
					$user_to_obj = new UserDAO($this->con, $user_id);
					$user_to_name = $user_to_obj->getFirstAndLastName();
					$user_to = "to <a href='" . $row['user_id'] . "'>" . $user_to_name . "</a>";
				}

				if ($added_by_obj->isAccountClosed()) {
					continue;
				}

				if ($this->logged_user_obj->isFriendOf($user_id)) { 

					if ($num_iterations++ < $start)
						continue;
					if ($count > $limit_pagination) {
						break;
					} else {
						$count++;
					}

					if ($logged_user_id == $user_id)
						$delete_button = "<button class='delete_button btn-danger' id='post$id'>Delete</button>";
					else
						$delete_button = "";

					$user_details_query = pg_query($this->con, "SELECT first_name, last_name FROM users WHERE user_id='$user_id'");

					$user_row = pg_fetch_array($user_details_query);

					$first_name = $user_row['first_name'];
					$last_name = $user_row['last_name'];
					$profile_pic = $added_by_obj->getProfilePic();

					$date_time_now = date("Y-m-d H:i:s");
					$start_date = new DateTime($date_time); // Time of post
					$end_date = new DateTime($date_time_now); // Current time
					$interval = (Object) $start_date->diff($end_date); // Difference between dates 

					if ($interval->y >= 1) {

						if ($interval == 1)
							$time_message = $interval->y . " year ago"; // 1 year ago
						else
							$time_message = $interval->y . " year's ago"; // 1+ year ago
					} else if ($interval->m >= 1) {

						if ($interval->d == 0) {
							$days = " ago";
						} else if ($interval->d == 1) {
							$days = $interval->d . " day ago";
						} else {
							$days = $interval->d . " day's ago";
						}


						if ($interval->m == 1) {
							$time_message = $interval->m . " month" . $days;
						} else {
							$time_message = $interval->m . " month's" . $days;
						}
					} else if ($interval->d >= 1) {
						if ($interval->d == 1) {
							$time_message = "Yesterday";
						} else {
							$time_message = $interval->d . " day's ago";
						}
					} else if ($interval->h >= 1) {
						if ($interval->h == 1) {
							$time_message = $interval->h . " hour ago";
						} else {
							$time_message = $interval->h . " hour's ago";
						}
					} else if ($interval->i >= 1) {
						if ($interval->i == 1) {
							$time_message = $interval->i . " minute ago";
						} else {
							$time_message = $interval->i . " minutes' ago";
						}
					} else {
						if ($interval->s < 30) {
							$time_message = "Just now";
						} else {
							$time_message = $interval->s . " second's ago";
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
							bootbox.confirm("Are you sure you want to delete this post?", function(result) {
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

			if ($count > $limit_pagination)
				$str .= "<input type='hidden' class='nextPage' value='" . ($page + 1) . "'>
							<input type='hidden' class='noMorePosts' value='false'>";
			else
				$str .= "<input type='hidden' class='noMorePosts' value='true'><p style='text-align: centre;'> No more posts to show! </p>";
		}

		echo $str;
	}


	public function loadProfilePosts($data, $limit_pagination)
	{
		$page = $data['page'];
		$logged_user_id = $this->logged_user_obj->getID();

		if ($page == 1)
			$start = 0;
		else
			$start = ($page - 1) * $limit_pagination;


		$str = ""; //String to return 
		$data_query = pg_query($this->con, "SELECT * FROM posts WHERE deleted=false AND user_id='$logged_user_id' ORDER BY id DESC");

		if (pg_num_rows($data_query) > 0) {
			$num_iterations = 0; // Number of results checked (not necasserily posted)
			$count = 1;

			while ($row = pg_fetch_array($data_query)) {
				$id = $row['post_id'];
				$user_id = $row['user_id'];
				$text_body = $row['text'];
				$date_time = $row['inclusion_date'];

				if ($num_iterations++ < $start)
					continue;

				// Once 10 posts have been loaded, break
				if ($count > $limit_pagination) {
					break;
				} else {
					$count++;
				}

				if ($logged_user_id == $user_id)
					$delete_button = "<button class='delete_button btn-danger' id='post$id'>Delete</button>";
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
				$interval =(Object) $start_date->diff($end_date); 
				if ($interval->y >= 1) {
					if ($interval == 1)
						$time_message = $interval->y . " year ago"; 
					else
						$time_message = $interval->y . " years ago"; 
				} else if ($interval->m >= 1) {
					if ($interval->d == 0) {
						$days = " ago";
					} else if ($interval->d == 1) {
						$days = $interval->d . " day ago";
					} else {
						$days = $interval->d . " days ago";
					}


					if ($interval->m == 1) {
						$time_message = $interval->m . " month" . $days;
					} else {
						$time_message = $interval->m . " months" . $days;
					}
				} else if ($interval->d >= 1) {
					if ($interval->d == 1) {
						$time_message = "Yesterday";
					} else {
						$time_message = $interval->d . " days ago";
					}
				} else if ($interval->h >= 1) {
					if ($interval->h == 1) {
						$time_message = $interval->h . " hour ago";
					} else {
						$time_message = $interval->h . " hours ago";
					}
				} else if ($interval->i >= 1) {
					if ($interval->i == 1) {
						$time_message = $interval->i . " minute ago";
					} else {
						$time_message = $interval->i . " minutes ago";
					}
				} else {
					if ($interval->s < 30) {
						$time_message = "Just now";
					} else {
						$time_message = $interval->s . " seconds ago";
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
							bootbox.confirm("Are you sure you want to delete this post??", function(result) {
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

			} //End loop

			if ($count > $limit_pagination)
				$str .= "<input type='hidden' class='nextPage' value='" . ($page + 1) . "'>
							<input type='hidden' class='noMorePosts' value='false'>";
			else
				$str .= "<input type='hidden' class='noMorePosts' value='true'><p style='text-align: centre;'> No more posts to show! </p>";
		}

		echo $str;
	}
}

?>