<?php
class PostDAO
{
	private $con;

	public function __construct()
	{
		$this->con = $GLOBALS['con'];
	}

	public function submitPost($userId, $postText)
	{
		$postText = strip_tags($postText);
		$isEmpty = preg_replace('/\s+/', '', $postText) == "";

		if (!$isEmpty) {
			$inclusion_date = date("Y-m-d h:i:s");
			pg_query($this->con, "INSERT INTO posts VALUES(default, default, '$userId', '$postText', '$inclusion_date', false)");
		}
	}

	public function getPosts($userId)
	{
		$query = pg_query($this->con, "SELECT * FROM posts WHERE user_id=$userId AND is_deleted=false ORDER BY post_id DESC");
		$posts = array();

		while ($row = pg_fetch_array($query)) {
			$post = new Post();
			$post->setId($row['post_id']);
			$post->setText($row['text']);
			$post->setDate($row['inclusion_date']);
			
			$posts[] = $post;
		}

		return $posts;
	}

	public function deletePost($postId)
    {
		$query = pg_query($this->con, "UPDATE posts SET is_deleted=true WHERE post_id='$postId'");
    }
}

?>