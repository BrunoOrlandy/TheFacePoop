<?php

class SearchDAO
{
    private $con;

    public function __construct()
    {
        $this->con = $GLOBALS['con'];
    }

    public function searchAll($searchString)
    {
        $results = array();

        $users = $this->searchUsers($searchString);
        if ($users != null)
            $results = $users;

        $posts = $this->searchPosts($searchString);
        if ($posts != null)
            $results = $posts;
            
        $comments = $this->searchComments($searchString);
        if ($comments != null)
            $results = $comments;

        return $results;
    }

    public function searchUsers($searchString)
    {
        $query = pg_query($this->con, "SELECT * FROM users WHERE (login LIKE '$searchString%' OR first_name LIKE '$searchString%' OR last_name LIKE '$searchString%') AND is_active=1 LIMIT 8");
        $users = array();

        while ($row = pg_fetch_array($query)) {
            $users[] = new User($row['user_id']);
        }

        return count($users) > 0 ? $users : null;
    }

    public function searchPosts($searchString)
    {
        $query = pg_query($this->con, "SELECT * FROM posts WHERE text LIKE '$searchString%' LIMIT 8");
        $posts = array();

        while ($row = pg_fetch_array($query)) {
            $posts[] = new User($row['user_id']);
        }

        return count($posts) > 0 ? $posts : null;
    }

    public function searchComments($searchString)
    {
        $query = pg_query($this->con, "SELECT * FROM comments WHERE text LIKE '$searchString%' LIMIT 8");
        $comments = array();

        while ($row = pg_fetch_array($query)) {
            $comments[] = new User($row['user_id']);
        }

        return count($comments) > 0 ? $comments : null;
    }
}
