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

	public function getIsActive()
	{
		$userId = $this->user['user_id'];
		$query = pg_query($this->con, "SELECT is_active FROM users WHERE user_id='$userId'");
		$row = pg_fetch_array($query);

		return $row['is_active'] == 1;
	}

	public function setIsActive($isActive)
	{
		$userId = $this->user['user_id'];
		pg_query($this->con, "UPDATE users SET is_active=$isActive WHERE user_id='$userId'");
	}

	public function getNumberOfFriendRequests()
	{
		$login = $this->user['login'];
		$query = pg_query($this->con, "SELECT * FROM friend_requests WHERE user_to='$login'");
		return pg_num_rows($query);
	}

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

	public function getProfilePhoto()
	{
		$userId = $this->user['user_id'];
		$query = pg_query($this->con, "SELECT image_id FROM users WHERE user_id='$userId'");
		$row = pg_fetch_array($query);
		$imageId = $row['image_id'];

		if ($imageId != '') {
			$imageQuery = pg_query($this->con, "SELECT file FROM images WHERE image_id='$imageId'");
			$imageRow = pg_fetch_array($imageQuery);
			$imagePath = $imageRow['file'];

			if ($imagePath != '')
				return $imagePath;
		}

		return "./assets/images/profile_pics/fb_default_green_sea.png";
	}

	public function isAccountClosed()
	{
		$userId = $this->user['user_id'];
		$query = pg_query($this->con, "SELECT is_active FROM users WHERE user_id='$userId'");
		$row = pg_fetch_array($query);

		return $row['is_active'] == 1;
	}
}
