<?php

include '../../configuration/constants.php';

if (filter_has_var(INPUT_GET, 'category_id') && filter_has_var(INPUT_GET, 'image_name')) {
	$clean_id = filter_var($_GET['category_id'], FILTER_SANITIZE_NUMBER_INT);
	$category_id = filter_var($clean_id, FILTER_VALIDATE_INT);

	$image_name = htmlspecialchars($_GET['image_name']);

	if ($image_name != "") {
		$path = "../../images/category/" . $image_name;
		$remove = unlink($path);

		if ($remove == false) {
			$_SESSION['remove'] = "<div id='message' class='fail category-message'><img src='../../images/logo/warning.svg' alt='warning' class='warning'><span>Failed to Remove Category Image</span></div>";

			header('location' . SITEURL . 'admin/category_manage/category_manage.php');
			die();
		}
	}
	mysqli_query($conn, "SET FOREIGN_KEY_CHECKS=0");
	
	$sql = "DELETE FROM food_list WHERE category_id = $category_id";
	$sql2 = "DELETE FROM category_list WHERE category_id = $category_id";

	$res = mysqli_query($conn, $sql);
	$res2 = mysqli_query($conn, $sql2);

	if ($res && $res2) {
		$_SESSION['delete'] = "<div id='message' class='success category-message'><img src='../../images/logo/successful.svg' alt='successful' class='successful'><span>Category Deleted Successfuly</span></div>";

		header('location:' . SITEURL . 'admin/category_manage/category_manage.php');
	} else {
		$_SESSION['delete'] = "<div id='message' class='fail category-message'><img src='../../images/logo/warning.svg' alt='warning' class='warning'><span>Failed to Delete Category</span></div>";

		header('location:' . SITEURL . 'admin/category_manage/category_manage.php');
	}
} else {
	header('location:' . SITEURL . 'admin/category_manage/category_manage.php');
}
