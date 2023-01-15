<?php

include '../../configuration.php';

if (filter_has_var(INPUT_GET, 'food_id') && filter_has_var(INPUT_GET, 'image_name')) {
	$sanitize_id = filter_var($_GET['food_id'], FILTER_SANITIZE_NUMBER_INT);
	$food_id = filter_var($sanitize_id, FILTER_VALIDATE_INT);

	$image_name = htmlspecialchars($_GET['image_name']);

	if ($image_name != "") {
		$path = "../../images/food/" . $image_name;
		$remove = unlink($path);
	}

	mysqli_query($conn, "SET FOREIGN_KEY_CHECKS=0");
	$sql = "DELETE FROM food_list WHERE food_id = $food_id";
	$res = mysqli_query($conn, $sql);

	if ($res) {
		$_SESSION['delete'] = "
			<div class='alert alert--success' id='alert'>
				<div class='alert__message'>
					Food Deleted Successfully
				</div>
			</div>
		";
		header('location:' . SITEURL . 'admin/food_manage/food_manage.php');
	} else {
		$_SESSION['delete'] = "
			<div class='alert alert--danger' id='alert'>
				<div class='alert__message'>	
					Failed to Delete Food
				</div>
			</div>
		";

		header('location:' . SITEURL . 'admin/food_manage/food_manage.php');
	}
} else {
	$_SESSION['no_foodid_found'] = "
		<div class='alert alert--danger' id='alert'>
			<div class='alert__message'>	
				Food Id Not Found
			</div>
		</div>
	";

	header('location:' . SITEURL . 'admin/food_manage/food_manage.php');
}
