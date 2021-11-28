<?php

class Friendship
{
    private $user;
    private $requestDate;
    private $acceptanceDate;
    private $blockDate;

    private $friendshipDAO;

    public function __construct($userId)
    {
        $this->friendshipDAO = new FriendshipDAO();

        $this->setUser(new User($userId));
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;

        return $this;
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

    public function getFriendRequests()
    {
        $userId = $this->getUser()->getId();

        return $this->friendshipDAO->getFriendRequests($userId);
    }

    public function acceptFriendRequest($userToId)
    {
        $userId = $this->getUser()->getId();

        $this->friendshipDAO->acceptFriendRequest($userId, $userToId);
    }

    public function rejectFriendRequest($userToId)
    {
        $userId = $this->getUser()->getId();

        $this->friendshipDAO->rejectFriendRequest($userId, $userToId);
    }
}
