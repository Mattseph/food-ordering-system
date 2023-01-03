<?php
if (!isset($_SESSION['user_id'])) {
	$_SESSION['error_login'] = "<div class='fail signin-message'><img src='../images/logo/warning.svg' alt='warning' class='warning'><span>Please login to access</span></div>";

	header('location:' . SITEURL . 'frontend/signin.php');
	exit();
}
