<?php

class User
{
    private $id;
    private $login;
    private $isActive;
    private $firstName;
    private $lastName;
    private $email;
    private $password;
    private $description;
    private $profilePhoto;
    private $coverPhoto;
    private $post;
    private $friendship;
    private $registerDate;
    private $birthdayDate;

    private $userDAO;

    public function __construct($userId)
    {
        $this->userDAO = new UserDAO($userId);

        $this->setId($this->userDAO->getID());
        $this->setFirstName($this->userDAO->getFirstName());
        $this->setLastName($this->userDAO->getLastName());
        $this->setIsActive($this->userDAO->getIsActive());

        $this->friendship = new Friendship();
        $this->post = new Post();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    public function getIsActive()
    {
        return $this->isActive;
    }

    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
        $this->userDAO->setIsActive();

        return $this;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFullName()
    {
        return $this->getFirstName() . $this->getLastName();
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function getProfilePhoto()
    {
        return $this->profilePhoto;
    }

    public function setProfilePhoto($profilePhoto)
    {
        $this->profilePhoto = $profilePhoto;

        return $this;
    }

    public function getCoverPhoto()
    {
        return $this->coverPhoto;
    }

    public function setCoverPhoto($coverPhoto)
    {
        $this->coverPhoto = $coverPhoto;

        return $this;
    }

    public function getPost()
    {
        return $this->post;
    }

    public function getFriendship()
    {
        return $this->friendship;
    }

    public function getRegisterDate()
    {
        return $this->registerDate;
    }

    public function setRegisterDate($registerDate)
    {
        $this->registerDate = $registerDate;

        return $this;
    }

    public function getBirthdayDate()
    {
        return $this->birthdayDate;
    }

    public function setBirthdayDate($birthdayDate)
    {
        $this->birthdayDate = $birthdayDate;

        return $this;
    }

    //Post region

    public function submitPost($postText)
    {
        $this->post->submitPost($this->getId(), $postText);
    }

    public function getPosts()
    {
        return $this->post->getPosts($this->getId());
    }

    public function deletePost($postId)
    {
        $this->post->deletePost($postId);
    }

    public function getReaction($postId)
    {
        return $this->post->getUserReaction($this->getId(), $postId);
    }

    //Friendship region

    public function isFriendOf($userToId)
    {
        return $this->friendship->isFriendOf($this->getId(), $userToId);
    }

    public function didReceiveRequest($userToId)
    {
        return $this->friendship->didReceiveRequest($this->getId(), $userToId);
    }

    public function didSendRequest($userToId)
    {
        return $this->friendship->didSendRequest($this->getId(), $userToId);
    }

    public function sendRequest($userToId)
    {
        return $this->friendship->sendRequest($this->getId(), $userToId);
    }

    public function removeFriend($userIdToRemove)
    {
        $this->friendship->removeFriend($this->getId(), $userIdToRemove);
    }

    public function getMutualFriends($userIdToCheck)
    {
        return $this->friendship->getMutualFriends($this->getId(), $userIdToCheck);
    }

    public function getFriendRequests()
    {
        return $this->friendship->getFriendRequests($this->getId());
    }

    public function getFriends()
    {
        $friends = $this->friendship->getFriends($this->getId());

        return $friends;
    }

    public function acceptFriendRequest($userToId)
    {
        $this->friendship->acceptFriendRequest($this->getId(), $userToId);
    }

    public function rejectFriendRequest($userToId)
    {
        $this->friendship->rejectFriendRequest($this->getId(), $userToId);
    }
}
