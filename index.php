<?php
include("includes/header.php");

if (isset($_POST['post'])) {
	$loggedUser->submitPost($_POST['post_text']);
}
?>


<div class="main_column column">
	<form class="post_form" action="index.php" method="POST">

		<textarea name="post_text" id="post_text" placeholder="O que você tem em mente?"></textarea>
		<button type="submit" name="post" id="post_button" class="btn btn-primary">
			<i class="fa fa-paper-plane"></i>
		</button>
		<hr>

	</form>

	<div class="posts_area"></div>
	<img id="loading" src="assets/images/icons/loading.gif">

</div>


<script>
	var userID = '<?php echo $loggedUser->getId(); ?>';

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