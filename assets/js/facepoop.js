$(document).ready(function () {

	$('#search_text_input').focus(function () {
		if (window.matchMedia("(min-width: 800px)").matches) {
			$(this).animate({ width: '250px' }, 500);
		}
	});

	$('.search_button').on('click', function () {
		document.search_form.submit();
	})

	$('#submit_profile_post').click(function () {
		$.ajax({
			type: "POST",
			url: "includes/handlers/ajax_submit_profile_post.php",
			data: $('form.profile_post').serialize(),
			success: function (msg) {
				$("#post_form").modal('hide');
				location.reload();
			},
			error: function () {
				alert('Não foi possível postar :C');
			}
		});

	});
});


$(document).click(function (e) {

	if (e.target.class != "search_results" && e.target.id != "search_text_input") {

		$(".search_results").html("");
		$('.search_results_footer').html("");
		$('.search_results_footer').toggleClass("search_results_footer_empty");
		$('.search_results_footer').toggleClass("search_results_footer");
	}

	if (e.target.className != "dropdown_data_window") {

		$(".dropdown_data_window").html("");
		$(".dropdown_data_window").css({ "padding": "0px", "height": "0px" });
	}
});

function getUsers(value, user) {
	$.post("includes/handlers/ajax_friend_search.php", { query: value, loggedUserLogin: user }, function (data) {
		$(".results").html(data);
	});
}

function getLiveSearchUsers(value, user) {

	$.post("includes/handlers/ajax_search.php", { query: value, loggedUserLogin: user }, function (data) {

		if ($(".search_results_footer_empty")[0]) {
			$(".search_results_footer_empty").toggleClass("search_results_footer");
			$(".search_results_footer_empty").toggleClass("search_results_footer_empty");
		}

		$('.search_results').html(data);
		$('.search_results_footer').html("<a href='search.php?q=" + value + "'>Ver todos os resultados</a>");

		if (data == "") {
			$('.search_results_footer').html("");
			$('.search_results_footer').toggleClass("search_results_footer_empty");
			$('.search_results_footer').toggleClass("search_results_footer");
		}
	});
}