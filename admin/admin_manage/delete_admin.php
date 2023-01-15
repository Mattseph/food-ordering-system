<?php

include '../../configuration.php';

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
		$_SESSION['delete'] = "
			<div class='alert alert--success' id='alert'>
				<div class='alert__message'>
					Admin Profile Deleted Successfully
				</div>
			</div>
		";
		//Redirecting to the manage admin page.
		header('location:' . SITEURL . 'admin/admin_manage/admin_manage.php');
	} else {
		//Creating SESSION variable to display message.
		$_SESSION['delete'] = "
			<div class='alert alert--danger' id='alert'>
                <div class='alert__message'>	
					Failed to Delete Admin Profile, Please try again
                </div>
			</div>
		";
		//Redirecting to the manage admin page.
		header('location:' . SITEURL . 'admin/admin_manage/admin_manage.php');
	}
} else {
	echo "Id invalid";
}
