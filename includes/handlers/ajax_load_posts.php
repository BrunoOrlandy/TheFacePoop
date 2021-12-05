<?php

include("../../config/config.php");
include("../models/User.php");
include("../models/Post.php");
include("../models/Reaction.php");
include("../models/Search.php");
include("../models/Friendship.php");
include("../models/DAOs/UserDAO.php");
include("../models/DAOs/PostDAO.php");
include("../models/DAOs/ReactionDAO.php");
include("../models/DAOs/SearchDAO.php");
include("../models/DAOs/FriendshipDAO.php");

$limit = 10;
$loggedUser = new User($_REQUEST['userID']);
$friends = $loggedUser->getFriends();

foreach ($friends as &$user) {
    if ($user instanceof User) {

        if (!$user->getIsActive())
            continue;

        $posts = $user->getPosts();

        foreach ($posts as &$post) {
            if ($post instanceof Post) {

                $page = $_REQUEST['page'];
                $num_iterations = 0;
                $count = 1;

                if ($page == 1)
                    $start = 0;
                else
                    $start = ($page - 1) * $limit;

                $str = "";

                if ($num_iterations++ < $start)
                    continue;
                if ($count > $limit) {
                    break;
                } else {
                    $count++;
                }

                $userId = $user->getId();
                $firstName = $user->getFirstName();
                $lastName = $user->getLastName();
                $profilePhoto = $user->getProfilePhoto();
                $postId = $post->getId();
                $postText = $post->getText();
                $postDate = $post->getDate();

                if ($loggedUser->getId() == $userId)
                    $deleteButton = "<button class='delete_button btn-danger' id='post$postId'>Excluir</button>";
                else
                    $deleteButton = "";

                $str .= "<div class='status_post' onClick='javascript:toggle$postId()'>
                            <div class='post_profilePhoto'>
                                <img src='$profilePhoto' width='50'>
                            </div>

                            <div class = 'post_main_frame' style='margin-left: 8px;'>

                                <div class='posted_by' style='color:#ACACAC;'>
                                    <a href=profile.php?profileUserID='$userId'> $firstName $lastName </a> &nbsp;&nbsp;&nbsp;&nbsp; $postDate
                                    $deleteButton
                                </div>
                                <div id='post_body'>
                                    <p style='font-size: 27px; line-height: 30px; margin-top: 10px;'>$postText<p>
                                    <br>
                                    <br>
                                    <br>
                                </div>
                            </div>				
                            
                            <div class='newsfeedPostOptions'>
                                <iframe src='reaction.php?post_id=$postId' scrolling='no'></iframe>
                            </div>

                        </div>
                        <hr>";

?>
                <script>
                    $(document).ready(function() {
                        $('#post<?php echo $postId; ?>').on('click', function() {
                            bootbox.confirm("Tem certeza que deseja excluir esta postagem?", function(result) {
                                $.post("includes/form_handlers/delete_post.php?post_id=<?php echo $postId; ?>&user_id=<?php echo $userId; ?>", {
                                    result: result
                                });

                                if (result)
                                    location.reload();
                            });
                        });


                    });
                </script>



<?php

            }

            if ($count < $limit)
                $str .= "<input type='hidden' class='nextPage' value='" . ($page + 1) . "'>
                        <input type='hidden' class='noMorePosts' value='false'>";
            else
                $str .= "<input type='hidden' class='noMorePosts' value='true'><p style='text-align: centre;'> Não existem mais postagens! </p>";

            echo $str;
        }
    }
}

?>