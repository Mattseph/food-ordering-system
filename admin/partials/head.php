<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin - Quick Bites</title>
	<link rel="stylesheet" href="../../css/admin.css">
	<link rel="icon" type="image/svg" href="../../images/logo/logo.jpg">
	<script src="../../js/timer.js" type="text/javascript"></script>
</head>

<?php
include '../../configuration/constants.php';
include 'login_checker.php';
?>

<body>
	<nav>
		<div class="navigation">
			<div class="logo">
				<img src="../../images/logo/logo.jpg" alt="Restaurant Logo">
			</div>

			<ul class="nav-bar">
				<li>
					<a href="<?php echo SITEURL; ?>admin/admin_manage/admin_manage.php">Admin</a>
				</li>

				<li>
					<a href="<?php echo SITEURL; ?>admin/category_manage/category_manage.php">Category</a>
				</li>

				<li>
					<a href="<?php echo SITEURL; ?>admin/food_manage/food_manage.php">Food</a>
				</li>
				<li>
					<a href="<?php echo SITEURL; ?>admin/order_manage/order_manage.php">Order</a>
				</li>
				<li>
					<a href="<?php echo SITEURL; ?>admin/views/views.php">Views</a>
				</li>
				<li>
					<a href="<?php echo SITEURL; ?>admin/delivery_rider_manage/delivery_manage.php">Delivery Rider</a>
				</li>
				<li>
					<a href="<?php echo SITEURL; ?>admin/supplier_manage/supplier_manage.php">Supplier</a>
				</li>
				<li>
					<a href="<?php echo SITEURL; ?>frontend/logout.php">Log out</a>
				</li>
			</ul>
		</div>
	</nav>