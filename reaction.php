<html>

<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="assets/css/fontsawesome.css">
    <link rel="stylesheet" type="text/css" href="assets/css/all.css">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="assets/css/jquery.Jcrop.css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/bootbox.min.js"></script>
    <script src="assets/js/bootbox.locales.min.js"></script>

    <script src="assets/js/facepoop.js"></script>
    <script src="assets/js/jquery.jcrop.js"></script>
    <script src="assets/js/jcrop_bits.js"></script>
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
    require 'config/config.php';
    include("includes/models/User.php");
    include("includes/models/Post.php");
    include("includes/models/Reaction.php");
    include("includes/models/Search.php");
    include("includes/models/Friendship.php");
    include("includes/models/DAOs/UserDAO.php");
    include("includes/models/DAOs/PostDAO.php");
    include("includes/models/DAOs/ReactionDAO.php");
    include("includes/models/DAOs/SearchDAO.php");
    include("includes/models/DAOs/FriendshipDAO.php");

    if (isset($_GET['post_id']) && isset($_GET['user_id'])) {
        $postId = $_GET['post_id'];
        $userId = $_GET['user_id'];
    }

    $post = new Post();
    $post->setId($postId);
    $reactions = $post->getReactions();
    $likes = 0;
    $dislikes = 0;
    $surprises = 0;
    $laughes = 0;
    $sadnesses = 0;
    $angers = 0;

    foreach ($reactions as &$reaction) {
        switch ($reaction->getReactionType()) {
            case 0:
                $likes++;
                break;
            case 1:
                $dislikes++;
                break;
            case 2:
                $surprises++;
                break;
            case 3:
                $laughes++;
                break;
            case 4:
                $sadnesses++;
                break;
            case 5:
                $angers++;
                break;
        }
    }

    $user = new User($userId);
    if (isset($_POST['like_button'])) {
        $reaction = $user->getReaction($post->getId());

        if (is_null($reaction))
            $user->reactTo($post->getId(), ReactionType::LIKE);
        else if (!is_null($reaction) && $reaction->getReactionType() == ReactionType::LIKE) {
            $user->unReactTo($reaction->getId());
        } else
            $user->changeReaction($post->getId(), ReactionType::LIKE);
    }

    if (isset($_POST['dislike_button'])) {
        $reaction = $user->getReaction($post->getId());

        if (is_null($reaction))
            $user->reactTo($post->getId(), ReactionType::DISLIKE);
        else if (!is_null($reaction) && $reaction->getReactionType() == ReactionType::DISLIKE) {
            $user->unReactTo($reaction->getId());
        } else
            $user->changeReaction($post->getId(), ReactionType::DISLIKE);
    }

    if (isset($_POST['surprise_button'])) {
        $reaction = $user->getReaction($post->getId());

        if (is_null($reaction))
            $user->reactTo($post->getId(), ReactionType::SURPRISE);
        else if (!is_null($reaction) && $reaction->getReactionType() == ReactionType::SURPRISE) {
            $user->unReactTo($reaction->getId());
        } else
            $user->changeReaction($post->getId(), ReactionType::SURPRISE);
    }

    if (isset($_POST['laugh_button'])) {
        $reaction = $user->getReaction($post->getId());

        if (is_null($reaction))
            $user->reactTo($post->getId(), ReactionType::LAUGH);
        else if (!is_null($reaction) && $reaction->getReactionType() == ReactionType::LAUGH) {
            $user->unReactTo($reaction->getId());
        } else
            $user->changeReaction($post->getId(), ReactionType::LAUGH);
    }

    if (isset($_POST['sadness_button'])) {
        $reaction = $user->getReaction($post->getId());

        if (is_null($reaction))
            $user->reactTo($post->getId(), ReactionType::SADNESS);
        else if (!is_null($reaction) && $reaction->getReactionType() == ReactionType::SADNESS) {
            $user->unReactTo($reaction->getId());
        } else
            $user->changeReaction($post->getId(), ReactionType::SADNESS);
    }

    if (isset($_POST['anger_button'])) {
        $reaction = $user->getReaction($post->getId());

        if (is_null($reaction))
            $user->reactTo($post->getId(), ReactionType::ANGER);
        else if (!is_null($reaction) && $reaction->getReactionType() == ReactionType::ANGER) {
            $user->unReactTo($reaction->getId());
        } else
            $user->changeReaction($post->getId(), ReactionType::ANGER);
    }

    echo '<form action="reaction.php?post_id=' . $postId . '&user_id=' . $userId . '" method="POST" id="form_like">
            <button type="submit" name="like_button" class="btn">
			    <i class="fa fa-thumbs-up"></i>
                    <div class="like_value">
                        ' . $likes . ' 
                    </div>
		    </button>
        </form>
        ';
    echo '<form action="reaction.php?post_id=' . $postId . '&user_id=' . $userId . '" method="POST" id="form_dislike">
            <button type="submit" name="dislike_button" class="btn comment_like">
                <i class="fa fa-thumbs-down"></i>
                    <div class="like_value">
                        ' . $dislikes . ' 
                    </div>
            </button>
        </form>
    ';
    echo '<form action="reaction.php?post_id=' . $postId . '&user_id=' . $userId . '" method="POST" id="form_surprise">
            <button type="submit" name="surprise_button" class="btn">
			    <i class="fas fa-surprise"></i>
                    <div class="like_value">
                        ' . $surprises . ' 
                    </div>
		    </button>
        </form>
        ';
    echo '<form action="reaction.php?post_id=' . $postId . '&user_id=' . $userId . '" method="POST" id="form_laugh">
            <button type="submit" name="laugh_button" class="btn">
            <i class="fa fa-laugh-squint"></i>
                <div class="like_value">
                    ' . $laughes . ' 
                </div>
            </button>
        </form>
    ';
    echo '<form action="reaction.php?post_id=' . $postId . '&user_id=' . $userId . '" method="POST" id="form_sadness">
            <button type="submit" name="sadness_button" class="btn">
            <i class="fas fa-sad-tear"></i>
                <div class="like_value">
                        ' . $sadnesses . ' 
                    </div>
		    </button>
        </form>
        ';
    echo '<form action="reaction.php?post_id=' . $postId . '&user_id=' . $userId . '" method="POST" id="form_anger">
        <button type="submit" name="anger_button" class="btn">
            <i class="fas fa-angry"></i>
                <div class="like_value">
                    ' . $angers . ' 
                </div>
        </button>
    </form>
    ';
    ?>

</body>

</html>