<?php

include("includes/header.php");

$profile_id = $loggedUser->getId();
$imgSrc = "";
$result_path = "";
$msg = "";

if (!isset($_POST['x']) && !isset($_FILES['image']['name'])) {
	$temppath = 'assets/images/profile_pics/' . $profile_id . 'fb_default_green_sea.jpeg';
	if (file_exists($temppath)) {
		@unlink($temppath);
	}
}

if (isset($_FILES['image']['name'])) {

	$tempName = $_FILES["image"]["tmp_name"];
	$imageName = $_FILES["image"]["name"];
	$imageName = str_replace(" ", "_", $imageName);
	$finalImageName = $profile_id . '_' . $imageName;
	$imageCopyFilePath = "./assets/images/profile_pics/$finalImageName";
	$imageDBFilePath = "assets/images/profile_pics/$finalImageName";
	$result = copy($tempName, $imageCopyFilePath);

	if ($result) {
		pg_query($con, "INSERT INTO images VALUES(default, '$imageDBFilePath')");
		$query = pg_query($con, "SELECT image_id FROM images WHERE file='$imageDBFilePath'");
		$row = pg_fetch_array($query);
		$imageId = $row['image_id'];

		pg_query($con, "UPDATE users SET image_id='$imageId' WHERE user_id='$profile_id'");
	}

	header("Location: settings.php");
}
?>
<div id="Overlay" style=" width:100%; height:100%; border:0px #990000 solid; position:absolute; top:0px; left:0px; z-index:2000; display:none;"></div>
<div class="main_column column">


	<div id="formExample">

		<p><b> <?= $msg ?> </b></p>

		<form action="upload.php" method="post" enctype="multipart/form-data">
			Selecione uma imagem
			<br /><br />
			<input type="file" id="image" name="image" /><br /><br />
			<button type="submit" class="btn btn-primary" ><i class="fa fa-upload"></i></button>
		</form><br /><br />

	</div>


</div>

<br /><br />