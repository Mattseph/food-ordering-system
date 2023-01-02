<?php

include '../../configuration/constants.php';

//Get the id to be deleted
if (filter_has_var(INPUT_GET, 'supplier_id')) {
	$clean_supp_id = filter_var($_GET['supplier_id'], FILTER_SANITIZE_NUMBER_INT);
	$supplier_id = filter_var($clean_supp_id, FILTER_VALIDATE_INT);

	mysqli_query($conn, "SET FOREIGN_KEY_CHECKS=0");

	//SQL query to delete admin
	$sql = "DELETE FROM suppliers WHERE supplier_id = $supplier_id";

	//Execute the query
	$res = mysqli_query($conn, $sql);

	if ($res) {
		//Creating SESSION variable to display message.
		$_SESSION['delete'] = "<div id='message' class='success supplier-message'><img src='../../images/logo/successful.svg' alt='successful' class='successful'><span>Supplier Deleted Successfully</span></div>";
		//Redirecting to the manage admin page.
		header('location:' . SITEURL . 'admin/supplier_manage/supplier_manage.php');
	} else {
		//Creating SESSION variable to display message.
		$_SESSION['delete'] = "<div id='message' class='fail supplier-message'><img src='../../images/logo/warning.svg' alt='warning' class='warning'><span>Failed to Delete Supplier</span></div>";
		//Redirecting to the manage admin page.
		header('location:' . SITEURL . 'admin/supplier_manage/supplier_manage.php');
	}

	mysqli_query($conn, "SET FOREIGN_KEY_CHECKS=1");
}
