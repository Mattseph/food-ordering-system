<?php include '../partials/head.php'; ?>

<div class="form">

	<?php

	if (filter_has_var(INPUT_GET, 'admin_id')) {
		$sanitize_id = filter_var($_GET['admin_id'], FILTER_SANITIZE_NUMBER_INT);
		$admin_id = filter_var($sanitize_id, FILTER_VALIDATE_INT);
	}
	?>
	<div class="row">
		<form action="" method="POST" autocomplete="off" enctype="multipart/form-data" class="crud">
			<h2>Change Password</h2>
			<div class="form-group">
				<div class="placeholder">
					<input type="password" name="currentpassword" id="currentpassword" pattern="[A-Za-z0-9!@#$%^&*()_+=-?/ ]{8,}" required autofocus>
					<label for="currentpassword">Current Password</label>
				</div>
			</div>

			<div class="form-group">
				<div class="placeholder">
					<input type="password" name="newpassword" id="newpassword" title="Must be at least 8 characters" pattern="[A-Za-z0-9!@#$%^&*()_+=-?/ ]{8,}" required>
					<label for="newpassword">New Password</label>
				</div>
			</div>

			<div class="form-group">
				<div class="placeholder">
					<input type="password" name="confirmpassword" id="confirmpassword" title="Must be atleast 8 characters" pattern="[A-Za-z0-9!@#$%^&*()_+=-?/ ]{8,}" required>
					<label for="confirmpassword">Confirm Password</label>
				</div>
			</div>

			<div>
				<input type="hidden" name="admin_id" value="<?php echo $admin_id; ?>">
				<button type="submit" name="submit" class="btn">Update Password</button>
			</div>
		</form>
	</div>

	<div class="form-background">
		<img src="../../images/admin-bg/admin-background.svg" alt="admin-background" />
	</div>
</div>

<?php
if (filter_has_var(INPUT_POST, 'submit')) {
	$clean_id = filter_var($_POST['admin_id'], FILTER_SANITIZE_NUMBER_INT);
	$admin_id = filter_var($clean_id, FILTER_VALIDATE_INT);
	
	$currentpassword = htmlspecialchars(md5($_POST['currentpassword']));
	$newpassword = htmlspecialchars(md5($_POST['newpassword']));
	$confirmpassword = htmlspecialchars(md5($_POST['confirmpassword']));

	$sql = "SELECT * FROM admin_list WHERE admin_id = $admin_id AND password = '$currentpassword'";

	$res = mysqli_query($conn, $sql);

	if ($res) {
		$count = mysqli_num_rows($res);

		if ($count === 1) {
			if ($newpassword == $confirmpassword) {

				$sql2 = "UPDATE admin_list SET 
						password = '$newpassword'
						where admin_id = $admin_id
				";

				$res2 = mysqli_query($conn, $sql2);

				if ($res2) {
					$_SESSION['change_pass'] = "<div id='message' class='success admin-message'><img src='../../images/logo/successful.svg' alt='successful' class='successful'><span>Password Changed Successfully</span></div>";

					header('location:' . SITEURL . 'admin/admin_manage/admin_manage.php');
				} else {
					$_SESSION['change_pass'] = "<div id='message' class='fail admin-message'><img src='../../images/logo/warning.svg' alt='warning' class='warning'><span>Failed to Changed Password</span></div>";

					header('location:' . SITEURL . 'admin/admin_manage/admin_manage.php');
				}
			} else {
				$_SESSION['pass_not_match'] = "<div id='message' class='fail admin-message'><img src='../../images/logo/warning.svg' alt='warning' class='warning'><span>Password Did Not Match</span></div>";

				header('location:' . SITEURL . 'admin/admin_manage/admin_manage.php');
			}
		} else {
			$_SESSION['user_not_found'] = "<div id='message' class='fail admin-message'><img src='../../images/logo/warning.svg' alt='warning' class='warning'><span>Invalid Current Password</span></div>";

			header('location:' . SITEURL . 'admin/admin_manage/admin_manage.php');
		}
	}
}
?>