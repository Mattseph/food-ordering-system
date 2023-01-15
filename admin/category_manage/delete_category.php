<?php

include '../../configuration.php';

if (filter_has_var(INPUT_GET, 'category_id') && filter_has_var(INPUT_GET, 'image_name')) {
	$clean_id = filter_var($_GET['category_id'], FILTER_SANITIZE_NUMBER_INT);
	$category_id = filter_var($clean_id, FILTER_VALIDATE_INT);

	$image_name = htmlspecialchars($_GET['image_name']);

	if ($image_name != "") {
		$path = "../../images/category/" . $image_name;
		$remove = unlink($path);

		if ($remove == false) {
			$_SESSION['remove'] = "
			<div class='alert alert--danger' id='alert'>
				<div class='alert__message'>	
					Failed to Remove Category Image
				</div>
			</div>
		";

			header('location' . SITEURL . 'admin/category_manage/category_manage.php');
			die();
		}
	}
	mysqli_query($conn, "SET FOREIGN_KEY_CHECKS=0");
	$sql = "DELETE FROM category_list WHERE category_id = $category_id";

	$res = mysqli_query($conn, $sql);

	if ($res) {
		$_SESSION['delete'] = "
			<div class='alert alert--success' id='alert'>
				<div class='alert__message'>
					Category Deleted Successfully
				</div>
			</div>
		";

		header('location:' . SITEURL . 'admin/category_manage/category_manage.php');
	} else {
		$_SESSION['delete'] = "
			<div class='alert alert--danger' id='alert'>
				<div class='alert__message'>	
					Failed to Delete Category
				</div>
			</div>
		";

		header('location:' . SITEURL . 'admin/category_manage/category_manage.php');
	}
} else {
	header('location:' . SITEURL . 'admin/category_manage/category_manage.php');
}
