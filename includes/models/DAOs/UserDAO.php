<?php

class UserDAO {
	private $user;
	private $con;

	// constructor

	public function __construct($con, $user_id){
		$this->con = $con;
		$user_details_query = pg_query($con, "SELECT * FROM users WHERE user_id='$user_id'");
		$this->user = pg_query($user_details_query);
	}

	public function getID() {
		return $this->user['user_id'];
	}

	// To get the login

	public function getLogin() {
		return $this->user['login'];
	}

	public function getNumberOfFriendRequests() {
		$login = $this->user['login'];
		$query = pg_query($this->con, "SELECT * FROM friend_requests WHERE user_to='$login'");
		return pg_num_rows($query);
	}

	// To get the number of posts

	public function getNumPosts() {
		$login = $this->user['login'];
		$query = pg_query($this->con, "SELECT num_posts FROM users WHERE login='$login'");
		$row = pg_fetch_array($query);
		return $row['num_posts'];
	}

	// To get the firstname and lastname

	public function getFirstAndLastName() {
		$login = $this->user['login'];
		$query = pg_query($this->con, "SELECT first_name, last_name FROM users WHERE login='$login'");
		$row = pg_fetch_array($query);
		return $row['first_name'] . " " . $row['last_name'];
	}

	// To get the profile_pic of user

	public function getProfilePic() {
		return "assets/images/profile_pics/imagem.jpg";
	}

	public function isAccountClosed() {
		$login = $this->user['login'];
		$query = pg_query($this->con, "SELECT is_active FROM users WHERE login='$login'");
		$row = pg_fetch_array($query);

		if($row['is_active'] == false)
			return true;
		else 
			return false;
	}

	// To verify both are friends or to added_by = loggedin user in profile page newsfeed

	public function isFriendOf($login_to_check) {
		$loginComma = "," . $login_to_check . ",";

		// if((strstr($this->user['friend_array'], $loginComma) || $login_to_check == $this->user['login'])) {
		// 	return true;
		// }
		// else {
		// 	return false;
		// }
		return true;
	}

	// To check for friend request receieved or not

	public function didReceiveRequest($user_from) {

		$user_to = $this->user['login'];

		$check_request_query = pg_query($this->con, "SELECT * FROM friend_requests WHERE user_to='$user_to' AND user_from='$user_from'");

		if(pg_num_rows($check_request_query) > 0) {

			return true;
		}
		else {

			return false;
		}
	}

	// To check whether request is sent or not

	public function didSendRequest($user_to) {

		$user_from = $this->user['login'];

		$check_request_query = pg_query($this->con, "SELECT * FROM friend_requests WHERE user_to='$user_to' AND user_from='$user_from'");

		if(pg_num_rows($check_request_query) > 0) {

			return true;
		}
		else {

			return false;
		}
	}

	// To Remove friend

	// public function removeFriend($user_to_remove) {

	// 	$logged_in_user = $this->user['login']; // To get the logged in login

	// 	$query = pg_query($this->con, "SELECT friend_array FROM users WHERE login='$user_to_remove'"); // To get the friend of user_to_remove

	// 	$row = pg_fetch_array($query);

	// 	$friend_array_login = $row['friend_array']; // User_to_remove friend _array

	// 	$new_friend_array = str_replace($user_to_remove . ",", "", $this->user['friend_array']); // Replace with null in logged_in user's friend array by finding the user_to_remove substring

	// 	$remove_friend = pg_query($this->con, "UPDATE users SET friend_array='$new_friend_array' WHERE login='$logged_in_user'"); // Update friend array after replacing with null of logged_in user

	// 	$new_friend_array = str_replace($this->user['login'] . ",", "", $friend_array_login); // Same process as above but in user_to_remove friend_array

	// 	$remove_friend = pg_query($this->con, "UPDATE users SET friend_array='$new_friend_array' WHERE login='$user_to_remove'"); // Updating new friend array of user_to_remove
	// }

	// To Send request

	public function sendRequest($user_to) {

		$user_from = $this->user['login']; // To get the login of logged_in user

		// Query to insert into friend_requests

		$query = pg_query($this->con, "INSERT INTO friend_requests VALUES('', '$user_to', '$user_from')");
	}

	// To get the mutual friend count

	// public function getMutualFriends($user_to_check) {
	// 	$mutualFriends = 0;
	// 	$user_array = $this->user['friend_array'];
	// 	$user_array_explode = explode(",", $user_array);

	// 	$query = pg_query($this->con, "SELECT friend_array FROM users WHERE login='$user_to_check'");
	// 	$row = pg_fetch_array($query);
	// 	$user_to_check_array = $row['friend_array'];
	// 	$user_to_check_array_explode = explode(",", $user_to_check_array);

	// 	foreach($user_array_explode as $i) {

	// 		foreach($user_to_check_array_explode as $j) {

	// 			if($i == $j && $i != "") {
	// 				$mutualFriends++;
	// 			}
	// 		}
	// 	}
	// 	return $mutualFriends;

	// }




}
