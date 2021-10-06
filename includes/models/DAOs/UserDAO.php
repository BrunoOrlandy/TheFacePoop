<?php

class UserDAO
{
	private $user;
	private $con;

	public function __construct($con, $user_id)
	{
		$this->con = $con;
		$user_details_query = pg_query($con, "SELECT * FROM users WHERE user_id='$user_id'");
		$this->user = pg_fetch_array($user_details_query);
	}

	public function getID()
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

	public function getNumPosts()
	{
		$login = $this->user['login'];
		$query = pg_query($this->con, "SELECT num_posts FROM users WHERE login='$login'");
		$row = pg_fetch_array($query);
		return $row['num_posts'];
	}

	public function getFirstAndLastName()
	{
		$login = $this->user['login'];
		$query = pg_query($this->con, "SELECT first_name, last_name FROM users WHERE login='$login'");
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
		$login = $this->user['login'];
		$query = pg_query($this->con, "SELECT is_active FROM users WHERE login='$login'");
		$row = pg_fetch_array($query);

		if ($row['is_active'] == false)
			return true;
		else
			return false;
	}

	public function isFriendOf($login_to_check)
	{
		return true;
	}

	public function didReceiveRequest($user_from)
	{

		$user_to = $this->user['login'];

		$check_request_query = pg_query($this->con, "SELECT * FROM users_friendships WHERE user_to='$user_to' AND user_from='$user_from'");

		if (pg_num_rows($check_request_query) > 0) {

			return true;
		} else {

			return false;
		}
	}

	public function didSendRequest($user_to)
	{

		$user_from = $this->user['login'];

		$check_request_query = pg_query($this->con, "SELECT * FROM users_friendships WHERE user_to='$user_to' AND user_from='$user_from'");

		if (pg_num_rows($check_request_query) > 0) {

			return true;
		} else {

			return false;
		}
	}

	public function sendRequest($user_to)
	{
		$user_from = $this->user['login'];

		pg_query($this->con, "INSERT INTO users_friendships VALUES(default, '$user_to', '$user_from')");
	}
}
