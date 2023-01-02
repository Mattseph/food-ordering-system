<?php

include '../../configuration/constants.php';

//Get the id to be deleted
if (filter_has_var(INPUT_GET, 'admin_id')) {
	$clean_id = filter_var($_GET['admin_id'], FILTER_SANITIZE_NUMBER_INT);
	$admin_id = filter_var($clean_id, FILTER_VALIDATE_INT);

	//SQL query to delete admin
	$sql = "DELETE FROM admin_list WHERE admin_id = $admin_id";

	//Execute the query
	$res = mysqli_query($conn, $sql);

	if ($res) {
		//Creating SESSION variable to display message.
		$_SESSION['delete'] = "<div id='message' class='success admin-message'><img src='../../images/logo/successful.svg' alt='successful' class='successful'><span>Admin Deleted Successfully</span></div>";
		//Redirecting to the manage admin page.
		header('location:' . SITEURL . 'admin/admin_manage/admin_manage.php');
	} else {
		//Creating SESSION variable to display message.
		$_SESSION['delete'] = "<div id='message' class='fail admin-message'><img src='../../images/logo/warning.svg' alt='warning' class='warning'><span>Failed to delete admin, Please try again.</span></div>";
		//Redirecting to the manage admin page.
		header('location:' . SITEURL . 'admin/admin_manage/admin_manage.php');
	}
} else {
	echo "Id invalid";
}
