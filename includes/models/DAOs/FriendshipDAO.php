<?php

class FriendshipDAO
{
    private $friendship;
    private $con;


    public function __construct($con, $user_id)
	{
		$this->con = $con;
		$this->friendship = new UserDAO($con, $user_id);
	}

    // Query to get freind_request's where user_to equals to loggedInUSER
    public function getFriendRequests($user_id){
	return pg_query($this->con, "SELECT * FROM friendships WHERE user_id='$user_id' and acceptance_date is null"); 
    }
}

?>