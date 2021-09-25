<?php

class Reaction
{
    private $date;
    private $user;
    private $reactionType;

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;

        return $this;
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

    public function getReactionType()
    {
        return $this->reactionType;
    }

    public function setReactionType($reactionType)
    {
        $this->reactionType = $reactionType;

        return $this;
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
