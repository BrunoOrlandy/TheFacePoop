<?php
include("includes/header.php");

if (isset($_GET['profileUserID'])) {
  $profileUserID = $_GET['profileUserID'];
}

if (isset($_POST['remove_friend'])) {
  $user = new User($loggedUserID);
  $user->removeFriend($profileUserID);
}

if (isset($_POST['add_friend'])) {
  $user = new User($loggedUserID);
  $user->sendRequest($profileUserID);
}

if (isset($_POST['respond_request'])) {
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

  <form action="<?php echo $profileUserID; ?>" method="POST">

    <?php

    if ($loggedUser->getId() != $profileUserID) {
      if ($loggedUser->isFriendOf($uprofileUserID)) {
        echo '<input type="submit" name="remove_friend" class="danger" value="Excluir amigo"><br>';
      } else if ($loggedUser->didReceiveRequest($profileUserID)) {
        echo '<input type="submit" name="respond_request" class="default" value="Responder solicitação"><br>';
      } else if ($loggedUser->didSendRequest($profileUserID)) {
        echo '<input type="submit" name="" class="default" value="Solicitação enviada"><br>';
      } else
        echo '<input type="submit" name="add_friend" class="success" value="Adicionar amigo"><br>';
    }

    ?>
  </form>

  <input type="submit" class="blue" data-toggle="modal" data-target="#post_form" value="Nova postagem">

  <?php

  if ($loggedUserID != $profileUserID) {

    echo '<div class="profile_info_bottom">';

    echo $loggedUser->getMutualFriends($profileUserID) . " amigo(s) em comum";

    echo '</div>';
  }

  ?>

</div>

<div class="profile_main_column column">

  <div class="tab-content">
    <div role="tabpanel" class="tab-pane fade in active" id="newsfeed_div">
      <div class="posts_area"></div>
      <img id="loading" src="assets/images/icons/loading.gif">
    </div>
  </div>

</div>

<div class="modal fade" id="post_form" tabindex="-1" role="dialog" aria-labelledby="postModalLabel" aria-hidden="true" style="z-index: 9999; margin-top: 60px;">

  <div class="modal-dialog">

    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="postModalLabel">Nova postagem!</h4>

      </div>

      <div class="modal-body">

        <form class="profile_post" action="" method="POST">

          <div class="form-group">

            <textarea class="form-control" name="post_body"></textarea>

            <input type="hidden" name="logged_user" value="<?php echo $profileUserID; ?>">

          </div>
        </form>
      </div>


      <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>

        <button type="button" class="btn btn-primary" name="post_button" id="submit_profile_post">Postar</button>

      </div>
    </div>
  </div>
</div>

<script>
  var userID = '<?php echo $profileUserID; ?>';

  $(document).ready(function() {

    $('#loading').show();

    $.ajax({
      url: "includes/handlers/ajax_load_profile_posts.php",
      type: "POST",
      data: "page=1&userID=" + userID,
      cache: false,

      success: function(data) {
        $('#loading').hide();
        $('.posts_area').html(data);
      }
    });

    $(window).scroll(function() {
      var height = $('.posts_area').height();
      var scroll_top = $(this).scrollTop();
      var page = $('.posts_area').find('.nextPage').val();
      var noMorePosts = $('.posts_area').find('.noMorePosts').val();

      if ((document.body.scrollHeight == document.body.scrollTop + window.innerHeight) && noMorePosts == 'false') {
        $('#loading').show();

        var ajaxReq = $.ajax({
          url: "includes/handlers/ajax_load_profile_posts.php",
          type: "POST",
          data: "page=" + page + "&userID=" + userID,
          cache: false,

          success: function(response) {
            $('.posts_area').find('.nextPage').remove();
            $('.posts_area').find('.noMorePosts').remove();

            $('#loading').hide();
            $('.posts_area').append(response);
          }
        });

      }

      return false;

    });
  });
</script>
</div>
</body>

</html>