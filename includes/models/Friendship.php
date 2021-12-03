<?php

class Friendship
{
    private $requestDate;
    private $acceptanceDate;
    private $blockDate;

    private $friendshipDAO;

    public function __construct()
    {
        $this->friendshipDAO = new FriendshipDAO();
    }

    public function getUserTo()
    {
        return $this->userTo;
    }

    public function setUserTo($userTo)
    {
        $this->userTo = $userTo;

        return $this;
    }

    public function getRequestDate()
    {
        return $this->requestDate;
    }

    public function setRequestDate($requestDate)
    {
        $this->requestDate = $requestDate;

        return $this;
    }

    public function getAcceptanceDate()
    {
        return $this->acceptanceDate;
    }

    public function setAcceptanceDate($acceptanceDate)
    {
        $this->acceptanceDate = $acceptanceDate;

        return $this;
    }

    public function getBlockDate()
    {
        return $this->blockDate;
    }

    public function setBlockDate($blockDate)
    {
        $this->blockDate = $blockDate;

        return $this;
    }

    public function isFriendOf($userFromId, $userToId)
    {
        return $this->friendshipDAO->isFriendOf($userFromId, $userToId);
    }

    public function didReceiveRequest($userFromId, $userToId)
    {
        return $this->friendshipDAO->didReceiveRequest($userFromId, $userToId);
    }

    public function didSendRequest($userFromId, $userToId)
    {
        return $this->friendshipDAO->didSendRequest($userFromId, $userToId);
    }

    public function sendRequest($userFromId, $userToId)
    {
        return $this->friendshipDAO->sendRequest($userFromId, $userToId);
    }

    public function removeFriend($userId, $userIdToRemove)
    {
        $this->friendshipDAO->removeFriend($userId, $userIdToRemove);
    }

    public function getMutualFriends($userId, $userIdToCheck)
    {
        return $this->friendshipDAO->getMutualFriends($userId, $userIdToCheck);
    }

    public function getFriendRequests($userId)
    {
        return $this->friendshipDAO->getFriendRequests($userId);
    }

    public function getFriends($userId)
    {
        return $this->friendshipDAO->getFriends($userId);
    }

    public function acceptFriendRequest($userId, $userToId)
    {
        $this->friendshipDAO->acceptFriendRequest($userId, $userToId);
    }

    public function rejectFriendRequest($userId, $userToId)
    {
        $this->friendshipDAO->rejectFriendRequest($userId, $userToId);
    }
}
