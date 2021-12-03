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

    public function isFriendOf($userFromId, $userToId)
    {
        $checkRequest = pg_query($this->con, "SELECT * FROM friendships WHERE ((user_to_id=$userFromId AND user_id=$userToId) OR (user_to_id=$userToId AND user_id=$userFromId)) AND (acceptance_date IS NOT NULL OR block_date IS NOT NULL)");

        if (pg_num_rows($checkRequest) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function didReceiveRequest($userFromId, $userToId)
    {
        $checkRequest = pg_query($this->con, "SELECT * FROM friendships WHERE user_to_id=$userToId AND user_id=$userFromId AND request_date IS NOT NULL");

        if (pg_num_rows($checkRequest) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function didSendRequest($userFromId, $userToId)
    {
        $checkRequest = pg_query($this->con, "SELECT * FROM friendships WHERE user_to_id=$userToId AND user_id=$userFromId AND request_date IS NOT NULL");

        if (pg_num_rows($checkRequest) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function sendRequest($userFromId, $userToId)
    {
        $date = date("Y-m-d");

        pg_query($this->con, "INSERT INTO friendships VALUES(default, $userToId, $userFromId, '$date', default, default)");
    }

    public function removeFriend($userId, $userIdToRemove)
    {
        pg_query($this->con, "DELETE FROM friendships WHERE user_to_id=$userId AND user_id=$userIdToRemove");
    }

    public function getMutualFriends($userId, $userIdToCheck)
    {
        $query = pg_query($this->con, "SELECT * FROM friendships WHERE user_to_id=$userId AND user_id=$userIdToCheck AND request_date IS NOT NULL");

        return pg_num_rows($query);
    }

    public function getFriends($userId)
    {
        $query = pg_query($this->con, "SELECT * FROM friendships WHERE (user_to_id=$userId OR user_id=$userId) AND acceptance_date IS NOT NULL");
        $friends = array();

        while ($row = pg_fetch_array($query)) {
            $friendUserId = $row['user_id'];
            $friendUserToId = $row['user_to_id'];

            if ($friendUserId != $userId)
                $friends[] = new User($friendUserId);
            else
                $friends[] = new User($friendUserToId);
        }

        return $friends;
    }
}
