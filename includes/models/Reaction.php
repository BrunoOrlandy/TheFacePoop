<?php

class Reaction
{
    private $id;
    private $date;
    private $reactionType;

    private $reactionDAO;

    public function __construct()
    {
        $this->reactionDAO = new ReactionDAO();
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

    public function getReactionType()
    {
        return $this->reactionType;
    }

    public function setReactionType($reactionType)
    {
        $this->reactionType = $reactionType;

        return $this;
    }

    public function submitReaction($userId, $postId, $reactionValue)
    {
        $this->reactionDAO->submitReaction($userId, $postId, $reactionValue);
    }

    public function getReactions($postId)
    {
        return $this->reactionDAO->getReactions($postId);
    }

    public function getUserReaction($userId, $postId)
    {
        return $this->reactionDAO->getUserReaction($userId, $postId);
    }
}

abstract class ReactionType
{
    const LIKE = 0;
    const DISLIKE = 1;
    const SUPRISE = 2;
    const LAUGH = 3;
    const SADNESS = 4;
    const ANGER = 5;
}
