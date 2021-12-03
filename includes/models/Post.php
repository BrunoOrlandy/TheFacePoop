<?php

class Post
{
    private $id;
    private $date;
    private $images;
    private $comments;
    private $reactions;
    private $text;

    private $postDAO;

    public function __construct()
    {
        $this->postDAO = new PostDAO();
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

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    public function getImages()
    {
        return $this->images;
    }

    public function setImages($images)
    {
        $this->images = $images;

        return $this;
    }

    public function getComments()
    {
        return $this->comments;
    }

    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    public function getReactions()
    {
        return $this->reactions;
    }

    public function setReactions($reactions)
    {
        $this->reactions = $reactions;

        return $this;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    public function submitPost($userId, $postText)
    {
        $this->postDAO->submitPost($userId, $postText);
    }

    public function getPosts($userId)
    {
        return $this->postDAO->getPosts($userId);
    }
}
