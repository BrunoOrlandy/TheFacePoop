<html>

<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>

<body>

    <style type="text/css">
        * {
            font-family: 'caveat-regular', Monospace;
        }

        body {
            background-color: #fff;
        }

        form {
            position: absolute;
            top: 0;
        }

        input[type="submit"]:focus {
            outline: 0;
        }
    </style>

    <?php
    include("includes/header.php");

    // if (isset($_SESSION['username'])) {
    //     $userLoggedIn = $_SESSION['username'];
    //     $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
    //     $user = mysqli_fetch_array($user_details_query);
    // } else {
    //     header("Location: register.php");
    // }

    if (isset($_GET['post_id'])) {
        $postId = $_GET['post_id'];
    }

    $post = new Post();
    $post->setId($postId);
    $reactions = $post->getReactions();

    // $get_likes = mysqli_query($con, "SELECT likes, added_by FROM posts WHERE id='$postId'");
    // $row = mysqli_fetch_array($get_likes);
    // $total_likes = $row['likes'];
    // $user_liked = $row['added_by'];

    // $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$user_liked'");
    // $row = mysqli_fetch_array($user_details_query);
    // $total_user_likes = $row['num_likes'];

    if (isset($_POST['like_button'])) {
        $post->submitReaction($loggedUser->getId(), 0);
    }

    if (isset($_POST['dislike_button'])) {
        $post->submitReaction($loggedUser->getId(), 1);
    }

    if (isset($_POST['surprise_button'])) {
        $post->submitReaction($loggedUser->getId(), 2);
    }

    if (isset($_POST['laugh_button'])) {
        $post->submitReaction($loggedUser->getId(), 3);
    }

    if (isset($_POST['sadness_button'])) {
        $post->submitReaction($loggedUser->getId(), 4);
    }

    if (isset($_POST['anger_button'])) {
        $post->submitReaction($loggedUser->getId(), 5);
    }

    $reaction = $loggedUser->getReaction($postId);

    if ($reaction->getReactionType() != null) {
        switch ($reaction->getReactionType()) {
            case 0:
                echo '<form action="reaction.php?post_id=' . $postId . '" method="POST">
				    <input type="submit" class="comment_like" name="like_button" value="Like">
				    <div class="like_value">
					    ' . $total_likes . ' Likes 
				    </div>
			        </form>
		        ';
                break;
            case 1:
                echo '<form action="reaction.php?post_id=' . $postId . '" method="POST">
				    <input type="submit" class="comment_like" name="dislike_button" value="Unlike">
				    <div class="like_value">
					    ' . $total_likes . ' Likes 
				    </div>
			        </form>
		        ';
                break;
            case 2:
                echo '<form action="reaction.php?post_id=' . $postId . '" method="POST">
				    <input type="submit" class="comment_like" name="surprise_button" value="Surprise">
				    <div class="like_value">
					    ' . $total_likes . ' Likes 
				    </div>
			        </form>
		        ';
                break;
            case 3:
                echo '<form action="reaction.php?post_id=' . $postId . '" method="POST">
                    <input type="submit" class="comment_like" name="laugh_button" value="Laugh">
                    <div class="like_value">
                        ' . $total_likes . ' Likes 
                    </div>
                    </form>
                ';
                break;
            case 4:
                echo '<form action="reaction.php?post_id=' . $postId . '" method="POST">
                    <input type="submit" class="comment_like" name="sadness_button" value="Sadness">
                    <div class="like_value">
                        ' . $total_likes . ' Likes 
                    </div>
                    </form>
                ';
                break;
            case 5:
                echo '<form action="reaction.php?post_id=' . $postId . '" method="POST">
                    <input type="submit" class="comment_like" name="anger_button" value="Anger">
                    <div class="like_value">
                        ' . $total_likes . ' Likes 
                    </div>
                    </form>
                ';
                break;
        }
    }
    ?>

</body>

</html>