<?php
session_start();
if (!isset($_SESSION['user_id'])) {
	$_SESSION['error_login'] = "
	<div class='alert alert--success' id='alert'>
		<div class='alert__message'>
			Sign in Failed
		</div>
	</div>";

	header('location:' . SITEURL . 'customer/signin.php');
	exit();
}
