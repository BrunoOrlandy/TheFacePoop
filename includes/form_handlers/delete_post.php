<?php

require '../../config/config.php';

if (isset($_GET['post_id']))
	$post_id = $_GET['post_id'];

if (isset($_POST['result'])) {
	if ($_POST['result'] == 'true')
		$query = pg_query($con, "UPDATE posts SET is_deleted=true WHERE post_id='$post_id'");
}
