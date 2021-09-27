<?php

class Post
{
    private $date;
    private $images;
    private $comments;
    private $reactions;
    private $text;
    private $postDao;
    
    public function __construct($con, $user_id){
        $this->postDao = new PostDAO($con, $user_id);
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

    public function is_coment_valid($post_text_body){
        $post_text_body = strip_tags($post_text_body);
		$post_text_body = pg_escape_string($this->con, $post_text_body); 
		$check_empty = preg_replace('/\s+/', '', $post_text_body); 
        
        return  $check_empty == '';
    }

    public function submitPost($post_text_body)
    {       
        if(!$this->is_coment_valid($post_text_body)){
            $this->postDao->submitPost($post_text_body);
        } 
    }   

    // quando existir interação com outros usuarios;
    public function loadPostsFriends($data, $limit_pagination){
        $this->postDao->loadPostsFriends($data, $limit_pagination);
    }

    //proprias postagens;
    public function loadProfilePost($data, $limit_pagination){
        $this->postDao->loadProfilePosts($data, $limit_pagination);
    }



}
