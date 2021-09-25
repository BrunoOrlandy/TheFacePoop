<?php

class Friendship
{
    private $user;
    private $requestDate;
    private $acceptanceDate;
    private $blockDate;

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;

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
}
