<?php

class User
{
    private $id;
    private $login;
    private $firstName;
    private $lastName;
    private $email;
    private $password;
    private $description;
    private $profilePhoto;
    private $coverPhoto;
    private $posts;
    private $friendships;
    private $registerDate;
    private $birthdayDate;

    private $userDAO;

    public function __construct($userId)
    {
        $this->userDAO = new UserDAO($userId);

        $this->setId($this->userDAO->getID());
        $this->setFirstName($this->userDAO->getFirstName());
        $this->setLastName($this->userDAO->getLastName());
        $this->setId($this->userDAO->getID());
        $this->setId($this->userDAO->getID());
        $this->setId($this->userDAO->getID());
        $this->setId($this->userDAO->getID());
        $this->setId($this->userDAO->getID());
        $this->setId($this->userDAO->getID());
        $this->setId($this->userDAO->getID());
        $this->setId($this->userDAO->getID());
        $this->setId($this->userDAO->getID());
        $this->setId($this->userDAO->getID());
        $this->setId($this->userDAO->getID());
        $this->setId($this->userDAO->getID());
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

    public function getPosts()
    {
        return $this->posts;
    }

    public function setPosts($posts)
    {
        $this->posts = $posts;

        return $this;
    }

    public function getFriendships()
    {
        return $this->friendships;
    }

    public function setFriendships($friendships)
    {
        $this->friendships = $friendships;

        return $this;
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

    public function isFriendOf($userToId)
    {
        return $this->userDAO->isFriendOf($userToId);
    }

    public function didReceiveRequest($userToId)
    {
        return $this->userDAO->didReceiveRequest($userToId);
    }

    public function didSendRequest($userToId)
    {
        return $this->userDAO->didSendRequest($userToId);
    }

    public function sendRequest($userToId)
    {
        return $this->userDAO->sendRequest($userToId);
    }

    public function removeFriend($userIdToRemove)
    {
        $this->userDAO->removeFriend($userIdToRemove);
    }

    public function getMutualFriends($userIdToCheck)
    {
        return $this->userDAO->getMutualFriends($userIdToCheck);
    }
}
