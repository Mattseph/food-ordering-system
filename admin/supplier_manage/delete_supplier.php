<?php
session_start();
include '../../configuration.php';

//Get the id to be deleted
if (filter_has_var(INPUT_GET, 'supplier_id')) {
	$clean_supp_id = filter_var($_GET['supplier_id'], FILTER_SANITIZE_NUMBER_INT);
	$supplier_id = filter_var($clean_supp_id, FILTER_VALIDATE_INT);

	$foreignQuery = "SET FOREIGN_KEY_CHECKS=0";
	$pdo->query($foreignQuery);

	//SQL query to delete admin
	$deletesupplierQuery = "DELETE FROM suppliers WHERE supplier_id = :supplier_id";
	$deletesupplierStatement = $pdo->prepare($deletesupplierQuery);
	$deletesupplierStatement->bindParam(':supplier_id', $supplier_id, PDO::PARAM_INT);

	if ($deletesupplierStatement->execute()) {
		//Creating SESSION variable to display message.
		$_SESSION['delete'] = "
			<div class='alert alert--success' id='alert'>
				<div class='alert__message'>
					Supplier Profile Deleted Successfully
				</div>
			</div>
		";
		//Redirecting to the manage admin page.
		header('location:' . SITEURL . 'admin/supplier_manage/supplier_manage.php');
	} else {
		//Creating SESSION variable to display message.
		$_SESSION['delete'] = "
			<div class='alert alert--danger' id='alert'>
				<div class='alert__message'>	
					Failed to Delete Supplier Profile
				</div>
			</div>
		";
		//Redirecting to the manage admin page.
		header('location:' . SITEURL . 'admin/supplier_manage/supplier_manage.php');
	}
}
