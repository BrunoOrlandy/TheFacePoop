<?php

class UserDAO
{
	private $user;
	private $con;

	public function __construct($userId)
	{
		$this->con = $GLOBALS['con'];
		$user_details_query = pg_query($this->con, "SELECT * FROM users WHERE user_id=$userId");
		$this->user = pg_fetch_array($user_details_query);
	}

	public function getId()
	{
		return $this->user['user_id'];
	}

	public function getLogin()
	{
		return $this->user['login'];
	}

	public function getNumberOfFriendRequests()
	{
		$login = $this->user['login'];
		$query = pg_query($this->con, "SELECT * FROM friend_requests WHERE user_to='$login'");
		return pg_num_rows($query);
	}

	// public function getNumPosts()
	// {
	// 	$login = $this->user['login'];
	// 	$query = pg_query($this->con, "SELECT num_posts FROM users WHERE login='$login'");
	// 	$row = pg_fetch_array($query);
	// 	return $row['num_posts'];
	// }

	public function getFirstName()
	{
		$userId = $this->user['user_id'];
		$query = pg_query($this->con, "SELECT first_name FROM users WHERE user_id='$userId'");
		$row = pg_fetch_array($query);

		return $row['first_name'];
	}

	public function getLastName()
	{
		$userId = $this->user['user_id'];
		$query = pg_query($this->con, "SELECT last_name FROM users WHERE user_id='$userId'");
		$row = pg_fetch_array($query);

		return $row['last_name'];
	}

	public function getFullName()
	{
		$userId = $this->user['user_id'];
		$query = pg_query($this->con, "SELECT first_name, last_name FROM users WHERE user_id='$userId'");
		$row = pg_fetch_array($query);

		return $row['first_name'] . " " . $row['last_name'];
	}

	public function getProfilePic()
	{
		return "assets/images/profile_pics/imagem.jpg";
		//ainda nao upa imagem kkk
	}

	public function isAccountClosed()
	{
		$userId = $this->user['user_id'];
		$query = pg_query($this->con, "SELECT is_active FROM users WHERE user_id='$userId'");
		$row = pg_fetch_array($query);

		if ($row['is_active'] == false)
			return true;
		else
			return false;
	}

	public function isFriendOf($userToId)
	{
		$userFromId = $this->user['user_id'];

		$checkRequest = pg_query($this->con, "SELECT * FROM friendships WHERE ((user_to_id=$userFromId AND user_id=$userToId) OR (user_to_id=$userToId AND user_id=$userFromId)) AND (acceptance_date IS NOT NULL OR block_date IS NOT NULL)");

		if (pg_num_rows($checkRequest) > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function didReceiveRequest($userToId)
	{
		$userFromId = $this->user['user_id'];

		$checkRequest = pg_query($this->con, "SELECT * FROM friendships WHERE user_to_id=$userToId AND user_id=$userFromId AND request_date IS NOT NULL");

		if (pg_num_rows($checkRequest) > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function didSendRequest($userToId)
	{
		$userFromId = $this->user['user_id'];

		$checkRequest = pg_query($this->con, "SELECT * FROM friendships WHERE user_to_id=$userToId AND user_id=$userFromId AND request_date IS NOT NULL");

		if (pg_num_rows($checkRequest) > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function sendRequest($userToId)
	{
		$userFromId = $this->user['user_id'];
		$date = date("Y-m-d");

		pg_query($this->con, "INSERT INTO friendships VALUES(default, $userToId, $userFromId, '$date', default, default)");
	}

	public function removeFriend($userIdToRemove)
	{
		$userId = $this->user['user_id'];

		pg_query($this->con, "DELETE FROM friendships WHERE user_to_id=$userId AND user_id=$userIdToRemove");
	}

	public function getMutualFriends($userIdToCheck)
	{
		$userId = $this->user['user_id'];

		$query = pg_query($this->con, "SELECT * FROM friendships WHERE user_to_id=$userId AND user_id=$userIdToCheck AND request_date IS NOT NULL");

		return pg_num_rows($query);
	}
}
