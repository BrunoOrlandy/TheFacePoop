<?php

class User
{
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

    public function getFirstAndLastName(){
        return $this->getFirstName().  $this->getLastName();
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
}
