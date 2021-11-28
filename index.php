<?php
include("includes/header.php");

if (isset($_POST['post'])) {
	$post = new PostDAO($loggedUserID);
	$post->submitPost($_POST['post_text']);
}
?>

<div class="user_details column">

	<a href="profile.php?profileUserID=<?php echo $loggedUserID; ?>"> <img src="assets/images/profile_pics/imagem.jpg"> </a>

	<div class="user_details_left_right">

		<a href="profile.php?profileUserID=<?php echo $loggedUserID; ?>">

			<?php
			echo $loggedUser->getFirstName() . " " . $loggedUser->getLastName();

			?>
		</a>
		<br>
	</div>

</div>

<div class="main_column column">
	<form class="post_form" action="index.php" method="POST">

		<textarea name="post_text" id="post_text" placeholder="O que você tem em mente?"></textarea>
		<input type="submit" name="post" id="post_button" value="Publicar">
		<hr>

	</form>

	<div class="posts_area"></div>
	<img id="loading" src="assets/images/icons/loading.gif">

</div>


<script>
	var userID = '<?php echo $loggedUserID; ?>';

	$(document).ready(function() {

		$('#loading').show();

		$.ajax({
			url: "includes/handlers/ajax_load_posts.php",
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
					url: "includes/handlers/ajax_load_posts.php",
					type: "POST",
					data: "page=1&userID=" + userID,
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