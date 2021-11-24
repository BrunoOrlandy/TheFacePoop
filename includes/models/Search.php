<?php

class Search
{
    private $searchDAO;

    public function __construct()
    {
        $this->searchDAO = new SearchDAO();
    }

    public function searchFor($searchString, $type)
    {
        switch ($type) {
            case "users":
                return $this->searchDAO->searchUsers($searchString);
            case "posts":
                return $this->searchDAO->searchPosts($searchString);
            case "comments":
                return $this->searchDAO->searchComments($searchString);
            default:
                return $this->searchDAO->searchAll($searchString);
        }
    }
}
