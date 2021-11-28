<?php

class FriendshipDAO
{
    private $con;

    public function __construct()
    {
        $this->con = $GLOBALS['con'];
    }

    public function getFriendRequests($userId)
    {
        $query = pg_query($this->con, "SELECT * FROM friendships WHERE user_to_id='$userId' and acceptance_date IS NULL");
        $users = array();

        while ($row = pg_fetch_array($query)) {
            $users[] = new User($row['user_id']);
        }

        return $users;
    }

    public function acceptFriendRequest($userId, $userToId)
    {
        $date = date("Y-m-d");

        pg_query($this->con, "UPDATE friendships SET acceptance_date='$date' WHERE user_to_id=$userId AND user_id=$userToId");
    }

    public function rejectFriendRequest($userId, $userToId)
    {
        pg_query($this->con, "DELETE FROM friendships WHERE user_to_id=$userId AND user_id=$userToId");
    }
}
