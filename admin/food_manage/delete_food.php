<?php

include '../../configuration/constants.php';

if (filter_has_var(INPUT_GET, 'food_id') && filter_has_var(INPUT_GET, 'image_name')) {
	$sanitize_id = filter_var($_GET['food_id'], FILTER_SANITIZE_NUMBER_INT);
	$food_id = filter_var($sanitize_id, FILTER_VALIDATE_INT);

	$image_name = htmlspecialchars($_GET['image_name']);

	if ($image_name != "") {
		$path = "../../images/food/" . $image_name;
		$remove = unlink($path);
	}

	
	$sql = "DELETE FROM food_list WHERE food_id = $food_id";
	$res = mysqli_query($conn, $sql);

	if ($res) {
		$_SESSION['delete'] = "<div id='message' class='success food-message'><img src='../../images/logo/successful.svg' alt='successful' class='successful'><span>Food Deleted Successfuly</span></div>";

		header('location:' . SITEURL . 'admin/food_manage/food_manage.php');
	} else {
		$_SESSION['delete'] = "<div id='message' class='failed'><img src='../../images/logo/warning.svg' alt='warning' class='warning'><span>Failed to Delete Food</span></div>";

		header('location:' . SITEURL . 'admin/food_manage/food_manage.php');
	}
} else {
	$_SESSION['unauthorize'] = "<div id='message' class='fail food-message'><img src='../../images/logo/warning.svg' alt='warning' class='warning'><span>Failed to Delete Food</span></div>";

	header('location:' . SITEURL . 'admin/food_manage/food_manage.php');
}
