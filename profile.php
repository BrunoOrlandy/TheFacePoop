<?php 
include("includes/header.php");


if(isset($_GET['login'])) {

	$login = $_GET['login']; 

	$user_details_query = pg_query($con, "SELECT * FROM users WHERE login= $login "); // passar para o DAO
	$user_array = pg_fetch_array($user_details_query);
	$num_friends = (substr_count($user_array['friend_array'], ",")) - 1; // To count the number of friends using comma
}


if(isset($_POST['remove_friend'])) {

	$user = new User($con, $userLoggedIn);
	//$user->removeFriend($login);
}


if(isset($_POST['add_friend'])) {

	$user = new User($con, $userLoggedIn);
//	$user->sendRequest($login);
}

// Triggers when respond_request is clicked

if(isset($_POST['respond_request'])) {

	header("Location: requests.php");
}

 ?>

 	<style type="text/css">
	 	.wrapper {
	 		margin-left: 0px;
			padding-left: 0px;
	 	}

 	</style>
	
 	<div class="profile_left">

 		<img src="assets/images/profile_pics/imagem.jpg">


 		<div class="profile_info">
      <p><?php echo "Friends: ";?></p>
 		</div>

 		<form action="<?php echo $login; ?>" method="POST">

 			<?php 

 			$profile_user_obj = new User($con, $login); 

 			$logged_in_user_obj = new User($con, $userLoggedIn); 
 			?>
 		</form>

    <!-- Post's something section -->

 		<input type="submit" class="blue" data-toggle="modal" data-target="#post_form" value="Post Something">

    <!-- Displays profile info -->

    <?php  

    // Displays Mutual Friends count

    if($userLoggedIn != $login) {

      echo '<div class="profile_info_bottom">';

        echo $logged_in_user_obj->getMutualFriends($login) . " Mutual Friends";

      echo '</div>';
    }


    ?>

 	</div>


	<div class="profile_main_column column">

    <ul class="nav nav-tabs" role="tablist" id="profileTabs">
      <li role="presentation" class="active"><a href="#newsfeed_div" aria-controls="newsfeed_div" role="tab" data-toggle="tab">Newsfeed</a></li>
      <li role="presentation"><a href="#messages_div" aria-controls="messages_div" role="tab" data-toggle="tab">Messages</a></li>
    </ul>

    <div class="tab-content">

      <div role="tabpanel" class="tab-pane fade in active" id="newsfeed_div">
        <div class="posts_area"></div>
        <img id="loading" src="assets/images/icons/loading.gif">
      </div>


      <div role="tabpanel" class="tab-pane fade" id="messages_div">
        <?php  
        

          echo "<h4>You and <a href='" . $login ."'>" . $profile_user_obj->getFirstAndLastName() . "</a></h4><hr><br>";

          echo "<div class='loaded_messages' id='scroll_messages'>";
            //echo $message_obj->getMessages($login);
          echo "</div>";
        ?>



        <div class="message_post">
          <form action="" method="POST">
              <textarea name='message_body' id='message_textarea' placeholder='Write your message ...'></textarea>
              <input type='submit' name='post_message' class='info' id='message_submit' value='Send'>
          </form>

        </div>

        <script>
          var div = document.getElementById("scroll_messages");
          div.scrollTop = div.scrollHeight;
        </script>
      </div>


    </div>


	</div>

  <!-- Bootstrap modal form in profile page-->

  <div class="modal fade" id="post_form" tabindex="-1" role="dialog" aria-labelledby="postModalLabel" aria-hidden="true" style="z-index: 9999; margin-top: 60px;">

    <div class="modal-dialog">

      <div class="modal-content">

        <div class="modal-header">

          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="postModalLabel">Post something!</h4>

        </div>

        <div class="modal-body">

        	<p>This will appear on the user's profile page and also their newsfeed for your friends to see!</p>

        	<form class="profile_post" action="" method="POST">

        		<div class="form-group">

        			<textarea class="form-control" name="post_body"></textarea>

        			<input type="hidden" name="user_from" value="<?php echo $userLoggedIn; ?>">

        			<input type="hidden" name="user_to" value="<?php echo $login; ?>">

        		</div>
        	</form>
        </div>


        <div class="modal-footer">

          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

          <button type="button" class="btn btn-primary" name="post_button" id="submit_profile_post">Post</button>

        </div>
      </div>
    </div>
  </div>

<!-- Ajax calls for loading profile newsfeed -->


<script>
  var userLoggedIn = '<?php echo $userLoggedIn; ?>';
  var profileUsername = '<?php echo $login; ?>';

  $(document).ready(function() {

    $('#loading').show();

    //Original ajax request for loading first posts 
    $.ajax({
      url: "includes/handlers/ajax_load_profile_posts.php",
      type: "POST",
      data: "page=1&userLoggedIn=" + userLoggedIn + "&profileUsername=" + profileUsername,
      cache:false,

      success: function(data) {
        $('#loading').hide();
        $('.posts_area').html(data);
      }
    });

    $(window).scroll(function() {
      var height = $('.posts_area').height(); //Div containing posts
      var scroll_top = $(this).scrollTop();
      var page = $('.posts_area').find('.nextPage').val();
      var noMorePosts = $('.posts_area').find('.noMorePosts').val();

      if ((document.body.scrollHeight == document.body.scrollTop + window.innerHeight) && noMorePosts == 'false') {
        $('#loading').show();

        var ajaxReq = $.ajax({
          url: "includes/handlers/ajax_load_profile_posts.php",
          type: "POST",
          data: "page=" + page + "&userLoggedIn=" + userLoggedIn + "&profileUsername=" + profileUsername,
          cache:false,

          success: function(response) {
            $('.posts_area').find('.nextPage').remove(); //Removes current .nextpage 
            $('.posts_area').find('.noMorePosts').remove(); //Removes current .nextpage 

            $('#loading').hide();
            $('.posts_area').append(response);
          }
        });

      } //End if 

      return false;

    }); //End (window).scroll(function())


  });

  </script>





	</div>
</body>
</html>