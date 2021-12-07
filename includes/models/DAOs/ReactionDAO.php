<?php
class ReactionDAO
{
    private $con;

    public function __construct()
    {
        $this->con = $GLOBALS['con'];
    }

    public function submitReaction($userId, $postId, $reactionValue)
    {
        $inclusion_date = date("Y-m-d h:i:s");
        pg_query($this->con, "INSERT INTO reactions VALUES(default, '$userId', '$postId', '$reactionValue', '$inclusion_date')");
    }

    public function getReactions($postId)
    {
        $query = pg_query($this->con, "SELECT * FROM reactions WHERE post_id=$postId");
        $reactions = array();

        while ($row = pg_fetch_array($query)) {
            $reaction = new Reaction();
            $reaction->setId($row['reaction_id']);
            $reaction->setReactionType($row['reaction_value']);
            $reaction->setDate($row['inclusion_date']);

            $reactions[] = $reaction;
        }

        return $reactions;
    }

    public function getUserReaction($userId, $postId)
    {
        $query = pg_query($this->con, "SELECT * FROM reactions WHERE user_id=$userId AND post_id=$postId");
        $row = pg_fetch_array($query);

        if ($row) {
            $reaction = new Reaction();
            $reaction->setId($row['reaction_id']);
            $reaction->setReactionType($row['reaction_value']);
            $reaction->setDate($row['inclusion_date']);
            
            return $reaction;
        }

        return null;
    }

    public function deleteReaction($reactionId)
    {
        pg_query($this->con, "DELETE FROM reactions WHERE reaction_id=$reactionId");
    }
}
