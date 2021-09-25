<?php

class Image
{
    private $id;
    private $bytes;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getBytes()
    {
        return $this->bytes;
    }

    public function setBytes($bytes)
    {
        $this->bytes = $bytes;

        return $this;
    }
}
